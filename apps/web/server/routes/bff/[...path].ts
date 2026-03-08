import { proxyBackendJson } from '../../utils/backend'

export default defineEventHandler(async (event) => {
  const rawPath = event.context.params?.path
  const path = Array.isArray(rawPath) ? rawPath.join('/') : rawPath

  if (!path) {
    return {
      message: 'Not found.',
    }
  }

  return await proxyBackendJson(event, `/${path}`)
})
