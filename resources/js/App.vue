<template>
    <div id="app" class="min-h-screen bg-background text-foreground">
        <!-- Theme Provider Wrapper -->
        <div class="theme-provider">
            <!-- Main Application -->
            <router-view />
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useTheme } from '@/composables/useTheme'

// Initialize theme system
const { initializeTheme } = useTheme()

onMounted(() => {
    initializeTheme()
})
</script>

<style>
/* Global styles will be handled by Tailwind CSS */
</style>
