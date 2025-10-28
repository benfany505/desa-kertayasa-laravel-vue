<template>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Profile Admin
            </h1>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <!-- Profile Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Informasi Profile
                </h2>

                <form @submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Lengkap
                        </label>
                        <Input v-model="profileForm.name" type="text" required :disabled="isLoading" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Email
                        </label>
                        <Input v-model="profileForm.email" type="email" required :disabled="isLoading" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            No. Telepon
                        </label>
                        <Input v-model="profileForm.phone" type="tel" :disabled="isLoading" />
                    </div>

                    <Button type="submit" :disabled="isLoading" class="w-full">
                        {{ isLoading ? 'Menyimpan...' : 'Update Profile' }}
                    </Button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Ubah Password
                </h2>

                <form @submit.prevent="changePassword" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Password Lama
                        </label>
                        <Input v-model="passwordForm.current_password" type="password" required :disabled="isLoading" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Password Baru
                        </label>
                        <Input v-model="passwordForm.password" type="password" required :disabled="isLoading" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Konfirmasi Password Baru
                        </label>
                        <Input v-model="passwordForm.password_confirmation" type="password" required
                            :disabled="isLoading" />
                    </div>

                    <Button type="submit" :disabled="isLoading" class="w-full">
                        {{ isLoading ? 'Mengubah...' : 'Ubah Password' }}
                    </Button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { useToast } from '@/components/ui/toast'

const authStore = useAuthStore()
const { toast } = useToast()
const isLoading = ref(false)

// Profile form
const profileForm = reactive({
    name: '',
    email: '',
    phone: '',
})

// Password form
const passwordForm = reactive({
    current_password: '',
    password: '',
    password_confirmation: '',
})

// Initialize profile data
onMounted(() => {
    if (authStore.user) {
        profileForm.name = authStore.user.name || ''
        profileForm.email = authStore.user.email || ''
        profileForm.phone = authStore.user.phone || ''
    }
})

// Update profile
const updateProfile = async () => {
    try {
        isLoading.value = true
        await authStore.updateProfile(profileForm)

        toast({
            title: 'Berhasil',
            description: 'Profile berhasil diperbarui',
        })
    } catch (error) {
        toast({
            title: 'Error',
            description: error.response?.data?.message || 'Gagal memperbarui profile',
            variant: 'destructive',
        })
    } finally {
        isLoading.value = false
    }
}

// Change password
const changePassword = async () => {
    if (passwordForm.password !== passwordForm.password_confirmation) {
        toast({
            title: 'Error',
            description: 'Konfirmasi password tidak sesuai',
            variant: 'destructive',
        })
        return
    }

    try {
        isLoading.value = true
        await authStore.changePassword(passwordForm)

        // Reset form
        Object.keys(passwordForm).forEach(key => {
            passwordForm[key] = ''
        })

        toast({
            title: 'Berhasil',
            description: 'Password berhasil diubah',
        })
    } catch (error) {
        toast({
            title: 'Error',
            description: error.response?.data?.message || 'Gagal mengubah password',
            variant: 'destructive',
        })
    } finally {
        isLoading.value = false
    }
}
</script>
