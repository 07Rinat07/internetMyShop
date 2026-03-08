export default defineNuxtRouteMiddleware(async () => {
  const auth = useAuth()

  const user = await auth.ensureUser()

  if (user) {
    return navigateTo('/profile')
  }
})
