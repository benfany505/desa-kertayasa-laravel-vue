<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Navigation Bar -->
        <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo and Navigation -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <router-link to="/" class="flex items-center">
                                <img class="h-8 w-8" src="/logo.png" alt="Desa Kertayasa" />
                                <span class="ml-2 text-xl font-bold text-gray-900 dark:text-white">
                                    Admin Panel
                                </span>
                            </router-link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden md:ml-6 md:flex md:space-x-8">
                            <router-link to="/admin"
                                class="border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                                active-class="border-blue-500 text-gray-900 dark:text-white">
                                Dashboard
                            </router-link>

                            <router-link to="/admin/news"
                                class="border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                                active-class="border-blue-500 text-gray-900 dark:text-white">
                                Berita
                            </router-link>

                            <router-link to="/admin/pages"
                                class="border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                                active-class="border-blue-500 text-gray-900 dark:text-white">
                                Halaman
                            </router-link>

                            <router-link to="/admin/gallery"
                                class="border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                                active-class="border-blue-500 text-gray-900 dark:text-white">
                                Galeri
                            </router-link>

                            <!-- Super Admin Only -->
                            <router-link v-if="authStore.user?.role === 'super_admin'" to="/admin/migration"
                                class="border-transparent text-orange-500 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-200 hover:border-orange-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                                active-class="border-orange-500 text-orange-900 dark:text-orange-100">
                                Data Migration
                            </router-link>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center">
                        <!-- Theme Toggle -->
                        <button @click="toggleTheme"
                            class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg">
                            <Sun v-if="isDark" class="h-5 w-5" />
                            <Moon v-else class="h-5 w-5" />
                        </button>

                        <!-- User Dropdown -->
                        <div class="ml-4 relative">
                            <div class="flex items-center">
                                <button @click="showUserMenu = !showUserMenu"
                                    class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <div
                                        class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-medium">
                                        {{ authStore.user?.name?.charAt(0).toUpperCase() }}
                                    </div>
                                    <span class="ml-2 text-gray-700 dark:text-gray-200 hidden md:block">
                                        {{ authStore.user?.name }}
                                    </span>
                                    <ChevronDown class="ml-1 h-4 w-4 text-gray-400" />
                                </button>
                            </div>

                            <!-- Dropdown Menu -->
                            <div v-if="showUserMenu" @click.away="showUserMenu = false"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    <div
                                        class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600">
                                        <div class="font-medium">{{ authStore.user?.name }}</div>
                                        <div class="text-gray-500 dark:text-gray-400 capitalize">{{ authStore.user?.role
                                            }}</div>
                                    </div>

                                    <router-link to="/admin/profile"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                                        @click="showUserMenu = false">
                                        Profile
                                    </router-link>

                                    <button @click="logout"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        Logout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <router-view />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { Sun, Moon, ChevronDown } from 'lucide-vue-next'

const router = useRouter()
const authStore = useAuthStore()

const showUserMenu = ref(false)
const isDark = ref(false)

onMounted(() => {
    // Check initial theme
    isDark.value = document.documentElement.classList.contains('dark')

    // Close dropdown when clicking outside
    document.addEventListener('click', closeDropdown)
})

onUnmounted(() => {
    document.removeEventListener('click', closeDropdown)
})

const closeDropdown = (event) => {
    if (!event.target.closest('.relative')) {
        showUserMenu.value = false
    }
}

const toggleTheme = () => {
    isDark.value = !isDark.value
    if (isDark.value) {
        document.documentElement.classList.add('dark')
        localStorage.setItem('theme', 'dark')
    } else {
        document.documentElement.classList.remove('dark')
        localStorage.setItem('theme', 'light')
    }
}

const logout = async () => {
    try {
        await authStore.logout()
        router.push('/admin/login')
    } catch (error) {
        console.error('Logout failed:', error)
    }
}
</script>
