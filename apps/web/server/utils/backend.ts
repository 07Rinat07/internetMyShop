import type { H3Event } from 'h3'
import {
  deleteCookie,
  getCookie,
  getMethod,
  getQuery,
  getRequestHeader,
  readBody,
  setCookie,
  setResponseStatus,
} from 'h3'

const accessTokenCookie = 'ims_access_token'
const basketCookie = 'ims_basket_id'
const thirtyDaysInSeconds = 60 * 60 * 24 * 30
const oneYearInSeconds = 60 * 60 * 24 * 365

type ProxyOptions = {
  includeAuth?: boolean
  includeBasket?: boolean
}

function isSecureCookie() {
  return process.env.NODE_ENV === 'production'
}

function backendApiBase(event: H3Event) {
  return String(useRuntimeConfig(event).backendApiBase)
}

function buildBackendHeaders(
  event: H3Event,
  options: ProxyOptions = {},
): Headers {
  const headers = new Headers()
  const contentType = getRequestHeader(event, 'content-type')

  headers.set('Accept', 'application/json')

  if (contentType) {
    headers.set('Content-Type', contentType)
  }

  if (options.includeAuth !== false) {
    const token = getCookie(event, accessTokenCookie)

    if (token) {
      headers.set('Authorization', `Bearer ${token}`)
    }
  }

  if (options.includeBasket !== false) {
    const basketId = getCookie(event, basketCookie)

    if (basketId) {
      headers.append('Cookie', `basket_id=${basketId}`)
    }
  }

  return headers
}

export function setAccessTokenCookie(event: H3Event, token: string) {
  setCookie(event, accessTokenCookie, token, {
    httpOnly: true,
    sameSite: 'lax',
    secure: isSecureCookie(),
    path: '/',
    maxAge: thirtyDaysInSeconds,
  })
}

export function clearAccessTokenCookie(event: H3Event) {
  deleteCookie(event, accessTokenCookie, {
    path: '/',
  })
}

export function hasAccessTokenCookie(event: H3Event) {
  return Boolean(getCookie(event, accessTokenCookie))
}

function syncBasketCookie(event: H3Event, headers: Headers) {
  const setCookieHeader = headers.get('set-cookie')

  if (!setCookieHeader) {
    return
  }

  const match = setCookieHeader.match(/basket_id=([^;]*)/)

  if (!match) {
    return
  }

  const value = decodeURIComponent(match[1] || '')

  if (valueIsDeleted(value)) {
    deleteCookie(event, basketCookie, { path: '/' })
    return
  }

  setCookie(event, basketCookie, value, {
    httpOnly: true,
    sameSite: 'lax',
    secure: isSecureCookie(),
    path: '/',
    maxAge: oneYearInSeconds,
  })
}

function valueIsDeleted(value: string) {
  return value === '' || value.toLowerCase() === 'deleted'
}

export async function proxyBackendJson(
  event: H3Event,
  path: string,
  options: ProxyOptions = {},
) {
  const method = getMethod(event)
  const body = ['GET', 'HEAD'].includes(method) ? undefined : await readBody(event)

  const response = await $fetch.raw(path, {
    baseURL: backendApiBase(event),
    method,
    query: getQuery(event),
    body,
    headers: buildBackendHeaders(event, options),
    ignoreResponseError: true,
  })

  syncBasketCookie(event, response.headers)
  setResponseStatus(event, response.status)

  return response._data
}

export async function sendAuthRequest(
  event: H3Event,
  path: '/auth/login' | '/auth/register',
) {
  const response = await $fetch.raw(path, {
    baseURL: backendApiBase(event),
    method: 'POST',
    body: await readBody(event),
    headers: buildBackendHeaders(event, { includeAuth: false }),
    ignoreResponseError: true,
  })

  setResponseStatus(event, response.status)

  if (response.status >= 400) {
    return response._data
  }

  const payload = response._data as {
    data?: {
      access_token?: string
      user?: unknown
    }
  } | null
  const accessToken = payload?.data?.access_token
  const user = payload?.data?.user ?? null

  if (accessToken) {
    setAccessTokenCookie(event, accessToken)
  }

  return {
    data: {
      user,
    },
  }
}
