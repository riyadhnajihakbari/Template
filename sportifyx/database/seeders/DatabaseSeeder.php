<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SportSeeder::class,
            EventSeeder::class,
            NewsSeeder::class,
            MatchSeeder::class,
            StoreProductSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}