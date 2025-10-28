<template>
    <section
        class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 dark:from-slate-950 dark:via-blue-950 dark:to-slate-900">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:60px_60px] opacity-20"></div>

        <!-- Main Content -->
        <div class="relative container mx-auto px-4 py-20 lg:py-28">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Left Content -->
                <div class="flex-1 text-center lg:text-left" data-aos="fade-right">
                    <!-- Badge -->
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm font-medium mb-6">
                        <Sparkles class="h-4 w-4 mr-2" />
                        SIMAK - Sistem Informasi Masyarakat Kertayasa
                    </div>

                    <!-- Main Heading -->
                    <h1 class="text-4xl lg:text-6xl font-bold text-white leading-tight mb-6">
                        Selamat Datang di
                        <span class="block bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent">
                            Desa Kertayasa
                        </span>
                    </h1>

                    <!-- Tagline -->
                    <p class="text-xl lg:text-2xl text-blue-100 font-medium mb-4">
                        {{ settings.village_tagline || 'Masyarakat Panuju Kertayasa Maju' }}
                    </p>

                    <!-- Description -->
                    <p class="text-lg text-white/80 mb-8 max-w-2xl mx-auto lg:mx-0">
                        {{ fullDescription }}
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <router-link :to="{ name: 'services.index' }">
                            <Button size="lg" :class="primaryButtonClass">
                                <FileText class="h-5 w-5 mr-2 group-hover:scale-110 transition-transform" />
                                Layanan Publik
                                <ArrowRight class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform" />
                            </Button>
                        </router-link>

                        <router-link :to="{ name: 'complaints.create' }">
                            <Button size="lg" variant="outline" :class="outlineButtonClass">
                                <MessageSquare class="h-5 w-5 mr-2 group-hover:scale-110 transition-transform" />
                                Pengaduan Online
                            </Button>
                        </router-link>
                    </div>
                </div>

                <!-- Right Content - Statistics Cards -->
                <div class="flex-1 lg:max-w-md" data-aos="fade-left">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Population Card -->
                        <div
                            class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300 group">
                            <div class="flex items-center justify-between mb-3">
                                <Users class="h-8 w-8 text-blue-300 group-hover:scale-110 transition-transform" />
                                <TrendingUp class="h-5 w-5 text-green-400" />
                            </div>
                            <div class="text-3xl font-bold text-white mb-1">
                                {{ formatNumber(settings.total_population || '8,420') }}
                            </div>
                            <div class="text-sm text-blue-100">Penduduk</div>
                        </div>

                        <!-- Families Card -->
                        <div
                            class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300 group">
                            <div class="flex items-center justify-between mb-3">
                                <Home class="h-8 w-8 text-cyan-300 group-hover:scale-110 transition-transform" />
                                <TrendingUp class="h-5 w-5 text-green-400" />
                            </div>
                            <div class="text-3xl font-bold text-white mb-1">
                                {{ formatNumber(settings.total_families || '2,431') }}
                            </div>
                            <div class="text-sm text-blue-100">Keluarga</div>
                        </div>

                        <!-- Area Card -->
                        <div
                            class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300 group">
                            <div class="flex items-center justify-between mb-3">
                                <MapPin class="h-8 w-8 text-green-300 group-hover:scale-110 transition-transform" />
                                <Mountain class="h-5 w-5 text-blue-400" />
                            </div>
                            <div class="text-3xl font-bold text-white mb-1">
                                {{ settings.village_area || '12.5' }}
                            </div>
                            <div class="text-sm text-blue-100">KM² Luas</div>
                        </div>

                        <!-- Hamlets Card -->
                        <div
                            class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300 group">
                            <div class="flex items-center justify-between mb-3">
                                <Building2 class="h-8 w-8 text-purple-300 group-hover:scale-110 transition-transform" />
                                <Grid3x3 class="h-5 w-5 text-indigo-400" />
                            </div>
                            <div class="text-3xl font-bold text-white mb-1">
                                {{ settings.total_hamlets || '6' }}
                            </div>
                            <div class="text-sm text-blue-100">Dusun</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Animation Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-blue-400/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-40 right-20 w-32 h-32 bg-cyan-400/10 rounded-full blur-xl animate-pulse delay-1000">
        </div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-purple-400/10 rounded-full blur-xl animate-pulse delay-500">
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Button } from '@/components/ui/button'
import {
    FileText, MessageSquare, ArrowRight, Users, Home, MapPin, Building2,
    TrendingUp, Mountain, Grid3x3, Sparkles
} from 'lucide-vue-next'

// Real data dari seeder
const settings = ref({
    village_tagline: 'Masyarakat Panuju Kertayasa Maju',
    village_district: 'Sindangagung',
    village_regency: 'Kuningan',
    village_province: 'Jawa Barat',
    total_population: '8420',
    total_families: '2431',
    village_area: '12.5',
    total_hamlets: '6'
})

const formatNumber = (num) => {
    if (typeof num === 'string' && num.includes(',')) return num
    return new Intl.NumberFormat('id-ID').format(num)
}

// Computed properties untuk mencegah formatter memecah strings
const fullDescription = computed(() => {
    const district = settings.value.village_district || 'Sindangagung'
    const regency = settings.value.village_regency || 'Kuningan'
    const province = settings.value.village_province || 'Jawa Barat'

    return `Portal informasi dan layanan digital untuk masyarakat Desa Kertayasa, Kecamatan ${district}, Kabupaten ${regency}, ${province}`
})

const primaryButtonClass = computed(() =>
    'group bg-white dark:bg-slate-100 text-slate-900 dark:text-slate-900 hover:bg-white/90 dark:hover:bg-slate-200 shadow-xl hover:shadow-2xl transition-all duration-300'
)

const outlineButtonClass = computed(() =>
    'group border-white/30 dark:border-slate-300/50 text-white dark:text-slate-100 hover:bg-white/10 dark:hover:bg-slate-700/50 hover:border-white/50 dark:hover:border-slate-300/70 backdrop-blur-sm'
)

onMounted(() => {
    // TODO: Fetch real data from API when available
    // fetchVillageSettings()
})
</script>
