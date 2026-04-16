import { navigateTo } from '#app'

export const checkAuth = () => {
  if (import.meta.server) return false

  const user = localStorage.getItem('user')

  if (user) {
    return true
  }

  return navigateTo('/auth/login')
}