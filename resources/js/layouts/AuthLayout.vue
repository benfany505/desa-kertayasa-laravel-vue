<template>
    <div class="min-h-screen bg-background">
        <!-- Sidebar -->
        <aside :class="[
            'fixed inset-y-0 left-0 z-50 w-64 bg-background border-r transition-transform duration-300 ease-in-out lg:translate-x-0',
            sidebarOpen ? 'translate-x-0' : '-translate-x-full'
        ]">
            <!-- Logo -->
            <div class="flex items-center justify-between p-4 border-b">
                <router-link to="/admin" class="flex items-center space-x-3">
                    <div class="h-8 w-8 bg-primary rounded-lg flex items-center justify-center">
                        <Building class="h-5 w-5 text-primary-foreground" />
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold">Admin Panel</h1>
                        <p class="text-xs text-muted-foreground">Desa Kertayasa</p>
                    </div>
                </router-link>
                <Button variant="ghost" size="sm" class="lg:hidden" @click="toggleSidebar">
                    <X class="h-4 w-4" />
                </Button>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <div v-for="section in navigation" :key="section.title" class="space-y-1">
                    <h3 v-if="section.title"
                        class="px-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">
                        {{ section.title }}
                    </h3>
                    <div class="space-y-1">
                        <template v-for="item in section.items" :key="item.name">
                            <!-- Single Item -->
                            <router-link v-if="!item.children" :to="item.to"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors group"
                                :class="[
                                    isActive(item.to)
                                        ? 'bg-primary text-primary-foreground'
                                        : 'text-muted-foreground hover:text-foreground hover:bg-accent'
                                ]">
                                <component :is="item.icon" class="h-4 w-4 mr-3 flex-shrink-0" />
                                {{ item.name }}
                                <Badge v-if="item.badge" variant="secondary" class="ml-auto">
                                    {{ item.badge }}
                                </Badge>
                            </router-link>

                            <!-- Collapsible Item -->
                            <div v-else>
                                <Button variant="ghost" class="w-full justify-start px-3 py-2 text-sm font-medium"
                                    @click="toggleSubmenu(item.name)">
                                    <component :is="item.icon" class="h-4 w-4 mr-3 flex-shrink-0" />
                                    {{ item.name }}
                                    <ChevronDown :class="[
                                        'h-4 w-4 ml-auto transition-transform',
                                        openSubmenus.includes(item.name) ? 'rotate-180' : ''
                                    ]" />
                                </Button>
                                <div v-if="openSubmenus.includes(item.name)" class="ml-6 space-y-1 border-l pl-4">
                                    <router-link v-for="child in item.children" :key="child.name" :to="child.to"
                                        class="flex items-center px-3 py-2 text-sm rounded-md transition-colors" :class="[
                                            isActive(child.to)
                                                ? 'bg-primary text-primary-foreground'
                                                : 'text-muted-foreground hover:text-foreground hover:bg-accent'
                                        ]">
                                        <component :is="child.icon" class="h-3 w-3 mr-3 flex-shrink-0" />
                                        {{ child.name }}
                                    </router-link>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t">
                <div class="flex items-center space-x-3">
                    <Avatar class="h-8 w-8">
                        <AvatarImage :src="user?.avatar" :alt="user?.name" />
                        <AvatarFallback>{{ user?.initials }}</AvatarFallback>
                    </Avatar>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ user?.name }}</p>
                        <p class="text-xs text-muted-foreground truncate">{{ user?.role }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Sidebar Overlay (Mobile) -->
        <div v-if="sidebarOpen" class="fixed inset-0 z-40 bg-background/80 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false" />

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Header -->
            <header
                class="sticky top-0 z-30 bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 border-b">
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center space-x-4">
                        <!-- Mobile Menu Button -->
                        <Button variant="ghost" size="sm" class="lg:hidden" @click="toggleSidebar">
                            <Menu class="h-4 w-4" />
                        </Button>

                        <!-- Breadcrumbs -->
                        <nav class="hidden sm:flex items-center space-x-2 text-sm">
                            <Home class="h-4 w-4 text-muted-foreground" />
                            <ChevronRight v-for="(crumb, index) in breadcrumbs" :key="index"
                                class="h-4 w-4 text-muted-foreground" />
                            <span v-for="(crumb, index) in breadcrumbs" :key="index">
                                <router-link v-if="index < breadcrumbs.length - 1" :to="crumb.to"
                                    class="text-muted-foreground hover:text-foreground">
                                    {{ crumb.name }}
                                </router-link>
                                <span v-else class="font-medium">{{ crumb.name }}</span>
                                <ChevronRight v-if="index < breadcrumbs.length - 1"
                                    class="h-4 w-4 text-muted-foreground ml-2" />
                            </span>
                        </nav>
                    </div>

                    <!-- Header Actions -->
                    <div class="flex items-center space-x-2">
                        <!-- Quick Actions -->
                        <Button variant="ghost" size="sm" @click="goToWebsite">
                            <ExternalLink class="h-4 w-4" />
                            <span class="hidden sm:inline ml-2">Lihat Website</span>
                        </Button>

                        <!-- Theme Toggle -->
                        <Button variant="ghost" size="sm" @click="toggleTheme">
                            <Sun v-if="isDark" class="h-4 w-4" />
                            <Moon v-else class="h-4 w-4" />
                        </Button>

                        <!-- Notifications -->
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="ghost" size="sm" class="relative">
                                    <Bell class="h-4 w-4" />
                                    <Badge v-if="notifications.length > 0" variant="destructive"
                                        class="absolute -top-1 -right-1 h-5 w-5 p-0 text-xs">
                                        {{ notifications.length }}
                                    </Badge>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end" class="w-80">
                                <DropdownMenuLabel>Notifikasi</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <div v-if="notifications.length === 0" class="p-4 text-center text-muted-foreground">
                                    Tidak ada notifikasi baru
                                </div>
                                <div v-else class="max-h-64 overflow-y-auto">
                                    <DropdownMenuItem v-for="notification in notifications" :key="notification.id"
                                        class="flex-col items-start p-4">
                                        <div class="flex items-center justify-between w-full">
                                            <span class="font-medium">{{ notification.title }}</span>
                                            <span class="text-xs text-muted-foreground">{{ notification.time }}</span>
                                        </div>
                                        <p class="text-sm text-muted-foreground mt-1">{{ notification.message }}</p>
                                    </DropdownMenuItem>
                                </div>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem class="justify-center">
                                    Lihat semua notifikasi
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>

                        <!-- User Menu -->
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="ghost" class="relative h-8 w-8 rounded-full">
                                    <Avatar class="h-8 w-8">
                                        <AvatarImage :src="user?.avatar" :alt="user?.name" />
                                        <AvatarFallback>{{ user?.initials }}</AvatarFallback>
                                    </Avatar>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent class="w-56" align="end">
                                <DropdownMenuLabel class="font-normal">
                                    <div class="flex flex-col space-y-1">
                                        <p class="text-sm font-medium">{{ user?.name }}</p>
                                        <p class="text-xs text-muted-foreground">{{ user?.email }}</p>
                                    </div>
                                </DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem @click="goToProfile">
                                    <User class="mr-2 h-4 w-4" />
                                    <span>Profil</span>
                                </DropdownMenuItem>
                                <DropdownMenuItem @click="goToSettings">
                                    <Settings class="mr-2 h-4 w-4" />
                                    <span>Pengaturan</span>
                                </DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem @click="logout" class="text-destructive">
                                    <LogOut class="mr-2 h-4 w-4" />
                                    <span>Keluar</span>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useTheme } from '@/composables/useTheme'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import {
    Building, Menu, X, Home, ChevronRight, ChevronDown, ExternalLink,
    Sun, Moon, Bell, User, Settings, LogOut,
    LayoutDashboard, FileText, Users, MessageSquare, Image, Download,
    BarChart3, Cog, Shield, Calendar, MapPin, DollarSign, Archive,
    Plus, Edit, Trash2, Eye
} from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()
const { isDark, toggleTheme } = useTheme()

