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

            <!-- News Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <!-- Featured News -->
                <div v-for="(article, index) in latestNews" :key="article.id" class="group cursor-pointer"
                    :class="{ 'md:col-span-2 lg:col-span-1': index === 0 }" data-aos="fade-up"
                    :data-aos-delay="index * 100"
                    @click="$router.push({ name: 'news.show', params: { slug: article.slug } })">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group-hover:scale-105">
                        <!-- Image -->
                        <div class="relative overflow-hidden">
                            <img :src="article.featured_image || '/assets/images/placeholder-news.jpg'"
                                :alt="article.title"
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
                                {{ article.excerpt }}
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

// Sample data dari seeder (real data dari Desa Kertayasa)
const latestNews = ref([
    {
        id: 1,
        title: 'Program Digitalisasi Layanan Desa Kertayasa',
        slug: 'program-digitalisasi-layanan-desa-kertayasa',
        excerpt: 'Desa Kertayasa meluncurkan sistem informasi digital untuk mempermudah masyarakat dalam mengakses berbagai layanan administratif.',
        featured_image: '/assets/images/news/digitalisasi-desa.jpg',
        is_featured: true,
        view_count: 125,
        published_at: new Date(Date.now() - 24 * 60 * 60 * 1000), // 1 day ago
        tags: '["digitalisasi", "teknologi", "layanan-desa"]'
    },
    {
        id: 2,
        title: 'Peningkatan Infrastruktur Jalan Desa Tahun 2025',
        slug: 'peningkatan-infrastruktur-jalan-desa-tahun-2025',
        excerpt: 'Pembangunan dan perbaikan jalan desa sepanjang 2.5 KM untuk meningkatkan aksesibilitas dan mobilitas masyarakat.',
        featured_image: '/assets/images/news/pembangunan-jalan.jpg',
        is_featured: false,
        view_count: 89,
        published_at: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000), // 3 days ago
        tags: '["infrastruktur", "pembangunan", "jalan-desa"]'
    },
    {
        id: 3,
        title: 'Kegiatan Gotong Royong Bersih Desa',
        slug: 'kegiatan-gotong-royong-bersih-desa',
        excerpt: 'Seluruh warga Kertayasa berpartisipasi dalam kegiatan gotong royong membersihkan lingkungan desa.',
        featured_image: '/assets/images/news/gotong-royong.jpg',
        is_featured: false,
        view_count: 67,
        published_at: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000), // 5 days ago
        tags: '["gotong-royong", "kebersihan", "lingkungan"]'
    }
])

const formatDate = (date) => {
    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }).format(new Date(date))
}

const getTagsArray = (tags) => {
    try {
        return JSON.parse(tags).map(tag => tag.replace('-', ' '))
    } catch {
        return []
    }
}

onMounted(() => {
    // TODO: Fetch real data from API when available
    // fetchLatestNews()
})
</script>
