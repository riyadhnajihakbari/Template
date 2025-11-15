@extends('layouts.app')

@section('title', 'Riwayat Pembelian - SportifyX')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8">Riwayat Pembelian Merchandise</h1>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                        <div class="flex items-start space-x-4">
                            @if($order->product->image)
                                <img src="{{ Storage::url($order->product->image) }}" alt="{{ $order->product->name }}" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded">
                            @else
                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-400 text-2xl">👕</span>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-base sm:text-lg">{{ $order->product->name }}</h3>
                                <p class="text-gray-600 text-sm">Jumlah: {{ $order->qty }} item</p>
                                <p class="text-gray-500 text-xs mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-lg sm:text-xl font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($order->status === 'shipped' ? 'bg-blue-100 text-blue-800' : 
                                   ($order->status === 'paid' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 sm:mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 sm:p-12 text-center">
            <div class="text-gray-400 text-5xl mb-4">🛍️</div>
            <p class="text-gray-500 mb-4">Kamu belum pernah membeli merchandise.</p>
            <a href="{{ route('store.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Kunjungi Store
            </a>
        </div>
    @endif
</div>
@endsection