// Reactive data
const sidebarOpen = ref(false)
const openSubmenus = ref(['content']) // Default open content menu

// Mock user data
const user = ref({
    name: 'Admin Desa',
    email: 'admin@desakertayasa.id',
    role: 'Super Admin',
    avatar: null,
    initials: 'AD'
})

// Mock notifications
const notifications = ref([
    {
        id: 1,
        title: 'Pengaduan Baru',
        message: 'Ada pengaduan baru dari warga tentang infrastruktur jalan',
        time: '5 menit lalu'
    },
    {
        id: 2,
        title: 'Berita Dipublikasi',
        message: 'Artikel "Rapat Koordinasi Bulanan" telah dipublikasi',
        time: '1 jam lalu'
    }
])

// Navigation structure
const navigation = [
    {
        title: '',
        items: [
            {
                name: 'Dashboard',
                to: '/admin',
                icon: LayoutDashboard
            }
        ]
    },
    {
        title: 'Konten',
        items: [
            {
                name: 'Manajemen Konten',
                icon: FileText,
                children: [
                    { name: 'Berita', to: '/admin/berita', icon: Plus },
                    { name: 'Halaman', to: '/admin/halaman', icon: Edit },
                    { name: 'Agenda', to: '/admin/agenda', icon: Calendar },
                    { name: 'Galeri', to: '/admin/galeri', icon: Image }
                ]
            },
            {
                name: 'Media',
                to: '/admin/media',
                icon: Image
            }
        ]
    },
    {
        title: 'Layanan',
        items: [
            {
                name: 'Layanan Publik',
                to: '/admin/layanan',
                icon: FileText
            },
            {
                name: 'Pengaduan',
                to: '/admin/pengaduan',
                icon: MessageSquare,
                badge: notifications.value.filter(n => n.title.includes('Pengaduan')).length || null
            },
            {
                name: 'Unduhan',
                to: '/admin/download',
                icon: Download
            }
        ]
    },
    {
        title: 'Transparansi',
        items: [
            {
                name: 'APBDes',
                to: '/admin/apbdes',
                icon: DollarSign
            },
            {
                name: 'Statistik',
                to: '/admin/statistik',
                icon: BarChart3
            }
        ]
    },
    {
        title: 'Sistem',
        items: [
            {
                name: 'Pengguna',
                to: '/admin/users',
                icon: Users
            },
            {
                name: 'Pengaturan',
                icon: Cog,
                children: [
                    { name: 'Identitas Desa', to: '/admin/settings/identity', icon: MapPin },
                    { name: 'Menu Navigasi', to: '/admin/settings/menu', icon: FileText },
                    { name: 'Keamanan', to: '/admin/settings/security', icon: Shield }
                ]
            },
            {
                name: 'Backup & Restore',
                to: '/admin/backup',
                icon: Archive
            }
        ]
    }
]

