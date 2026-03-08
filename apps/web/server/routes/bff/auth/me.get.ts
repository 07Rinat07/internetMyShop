import {
  clearAccessTokenCookie,
  hasAccessTokenCookie,
  proxyBackendJson,
} from '../../../utils/backend'
import { setResponseStatus } from 'h3'

export default defineEventHandler(async (event) => {
  if (!hasAccessTokenCookie(event)) {
    setResponseStatus(event, 401)

    return {
      message: 'Unauthenticated.',
    }
  }

  const response = await proxyBackendJson(event, '/auth/me')

  if (event.node.res.statusCode === 401) {
    clearAccessTokenCookie(event)
  }

  return response
})
