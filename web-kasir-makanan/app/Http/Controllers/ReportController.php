<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $period = $request->get('period', 'daily');
        $date = $request->get('date', today());

        $query = Order::completed();

        switch($period) {
            case 'daily':
                $query->whereDate('created_at', $date);
                break;
            case 'weekly':
                $query->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
                break;
            case 'monthly':
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
                break;
        }

        $orders = $query->with(['items.menuItem', 'user'])->latest()->get();
        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();

        return view('reports.sales', compact('orders', 'totalSales', 'totalOrders', 'period'));
    }

    public function inventory()
    {
        $menuItems = MenuItem::with('category')
            ->orderBy('stock', 'asc')
            ->get();

        $lowStock = $menuItems->where('stock', '<', 10)->count();

        return view('reports.inventory', compact('menuItems', 'lowStock'));
    }
}
