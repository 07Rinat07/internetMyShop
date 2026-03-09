import type { AuthUser } from '~/types/api'
import { normalizeLocale } from '~/utils/locale'

type ApiErrorShape = {
  data?: {
    message?: string
    errors?: Record<string, string[]>
  }
  response?: {
    status?: number
  }
}

type ApiClientOptions = NonNullable<Parameters<typeof $fetch>[1]> & {
  headers?: HeadersInit
}

export function useApiClient() {
  const config = useRuntimeConfig()
  const authUser = useState<AuthUser | null>('auth-user', () => null)
  const authResolved = useState<boolean>('auth-resolved', () => false)
  const localeState = useState('locale', () => normalizeLocale(useCookie<string>('locale').value))
  const apiBase = config.public.apiBase

  return async function apiClient<T>(path: string, options: ApiClientOptions = {}) {
    const headers = new Headers(options.headers as HeadersInit | undefined)
    const requestCookies = import.meta.server ? useRequestHeaders(['cookie']).cookie : undefined

    headers.set('Accept', 'application/json')

    if (requestCookies && !headers.has('cookie')) {
      headers.set('cookie', requestCookies)
    }

    headers.set('X-Locale', normalizeLocale(String(localeState.value || '')))

    try {
      return await $fetch<T>(path, {
        ...options,
        baseURL: apiBase,
        credentials: 'include',
        headers,
      })
    } catch (error) {
      const status = (error as ApiErrorShape).response?.status

      if (status === 401) {
        authUser.value = null
        authResolved.value = true
      }

      throw error
    }
  }
}

export function getApiErrorMessage(error: unknown, fallback = 'Request failed.') {
  const payload = error as ApiErrorShape
  const firstValidationError = payload.data?.errors
    ? Object.values(payload.data.errors)[0]?.[0]
    : null

  return firstValidationError || payload.data?.message || fallback
}
