<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $news = [
            [
                'title' => 'Timnas Indonesia Menang 3-1 Atas Vietnam',
                'content' => 'Timnas Indonesia berhasil meraih kemenangan gemilang dengan skor 3-1 atas Vietnam dalam laga kualifikasi Piala Dunia 2026. Gol-gol Indonesia dicetak oleh pemain-pemain berkualitas yang tampil maksimal sepanjang pertandingan.',
                'category' => 'Sepak Bola',
                'template_type' => 'A',
                'status' => 'published',
            ],
            [
                'title' => 'Persebaya Rekrut Pemain Baru Asal Brasil',
                'description' => 'Persebaya Surabaya resmi mengumumkan perekrutan striker asal Brasil untuk memperkuat lini depan mereka di putaran kedua Liga 1 Indonesia.',
                'content' => 'Persebaya Surabaya resmi mengumumkan perekrutan striker asal Brasil untuk memperkuat lini depan mereka di putaran kedua Liga 1 Indonesia. Pemain ini diharapkan bisa membawa angin segar bagi tim Bajul Ijo.',
                'category' => 'Sepak Bola',
                'template_type' => 'B',
                'status' => 'published',
            ],
            [
                'title' => 'Indonesia Sabet 2 Emas di Kejuaraan Badminton Asia',
                'content' => 'Tim badminton Indonesia berhasil meraih 2 medali emas di Kejuaraan Badminton Asia 2024. Prestasi gemilang ini menunjukkan dominasi Indonesia di kancah bulu tangkis Asia.',
                'category' => 'Badminton',
                'template_type' => 'C',
                'status' => 'published',
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }
    }
}