<template>
    <section class="py-16 lg:py-24 bg-slate-50 dark:bg-slate-800">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Hubungi Kami
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                    Kami siap melayani dan membantu masyarakat Desa Kertayasa
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Info -->
                <div class="space-y-8" data-aos="fade-right">
                    <!-- Address -->
                    <div class="group">
                        <div
                            class="flex items-start space-x-4 p-6 bg-white dark:bg-slate-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <MapPin class="h-7 w-7 text-blue-600 dark:text-blue-400" />
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Alamat</h3>
                                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                                    {{ contact.address }}<br>
                                    Kecamatan {{ contact.district }}, Kabupaten {{ contact.regency }}<br>
                                    {{ contact.province }} {{ contact.postal_code }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="group">
                        <div
                            class="flex items-start space-x-4 p-6 bg-white dark:bg-slate-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <Phone class="h-7 w-7 text-green-600 dark:text-green-400" />
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Telepon</h3>
                                <p class="text-slate-600 dark:text-slate-300">{{ contact.phone }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Senin - Jumat: 08:00 - 16:00
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="group">
                        <div
                            class="flex items-start space-x-4 p-6 bg-white dark:bg-slate-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <Mail class="h-7 w-7 text-purple-600 dark:text-purple-400" />
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Email</h3>
                                <p class="text-slate-600 dark:text-slate-300">{{ contact.email }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Respon dalam 1x24 jam</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="group">
                        <div
                            class="p-6 bg-white dark:bg-slate-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Media Sosial</h3>
                            <div class="flex space-x-4">
                                <a :href="contact.social.facebook"
                                    class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                                    <Facebook class="h-6 w-6" />
                                </a>
                                <a :href="contact.social.instagram"
                                    class="w-12 h-12 bg-pink-600 rounded-xl flex items-center justify-center text-white hover:bg-pink-700 transition-colors">
                                    <Instagram class="h-6 w-6" />
                                </a>
                                <a :href="contact.social.youtube"
                                    class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center text-white hover:bg-red-700 transition-colors">
                                    <Youtube class="h-6 w-6" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Contact Form -->
                <div data-aos="fade-left">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-xl">
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Kirim Pesan</h3>

                        <form @submit.prevent="submitMessage" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <Input v-model="messageForm.name" placeholder="Nama Lengkap" required
                                        class="h-12" />
                                </div>
                                <div>
                                    <Input v-model="messageForm.email" type="email" placeholder="Email" required
                                        class="h-12" />
                                </div>
                            </div>

                            <div>
                                <Input v-model="messageForm.subject" placeholder="Subjek" required class="h-12" />
                            </div>

                            <div>
                                <textarea v-model="messageForm.message" placeholder="Pesan Anda" required rows="5"
                                    class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400"></textarea>
                            </div>

                            <Button type="submit" size="lg" class="w-full group" :disabled="isSubmitting">
                                <Send class="h-5 w-5 mr-2 group-hover:translate-x-1 transition-transform" />
                                {{ isSubmitting ? 'Mengirim...' : 'Kirim Pesan' }}
                            </Button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { MapPin, Phone, Mail, Send, Facebook, Instagram, Youtube } from 'lucide-vue-next'

// Real contact data dari seeder
const contact = ref({
    address: 'Jl. Desa Kertayasa',
    district: 'Sindangagung',
    regency: 'Kuningan',
    province: 'Jawa Barat',
    postal_code: '45573',
    phone: '(0232) 8910588',
    email: 'admin@desakertayasa.id',
    social: {
        facebook: 'https://facebook.com/desakertayasa',
        instagram: 'https://instagram.com/desakertayasa',
        youtube: 'https://youtube.com/@desakertayasa'
    }
})

const messageForm = reactive({
    name: '',
    email: '',
    subject: '',
    message: ''
})

const isSubmitting = ref(false)

const submitMessage = async () => {
    isSubmitting.value = true

    try {
        // TODO: Submit to API when available
        console.log('Message submitted:', messageForm)

        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000))

        // Reset form
        Object.keys(messageForm).forEach(key => {
            messageForm[key] = ''
        })

        // Show success message (implement toast later)
        alert('Pesan berhasil dikirim! Terima kasih.')

    } catch (error) {
        console.error('Error submitting message:', error)
        alert('Gagal mengirim pesan. Silakan coba lagi.')
    } finally {
        isSubmitting.value = false
    }
}
</script>
