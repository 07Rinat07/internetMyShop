import type {
  ApiEnvelope,
  AuthResponseData,
  AuthUser,
  LoginPayload,
  RegisterPayload,
} from '~/types/api'

export function useAuth() {
  const api = useApiClient()
  const token = useCookie<string | null>('access_token', {
    sameSite: 'lax',
    secure: !import.meta.dev,
  })
  const user = useState<AuthUser | null>('auth-user', () => null)
  const busy = useState<boolean>('auth-busy', () => false)
  const loggedIn = computed(() => Boolean(token.value))

  async function consumeAuthResponse(endpoint: string, payload: LoginPayload | RegisterPayload) {
    busy.value = true

    try {
      const response = await api<ApiEnvelope<AuthResponseData>>(endpoint, {
        method: 'POST',
        body: payload,
      })

      token.value = response.data.access_token
      user.value = response.data.user

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

  async function fetchMe() {
    if (!token.value) {
      user.value = null
      return null
    }

    const response = await api<ApiEnvelope<AuthUser>>('/auth/me')
    user.value = response.data

    return response.data
  }

  async function ensureUser() {
    if (user.value) {
      return user.value
    }

    try {
      return await fetchMe()
    } catch {
      token.value = null
      user.value = null
      return null
    }
  }

  async function logout() {
    if (token.value) {
      try {
        await api('/auth/logout', { method: 'POST' })
      } catch {
      }
    }

    token.value = null
    user.value = null

    await navigateTo('/login')
  }

  return {
    token,
    user,
    busy,
    loggedIn,
    login,
    register,
    fetchMe,
    ensureUser,
    logout,
  }
}
