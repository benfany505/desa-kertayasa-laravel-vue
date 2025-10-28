<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings - Data dari etnproje_kertayasa.sql
            ['key' => 'village_name', 'value' => 'Desa Kertayasa', 'type' => 'text', 'description' => 'Nama Desa', 'group' => 'general'],
            ['key' => 'village_logo', 'value' => '/assets/images/logo-desa.png', 'type' => 'text', 'description' => 'Logo Desa', 'group' => 'general'],
            ['key' => 'village_tagline', 'value' => 'Masyarakat Panuju Kertayasa Maju', 'type' => 'text', 'description' => 'Tagline Desa dari data asli', 'group' => 'general'],
            ['key' => 'village_vision', 'value' => 'Menjadi Desa Kertayasa MAJU (Makmur, Agamis dan Juara) berbasis Potensi Desa pada tahun 2025', 'type' => 'text', 'description' => 'Visi Desa', 'group' => 'general'],
            ['key' => 'village_mission', 'value' => json_encode([
                'Memperkuat Kualitas Pembinaan Sumber Daya Manusia yang Cerdas Secara Intelektual, Emosional dan Spiritual.',
                'Memaksimalkan Potensi Sumber Daya Manusia dan Sumber Daya Alam sebagai Peluang Dunia Usaha dan Produktivitas Ekonomi masyarakat yang Ramah Lingkungan',
                'Mewujudkan tata kelola pemerintahan Desa yang inovatif, kreatif dan Memudahkan.',
                'Melakukan sinergitas program dengan pemerintah maupun swasta dalam rangka penguatan ketercapaian program Desa',
                'Memperkuat Pembinaan Potensi Masyarakat dalam Bidang Pendidikan, Olahraga, Kebudayaan dan Kesenian.',
                'Turut berkompetisi dalam membangun jejaring, bersama pemerintah daerah dan pusat untuk kemajuan desa.'
            ]), 'type' => 'json', 'description' => 'Misi Desa', 'group' => 'general'],

            // Contact Information - Data asli dari etnproje_kertayasa.sql
            ['key' => 'village_address', 'value' => 'Jl. Desa Kertayasa', 'type' => 'text', 'description' => 'Alamat Desa', 'group' => 'contact'],
            ['key' => 'village_postal_code', 'value' => '45573', 'type' => 'text', 'description' => 'Kode Pos', 'group' => 'contact'],
            ['key' => 'village_phone', 'value' => '(0232) 8910588', 'type' => 'text', 'description' => 'Telepon Desa', 'group' => 'contact'],
            ['key' => 'village_email', 'value' => 'admin@desakertayasa.id', 'type' => 'text', 'description' => 'Email Desa', 'group' => 'contact'],
            ['key' => 'village_website', 'value' => 'https://desakertayasa.id', 'type' => 'text', 'description' => 'Website Desa', 'group' => 'contact'],
            ['key' => 'village_province', 'value' => 'JAWA BARAT', 'type' => 'text', 'description' => 'Provinsi', 'group' => 'contact'],
            ['key' => 'village_regency', 'value' => 'KUNINGAN', 'type' => 'text', 'description' => 'Kabupaten', 'group' => 'contact'],
            ['key' => 'village_district', 'value' => 'SINDANGAGUNG', 'type' => 'text', 'description' => 'Kecamatan', 'group' => 'contact'],

            // Leadership - Data asli dari etnproje_kertayasa.sql
            ['key' => 'village_head', 'value' => 'ARIEF AMARUDIN S.Sos.I', 'type' => 'text', 'description' => 'Kepala Desa', 'group' => 'leadership'],
            ['key' => 'village_secretary', 'value' => 'OPA SAPARUDIMAN', 'type' => 'text', 'description' => 'Sekretaris Desa', 'group' => 'leadership'],

            // Statistics (data estimasi berdasarkan website desa pada umumnya)
            ['key' => 'total_population', 'value' => '8420', 'type' => 'number', 'description' => 'Total Penduduk', 'group' => 'statistics'],
            ['key' => 'total_families', 'value' => '2431', 'type' => 'number', 'description' => 'Total KK', 'group' => 'statistics'],
            ['key' => 'village_area', 'value' => '12.5', 'type' => 'number', 'description' => 'Luas Desa (KM²)', 'group' => 'statistics'],
            ['key' => 'total_hamlets', 'value' => '6', 'type' => 'number', 'description' => 'Jumlah Dusun', 'group' => 'statistics'],

            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/desakertayasa', 'type' => 'text', 'description' => 'Facebook URL', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/desakertayasa', 'type' => 'text', 'description' => 'Instagram URL', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@desakertayasa', 'type' => 'text', 'description' => 'YouTube URL', 'group' => 'social'],

            // SEO Settings
            ['key' => 'meta_title', 'value' => 'Desa Kertayasa - SIMAK (Sistem Informasi Masyarakat Kertayasa)', 'type' => 'text', 'description' => 'Meta Title', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Website resmi Pemerintah Desa Kertayasa, Kecamatan Sindangagung, Kabupaten Kuningan, Jawa Barat. Portal informasi dan layanan digital untuk masyarakat.', 'type' => 'text', 'description' => 'Meta Description', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'Desa Kertayasa, SIMAK, Sindangagung, Kuningan, Jawa Barat, Pemerintah Desa, Layanan Digital', 'type' => 'text', 'description' => 'Meta Keywords', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            DB::table('village_settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'type' => $setting['type'],
                'description' => $setting['description'],
                'group' => $setting['group'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
