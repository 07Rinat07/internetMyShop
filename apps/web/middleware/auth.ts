export default defineNuxtRouteMiddleware(async () => {
  const auth = useAuth()

  if (!auth.token.value) {
    return navigateTo('/login')
  }

  const user = await auth.ensureUser()

  if (!user) {
    return navigateTo('/login')
  }
})
