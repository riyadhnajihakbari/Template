@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h2>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Penjualan Hari Ini</p>
                    <h3 class="text-3xl font-bold">Rp {{ number_format($todaySales, 0, ',', '.') }}</h3>
                </div>
                <div class="text-5xl opacity-20">💰</div>
            </div>
        </div>

        <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Transaksi Hari Ini</p>
                    <h3 class="text-3xl font-bold">{{ $todayOrders }}</h3>
                </div>
                <div class="text-5xl opacity-20">📊</div>
            </div>
        </div>

        <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Rata-rata Transaksi</p>
                    <h3 class="text-3xl font-bold">
                        Rp {{ $todayOrders > 0 ? number_format($todaySales / $todayOrders, 0, ',', '.') : 0 }}
                    </h3>
                </div>
                <div class="text-5xl opacity-20">📈</div>
            </div>
        </div>

        <div class="card bg-gradient-to-br from-orange-500 to-orange-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm mb-1">Status</p>
                    <h3 class="text-2xl font-bold">Aktif</h3>
                </div>
                <div class="text-5xl opacity-20">✅</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="card">
            <h3 class="text-xl font-bold mb-4">Transaksi Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No. Order</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Meja</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-sm">{{ $order->table_number }}</td>
                            <td class="px-4 py-3 text-sm font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @if($order->status == 'completed')
                                <span class="status-badge status-done">Selesai</span>
                                @elseif($order->status == 'processing')
                                <span class="status-badge status-process">Diproses</span>
                                @else
                                <span class="status-badge status-new">Baru</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                Belum ada transaksi hari ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Popular Items -->
        <div class="card">
            <h3 class="text-xl font-bold mb-4">Menu Populer Hari Ini</h3>
            <div class="space-y-3">
                @forelse($popularItems as $item)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="text-3xl">🍽️</div>
                        <div>
                            <div class="font-semibold">{{ $item->name }}</div>
                            <div class="text-sm text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-pos-primary">{{ $item->total_sold }}</div>
                        <div class="text-xs text-gray-600">terjual</div>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-500 py-8">
                    Belum ada penjualan hari ini
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
