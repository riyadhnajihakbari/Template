<?php

namespace Database\Seeders;

use App\Models\Sport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SportSeeder extends Seeder
{
    public function run(): void
    {
        $sports = [
            ['name' => 'Sepak Bola', 'icon' => '⚽'],
            ['name' => 'Basket', 'icon' => '🏀'],
            ['name' => 'Badminton', 'icon' => '🏸'],
            ['name' => 'Futsal', 'icon' => '⚽'],
            ['name' => 'Voli', 'icon' => '🏐'],
            ['name' => 'Tennis', 'icon' => '🎾'],
        ];

        foreach ($sports as $sport) {
            Sport::create([
                'name' => $sport['name'],
                'slug' => Str::slug($sport['name']),
                'icon' => $sport['icon'],
            ]);
        }
    }
}