<?php

namespace Database\Seeders;

use App\Models\MatchResult;
use App\Models\Sport;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MatchSeeder extends Seeder
{
    public function run(): void
    {
        $sepakBola = Sport::where('slug', 'sepak-bola')->first();
        $basket = Sport::where('slug', 'basket')->first();

        $matches = [
            [
                'sport_id' => $sepakBola->id,
                'team_a' => 'Persib Bandung',
                'team_b' => 'Arema FC',
                'score_a' => 2,
                'score_b' => 1,
                'tanggal' => Carbon::now()->subDays(3),
                'lokasi' => 'Stadion Si Jalak Harupat',
            ],
            [
                'sport_id' => $sepakBola->id,
                'team_a' => 'Persija Jakarta',
                'team_b' => 'PSIS Semarang',
                'score_a' => 3,
                'score_b' => 0,
                'tanggal' => Carbon::now()->subDays(5),
                'lokasi' => 'Stadion Patriot Candrabhaga',
            ],
            [
                'sport_id' => $basket->id,
                'team_a' => 'Pelita Jaya',
                'team_b' => 'Satria Muda',
                'score_a' => 78,
                'score_b' => 82,
                'tanggal' => Carbon::now()->subDays(2),
                'lokasi' => 'Britama Arena',
            ],
        ];

        foreach ($matches as $match) {
            MatchResult::create($match);
        }
    }
}