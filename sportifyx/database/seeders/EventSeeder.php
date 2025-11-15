<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Sport;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $sepakBola = Sport::where('slug', 'sepak-bola')->first();
        $basket = Sport::where('slug', 'basket')->first();
        $badminton = Sport::where('slug', 'badminton')->first();

        $events = [
            [
                'sport_id' => $sepakBola->id,
                'title' => 'Liga 1 Indonesia: Persib vs Persebaya',
                'description' => 'Pertandingan seru antara Maung Bandung dan Bajul Ijo',
                'lokasi' => 'Stadion Si Jalak Harupat, Bandung',
                'tanggal_mulai' => Carbon::now()->addDays(7)->setTime(19, 0),
                'tanggal_selesai' => Carbon::now()->addDays(7)->setTime(21, 0),
                'status' => 'published',
            ],
            [
                'sport_id' => $basket->id,
                'title' => 'IBL Basketball: Pelita Jaya vs Satria Muda',
                'description' => 'Final IBL 2024',
                'lokasi' => 'Britama Arena, Jakarta',
                'tanggal_mulai' => Carbon::now()->addDays(14)->setTime(18, 0),
                'tanggal_selesai' => Carbon::now()->addDays(14)->setTime(20, 30),
                'status' => 'published',
            ],
            [
                'sport_id' => $badminton->id,
                'title' => 'Indonesia Open Badminton Semifinal',
                'description' => 'Semifinal Indonesia Open 2024',
                'lokasi' => 'Istora Senayan, Jakarta',
                'tanggal_mulai' => Carbon::now()->addDays(21)->setTime(10, 0),
                'tanggal_selesai' => Carbon::now()->addDays(21)->setTime(18, 0),
                'status' => 'published',
            ],
        ];

        foreach ($events as $eventData) {
            $event = Event::create($eventData);
            
            // Create tickets for each event
            $ticketTypes = [
                ['kategori' => 'VVIP', 'harga' => 1500000, 'kuota' => 50],
                ['kategori' => 'VIP', 'harga' => 750000, 'kuota' => 200],
                ['kategori' => 'Reguler', 'harga' => 350000, 'kuota' => 500],
                ['kategori' => 'Ekonomi', 'harga' => 150000, 'kuota' => 1000],
            ];

            foreach ($ticketTypes as $ticket) {
                Ticket::create([
                    'event_id' => $event->id,
                    'kategori' => $ticket['kategori'],
                    'harga' => $ticket['harga'],
                    'kuota' => $ticket['kuota'],
                ]);
            }
        }
    }
}