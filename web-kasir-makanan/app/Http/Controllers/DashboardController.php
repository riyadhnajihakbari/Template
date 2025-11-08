<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $todaySales = Order::today()->completed()->sum('total_amount');
        $todayOrders = Order::today()->count();
        $popularItems = MenuItem::select('menu_items.*', DB::raw('SUM(order_items.qty) as total_sold'))
            ->join('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereDate('orders.created_at', today())
            ->groupBy('menu_items.id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        $recentOrders = Order::with(['items.menuItem', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('todaySales', 'todayOrders', 'popularItems', 'recentOrders'));
    }
}
