export default defineNuxtRouteMiddleware(() => {
  if (import.meta.server) return

  const user = localStorage.getItem('user')

  if (!user) {
    return navigateTo('/auth/login')
  }
})