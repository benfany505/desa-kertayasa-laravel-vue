<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DataMigrationController extends Controller
{
    public function getStatus()
    {
        try {
            $status = [
                'news' => DB::table('news')->count(),
                'users' => DB::table('users')->count(),
            ];

            $sqlFilePath = base_path('etnproje_kertayasa.sql');
            $sqlFileExists = file_exists($sqlFilePath);

            return response()->json([
                'success' => true,
                'status' => $status,
                'sql_file_exists' => $sqlFileExists,
                'sql_file_path' => $sqlFilePath
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get migration status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function importNews(Request $request)
    {
        try {
            $newsData = $this->parseNewsFromSQL();
            $imported = 0;

            foreach ($newsData as $item) {
                $exists = DB::table('news')->where('title', $item['title'])->exists();
                if (!$exists) {
                    DB::table('news')->insert([
                        'title' => $item['title'],
                        'slug' => Str::slug($item['title']),
                        'excerpt' => $this->generateExcerpt($item['content']),
                        'content' => $item['content'],
                        'featured_image' => $item['image'], // Hanya nama file saja
                        'status' => 'published',
                        'is_featured' => $imported < 3,
                        'view_count' => $item['views'] ?? 0,
                        'published_at' => $this->parseDate($item['published_at']),
                        'author_id' => 1,
                        'tags' => json_encode(['kertayasa', 'berita']),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $imported++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully imported {$imported} news articles",
                'imported_count' => $imported
            ]);
        } catch (\Exception $e) {
            Log::error('News import failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to import news data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function importAll(Request $request)
    {
        try {
            $results = [];

            // Import News
            $results['news'] = $this->importNewsData();

            // Import Village Identity
            $results['identitas'] = $this->importIdentitasData();

            // Import APBDes
            $results['apbdes'] = $this->importApbdesData();

            // Import Gallery
            $results['gallery'] = $this->importGalleryData();

            return response()->json([
                'success' => true,
                'message' => 'All data imported successfully',
                'results' => $results
            ]);
        } catch (\Exception $e) {
            Log::error('Import all failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to import all data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function clearData(Request $request)
    {
        try {
            $table = $request->input('table', 'news');
            $count = DB::table($table)->count();

            if ($count > 0) {
                DB::table($table)->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Data cleared successfully',
                'cleared' => [$table => $count]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function parseNewsFromSQL()
    {
        $sqlFile = base_path('etnproje_kertayasa.sql');
        if (!file_exists($sqlFile)) {
            Log::error('SQL file not found: ' . $sqlFile);
            return [];
        }

        $content = file_get_contents($sqlFile);
        $newsData = [];

        // Simple approach: find all lines that start with ( and contain berita data
        $lines = explode("\n", $content);
        $insideBeritaInsert = false;

        foreach ($lines as $line) {
            $line = trim($line);

            // Check if we're starting berita INSERT
            if (str_contains($line, 'INSERT INTO `berita`')) {
                $insideBeritaInsert = true;
                Log::info('Found berita INSERT statement');
                continue;
            }

            // Check if we're ending berita INSERT
            if ($insideBeritaInsert && str_ends_with($line, ';')) {
                $insideBeritaInsert = false;
                // Process this last line too if it has data
                if (str_starts_with($line, '(')) {
                    $this->parseBeritaRow($line, $newsData);
                }
                continue;
            }

            // Parse berita data rows
            if ($insideBeritaInsert && str_starts_with($line, '(')) {
                $this->parseBeritaRow($line, $newsData);
            }
        }

        Log::info('Parsed ' . count($newsData) . ' news items from SQL file');
        return $newsData;
    }

    private function parseBeritaRow($line, &$newsData)
    {
        try {
            // Remove parentheses and trailing comma/semicolon
            $line = trim($line, '(),; ');

            // Simple split by comma - but be careful with quoted content
            $fields = $this->splitCSVLine($line);

            if (count($fields) >= 10) {
                // SQL structure: id_berita, judul_berita, ht_berita, isi_berita, tgl_berita, jam_berita, img_berita, dilihat, id_user, flag
                $title = $this->cleanValue($fields[1]);
                $content = $this->cleanValue($fields[3]);
                $date = $this->cleanValue($fields[4]);
                $time = $this->cleanValue($fields[5]);
                $image = $this->cleanValue($fields[6]);
                $views = intval($this->cleanValue($fields[7]));

                if (!empty($title)) {
                    $newsData[] = [
                        'title' => $title,
                        'content' => $content,
                        'published_at' => $date . ' ' . $time,
                        'image' => $image,
                        'views' => $views
                    ];
                    Log::info('Parsed news: ' . substr($title, 0, 50) . '...');
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to parse berita row: ' . $e->getMessage());
        }
    }

    private function splitCSVLine($line)
    {
        // Simple approach: split by comma but handle quoted strings
        $fields = [];
        $current = '';
        $inQuotes = false;
        $quoteChar = '';

        for ($i = 0; $i < strlen($line); $i++) {
            $char = $line[$i];

            if (!$inQuotes && ($char === "'" || $char === '"')) {
                $inQuotes = true;
                $quoteChar = $char;
            } elseif ($inQuotes && $char === $quoteChar) {
                $inQuotes = false;
            } elseif (!$inQuotes && $char === ',') {
                $fields[] = trim($current);
                $current = '';
                continue;
            }

            $current .= $char;
        }

        if ($current !== '') {
            $fields[] = trim($current);
        }

        return $fields;
    }

    private function cleanValue($value)
    {
        $value = trim($value);

        // Remove quotes
        if ((str_starts_with($value, "'") && str_ends_with($value, "'")) ||
            (str_starts_with($value, '"') && str_ends_with($value, '"'))
        ) {
            $value = substr($value, 1, -1);
        }

        // Handle NULL
        if (strtoupper($value) === 'NULL') {
            return null;
        }

        return $value;
    }



    private function importNewsData()
    {
        $newsData = $this->parseNewsFromSQL();
        $imported = 0;

        foreach ($newsData as $item) {
            $exists = DB::table('news')->where('title', $item['title'])->exists();
            if (!$exists) {
                DB::table('news')->insert([
                    'title' => $item['title'],
                    'slug' => Str::slug($item['title']),
                    'excerpt' => $this->generateExcerpt($item['content']),
                    'content' => $item['content'],
                    'featured_image' => $item['image'], // Hanya nama file saja
                    'status' => 'published',
                    'is_featured' => $imported < 3,
                    'view_count' => $item['views'] ?? 0,
                    'published_at' => $this->parseDate($item['published_at']),
                    'author_id' => 1,
                    'tags' => json_encode(['kertayasa', 'berita']),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $imported++;
            }
        }

        return ['imported' => $imported, 'message' => "Imported {$imported} news articles"];
    }

    private function importIdentitasData()
    {
        $data = $this->parseTableFromSQL('identitas');
        $imported = 0;

        foreach ($data as $item) {
            // Create or update village identity
            DB::table('village_profiles')->updateOrInsert(
                ['id' => 1],
                [
                    'name' => $this->cleanValue($item[1] ?? 'Desa Kertayasa'),
                    'description' => $this->cleanValue($item[2] ?? ''),
                    'address' => $this->cleanValue($item[3] ?? ''),
                    'postal_code' => $this->cleanValue($item[4] ?? ''),
                    'phone' => $this->cleanValue($item[5] ?? ''),
                    'email' => $this->cleanValue($item[6] ?? ''),
                    'website' => $this->cleanValue($item[7] ?? ''),
                    'province' => $this->cleanValue($item[8] ?? ''),
                    'regency' => $this->cleanValue($item[9] ?? ''),
                    'district' => $this->cleanValue($item[10] ?? ''),
                    'village_head' => $this->cleanValue($item[12] ?? ''),
                    'village_secretary' => $this->cleanValue($item[13] ?? ''),
                    'logo' => $this->cleanValue($item[14] ?? ''),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
            $imported++;
        }

        return ['imported' => $imported, 'message' => "Imported {$imported} village identity records"];
    }

    private function importApbdesData()
    {
        $data = $this->parseTableFromSQL('apbdes');
        $imported = 0;

        foreach ($data as $item) {
            $exists = DB::table('apbdes')->where('year', $this->cleanValue($item[1]))->exists();
            if (!$exists) {
                DB::table('apbdes')->insert([
                    'year' => intval($this->cleanValue($item[1])),
                    'revenue_details' => $this->cleanValue($item[2] ?? ''),
                    'total_revenue' => intval($this->cleanValue($item[3] ?? 0)),
                    'expenditure_details' => $this->cleanValue($item[4] ?? ''),
                    'total_expenditure' => intval($this->cleanValue($item[5] ?? 0)),
                    'balance' => intval($this->cleanValue($item[6] ?? 0)),
                    'total_spending' => intval($this->cleanValue($item[7] ?? 0)),
                    'total_income' => intval($this->cleanValue($item[8] ?? 0)),
                    'total_financing' => intval($this->cleanValue($item[9] ?? 0)),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $imported++;
            }
        }

        return ['imported' => $imported, 'message' => "Imported {$imported} APBDes records"];
    }

    private function importGalleryData()
    {
        $data = $this->parseTableFromSQL('gallery');
        $imported = 0;

        foreach ($data as $item) {
            $imageName = $this->cleanValue($item[1] ?? '');
            $title = $this->cleanValue($item[2] ?? 'Gallery Image');

            if (!empty($imageName)) {
                $exists = DB::table('galleries')->where('image_path', 'like', '%' . $imageName . '%')->exists();
                if (!$exists) {
                    // Truncate title if too long
                    $titleTruncated = Str::limit($title, 200, '');
                    $descTruncated = Str::limit($title, 500, '');

                    DB::table('galleries')->insert([
                        'title' => $titleTruncated,
                        'slug' => Str::slug($titleTruncated . '-' . $imageName . '-' . uniqid()),
                        'description' => $descTruncated,
                        'image_path' => $imageName, // Hanya nama file saja
                        'thumbnail_path' =>  $imageName, // Hanya nama file thumbnail
                        'type' => 'image',
                        'metadata' => json_encode(['original_filename' => $imageName]),
                        'is_featured' => $imported < 6,
                        'sort_order' => $imported + 1,
                        'uploaded_by' => 1, // Default admin user
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $imported++;
                }
            }
        }

        return ['imported' => $imported, 'message' => "Imported {$imported} gallery images"];
    }

    private function parseTableFromSQL($tableName)
    {
        $sqlFile = base_path('etnproje_kertayasa.sql');
        if (!file_exists($sqlFile)) {
            Log::error('SQL file not found: ' . $sqlFile);
            return [];
        }

        $content = file_get_contents($sqlFile);
        $data = [];

        // Simple approach: find all lines for specific table
        $lines = explode("\n", $content);
        $insideInsert = false;

        foreach ($lines as $line) {
            $line = trim($line);

            // Check if we're starting table INSERT
            if (str_contains($line, "INSERT INTO `{$tableName}`")) {
                $insideInsert = true;
                Log::info("Found {$tableName} INSERT statement");
                continue;
            }

            // Check if we're ending INSERT
            if ($insideInsert && str_ends_with($line, ';')) {
                $insideInsert = false;
                // Process this last line too if it has data
                if (str_starts_with($line, '(')) {
                    $this->parseTableRow($line, $data);
                }
                continue;
            }

            // Parse data rows
            if ($insideInsert && str_starts_with($line, '(')) {
                $this->parseTableRow($line, $data);
            }
        }

        Log::info("Parsed " . count($data) . " {$tableName} items from SQL file");
        return $data;
    }

    private function parseTableRow($line, &$data)
    {
        try {
            // Remove parentheses and trailing comma/semicolon
            $line = trim($line, '(),; ');

            // Simple split by comma - but be careful with quoted content
            $fields = $this->splitCSVLine($line);

            if (count($fields) > 0) {
                $data[] = $fields;
            }
        } catch (\Exception $e) {
            Log::warning('Failed to parse table row: ' . $e->getMessage());
        }
    }

    private function parseDate($dateString)
    {
        if (empty($dateString) || $dateString === 'NULL') {
            return now();
        }

        try {
            return \Carbon\Carbon::parse($dateString);
        } catch (\Exception $e) {
            return now();
        }
    }

    private function generateExcerpt($content, $length = 150)
    {
        $clean = strip_tags($content);
        return Str::limit($clean, $length);
    }
}
