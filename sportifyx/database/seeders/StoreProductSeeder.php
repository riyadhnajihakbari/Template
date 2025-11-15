<?php

namespace Database\Seeders;

use App\Models\StoreProduct;
use Illuminate\Database\Seeder;

class StoreProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Jersey Timnas Home 2024',
                'description' => 'Jersey resmi tim nasional Indonesia edisi home 2024',
                'category' => 'Jersey',
                'price' => 850000,
                'discount' => 10,
                'stock' => 100,
            ],
            [
                'name' => 'Jersey Timnas Away 2024',
                'description' => 'Jersey resmi tim nasional Indonesia edisi away 2024',
                'category' => 'Jersey',
                'price' => 850000,
                'discount' => 0,
                'stock' => 80,
            ],
            [
                'name' => 'Sepatu Futsal Ortuseight',
                'description' => 'Sepatu futsal berkualitas tinggi',
                'category' => 'Sepatu',
                'price' => 450000,
                'discount' => 15,
                'stock' => 50,
            ],
            [
                'name' => 'Kaos Training Nike',
                'description' => 'Kaos training nyaman untuk olahraga',
                'category' => 'Pakaian',
                'price' => 350000,
                'discount' => 0,
                'stock' => 200,
            ],
        ];

        foreach ($products as $product) {
            StoreProduct::create($product);
        }
    }
}