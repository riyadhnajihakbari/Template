<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'BCA',
                'type' => 'bank',
                'account_number' => '1234567890',
                'account_name' => 'PT SportifyX Indonesia',
            ],
            [
                'name' => 'BRI',
                'type' => 'bank',
                'account_number' => '0987654321',
                'account_name' => 'PT SportifyX Indonesia',
            ],
            [
                'name' => 'BSI',
                'type' => 'bank',
                'account_number' => '7788990011',
                'account_name' => 'PT SportifyX Indonesia',
            ],
            [
                'name' => 'Mandiri',
                'type' => 'bank',
                'account_number' => '1122334455',
                'account_name' => 'PT SportifyX Indonesia',
            ],
            [
                'name' => 'DANA',
                'type' => 'ewallet',
                'account_number' => '081234567890',
                'account_name' => 'SportifyX Official',
            ],
            [
                'name' => 'OVO',
                'type' => 'ewallet',
                'account_number' => '081234567891',
                'account_name' => 'SportifyX Official',
            ],
            [
                'name' => 'GoPay',
                'type' => 'ewallet',
                'account_number' => '081234567892',
                'account_name' => 'SportifyX Official',
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}