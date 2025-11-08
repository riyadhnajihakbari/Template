<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\MenuItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kasir.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Manajer Resto',
            'email' => 'manajer@kasir.com',
            'password' => Hash::make('password'),
            'role' => 'manajer',
        ]);

        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@kasir.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        User::create([
            'name' => 'Koki 1',
            'email' => 'koki@kasir.com',
            'password' => Hash::make('password'),
            'role' => 'koki',
        ]);

        // Create Categories
        $makananUtama = Category::create([
            'name' => 'Makanan Utama',
            'description' => 'Menu makanan utama',
            'is_active' => true,
        ]);

        $minuman = Category::create([
            'name' => 'Minuman',
            'description' => 'Menu minuman',
            'is_active' => true,
        ]);

        $snack = Category::create([
            'name' => 'Snack & Gorengan',
            'description' => 'Menu snack dan gorengan',
            'is_active' => true,
        ]);

        $dessert = Category::create([
            'name' => 'Dessert',
            'description' => 'Menu penutup',
            'is_active' => true,
        ]);

        // Create Menu Items - Makanan Utama
        MenuItem::create([
            'category_id' => $makananUtama->id,
            'name' => 'Nasi Goreng Spesial',
            'description' => 'Nasi goreng dengan telur, ayam, dan sayuran',
            'price' => 25000,
            'stock' => 50,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $makananUtama->id,
            'name' => 'Mie Goreng',
            'description' => 'Mie goreng dengan sayuran dan telur',
            'price' => 22000,
            'stock' => 50,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $makananUtama->id,
            'name' => 'Ayam Geprek',
            'description' => 'Ayam goreng geprek pedas dengan sambal',
            'price' => 28000,
            'stock' => 30,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $makananUtama->id,
            'name' => 'Soto Ayam',
            'description' => 'Soto ayam kampung dengan nasi',
            'price' => 23000,
            'stock' => 40,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $makananUtama->id,
            'name' => 'Gado-Gado',
            'description' => 'Sayuran dengan bumbu kacang',
            'price' => 20000,
            'stock' => 35,
            'is_active' => true,
        ]);

        // Create Menu Items - Minuman
        MenuItem::create([
            'category_id' => $minuman->id,
            'name' => 'Es Teh Manis',
            'description' => 'Teh manis dingin',
            'price' => 5000,
            'stock' => 100,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $minuman->id,
            'name' => 'Es Jeruk',
            'description' => 'Jeruk peras segar',
            'price' => 8000,
            'stock' => 80,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $minuman->id,
            'name' => 'Kopi Hitam',
            'description' => 'Kopi hitam panas',
            'price' => 10000,
            'stock' => 60,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $minuman->id,
            'name' => 'Es Kelapa Muda',
            'description' => 'Kelapa muda segar',
            'price' => 12000,
            'stock' => 40,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $minuman->id,
            'name' => 'Jus Alpukat',
            'description' => 'Jus alpukat segar',
            'price' => 15000,
            'stock' => 30,
            'is_active' => true,
        ]);

        // Create Menu Items - Snack
        MenuItem::create([
            'category_id' => $snack->id,
            'name' => 'Pisang Goreng',
            'description' => 'Pisang goreng crispy (5 pcs)',
            'price' => 10000,
            'stock' => 50,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $snack->id,
            'name' => 'Tahu Isi',
            'description' => 'Tahu isi sayur (5 pcs)',
            'price' => 12000,
            'stock' => 45,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $snack->id,
            'name' => 'Risoles',
            'description' => 'Risoles isi ragout (5 pcs)',
            'price' => 15000,
            'stock' => 40,
            'is_active' => true,
        ]);

        // Create Menu Items - Dessert
        MenuItem::create([
            'category_id' => $dessert->id,
            'name' => 'Es Campur',
            'description' => 'Es campur dengan buah dan jelly',
            'price' => 15000,
            'stock' => 30,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $dessert->id,
            'name' => 'Kolak Pisang',
            'description' => 'Kolak pisang hangat',
            'price' => 12000,
            'stock' => 25,
            'is_active' => true,
        ]);

        MenuItem::create([
            'category_id' => $dessert->id,
            'name' => 'Puding Coklat',
            'description' => 'Puding coklat lembut',
            'price' => 10000,
            'stock' => 35,
            'is_active' => true,
        ]);
    }
}
