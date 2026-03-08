import { sendAuthRequest } from '../../../utils/backend'

export default defineEventHandler(async (event) => {
  return await sendAuthRequest(event, '/auth/login')
})
