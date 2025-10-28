<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     * Sample data - 5 berita terbaru, nanti akan ada migration bridge untuk import semua data dari SQL asli
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Program Digitalisasi Layanan Desa Kertayasa',
                'slug' => Str::slug('Program Digitalisasi Layanan Desa Kertayasa'),
                'excerpt' => 'Desa Kertayasa meluncurkan sistem informasi digital untuk mempermudah masyarakat dalam mengakses berbagai layanan administratif.',
                'content' => '<p>Desa Kertayasa dengan bangga meluncurkan sistem informasi digital yang akan memudahkan masyarakat dalam mengakses berbagai layanan administratif. Program ini merupakan bagian dari visi Desa Kertayasa MAJU (Makmur, Agamis dan Juara).</p><p>Dengan adanya sistem digital ini, masyarakat dapat mengakses informasi dan layanan desa secara online, mulai dari pengajuan surat-menyurat, informasi kegiatan desa, hingga pengaduan masyarakat.</p>',
                'featured_image' => '/assets/images/news/digitalisasi-desa.jpg',
                'status' => 'published',
                'is_featured' => true,
                'view_count' => 125,
                'published_at' => now()->subDays(1),
                'author_id' => 1,
                'tags' => json_encode(['digitalisasi', 'teknologi', 'layanan-desa'])
            ],
            [
                'title' => 'Gotong Royong Pembersihan Desa Menyambut Hari Kemerdekaan',
                'slug' => Str::slug('Gotong Royong Pembersihan Desa Menyambut Hari Kemerdekaan'),
                'excerpt' => 'Masyarakat Desa Kertayasa bergotong royong membersihkan lingkungan desa dalam rangka menyambut peringatan hari kemerdekaan RI.',
                'content' => '<p>Dalam rangka menyambut peringatan Hari Kemerdekaan Republik Indonesia, masyarakat Desa Kertayasa mengadakan gotong royong pembersihan lingkungan desa. Kegiatan ini diikuti oleh seluruh elemen masyarakat dari berbagai kalangan.</p><p>Semangat gotong royong yang masih kuat di Desa Kertayasa menunjukkan bahwa nilai-nilai kebersamaan masih terjaga dengan baik di tengah masyarakat.</p>',
                'featured_image' => '/assets/images/news/gotong-royong.jpg',
                'status' => 'published',
                'is_featured' => false,
                'view_count' => 89,
                'published_at' => now()->subDays(3),
                'author_id' => 1,
                'tags' => json_encode(['gotong-royong', 'kebersihan', 'kemerdekaan'])
            ],
            [
                'title' => 'Pelatihan UMKM Digital untuk Warga Desa',
                'slug' => Str::slug('Pelatihan UMKM Digital untuk Warga Desa'),
                'excerpt' => 'Dinas Koperasi bekerja sama dengan Pemerintah Desa mengadakan pelatihan UMKM digital untuk meningkatkan ekonomi warga.',
                'content' => '<p>Pemerintah Desa Kertayasa bekerja sama dengan Dinas Koperasi Kabupaten Kuningan mengadakan pelatihan UMKM digital untuk para pelaku usaha mikro di desa. Pelatihan ini bertujuan untuk meningkatkan kemampuan warga dalam memasarkan produk secara online.</p><p>Materi pelatihan mencakup cara membuat toko online, pemasaran digital, dan manajemen keuangan UMKM. Diharapkan setelah pelatihan ini, UMKM di Desa Kertayasa dapat berkembang lebih pesat.</p>',
                'featured_image' => '/assets/images/news/pelatihan-umkm.jpg',
                'status' => 'published',
                'is_featured' => true,
                'view_count' => 156,
                'published_at' => now()->subDays(5),
                'author_id' => 1,
                'tags' => json_encode(['umkm', 'pelatihan', 'ekonomi-digital'])
            ],
            [
                'title' => 'Posyandu Balita Rutin Bulan Oktober 2025',
                'slug' => Str::slug('Posyandu Balita Rutin Bulan Oktober 2025'),
                'excerpt' => 'Kegiatan Posyandu balita rutin bulan Oktober 2025 dilaksanakan di setiap dusun dengan partisipasi aktif para ibu.',
                'content' => '<p>Kegiatan Posyandu balita rutin bulan Oktober 2025 telah dilaksanakan di seluruh dusun di Desa Kertayasa. Kegiatan ini diikuti oleh puluhan ibu-ibu dengan balita mereka untuk melakukan pemeriksaan kesehatan rutin.</p><p>Tim kesehatan dari Puskesmas Sindangagung hadir untuk memberikan pelayanan kesehatan terbaik. Selain pemeriksaan kesehatan, juga diberikan penyuluhan tentang gizi balita dan imunisasi.</p>',
                'featured_image' => '/assets/images/news/posyandu.jpg',
                'status' => 'published',
                'is_featured' => false,
                'view_count' => 67,
                'published_at' => now()->subDays(7),
                'author_id' => 1,
                'tags' => json_encode(['posyandu', 'kesehatan', 'balita'])
            ],
            [
                'title' => 'Renovasi Balai Desa Kertayasa Tahap Pertama Selesai',
                'slug' => Str::slug('Renovasi Balai Desa Kertayasa Tahap Pertama Selesai'),
                'excerpt' => 'Renovasi balai desa tahap pertama telah selesai dilaksanakan dengan dukungan Dana Desa dan swadaya masyarakat.',
                'content' => '<p>Renovasi Balai Desa Kertayasa tahap pertama telah selesai dilaksanakan. Renovasi ini meliputi perbaikan atap, cat tembok, dan penataan ruangan untuk memberikan kenyamanan bagi masyarakat yang berkunjung ke balai desa.</p><p>Kepala Desa Kertayasa menyampaikan terima kasih kepada seluruh masyarakat yang telah mendukung renovasi ini melalui gotong royong dan swadaya. Renovasi tahap kedua akan segera dimulai untuk melengkapi fasilitas balai desa.</p>',
                'featured_image' => '/assets/images/news/renovasi-balai.jpg',
                'status' => 'published',
                'is_featured' => false,
                'view_count' => 98,
                'published_at' => now()->subDays(10),
                'author_id' => 1,
                'tags' => json_encode(['renovasi', 'balai-desa', 'pembangunan'])
            ]
        ];

        foreach ($news as $item) {
            DB::table('news')->insert(array_merge($item, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
