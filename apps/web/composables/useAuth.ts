import type {
  ApiEnvelope,
  AuthResponseData,
  AuthUser,
  LoginPayload,
  RegisterPayload,
} from '~/types/api'

export function useAuth() {
  const api = useApiClient()
  const user = useState<AuthUser | null>('auth-user', () => null)
  const resolved = useState<boolean>('auth-resolved', () => false)
  const busy = useState<boolean>('auth-busy', () => false)
  const loggedIn = computed(() => Boolean(user.value))

  async function consumeAuthResponse(endpoint: string, payload: LoginPayload | RegisterPayload) {
    busy.value = true

    try {
      const response = await api<ApiEnvelope<AuthResponseData>>(endpoint, {
        method: 'POST',
        body: payload,
      })

      user.value = response.data.user
      resolved.value = true

      return response.data.user
    } finally {
      busy.value = false
    }
  }

  async function login(payload: LoginPayload) {
    return await consumeAuthResponse('/auth/login', payload)
  }

  async function register(payload: RegisterPayload) {
    return await consumeAuthResponse('/auth/register', payload)
  }

  async function fetchMe(force = false) {
    if (resolved.value && !force) {
      return user.value
    }

    try {
      const response = await api<ApiEnvelope<AuthUser>>('/auth/me')
      user.value = response.data

      return response.data
    } catch {
      user.value = null
      return null
    } finally {
      resolved.value = true
    }
  }

  async function ensureUser() {
    return await fetchMe()
  }

  async function logout() {
    try {
      await api('/auth/logout', { method: 'POST' })
    } catch {
      // Local auth state still has to be cleared if the backend token is already gone.
    }

    user.value = null
    resolved.value = true

    await navigateTo('/login')
  }

  return {
    user,
    resolved,
    busy,
    loggedIn,
    login,
    register,
    fetchMe,
    ensureUser,
    logout,
  }
}
