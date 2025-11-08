@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Laporan Penjualan</h2>
        <button onclick="window.print()" class="btn-primary no-print">
            🖨️ Cetak Laporan
        </button>
    </div>

    <!-- Period Filter -->
    <div class="card mb-6 no-print">
        <div class="flex items-center space-x-2">
            <a href="{{ route('reports.sales', ['period' => 'daily']) }}" 
               class="px-4 py-2 rounded-lg {{ $period == 'daily' ? 'bg-pos-primary text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                Harian
            </a>
            <a href="{{ route('reports.sales', ['period' => 'weekly']) }}" 
               class="px-4 py-2 rounded-lg {{ $period == 'weekly' ? 'bg-pos-primary text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                Mingguan
            </a>
            <a href="{{ route('reports.sales', ['period' => 'monthly']) }}" 
               class="px-4 py-2 rounded-lg {{ $period == 'monthly' ? 'bg-pos-primary text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                Bulanan
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="text-blue-100 text-sm mb-1">Total Penjualan</div>
            <div class="text-4xl font-bold">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
        </div>

        <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
            <div class="text-green-100 text-sm mb-1">Total Transaksi</div>
            <div class="text-4xl font-bold">{{ $totalOrders }}</div>
        </div>

        <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white">
            <div class="text-purple-100 text-sm mb-1">Rata-rata Transaksi</div>
            <div class="text-4xl font-bold">
                Rp {{ $totalOrders > 0 ? number_format($totalSales / $totalOrders, 0, ',', '.') : 0 }}
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card overflow-hidden">
        <h3 class="text-xl font-bold mb-4">Detail Transaksi</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No. Order</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Meja</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kasir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-sm">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 text-sm">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $order->table_number }}</td>
                        <td class="px-6 py-4 text-sm">
                            <ul class="text-xs space-y-1">
                                @foreach($order->items as $item)
                                <li>{{ $item->qty }}x {{ $item->menuItem->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold uppercase">
                                {{ $order->payment_method }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $order->user ? $order->user->name : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="text-5xl mb-4">📊</div>
                            <div class="text-lg font-semibold">Belum ada transaksi</div>
                            <div class="text-sm mt-2">Transaksi akan muncul di sini</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white;
    }
    
    .card {
        box-shadow: none !important;
        page-break-inside: avoid;
    }
}
</style>
@endsection