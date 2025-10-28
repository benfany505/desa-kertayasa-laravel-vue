<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <h1 class="text-6xl font-bold text-red-500 mb-4">500</h1>
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">
                    Server Error
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Terjadi kesalahan pada server. Silakan coba lagi nanti.
                </p>
            </div>

            <div class="space-y-4">
                <Button @click="$router.go(-1)" variant="outline" class="w-full">
                    Kembali ke Halaman Sebelumnya
                </Button>

                <Button @click="$router.push('/')" class="w-full">
                    Kembali ke Beranda
                </Button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Button } from '@/components/ui/button'
</script>
