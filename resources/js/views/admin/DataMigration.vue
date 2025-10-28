<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4 py-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Data Migration Center
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Import data dari website lama (etnproje_kertayasa.sql) ke sistem baru
                </p>
            </div>

            <!-- Migration Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div v-for="(count, table) in migrationStatus" :key="table"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 capitalize">
                        {{ table.replace('_', ' ') }}
                    </h3>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                        {{ count }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        records
                    </p>
                </div>
            </div>

            <!-- SQL File Status -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    SQL File Status
                </h3>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div :class="sqlFileExists ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                            class="px-3 py-1 rounded-full text-sm font-medium">
                            {{ sqlFileExists ? 'File Found' : 'File Not Found' }}
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        {{ sqlFilePath }}
                    </p>
                </div>
            </div>

            <!-- Migration Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Import Data -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        Import Data
                    </h3>

                    <div class="space-y-4">
                        <!-- Import News -->
                        <div
                            class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white">News Articles</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Import berita dari tabel 'berita'
                                </p>
                            </div>
                            <Button @click="importNews" :disabled="loading.news" class="bg-blue-600 hover:bg-blue-700">
                                <Loader2 v-if="loading.news" class="w-4 h-4 mr-2 animate-spin" />
                                Import News
                            </Button>
                        </div>

                        <!-- Import APBD -->
                        <div
                            class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white">APBD Data</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Import data APBD dari tabel 'apbdes'
                                </p>
                            </div>
                            <Button @click="importApbd" :disabled="loading.apbd"
                                class="bg-green-600 hover:bg-green-700">
                                <Loader2 v-if="loading.apbd" class="w-4 h-4 mr-2 animate-spin" />
                                Import APBD
                            </Button>
                        </div>
                    </div>
                </div>

                <!-- Clear Data -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        Clear Data
                    </h3>

                    <div class="space-y-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Hapus semua data untuk testing migration ulang
                        </p>

                        <div class="space-y-2">
                            <label
                                v-for="table in ['news', 'pages', 'gallery_categories', 'gallery_items', 'apbd', 'agendas']"
                                :key="table" class="flex items-center">
                                <input type="checkbox" v-model="selectedTables" :value="table"
                                    class="rounded border-gray-300 dark:border-gray-600">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 capitalize">
                                    {{ table.replace('_', ' ') }}
                                </span>
                            </label>
                        </div>

                        <Button @click="clearData" :disabled="loading.clear || selectedTables.length === 0"
                            variant="destructive">
                            <Loader2 v-if="loading.clear" class="w-4 h-4 mr-2 animate-spin" />
                            Clear Selected Data
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Migration Log -->
            <div v-if="migrationLog.length > 0" class="mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        Migration Log
                    </h3>
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        <div v-for="(log, index) in migrationLog" :key="index"
                            :class="log.type === 'error' ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400'"
                            class="text-sm font-mono p-2 bg-gray-50 dark:bg-gray-700 rounded">
                            [{{ log.timestamp }}] {{ log.message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { Button } from '@/components/ui/button'
import { Loader2 } from 'lucide-vue-next'

const router = useRouter()
const authStore = useAuthStore()

// Reactive data
const migrationStatus = ref({})
const sqlFileExists = ref(false)
const sqlFilePath = ref('')
const selectedTables = ref([])
const migrationLog = ref([])

const loading = ref({
    status: false,
    news: false,
    apbd: false,
    clear: false
})

// Check if user is super admin
onMounted(async () => {
    if (!authStore.user || authStore.user.role !== 'super_admin') {
        router.push('/admin/dashboard')
        return
    }

    await getStatus()
})

const getStatus = async () => {
    loading.value.status = true
    try {
        const response = await fetch('/api/migration/status', {
            headers: {
                'Authorization': `Bearer ${authStore.token}`,
                'Content-Type': 'application/json'
            }
        })

        const data = await response.json()

        if (data.success) {
            migrationStatus.value = data.status
            sqlFileExists.value = data.sql_file_exists
            sqlFilePath.value = data.sql_file_path
        } else {
            addLog('error', data.message || 'Failed to get migration status')
        }
    } catch (error) {
        addLog('error', `Status check failed: ${error.message}`)
    } finally {
        loading.value.status = false
    }
}

const importNews = async () => {
    loading.value.news = true
    try {
        const response = await fetch('/api/migration/import-news', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${authStore.token}`,
                'Content-Type': 'application/json'
            }
        })

        const data = await response.json()

        if (data.success) {
            addLog('success', data.message)
            await getStatus() // Refresh status
        } else {
            addLog('error', data.message || 'Failed to import news')
        }
    } catch (error) {
        addLog('error', `News import failed: ${error.message}`)
    } finally {
        loading.value.news = false
    }
}

const importApbd = async () => {
    loading.value.apbd = true
    try {
        const response = await fetch('/api/migration/import-apbd', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${authStore.token}`,
                'Content-Type': 'application/json'
            }
        })

        const data = await response.json()

        if (data.success) {
            addLog('success', data.message)
            await getStatus() // Refresh status
        } else {
            addLog('error', data.message || 'Failed to import APBD')
        }
    } catch (error) {
        addLog('error', `APBD import failed: ${error.message}`)
    } finally {
        loading.value.apbd = false
    }
}

const clearData = async () => {
    if (!confirm('Are you sure you want to clear the selected data? This action cannot be undone.')) {
        return
    }

    loading.value.clear = true
    try {
        const response = await fetch('/api/migration/clear-data', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${authStore.token}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                tables: selectedTables.value
            })
        })

        const data = await response.json()

        if (data.success) {
            addLog('success', data.message)
            selectedTables.value = []
            await getStatus() // Refresh status
        } else {
            addLog('error', data.message || 'Failed to clear data')
        }
    } catch (error) {
        addLog('error', `Clear data failed: ${error.message}`)
    } finally {
        loading.value.clear = false
    }
}

const addLog = (type, message) => {
    migrationLog.value.unshift({
        type,
        message,
        timestamp: new Date().toLocaleTimeString()
    })

    // Keep only last 50 logs
    if (migrationLog.value.length > 50) {
        migrationLog.value = migrationLog.value.slice(0, 50)
    }
}
</script>
