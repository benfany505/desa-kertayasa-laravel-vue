// Auth Store using Pinia
import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('auth_token') || null,
    isLoading: false,
    error: null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token && !!state.user,
    isAdmin: (state) => state.user?.role === 'admin' || state.user?.role === 'super_admin',
    isSuperAdmin: (state) => state.user?.role === 'super_admin',
    hasRole: (state) => (roles) => {
      if (!state.user?.role) return false
      if (Array.isArray(roles)) {
        return roles.includes(state.user.role)
      }
      return state.user.role === roles
    },
  },

  actions: {
    // Initialize auth state
    async initAuth() {
      if (this.token) {
        // Set axios default header
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`

        try {
          await this.fetchUser()
        } catch (error) {
          console.error('Failed to initialize auth:', error)
          this.logout()
        }
      }
    },

    // Login action
    async login(credentials) {
      try {
        this.isLoading = true
        this.error = null

        const response = await axios.post('/api/auth/login', credentials)

        this.token = response.data.token
        this.user = response.data.user

        // Store token in localStorage
        localStorage.setItem('auth_token', this.token)

        // Set axios default header
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`

        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Login failed'
        throw error
      } finally {
        this.isLoading = false
      }
    },

    // Logout action
    async logout() {
      try {
        if (this.token) {
          await axios.post('/api/auth/logout')
        }
      } catch (error) {
        console.error('Logout API failed:', error)
      } finally {
        // Clear state regardless of API success
        this.user = null
        this.token = null
        this.error = null

        // Clear localStorage
        localStorage.removeItem('auth_token')

        // Remove axios default header
        delete axios.defaults.headers.common['Authorization']
      }
    },

    // Fetch current user
    async fetchUser() {
      try {
        const response = await axios.get('/api/auth/user')
        this.user = response.data.user
        return response.data
      } catch (error) {
        console.error('Failed to fetch user:', error)
        throw error
      }
    },

    // Update user profile
    async updateProfile(profileData) {
      try {
        this.isLoading = true
        this.error = null

        const response = await axios.put('/api/auth/profile', profileData)
        this.user = { ...this.user, ...response.data.user }

        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Profile update failed'
        throw error
      } finally {
        this.isLoading = false
      }
    },

    // Change password
    async changePassword(passwordData) {
      try {
        this.isLoading = true
        this.error = null

        const response = await axios.put('/api/auth/change-password', passwordData)

        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Password change failed'
        throw error
      } finally {
        this.isLoading = false
      }
    },

    // Clear error
    clearError() {
      this.error = null
    },
  },
})