// Computed properties
const breadcrumbs = computed(() => {
    const path = route.path
    const segments = path.split('/').filter(Boolean).slice(1) // Remove first 'admin'

    return segments.map((segment, index) => {
        const to = '/admin/' + segments.slice(0, index + 1).join('/')
        const name = segment.charAt(0).toUpperCase() + segment.slice(1)
        return { name, to }
    })
})

// Methods
const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value
}

const toggleSubmenu = (menuName) => {
    if (openSubmenus.value.includes(menuName)) {
        openSubmenus.value = openSubmenus.value.filter(name => name !== menuName)
    } else {
        openSubmenus.value.push(menuName)
    }
}

const isActive = (path) => {
    return route.path === path || route.path.startsWith(path + '/')
}

const goToWebsite = () => {
    window.open('/', '_blank')
}

const goToProfile = () => {
    router.push('/admin/profile')
}

const goToSettings = () => {
    router.push('/admin/settings')
}

const logout = () => {
    // Implement logout logic
    console.log('Logout')
    router.push('/admin/login')
}
</script>

<style scoped>
/* Custom scrollbar for sidebar */
aside {
    scrollbar-width: thin;
    scrollbar-color: rgb(203 213 225 / 0.5) transparent;
}

aside::-webkit-scrollbar {
    width: 6px;
}

aside::-webkit-scrollbar-track {
    background: transparent;
}

aside::-webkit-scrollbar-thumb {
    background-color: rgb(203 213 225 / 0.5);
    border-radius: 3px;
}

aside::-webkit-scrollbar-thumb:hover {
    background-color: rgb(203 213 225 / 0.7);
}
</style>
