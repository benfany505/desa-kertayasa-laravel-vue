<template>
    <div class="min-h-screen bg-background text-foreground">
        <!-- Header -->
        <header
            class="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
            <div class="container mx-auto px-4">
                <!-- Top Bar with Contact Info -->
                <div class="hidden lg:flex items-center justify-between py-2 text-sm text-muted-foreground border-b">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <Phone class="h-4 w-4 mr-1" />
                            <span>(0265) 123-4567</span>
                        </div>
                        <div class="flex items-center">
                            <Mail class="h-4 w-4 mr-1" />
                            <span>info@desakertayasa.id</span>
                        </div>
                        <div class="flex items-center">
                            <MapPin class="h-4 w-4 mr-1" />
                            <span>Kuningan, Jawa Barat</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="#" class="hover:text-primary transition-colors">
                            <Facebook class="h-4 w-4" />
                        </a>
                        <a href="#" class="hover:text-primary transition-colors">
                            <Twitter class="h-4 w-4" />
                        </a>
                        <a href="#" class="hover:text-primary transition-colors">
                            <Instagram class="h-4 w-4" />
                        </a>
                        <a href="#" class="hover:text-primary transition-colors">
                            <Youtube class="h-4 w-4" />
                        </a>
                    </div>
                </div>

                <!-- Main Navigation -->
                <div class="flex items-center justify-between py-4">
                    <!-- Logo & Brand -->
                    <router-link to="/" class="flex items-center space-x-3">
                        <div class="h-12 w-12 bg-primary rounded-full flex items-center justify-center">
                            <Building class="h-6 w-6 text-primary-foreground" />
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="text-xl font-bold text-primary">Desa Kertayasa</h1>
                            <p class="text-sm text-muted-foreground">Pemerintahan Desa</p>
                        </div>
                    </router-link>

                    <!-- Desktop Navigation -->
                    <nav class="hidden lg:flex items-center space-x-6">
                        <router-link v-for="item in navigation" :key="item.name" :to="item.to"
                            class="text-sm font-medium transition-colors hover:text-primary"
                            :class="{ 'text-primary': $route.path === item.to }">
                            {{ item.name }}
                        </router-link>
                    </nav>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                        <!-- Admin Login Button -->
                        <router-link :to="{ name: 'admin.login' }">
                            <Button variant="outline" size="sm" class="hidden sm:flex">
                                <Shield class="h-4 w-4 mr-1" />
                                Admin
                            </Button>
                        </router-link>

                        <!-- Theme Toggle -->
                        <Button variant="ghost" size="sm" @click="toggleTheme">
                            <Sun v-if="isDark" class="h-4 w-4" />
                            <Moon v-else class="h-4 w-4" />
                            <span class="sr-only">Toggle theme</span>
                        </Button>

                        <!-- Search Button -->
                        <Button variant="ghost" size="sm" @click="openSearch">
                            <Search class="h-4 w-4" />
                            <span class="sr-only">Search</span>
                        </Button>

                        <!-- Mobile Menu Button -->
                        <Button variant="ghost" size="sm" class="lg:hidden" @click="toggleMobileMenu">
                            <Menu v-if="!mobileMenuOpen" class="h-4 w-4" />
                            <X v-else class="h-4 w-4" />
                            <span class="sr-only">Toggle menu</span>
                        </Button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div v-if="mobileMenuOpen" class="lg:hidden border-t py-4">
                    <nav class="flex flex-col space-y-2">
                        <router-link v-for="item in navigation" :key="item.name" :to="item.to"
                            class="px-3 py-2 text-sm font-medium transition-colors hover:text-primary hover:bg-accent rounded-md"
                            :class="{ 'text-primary bg-accent': $route.path === item.to }"
                            @click="mobileMenuOpen = false">
                            {{ item.name }}
                        </router-link>

                        <!-- Admin Login for Mobile -->
                        <router-link :to="{ name: 'admin.login' }"
                            class="px-3 py-2 text-sm font-medium transition-colors hover:text-primary hover:bg-accent rounded-md border-t mt-2 pt-4"
                            @click="mobileMenuOpen = false">
                            <Shield class="h-4 w-4 mr-2 inline" />
                            Login Admin
                        </router-link>
                    </nav>
                </div>
            </div>
        </header>



        <!-- Breadcrumbs (not on homepage) -->
        <nav v-if="!isHomepage" class="bg-muted/50 border-b">
            <div class="container mx-auto px-4 py-3">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <router-link to="/" class="text-muted-foreground hover:text-foreground">
                            <Home class="h-4 w-4" />
                            <span class="sr-only">Home</span>
                        </router-link>
                    </li>
                    <ChevronRight v-for="(crumb, index) in breadcrumbs" :key="index"
                        class="h-4 w-4 text-muted-foreground" />
                    <li v-for="(crumb, index) in breadcrumbs" :key="index">
                        <router-link v-if="index < breadcrumbs.length - 1" :to="crumb.to"
                            class="text-muted-foreground hover:text-foreground">
                            {{ crumb.name }}
                        </router-link>
                        <span v-else class="text-foreground font-medium">{{ crumb.name }}</span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-muted border-t">
            <div class="container mx-auto px-4 py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- About -->
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="h-8 w-8 bg-primary rounded-full flex items-center justify-center">
                                <Building class="h-4 w-4 text-primary-foreground" />
                            </div>
                            <h3 class="font-semibold">Desa Kertayasa</h3>
                        </div>
                        <p class="text-sm text-muted-foreground mb-4">
                            Website resmi Pemerintah Desa Kertayasa, Kecamatan Kuningan, Kabupaten Kuningan, Provinsi
                            Jawa Barat.
                        </p>
                        <div class="flex space-x-2">
                            <Button variant="outline" size="sm">
                                <Facebook class="h-4 w-4" />
                            </Button>
                            <Button variant="outline" size="sm">
                                <Twitter class="h-4 w-4" />
                            </Button>
                            <Button variant="outline" size="sm">
                                <Instagram class="h-4 w-4" />
                            </Button>
                            <Button variant="outline" size="sm">
                                <Youtube class="h-4 w-4" />
                            </Button>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="font-semibold mb-4">Navigasi</h3>
                        <ul class="space-y-2 text-sm">
                            <li v-for="item in navigation" :key="item.name">
                                <router-link :to="item.to"
                                    class="text-muted-foreground hover:text-foreground transition-colors">
                                    {{ item.name }}
                                </router-link>
                            </li>
                        </ul>
                    </div>

                    <!-- Services -->
                    <div>
                        <h3 class="font-semibold mb-4">Layanan</h3>
                        <ul class="space-y-2 text-sm">
                            <li><router-link to="/layanan"
                                    class="text-muted-foreground hover:text-foreground transition-colors">Layanan
                                    Publik</router-link></li>
                            <li><router-link to="/pengaduan"
                                    class="text-muted-foreground hover:text-foreground transition-colors">Pengaduan
                                    Online</router-link></li>
                            <li><router-link to="/download"
                                    class="text-muted-foreground hover:text-foreground transition-colors">Unduhan</router-link>
                            </li>
                            <li><router-link to="/transparansi"
                                    class="text-muted-foreground hover:text-foreground transition-colors">Transparansi</router-link>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="font-semibold mb-4">Kontak</h3>
                        <ul class="space-y-2 text-sm text-muted-foreground">
                            <li class="flex items-start">
                                <MapPin class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0" />
                                <span>Jl. Raya Kertayasa No. 123<br>Kuningan, Jawa Barat 45511</span>
                            </li>
                            <li class="flex items-center">
                                <Phone class="h-4 w-4 mr-2 flex-shrink-0" />
                                <span>(0265) 123-4567</span>
                            </li>
                            <li class="flex items-center">
                                <Mail class="h-4 w-4 mr-2 flex-shrink-0" />
                                <span>info@desakertayasa.id</span>
                            </li>
                            <li class="flex items-center">
                                <Clock class="h-4 w-4 mr-2 flex-shrink-0" />
                                <span>Senin - Jumat: 08:00 - 16:00</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t mt-8 pt-8 text-center text-sm text-muted-foreground">
                    <p>&copy; {{ currentYear }} Pemerintah Desa Kertayasa. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </footer>

        <!-- Search Modal -->
        <Dialog v-model:open="searchOpen">
            <DialogContent class="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>Pencarian</DialogTitle>
                    <DialogDescription>
                        Cari informasi, berita, atau layanan di website ini
                    </DialogDescription>
                </DialogHeader>
                <div class="grid gap-4 py-4">
                    <div class="relative">
                        <Search class="absolute left-2 top-2.5 h-4 w-4 text-muted-foreground" />
                        <Input v-model="searchQuery" placeholder="Ketik kata kunci..." class="pl-8"
                            @keyup.enter="performSearch" />
                    </div>
                </div>
                <DialogFooter>
                    <Button type="button" variant="outline" @click="searchOpen = false">
                        Batal
                    </Button>
                    <Button type="button" @click="performSearch">
                        <Search class="h-4 w-4 mr-2" />
                        Cari
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useTheme } from '@/composables/useTheme'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import {
    Building, Phone, Mail, MapPin, Facebook, Twitter, Instagram, Youtube,
    Sun, Moon, Search, Menu, X, Home, ChevronRight, FileText, MessageSquare, Clock, Shield
} from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()
const { isDark, toggleTheme } = useTheme()

