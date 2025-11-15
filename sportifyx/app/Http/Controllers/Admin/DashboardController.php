<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StoreOrder;
use App\Models\News;
use App\Models\MatchResult;
use App\Models\Event;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $todayRevenue = Order::where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total_harga');

        $monthRevenue = Order::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('total_harga');

        $totalTicketsSold = Order::where('status', 'paid')->sum('jumlah');

        $recentTicketOrders = Order::with(['user', 'event'])
            ->latest()
            ->take(10)
            ->get();

        $recentStoreOrders = StoreOrder::with(['user', 'product'])
            ->latest()
            ->take(10)
            ->get();

        $latestNews = News::latest()->take(5)->get();
        $latestMatches = MatchResult::latest('tanggal')->take(5)->get();

        $monthlySales = Order::where('status', 'paid')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_harga) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlySales[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'todayRevenue',
            'monthRevenue',
            'totalTicketsSold',
            'recentTicketOrders',
            'recentStoreOrders',
            'latestNews',
            'latestMatches',
            'chartData'
        ));
    }
}