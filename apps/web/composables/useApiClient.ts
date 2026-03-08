import type { AuthUser } from '~/types/api'

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
  const token = useCookie<string | null>('access_token', {
    sameSite: 'lax',
    secure: !import.meta.dev,
  })
  const authUser = useState<AuthUser | null>('auth-user', () => null)

  return async function apiClient<T>(path: string, options: ApiClientOptions = {}) {
    const headers = new Headers(options.headers as HeadersInit | undefined)
    headers.set('Accept', 'application/json')

    if (token.value) {
      headers.set('Authorization', `Bearer ${token.value}`)
    }

    try {
      return await $fetch<T>(path, {
        ...options,
        baseURL: config.public.apiBase,
        credentials: 'include',
        headers,
      })
    } catch (error) {
      const status = (error as ApiErrorShape).response?.status

      if (status === 401) {
        token.value = null
        authUser.value = null
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
