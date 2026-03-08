export default defineNuxtRouteMiddleware(async () => {
  const auth = useAuth()

  if (!auth.token.value) {
    return
  }

  const user = await auth.ensureUser()

  if (user) {
    return navigateTo('/profile')
  }
})
