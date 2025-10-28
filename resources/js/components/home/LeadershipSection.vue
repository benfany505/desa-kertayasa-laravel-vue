<template>
    <section class="py-16 lg:py-24 bg-white dark:bg-slate-900">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Pimpinan Desa
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                    Kepemimpinan yang berkomitmen untuk memajukan Desa Kertayasa menuju visi MAJU
                </p>
            </div>

            <!-- Leadership Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto mb-12">
                <!-- Village Head -->
                <div class="group" data-aos="fade-right">
                    <div
                        class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-700 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 group-hover:scale-105">
                        <!-- Photo -->
                        <div class="flex justify-center mb-6">
                            <div class="relative">
                                <div
                                    class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 p-1 shadow-xl">
                                    <img :src="leadership.village_head.photo || '/assets/images/placeholder-avatar.jpg'"
                                        :alt="leadership.village_head.name"
                                        class="w-full h-full rounded-full object-cover bg-white" />
                                </div>
                                <!-- Badge -->
                                <div class="absolute -bottom-2 -right-2">
                                    <div class="bg-blue-600 text-white p-2 rounded-full shadow-lg">
                                        <Crown class="h-5 w-5" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">
                                {{ leadership.village_head.name }}
                            </h3>
                            <p class="text-blue-600 dark:text-blue-400 font-semibold mb-4">
                                Kepala Desa
                            </p>
                            <p class="text-slate-600 dark:text-slate-300 text-sm mb-6">
                                "Memimpin dengan dedikasi tinggi untuk mewujudkan Desa Kertayasa yang MAJU (Makmur,
                                Agamis dan Juara)"
                            </p>

                            <!-- Contact -->
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-center text-slate-600 dark:text-slate-400">
                                    <Phone class="h-4 w-4 mr-2" />
                                    {{ leadership.village_head.phone || '(0232) 8910588' }}
                                </div>
                                <div class="flex items-center justify-center text-slate-600 dark:text-slate-400">
                                    <Mail class="h-4 w-4 mr-2" />
                                    {{ leadership.village_head.email || 'kades@desakertayasa.id' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Village Secretary -->
                <div class="group" data-aos="fade-left">
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-slate-800 dark:to-slate-700 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 group-hover:scale-105">
                        <!-- Photo -->
                        <div class="flex justify-center mb-6">
                            <div class="relative">
                                <div
                                    class="w-32 h-32 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 p-1 shadow-xl">
                                    <img :src="leadership.village_secretary.photo || '/assets/images/placeholder-avatar.jpg'"
                                        :alt="leadership.village_secretary.name"
                                        class="w-full h-full rounded-full object-cover bg-white" />
                                </div>
                                <!-- Badge -->
                                <div class="absolute -bottom-2 -right-2">
                                    <div class="bg-green-600 text-white p-2 rounded-full shadow-lg">
                                        <FileText class="h-5 w-5" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">
                                {{ leadership.village_secretary.name }}
                            </h3>
                            <p class="text-green-600 dark:text-green-400 font-semibold mb-4">
                                Sekretaris Desa
                            </p>
                            <p class="text-slate-600 dark:text-slate-300 text-sm mb-6">
                                "Berkomitmen mendukung administrasi dan tata kelola pemerintahan desa yang profesional"
                            </p>

                            <!-- Contact -->
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-center text-slate-600 dark:text-slate-400">
                                    <Phone class="h-4 w-4 mr-2" />
                                    {{ leadership.village_secretary.phone || '(0232) 8910588' }}
                                </div>
                                <div class="flex items-center justify-center text-slate-600 dark:text-slate-400">
                                    <Mail class="h-4 w-4 mr-2" />
                                    {{ leadership.village_secretary.email || 'sekdes@desakertayasa.id' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vision Mission -->
            <div class="max-w-4xl mx-auto" data-aos="fade-up">
                <div
                    class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-800 dark:to-slate-700 rounded-3xl p-8 lg:p-12">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Vision -->
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center mr-4">
                                    <Target class="h-6 w-6 text-white" />
                                </div>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Visi</h3>
                            </div>
                            <p class="text-slate-700 dark:text-slate-300 leading-relaxed">
                                {{ visionMission.vision }}
                            </p>
                        </div>

                        <!-- Mission -->
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-green-600 rounded-2xl flex items-center justify-center mr-4">
                                    <Compass class="h-6 w-6 text-white" />
                                </div>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Misi</h3>
                            </div>
                            <ul class="space-y-3">
                                <li v-for="(mission, index) in visionMission.missions" :key="index"
                                    class="flex items-start text-slate-700 dark:text-slate-300">
                                    <CheckCircle class="h-5 w-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" />
                                    <span class="text-sm leading-relaxed">{{ mission }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue'
import { Crown, FileText, Phone, Mail, Target, Compass, CheckCircle } from 'lucide-vue-next'

// Real data dari seeder VillageSettingsSeeder
const leadership = ref({
    village_head: {
        name: 'ARIEF AMARUDIN S.Sos.I',
        photo: null, // Will be populated when API is ready
        phone: '(0232) 8910588',
        email: 'kades@desakertayasa.id'
    },
    village_secretary: {
        name: 'OPA SAPARUDIMAN',
        photo: null, // Will be populated when API is ready
        phone: '(0232) 8910588',
        email: 'sekdes@desakertayasa.id'
    }
})

const visionMission = ref({
    vision: 'Menjadi Desa Kertayasa MAJU (Makmur, Agamis dan Juara) berbasis Potensi Desa pada tahun 2025',
    missions: [
        'Memperkuat Kualitas Pembinaan Sumber Daya Manusia yang Cerdas Secara Intelektual, Emosional dan Spiritual.',
        'Memaksimalkan Potensi Sumber Daya Manusia dan Sumber Daya Alam sebagai Peluang Dunia Usaha dan Produktivitas Ekonomi masyarakat yang Ramah Lingkungan',
        'Mewujudkan tata kelola pemerintahan Desa yang inovatif, kreatif dan Memudahkan.',
        'Melakukan sinergitas program dengan pemerintah maupun swasta dalam rangka penguatan ketercapaian program Desa',
        'Memperkuat Pembinaan Potensi Masyarakat dalam Bidang Pendidikan, Olahraga, Kebudayaan dan Kesenian.',
        'Turut berkompetisi dalam membangun jejaring, bersama pemerintah daerah dan pusat untuk kemajuan desa.'
    ]
})
</script>
