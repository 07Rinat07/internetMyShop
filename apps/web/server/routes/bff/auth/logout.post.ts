import {
  clearAccessTokenCookie,
  hasAccessTokenCookie,
  proxyBackendJson,
} from '../../../utils/backend'
import { setResponseStatus } from 'h3'

export default defineEventHandler(async (event) => {
  if (hasAccessTokenCookie(event)) {
    await proxyBackendJson(event, '/auth/logout')
  } else {
    setResponseStatus(event, 204)
  }

  clearAccessTokenCookie(event)

  return null
})
