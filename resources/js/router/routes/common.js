// Common/Error Routes
const commonRoutes = [
  {
    path: '/404',
    name: 'not-found',
    component: () => import('@/pages/NotFound.vue'),
    meta: {
      title: 'Halaman Tidak Ditemukan - Website Desa Kertayasa',
      layout: 'error',
    },
  },
  {
    path: '/403',
    name: 'forbidden',
    component: () => import('@/pages/Forbidden.vue'),
    meta: {
      title: 'Akses Ditolak - Website Desa Kertayasa',
      layout: 'error',
    },
  },
  {
    path: '/500',
    name: 'server-error',
    component: () => import('@/pages/ServerError.vue'),
    meta: {
      title: 'Server Error - Website Desa Kertayasa',
      layout: 'error',
    },
  },
  // Catch all 404 - must be last
  {
    path: '/:pathMatch(.*)*',
    redirect: '/404',
  },
]

export default commonRoutes
