// Admin Routes
const adminRoutes = [
  {
    path: '/admin/login',
    name: 'admin.login',
    component: () => import('@/pages/admin/Login.vue'),
    meta: {
      title: 'Login Admin - Website Desa Kertayasa',
      requiresGuest: true,
      layout: 'auth',
    },
  },
  {
    path: '/admin',
    name: 'admin.dashboard',
    component: () => import('@/pages/admin/Dashboard.vue'),
    meta: {
      title: 'Dashboard Admin - Website Desa Kertayasa',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  {
    path: '/admin/profile',
    name: 'admin.profile',
    component: () => import('@/pages/admin/Profile.vue'),
    meta: {
      title: 'Profile Admin - Website Desa Kertayasa',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  // Berita Management
  {
    path: '/admin/berita',
    name: 'admin.news.index',
    component: () => import('@/pages/admin/news/Index.vue'),
    meta: {
      title: 'Manajemen Berita - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  {
    path: '/admin/berita/create',
    name: 'admin.news.create',
    component: () => import('@/pages/admin/news/Create.vue'),
    meta: {
      title: 'Tambah Berita - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  {
    path: '/admin/berita/:id/edit',
    name: 'admin.news.edit',
    component: () => import('@/pages/admin/news/Edit.vue'),
    meta: {
      title: 'Edit Berita - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  // Halaman Statis Management
  {
    path: '/admin/halaman',
    name: 'admin.pages.index',
    component: () => import('@/pages/admin/pages/Index.vue'),
    meta: {
      title: 'Manajemen Halaman - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  {
    path: '/admin/halaman/create',
    name: 'admin.pages.create',
    component: () => import('@/pages/admin/pages/Create.vue'),
    meta: {
      title: 'Tambah Halaman - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  {
    path: '/admin/halaman/:id/edit',
    name: 'admin.pages.edit',
    component: () => import('@/pages/admin/pages/Edit.vue'),
    meta: {
      title: 'Edit Halaman - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  // Galeri Management
  {
    path: '/admin/galeri',
    name: 'admin.gallery.index',
    component: () => import('@/pages/admin/gallery/Index.vue'),
    meta: {
      title: 'Manajemen Galeri - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  {
    path: '/admin/galeri/create',
    name: 'admin.gallery.create',
    component: () => import('@/pages/admin/gallery/Create.vue'),
    meta: {
      title: 'Tambah Galeri - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  // Pengaduan Management
  {
    path: '/admin/pengaduan',
    name: 'admin.complaints.index',
    component: () => import('@/pages/admin/complaints/Index.vue'),
    meta: {
      title: 'Manajemen Pengaduan - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  {
    path: '/admin/pengaduan/:id',
    name: 'admin.complaints.show',
    component: () => import('@/pages/admin/complaints/Show.vue'),
    meta: {
      title: 'Detail Pengaduan - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  // Layanan Management
  {
    path: '/admin/layanan',
    name: 'admin.services.index',
    component: () => import('@/pages/admin/services/Index.vue'),
    meta: {
      title: 'Manajemen Layanan - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  {
    path: '/admin/layanan/create',
    name: 'admin.services.create',
    component: () => import('@/pages/admin/services/Create.vue'),
    meta: {
      title: 'Tambah Layanan - Admin',
      requiresAuth: true,
      layout: 'admin',
    },
  },
  // User Management (Super Admin only)
  {
    path: '/admin/users',
    name: 'admin.users.index',
    component: () => import('@/pages/admin/users/Index.vue'),
    meta: {
      title: 'Manajemen User - Admin',
      requiresAuth: true,
      requiresRole: ['super_admin'],
      layout: 'admin',
    },
  },
  // Data Migration (Super Admin only)
  {
    path: '/admin/migration',
    name: 'admin.migration.index',
    component: () => import('@/views/admin/DataMigration.vue'),
    meta: {
      title: 'Data Migration - Admin',
      requiresAuth: true,
      requiresRole: ['super_admin'],
      layout: 'admin',
    },
  },
]

export default adminRoutes
