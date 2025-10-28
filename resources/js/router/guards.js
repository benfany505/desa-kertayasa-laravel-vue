// Authentication Guards
import { useAuthStore } from '@/stores/auth'

export const authGuards = {
  // Check if user is authenticated
  requiresAuth: (to, from, next) => {
    const authStore = useAuthStore()

    if (!authStore.isAuthenticated) {
      next({
        name: 'admin.login',
        query: { redirect: to.fullPath },
      })
      return false
    }
    return true
  },

  // Check if user is guest (not authenticated)
  requiresGuest: (to, from, next) => {
    const authStore = useAuthStore()

    if (authStore.isAuthenticated) {
      next({ name: 'admin.dashboard' })
      return false
    }
    return true
  },

  // Check user role
  requiresRole: (to, from, next, requiredRoles) => {
    const authStore = useAuthStore()

    if (!authStore.user || !requiredRoles.includes(authStore.user.role)) {
      next({ name: 'forbidden' })
      return false
    }
    return true
  },

  // Apply guards based on route meta
  applyGuards: (to, from, next) => {
    // Check guest requirement
    if (to.meta.requiresGuest) {
      if (!authGuards.requiresGuest(to, from, next)) return
    }

    // Check authentication requirement
    if (to.meta.requiresAuth) {
      if (!authGuards.requiresAuth(to, from, next)) return
    }

    // Check role requirement
    if (to.meta.requiresRole) {
      if (!authGuards.requiresRole(to, from, next, to.meta.requiresRole)) return
    }

    next()
  },
}
