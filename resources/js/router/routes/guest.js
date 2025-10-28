// Guest/Public Routes
const guestRoutes = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/pages/Home.vue'),
    meta: {
      title: 'Beranda - Website Desa Kertayasa',
      requiresGuest: false,
    },
  },
  {
    path: '/tentang',
    name: 'about',
    component: () => import('@/pages/About.vue'),
    meta: {
      title: 'Tentang - Website Desa Kertayasa',
      requiresGuest: false,
    },
  },
  {
    path: '/berita',
    name: 'news.index',
    component: () => import('@/pages/news/Index.vue'),
    meta: {
      title: 'Berita - Website Desa Kertayasa',
      requiresGuest: false,
    },
  },
  {
    path: '/berita/:slug',
    name: 'news.show',
    component: () => import('@/pages/news/Show.vue'),
    meta: {
      title: 'Berita - Website Desa Kertayasa',
      requiresGuest: false,
    },
  },
  {
    path: '/galeri',
    name: 'gallery.index',
    component: () => import('@/pages/gallery/Index.vue'),
    meta: {
      title: 'Galeri - Website Desa Kertayasa',
      requiresGuest: false,
    },
  },
  {
    path: '/layanan',
    name: 'services.index',
    component: () => import('@/pages/services/Index.vue'),
    meta: {
      title: 'Layanan - Website Desa Kertayasa',
      requiresGuest: false,
    },
  },
  {
    path: '/pengaduan',
    name: 'complaints.create',
    component: () => import('@/pages/complaints/Create.vue'),
    meta: {
      title: 'Pengaduan - Website Desa Kertayasa',
      requiresGuest: false,
    },
  },
  {
    path: '/kontak',
    name: 'contact',
    component: () => import('@/pages/Contact.vue'),
    meta: {
      title: 'Kontak - Website Desa Kertayasa',
      requiresGuest: false,
    },
  },
]

export default guestRoutes
