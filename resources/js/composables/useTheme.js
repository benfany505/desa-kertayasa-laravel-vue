import { ref, computed, watchEffect } from 'vue'

const isDark = ref(false)
const systemPreference = ref('light')

export function useTheme() {
  // Get system preference
  const getSystemPreference = () => {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
  }

  // Initialize theme
  const initializeTheme = () => {
    systemPreference.value = getSystemPreference()

    // Get stored preference or use system preference
    const stored = localStorage.getItem('theme')
    if (stored) {
      isDark.value = stored === 'dark'
    } else {
      isDark.value = systemPreference.value === 'dark'
    }

    // Listen for system changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
      systemPreference.value = e.matches ? 'dark' : 'light'
      if (!localStorage.getItem('theme')) {
        isDark.value = e.matches
      }
    })
  }

  // Toggle theme
  const toggleTheme = () => {
    isDark.value = !isDark.value
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
  }

  // Set specific theme
  const setTheme = (theme) => {
    isDark.value = theme === 'dark'
    localStorage.setItem('theme', theme)
  }

  // Apply theme to document
  watchEffect(() => {
    if (isDark.value) {
      document.documentElement.classList.add('dark')
    } else {
      document.documentElement.classList.remove('dark')
    }
  })

  const currentTheme = computed(() => (isDark.value ? 'dark' : 'light'))

  return {
    isDark: computed(() => isDark.value),
    currentTheme,
    systemPreference: computed(() => systemPreference.value),
    toggleTheme,
    setTheme,
    initializeTheme,
  }
}
