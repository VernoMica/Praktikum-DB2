<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            \App\Models\Partner::create([
                'name' => fake()->company(),
                'logo_url' => 'https://placehold.co/200x200?text=' . urlencode(fake()->company()),
            ]);
        }
    }
}
