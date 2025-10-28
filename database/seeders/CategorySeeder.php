<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeder.
     * Sample categories untuk berita - nanti akan ada migration bridge
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Berita Desa',
                'slug' => Str::slug('Berita Desa'),
                'description' => 'Berita dan informasi terkini tentang kegiatan di Desa Kertayasa',
                'color' => '#3B82F6',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Pembangunan',
                'slug' => Str::slug('Pembangunan'),
                'description' => 'Informasi tentang pembangunan infrastruktur dan fasilitas desa',
                'color' => '#10B981',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Kesehatan',
                'slug' => Str::slug('Kesehatan'),
                'description' => 'Program dan kegiatan kesehatan masyarakat',
                'color' => '#EF4444',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Ekonomi & UMKM',
                'slug' => Str::slug('Ekonomi & UMKM'),
                'description' => 'Program pengembangan ekonomi dan UMKM desa',
                'color' => '#F59E0B',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Pendidikan',
                'slug' => Str::slug('Pendidikan'),
                'description' => 'Kegiatan dan program pendidikan masyarakat',
                'color' => '#8B5CF6',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Lingkungan',
                'slug' => Str::slug('Lingkungan'),
                'description' => 'Program kebersihan dan pelestarian lingkungan',
                'color' => '#059669',
                'is_active' => true,
                'sort_order' => 6
            ]
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert(array_merge($category, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
