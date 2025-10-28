<template>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Manajemen Galeri
            </h1>
            <Button @click="$router.push({ name: 'admin.gallery.create' })">
                Tambah Galeri
            </Button>
        </div>

        <!-- Coming Soon -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="text-center py-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    Manajemen Galeri
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Halaman ini akan segera tersedia setelah API setup selesai.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Button } from '@/components/ui/button'
</script>
