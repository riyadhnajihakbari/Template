<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user pelanggan contoh
        $customers = [
            [
                'name' => 'Pelanggan Demo',
                'email' => 'pelanggan@example.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
            ],
        ];

        foreach ($customers as $customer) {
            User::updateOrCreate(
                ['email' => $customer['email']],
                $customer
            );
        }

        $this->command->info('Customer users seeded successfully!');
    }
}