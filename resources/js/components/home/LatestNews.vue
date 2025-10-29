<template>
    <section class="py-16 lg:py-24 bg-white dark:bg-slate-900">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Berita Terkini
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                    Informasi terbaru seputar kegiatan dan perkembangan Desa Kertayasa
                </p>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <div v-for="i in 6" :key="i" class="animate-pulse">
                    <div class="bg-slate-200 dark:bg-slate-700 rounded-2xl h-64"></div>
                </div>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="text-center py-8">
                <p class="text-red-600 dark:text-red-400">{{ error }}</p>
                <button @click="fetchLatestNews"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Coba Lagi
                </button>
            </div>

            <!-- News Grid -->
            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <!-- Featured News -->
                <div v-for="(article, index) in latestNews" :key="article.id" class="group cursor-pointer"
                    :class="{ 'md:col-span-2 lg:col-span-1': index === 0 }" data-aos="fade-up"
                    :data-aos-delay="index * 100"
                    @click="$router.push({ name: 'news.show', params: { slug: article.slug } })">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group-hover:scale-105">
                        <!-- Image -->
                        <div class="relative overflow-hidden">
                            <img :src="getImageUrl(article.featured_image)" :alt="article.title"
                                class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                            </div>

                            <!-- Featured Badge -->
                            <div v-if="article.is_featured" class="absolute top-4 left-4">
                                <Badge class="bg-red-500 text-white">
                                    <Star class="h-3 w-3 mr-1" />
                                    Unggulan
                                </Badge>
                            </div>

                            <!-- Date -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <div class="flex items-center text-sm">
                                    <Calendar class="h-4 w-4 mr-1" />
                                    {{ formatDate(article.published_at) }}
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3
                                class="text-xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                {{ article.title }}
                            </h3>

                            <p class="text-slate-600 dark:text-slate-300 mb-4 line-clamp-3">
                                {{ cleanExcerpt(article.content) }}
                            </p>

                            <!-- Tags -->
                            <div class="flex flex-wrap gap-2 mb-4" v-if="article.tags">
                                <Badge v-for="tag in getTagsArray(article.tags)" :key="tag" variant="secondary"
                                    class="text-xs">
                                    {{ tag }}
                                </Badge>
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                                    <Eye class="h-4 w-4 mr-1" />
                                    {{ article.view_count || 0 }} views
                                </div>

                                <div
                                    class="flex items-center text-blue-600 dark:text-blue-400 font-medium group-hover:translate-x-1 transition-transform">
                                    Baca Selengkapnya
                                    <ArrowRight class="h-4 w-4 ml-1" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center" data-aos="fade-up">
                <router-link :to="{ name: 'news.index' }">
                    <Button size="lg" variant="outline" class="group">
                        Lihat Semua Berita
                        <ArrowRight class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </Button>
                </router-link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Calendar, Star, Eye, ArrowRight } from 'lucide-vue-next'

// News data from API
const latestNews = ref([])
const loading = ref(true)
const error = ref(null)

// Fetch latest news from API
const fetchLatestNews = async () => {
    try {
        loading.value = true
        const response = await fetch('/api/news/latest')
        const result = await response.json()

        if (result.success) {
            latestNews.value = result.data
        } else {
            error.value = 'Failed to load news'
        }
    } catch (err) {
        error.value = 'Network error while loading news'
        console.error('Error fetching news:', err)
    } finally {
        loading.value = false
    }
}

const formatDate = (date) => {
    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }).format(new Date(date))
}

const getTagsArray = (tags) => {
    try {
        return Array.isArray(tags) ? tags : JSON.parse(tags).map(tag => tag.replace('-', ' '))
    } catch {
        return []
    }
}

const getImageUrl = (imageName) => {
    if (!imageName) {
        return '/storage/assets/image/placeholder-news.jpg'
    }
    return `/storage/assets/image/berita/${imageName}`
}

const cleanExcerpt = (htmlContent, maxLength = 120) => {
    if (!htmlContent) return ''

    let cleanText = htmlContent

    // First decode HTML entities
    cleanText = cleanText
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>')
        .replace(/&quot;/g, '"')
        .replace(/&#039;/g, "'")
        .replace(/&amp;/g, '&')
        .replace(/&nbsp;/g, ' ')

    // Remove common escape characters
    cleanText = cleanText
        .replace(/\\r\\n/g, ' ')
        .replace(/\\n/g, ' ')
        .replace(/\\r/g, ' ')
        .replace(/\r\n/g, ' ')
        .replace(/\n/g, ' ')
        .replace(/\r/g, ' ')

    // Create a temporary div to parse remaining HTML
    const tempDiv = document.createElement('div')
    tempDiv.innerHTML = cleanText

    // Get text content only (removes all HTML tags)
    let textContent = tempDiv.textContent || tempDiv.innerText || ''

    // Remove extra whitespace and normalize spaces
    textContent = textContent
        .replace(/\s+/g, ' ')
        .replace(/^\s+|\s+$/g, '')
        .trim()

    // Truncate to maxLength with ellipsis
    if (textContent.length > maxLength) {
        textContent = textContent.substring(0, maxLength).trim() + '...'
    }

    return textContent
}

onMounted(() => {
    fetchLatestNews()
})
</script>
