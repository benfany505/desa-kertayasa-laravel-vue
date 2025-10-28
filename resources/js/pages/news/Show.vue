<template>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <Button @click="$router.push({ name: 'news.index' })" variant="outline" class="mb-6">
                ← Kembali ke Berita
            </Button>

            <!-- Coming Soon -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="text-center py-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Detail Berita
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Halaman ini akan segera tersedia setelah API setup selesai.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Button } from '@/components/ui/button'
</script>
