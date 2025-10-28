<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@desakertayasa.id',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        // Create Admin
        \App\Models\User::create([
            'name' => 'Admin Desa',
            'email' => 'admin@kertayasa.desa.id',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        // Create Editor
        \App\Models\User::create([
            'name' => 'Editor Berita',
            'email' => 'editor@desakertayasa.id',
            'email_verified_at' => now(),
            'password' => bcrypt('editor123'),
            'role' => 'editor',
            'phone' => '081234567892',
            'is_active' => true,
        ]);
    }
}
