<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Utama
        \App\Models\User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 2. Insert Kategori Event
        $catIT = \App\Models\Category::create([
            'name' => 'Seminar IT', 
            'slug' => 'seminar-it'
        ]);
        $catEnt = \App\Models\Category::create([
            'name' => 'Entertainment', 
            'slug' => 'entertainment'
        ]);
        $catSport = \App\Models\Category::create([
            'name' => 'E-Sport', 
            'slug' => 'e-sport'
        ]);
        $catDesign = \App\Models\Category::create([
            'name' => 'Design', 
            'slug' => 'design'
        ]);

        // 3. Insert Sampel Events (Minimal 6)
        
        // Event 1: Design
        \App\Models\Event::create([
            'category_id' => $catDesign->id,
            'title' => 'UI/UX Masterclass',
            'description' => 'Pelajari desain antarmuka modern dengan tools industri terbaru.',
            'date' => '2026-06-15 09:00:00',
            'location' => 'Lab ICT Amikom',
            'price' => 75000,
            'stock' => 30,
            'poster_path' => 'posters/uiux.png',
        ]);

        // Event 2: E-Sport
        \App\Models\Event::create([
            'category_id' => $catSport->id,
            'title' => 'E-Sport U-Champ',
            'description' => 'Turnamen Mobile Legends antar mahasiswa Amikom.',
            'date' => '2026-07-20 10:00:00',
            'location' => 'Gedung Samping',
            'price' => 25000,
            'stock' => 128,
            'poster_path' => 'posters/esport.png',
        ]);

        // Event 3: Entertainment
        \App\Models\Event::create([
            'category_id' => $catEnt->id,
            'title' => 'Jazz Night 2025',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz berkualitas.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Halaman Depan Amikom',
            'price' => 50000,
            'stock' => 200,
            'poster_path' => 'posters/jazz.png',
        ]);

        // Event 4: Seminar IT
        \App\Models\Event::create([
            'category_id' => $catIT->id,
            'title' => 'AI Summit & Expo 2026',
            'description' => 'Jelajahi tren terkini dalam bidang Artificial Intelligence dan Robotika.',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Cinema Amikom',
            'price' => 45000,
            'stock' => 150,
            'poster_path' => 'posters/ai-summit.png',
        ]);

        // Event 5: Design
        \App\Models\Event::create([
            'category_id' => $catDesign->id,
            'title' => 'Photography Workshop',
            'description' => 'Teknik dasar fotografi untuk pemula menggunakan kamera smartphone.',
            'date' => '2026-08-05 08:00:00',
            'location' => 'Amikom Creative Hub',
            'price' => 30000,
            'stock' => 50,
            'poster_path' => 'posters/photo.png',
        ]);

        // Event 6: Seminar IT
        \App\Models\Event::create([
            'category_id' => $catIT->id,
            'title' => 'Code Jam 2026: Competitive Programming',
            'description' => 'Uji kemampuan algoritma Anda dalam kompetisi coding tahunan.',
            'date' => '2026-09-12 13:00:00',
            'location' => 'Lab Komputer 3',
            'price' => 0,
            'stock' => 100,
            'poster_path' => 'posters/codejam.png',
        ]);
    }
}
