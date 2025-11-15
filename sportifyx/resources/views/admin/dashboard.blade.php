@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Pendapatan Hari Ini</h3>
        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Pendapatan Bulan Ini</h3>
        <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Total Tiket Terjual</h3>
        <p class="text-2xl font-bold">{{ number_format($totalTicketsSold) }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm">Berita Terbaru</h3>
        <p class="text-2xl font-bold">{{ $latestNews->count() }}</p>
    </div>
</div>

<!-- Sales Chart -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h3 class="text-lg font-semibold mb-4">Grafik Penjualan Bulanan {{ date('Y') }}</h3>
    <canvas id="salesChart" height="100"></canvas>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <!-- Recent Ticket Orders -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Transaksi Tiket Terbaru</h3>
        <div class="space-y-3">
            @foreach($recentTicketOrders as $order)
                <div class="border-b pb-2">
                    <p class="font-semibold">{{ $order->event->title }}</p>
                    <p class="text-sm text-gray-600">
                        {{ $order->user->name }} • {{ $order->jumlah }} tiket • 
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Store Orders -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Transaksi Store Terbaru</h3>
        <div class="space-y-3">
            @foreach($recentStoreOrders as $order)
                <div class="border-b pb-2">
                    <p class="font-semibold">{{ $order->product->name }}</p>
                    <p class="text-sm text-gray-600">
                        {{ $order->user->name }} • {{ $order->qty }} item • 
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Penjualan (Rp)',
                data: @json($chartData),
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endsection