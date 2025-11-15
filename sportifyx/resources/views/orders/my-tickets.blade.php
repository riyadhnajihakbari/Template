@extends('layouts.app')

@section('title', 'Tiket Saya - SportifyX')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8">Tiket Saya</h1>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 {{ $order->status === 'pending' ? 'border-l-4 border-amber-400' : ($order->status === 'paid' ? 'border-l-4 border-emerald-400' : '') }}">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-sm font-semibold text-blue-600">{{ $order->event->sport->name }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $order->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 
                                       ($order->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $order->status === 'paid' ? 'Lunas' : ($order->status === 'pending' ? 'Menunggu Pembayaran' : ucfirst($order->status)) }}
                                </span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">{{ $order->event->title }}</h3>
                            <div class="mt-2 space-y-1 text-sm text-gray-600">
                                <p>📅 {{ $order->event->tanggal_mulai->format('d F Y, H:i') }}</p>
                                <p>📍 {{ $order->event->lokasi }}</p>
                            </div>
                            <div class="mt-3">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $order->ticket->kategori }}
                                </span>
                                <span class="ml-2 text-gray-600">x {{ $order->jumlah }} tiket</span>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-xl sm:text-2xl font-bold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Order #{{ $order->id }}</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t flex flex-wrap gap-3">
                        <a href="{{ route('tickets.order.detail', $order) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                            Lihat Detail & Instruksi Pembayaran →
                        </a>
                        @if($order->status === 'paid')
                            <span class="text-emerald-600 font-medium text-sm">✓ Tiket Aktif</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-8 sm:p-12 text-center">
            <div class="text-gray-400 text-6xl mb-4">🎫</div>
            <p class="text-gray-500 mb-4">Kamu belum memiliki tiket.</p>
            <a href="{{ route('events.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                Cari Event
            </a>
        </div>
    @endif
</div>
@endsection