// Reactive data
const mobileMenuOpen = ref(false)
const searchOpen = ref(false)
const searchQuery = ref('')

// Navigation items
const navigation = [
    { name: 'Beranda', to: '/' },
    { name: 'Profil', to: '/profil' },
    { name: 'Berita', to: '/berita' },
    { name: 'Layanan', to: '/layanan' },
    { name: 'Transparansi', to: '/transparansi' },
    { name: 'Galeri', to: '/galeri' },
    { name: 'Kontak', to: '/kontak' },
]

// Computed properties
const isHomepage = computed(() => route.path === '/')
const showHero = computed(() => isHomepage.value)
const currentYear = computed(() => new Date().getFullYear())

// Breadcrumbs logic
const breadcrumbs = computed(() => {
    const path = route.path
    const segments = path.split('/').filter(Boolean)

    return segments.map((segment, index) => {
        const to = '/' + segments.slice(0, index + 1).join('/')
        const name = segment.charAt(0).toUpperCase() + segment.slice(1)
        return { name, to }
    })
})

// Methods
const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value
}

const openSearch = () => {
    searchOpen.value = true
}

const performSearch = () => {
    if (searchQuery.value.trim()) {
        router.push({ name: 'search', query: { q: searchQuery.value } })
        searchOpen.value = false
        searchQuery.value = ''
    }
}

// Close mobile menu when route changes
onMounted(() => {
    router.afterEach(() => {
        mobileMenuOpen.value = false
    })
})
</script>

<style scoped>
.bg-grid-white\/\[0\.05\] {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(255 255 255 / 0.05)'%3e%3cpath d='m0 .5 32 0'/%3e%3cpath d='m0 32.5 32 0'/%3e%3cpath d='m.5 0 0 32'/%3e%3cpath d='m32.5 0 0 32'/%3e%3c/svg%3e");
}
</style>
