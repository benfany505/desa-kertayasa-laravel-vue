<template>
    <section class="py-16 lg:py-24 bg-slate-50 dark:bg-slate-800">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Layanan Digital
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                    Nikmati kemudahan mengakses layanan pemerintah desa secara online, kapan saja dan dimana saja
                </p>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="(service, index) in services" :key="service.id" class="group cursor-pointer"
                    data-aos="fade-up" :data-aos-delay="index * 100" @click="handleServiceClick(service)">
                    <div
                        class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 group-hover:scale-105 group-hover:-translate-y-2">
                        <!-- Icon -->
                        <div class="flex items-center justify-center w-16 h-16 rounded-2xl mb-6 group-hover:scale-110 transition-transform duration-300"
                            :class="service.bgColor">
                            <component :is="service.icon" :class="`h-8 w-8 ${service.iconColor}`" />
                        </div>

                        <!-- Content -->
                        <h3
                            class="text-xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ service.name }}
                        </h3>

                        <p class="text-slate-600 dark:text-slate-300 mb-6 line-clamp-3">
                            {{ service.description }}
                        </p>

                        <!-- Requirements -->
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Persyaratan:</h4>
                            <ul class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                                <li v-for="req in service.requirements.slice(0, 2)" :key="req" class="flex items-start">
                                    <CheckCircle class="h-4 w-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" />
                                    {{ req }}
                                </li>
                                <li v-if="service.requirements.length > 2"
                                    class="text-blue-600 dark:text-blue-400 font-medium">
                                    +{{ service.requirements.length - 2 }} persyaratan lainnya
                                </li>
                            </ul>
                        </div>

                        <!-- Action -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                                <Clock class="h-4 w-4 mr-1" />
                                {{ service.processTime }}
                            </div>

                            <div
                                class="flex items-center text-blue-600 dark:text-blue-400 font-medium group-hover:translate-x-1 transition-transform">
                                Ajukan
                                <ArrowRight class="h-4 w-4 ml-1" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12" data-aos="fade-up">
                <router-link :to="{ name: 'services.index' }">
                    <Button size="lg" class="group">
                        Lihat Semua Layanan
                        <ArrowRight class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </Button>
                </router-link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { Button } from '@/components/ui/button'
import {
    FileText, Users, Home, CreditCard, Baby, Heart,
    CheckCircle, Clock, ArrowRight
} from 'lucide-vue-next'

const router = useRouter()

// Real services data sesuai dengan layanan desa pada umumnya
const services = ref([
    {
        id: 1,
        name: 'Surat Keterangan Domisili',
        description: 'Pengurusan surat keterangan domisili untuk berbagai keperluan administrasi.',
        icon: FileText,
        bgColor: 'bg-blue-100 dark:bg-blue-900/30',
        iconColor: 'text-blue-600 dark:text-blue-400',
        requirements: [
            'KTP asli dan fotocopy',
            'Kartu Keluarga asli dan fotocopy',
            'Surat pengantar RT/RW'
        ],
        processTime: '1-2 hari kerja'
    },
    {
        id: 2,
        name: 'Surat Keterangan Usaha',
        description: 'Surat keterangan untuk usaha kecil dan menengah yang berada di wilayah desa.',
        icon: CreditCard,
        bgColor: 'bg-green-100 dark:bg-green-900/30',
        iconColor: 'text-green-600 dark:text-green-400',
        requirements: [
            'KTP asli dan fotocopy',
            'Surat keterangan domisili usaha',
            'Foto lokasi usaha'
        ],
        processTime: '2-3 hari kerja'
    },
    {
        id: 3,
        name: 'Surat Keterangan Tidak Mampu',
        description: 'Surat keterangan untuk masyarakat kurang mampu untuk berbagai program bantuan.',
        icon: Heart,
        bgColor: 'bg-red-100 dark:bg-red-900/30',
        iconColor: 'text-red-600 dark:text-red-400',
        requirements: [
            'KTP asli dan fotocopy',
            'Kartu Keluarga asli dan fotocopy',
            'Surat pengantar RT/RW',
            'Surat keterangan penghasilan'
        ],
        processTime: '1-2 hari kerja'
    },
    {
        id: 4,
        name: 'Surat Keterangan Kelahiran',
        description: 'Pengurusan surat keterangan kelahiran untuk proses pembuatan akta kelahiran.',
        icon: Baby,
        bgColor: 'bg-purple-100 dark:bg-purple-900/30',
        iconColor: 'text-purple-600 dark:text-purple-400',
        requirements: [
            'Surat keterangan lahir dari bidan/dokter',
            'KTP kedua orang tua',
            'Kartu Keluarga asli dan fotocopy',
            'Buku nikah asli dan fotocopy'
        ],
        processTime: '1 hari kerja'
    },
    {
        id: 5,
        name: 'Surat Pindah Penduduk',
        description: 'Layanan untuk penduduk yang akan pindah alamat ke luar wilayah desa.',
        icon: Home,
        bgColor: 'bg-yellow-100 dark:bg-yellow-900/30',
        iconColor: 'text-yellow-600 dark:text-yellow-400',
        requirements: [
            'KTP asli yang akan pindah',
            'Kartu Keluarga asli dan fotocopy',
            'Surat pengantar RT/RW',
            'Surat keterangan pindah dari kelurahan tujuan'
        ],
        processTime: '2-3 hari kerja'
    },
    {
        id: 6,
        name: 'Legalisir Dokumen',
        description: 'Layanan legalisir dokumen-dokumen penting untuk berbagai keperluan.',
        icon: Users,
        bgColor: 'bg-indigo-100 dark:bg-indigo-900/30',
        iconColor: 'text-indigo-600 dark:text-indigo-400',
        requirements: [
            'Dokumen asli yang akan dilegalisir',
            'KTP pemohon',
            'Fotocopy dokumen'
        ],
        processTime: '1 hari kerja'
    }
])

const handleServiceClick = (service) => {
    // For now, redirect to services page
    // Later this can open a modal or direct application form
    router.push({ name: 'services.index' })
}
</script>
