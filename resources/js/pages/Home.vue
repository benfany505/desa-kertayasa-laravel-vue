<template>
    <GuestLayout>
        <!-- Hero Section -->
        <HeroSection />

        <!-- Latest News Section -->
        <LatestNews />

        <!-- Services Section -->
        <ServicesSection />

        <!-- Leadership Section -->
        <LeadershipSection />

        <!-- Contact Section -->
        <ContactSection />
    </GuestLayout>
</template>

<script setup>
import GuestLayout from "@/layouts/GuestLayout.vue"
import HeroSection from "@/components/home/HeroSection.vue"
import LatestNews from "@/components/home/LatestNews.vue"
import ServicesSection from "@/components/home/ServicesSection.vue"
import LeadershipSection from "@/components/home/LeadershipSection.vue"
import ContactSection from "@/components/home/ContactSection.vue"
</script>
