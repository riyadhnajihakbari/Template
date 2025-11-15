<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use App\Models\MatchResult;
use App\Models\Sport;
use App\Models\StoreProduct;

class HomeController extends Controller
{
    public function index()
    {
        $sports = Sport::all();
        $upcomingEvents = Event::where('status', 'published')
            ->where('tanggal_mulai', '>', now())
            ->orderBy('tanggal_mulai')
            ->take(6)
            ->get();
        $latestNews = News::where('status', 'published')
            ->latest()
            ->take(4)
            ->get();
        $recentMatches = MatchResult::with('sport')
            ->whereMonth('tanggal', now()->month)
            ->latest('tanggal')
            ->take(5)
            ->get();
        $featuredProducts = StoreProduct::take(4)->get();

        return view('home', compact(
            'sports',
            'upcomingEvents',
            'latestNews',
            'recentMatches',
            'featuredProducts'
        ));
    }
}