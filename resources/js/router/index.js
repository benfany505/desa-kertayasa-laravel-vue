import { createRouter, createWebHistory } from 'vue-router'

// Import route modules
import guestRoutes from './routes/guest'
import adminRoutes from './routes/admin'
import commonRoutes from './routes/common'

// Import guards
import { authGuards } from './guards'

// Combine all routes
const routes = [...guestRoutes, ...adminRoutes, ...commonRoutes]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  },
})

// Navigation guards
router.beforeEach((to, from, next) => {
  // Update document title
  if (to.meta.title) {
    document.title = to.meta.title
  }

  // Apply authentication guards
  authGuards.applyGuards(to, from, next)
})

export default router
