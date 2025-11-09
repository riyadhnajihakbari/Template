@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-8 fade-in-up">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-4xl font-bold bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 bg-clip-text text-transparent mb-2">
                    Dashboard
                </h2>
                <p class="text-gray-600 flex items-center gap-2">
                    <span>👋</span>
                    <span>Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>!</span>
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ now()->format('l') }}</p>
                <p class="text-lg font-semibold text-gray-800">{{ now()->format('d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Penjualan Hari Ini -->
        <div class="stat-card stat-orange text-white shadow-xl" style="animation: fadeInUp 0.6s ease-out 0.1s both;">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-3xl backdrop-blur-sm">
                        💰
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-semibold opacity-90">HARI INI</div>
                    </div>
                </div>
                <div>
                    <p class="text-white/90 text-sm mb-1 font-medium">Penjualan Hari Ini</p>
                    <h3 class="text-3xl font-bold">Rp {{ number_format($todaySales, 0, ',', '.') }}</h3>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20 flex items-center justify-between">
                    <span class="text-xs text-white/70">📅 {{ now()->format('d M Y') }}</span>
                    <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Live</span>
                </div>
            </div>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="stat-card stat-green text-white shadow-xl" style="animation: fadeInUp 0.6s ease-out 0.2s both;">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-3xl backdrop-blur-sm">
                        📊
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-semibold opacity-90">TRANSAKSI</div>
                    </div>
                </div>
                <div>
                    <p class="text-white/90 text-sm mb-1 font-medium">Transaksi Hari Ini</p>
                    <h3 class="text-3xl font-bold">{{ $todayOrders }}</h3>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20 flex items-center justify-between">
                    <span class="text-xs text-white/70">Total pesanan</span>
                    <span class="text-xs bg-white/20 px-2 py-1 rounded-full">✓ Selesai</span>
                </div>
            </div>
        </div>

        <!-- Rata-rata Transaksi -->
        <div class="stat-card stat-purple text-white shadow-xl" style="animation: fadeInUp 0.6s ease-out 0.3s both;">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-3xl backdrop-blur-sm">
                        📈
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-semibold opacity-90">RATA-RATA</div>
                    </div>
                </div>
                <div>
                    <p class="text-white/90 text-sm mb-1 font-medium">Rata-rata Transaksi</p>
                    <h3 class="text-3xl font-bold">
                        Rp {{ $todayOrders > 0 ? number_format($todaySales / $todayOrders, 0, ',', '.') : 0 }}
                    </h3>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20 flex items-center justify-between">
                    <span class="text-xs text-white/70">Per transaksi</span>
                    <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Avg</span>
                </div>
            </div>
        </div>

        <!-- Status Sistem - UPDATED WITH OFFLINE STATUS -->
        <div id="system-status-card" class="stat-card stat-blue text-white shadow-xl" style="animation: fadeInUp 0.6s ease-out 0.4s both;">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div id="status-icon" class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-3xl backdrop-blur-sm">
                        ✅
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-semibold opacity-90">SISTEM</div>
                    </div>
                </div>
                <div>
                    <p class="text-white/90 text-sm mb-1 font-medium">Status Sistem</p>
                    <h3 id="status-text" class="text-2xl font-bold">Online & Aktif</h3>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20 flex items-center justify-between">
                    <span id="status-message" class="text-xs text-white/70">All systems operational</span>
                    <div id="status-indicator" class="flex gap-1">
                        <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></span>
                        <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse" style="animation-delay: 0.2s"></span>
                        <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse" style="animation-delay: 0.4s"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="modern-card p-6" style="animation: fadeInUp 0.6s ease-out 0.5s both;">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center text-xl shadow-md">
                        📋
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Transaksi Terbaru</h3>
                </div>
                <a href="{{ route('reports.sales') }}" class="text-sm font-semibold text-orange-600 hover:text-orange-700 transition-colors flex items-center gap-1">
                    Lihat Semua 
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th class="text-left rounded-tl-lg">No. Order</th>
                            <th class="text-left">Meja</th>
                            <th class="text-left">Total</th>
                            <th class="text-left rounded-tr-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="font-mono text-sm font-semibold text-gray-700">{{ $order->order_number }}</td>
                            <td class="text-sm text-gray-600">
                                <span class="inline-flex items-center gap-2">
                                    <span class="text-base">🪑</span>
                                    {{ $order->table_number }}
                                </span>
                            </td>
                            <td class="text-sm font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($order->status == 'completed')
                                <span class="status-badge status-done">
                                    <span class="text-base">✓</span>
                                    Selesai
                                </span>
                                @elseif($order->status == 'processing')
                                <span class="status-badge status-process">
                                    <span class="text-base">⏳</span>
                                    Diproses
                                </span>
                                @else
                                <span class="status-badge status-new">
                                    <span class="text-base">🆕</span>
                                    Baru
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center text-4xl">
                                        📭
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada transaksi hari ini</p>
                                    <a href="{{ route('pos.index') }}" class="btn-primary text-sm">
                                        Buat Transaksi Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Popular Items -->
        <div class="modern-card p-6" style="animation: fadeInUp 0.6s ease-out 0.6s both;">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center text-xl shadow-md">
                        🔥
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Menu Populer Hari Ini</h3>
                </div>
                <a href="{{ route('menu.index') }}" class="text-sm font-semibold text-orange-600 hover:text-orange-700 transition-colors flex items-center gap-1">
                    Lihat Menu 
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            
            <div class="space-y-3">
                @forelse($popularItems as $index => $item)
                <div class="flex items-center justify-between p-4 rounded-xl transition-all duration-300 hover:shadow-md border border-gray-100 hover:border-orange-200 bg-gradient-to-r from-white to-orange-50/30">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl bg-gradient-to-br from-orange-100 to-orange-200 shadow-sm">
                                🍽️
                            </div>
                            <div class="absolute -top-2 -left-2 w-6 h-6 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-md">
                                {{ $index + 1 }}
                            </div>
                        </div>
                        <div>
                            <div class="font-bold text-gray-800">{{ $item->name }}</div>
                            <div class="text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
                            {{ $item->total_sold }}
                        </div>
                        <div class="text-xs text-gray-500 font-medium">terjual</div>
                    </div>
                </div>
                @empty
                <div class="text-center py-16">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center text-4xl">
                            🍽️
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada penjualan hari ini</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('pos.index') }}" class="modern-card p-6 hover:shadow-2xl transition-all duration-300 group" style="animation: fadeInUp 0.6s ease-out 0.7s both;">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 transition-transform">
                    💰
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">Transaksi Baru</h4>
                    <p class="text-sm text-gray-600">Buat penjualan baru</p>
                </div>
            </div>
        </a>

        @if(auth()->user()->isManajer() || auth()->user()->isAdmin())
        <a href="{{ route('menu.index') }}" class="modern-card p-6 hover:shadow-2xl transition-all duration-300 group" style="animation: fadeInUp 0.6s ease-out 0.8s both;">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 transition-transform">
                    🍔
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">Kelola Menu</h4>
                    <p class="text-sm text-gray-600">Tambah atau edit menu</p>
                </div>
            </div>
        </a>

        <a href="{{ route('reports.sales') }}" class="modern-card p-6 hover:shadow-2xl transition-all duration-300 group" style="animation: fadeInUp 0.6s ease-out 0.9s both;">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 transition-transform">
                    📈
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">Lihat Laporan</h4>
                    <p class="text-sm text-gray-600">Analisis penjualan</p>
                </div>
            </div>
        </a>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Update status sistem based on connection
function updateSystemStatus() {
    const card = document.getElementById('system-status-card');
    const icon = document.getElementById('status-icon');
    const text = document.getElementById('status-text');
    const message = document.getElementById('status-message');
    const indicator = document.getElementById('status-indicator');
    const connectionDot = document.getElementById('connection-status');

    if (navigator.onLine) {
        // Online
        card.className = 'stat-card stat-blue text-white shadow-xl';
        icon.innerHTML = '✅';
        text.textContent = 'Online & Aktif';
        message.textContent = 'All systems operational';
        indicator.innerHTML = `
            <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></span>
            <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse" style="animation-delay: 0.2s"></span>
            <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse" style="animation-delay: 0.4s"></span>
        `;
        if (connectionDot) {
            connectionDot.className = 'w-2 h-2 bg-green-500 rounded-full animate-pulse';
        }
    } else {
        // Offline
        card.className = 'stat-card stat-red text-white shadow-xl';
        icon.innerHTML = '⚠️';
        text.textContent = 'Mode Offline';
        message.textContent = 'Data akan disinkronkan saat online';
        indicator.innerHTML = `
            <span class="w-2 h-2 bg-red-300 rounded-full animate-pulse"></span>
            <span class="w-2 h-2 bg-red-300 rounded-full animate-pulse" style="animation-delay: 0.2s"></span>
            <span class="w-2 h-2 bg-red-300 rounded-full animate-pulse" style="animation-delay: 0.4s"></span>
        `;
        if (connectionDot) {
            connectionDot.className = 'w-2 h-2 bg-red-500 rounded-full animate-pulse';
        }
    }
}

// Listen to connection changes
window.addEventListener('online', () => {
    updateSystemStatus();
    Toast.success('Koneksi kembali online! Data akan disinkronkan.');
});

window.addEventListener('offline', () => {
    updateSystemStatus();
    Toast.warning('Koneksi terputus. Mode offline aktif.');
});

// Initial check
updateSystemStatus();
</script>
@endpush
@endsection