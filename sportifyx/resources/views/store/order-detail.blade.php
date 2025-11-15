@extends('layouts.app')

@section('title', 'Detail Pesanan - SportifyX')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Pesanan</h1>
        <p class="text-gray-600 mt-1">Order ID: #{{ $order->id }}</p>
    </div>

    <!-- Progress Bar -->
    <div class="flex items-center mb-8">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-emerald-600 text-white rounded-full flex items-center justify-center font-semibold">✓</div>
            <span class="ml-2 font-medium text-emerald-600">Jumlah</span>
        </div>
        <div class="flex-1 h-1 bg-emerald-600 mx-4"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 bg-emerald-600 text-white rounded-full flex items-center justify-center font-semibold">✓</div>
            <span class="ml-2 font-medium text-emerald-600">Pembayaran</span>
        </div>
        <div class="flex-1 h-1 bg-emerald-600 mx-4"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold">3</div>
            <span class="ml-2 font-medium text-blue-600">Selesai</span>
        </div>
    </div>

    <!-- Status Alert -->
    @if($order->status === 'pending')
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
            <div class="flex items-start">
                <span class="text-2xl mr-3">⏳</span>
                <div>
                    <h3 class="font-semibold text-amber-800">Menunggu Pembayaran</h3>
                    <p class="text-amber-700 text-sm mt-1">
                        Silakan transfer sesuai instruksi di bawah. Pesanan akan diproses setelah pembayaran dikonfirmasi oleh admin.
                    </p>
                </div>
            </div>
        </div>
    @elseif($order->status === 'paid')
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-6">
            <div class="flex items-start">
                <span class="text-2xl mr-3">✅</span>
                <div>
                    <h3 class="font-semibold text-emerald-800">Pembayaran Dikonfirmasi</h3>
                    <p class="text-emerald-700 text-sm mt-1">
                        Pembayaran kamu sudah dikonfirmasi. Pesanan sedang diproses.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Payment Instructions -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4">Instruksi Pembayaran</h2>
            
            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                <p class="text-sm text-blue-600 font-medium mb-1">Transfer ke:</p>
                <p class="text-2xl font-bold text-blue-800">{{ $order->paymentMethod->name }}</p>
                <p class="text-lg font-mono mt-2">{{ $order->paymentMethod->account_number }}</p>
                <p class="text-sm text-blue-700">a.n. {{ $order->paymentMethod->account_name }}</p>
            </div>

            <div class="bg-red-50 rounded-lg p-4 mb-4">
                <p class="text-sm text-red-600 font-medium mb-1">Total yang harus dibayar:</p>
                <p class="text-3xl font-bold text-red-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>

            <div class="space-y-3 text-sm">
                <p class="font-medium">Catatan Penting:</p>
                <ul class="list-disc list-inside space-y-2 text-gray-600">
                    <li>Transfer sesuai nominal di atas</li>
                    <li>Setelah transfer, admin akan memverifikasi pembayaranmu</li>
                    <li>Status pesanan akan berubah menjadi "Paid" setelah dikonfirmasi</li>
                    <li>Pembayaran akan hangus jika tidak dilakukan dalam 24 jam</li>
                </ul>
            </div>

            @if($order->status === 'pending')
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-700 mb-2">Sudah melakukan pembayaran?</p>
                    <p class="text-xs text-gray-600">Status pesananmu akan diupdate oleh admin setelah pembayaran terverifikasi.</p>
                </div>
            @endif
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4">Detail Pesanan</h2>
            
            <div class="flex items-start space-x-4 pb-4 border-b">
                @if($order->product->image)
                    <img src="{{ Storage::url($order->product->image) }}" alt="{{ $order->product->name }}" class="w-20 h-20 object-cover rounded-lg">
                @else
                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">👕</div>
                @endif
                <div>
                    <p class="font-semibold">{{ $order->product->name }}</p>
                    <p class="text-sm text-gray-600">{{ $order->product->category }}</p>
                    <p class="text-sm text-gray-600 mt-1">Jumlah: {{ $order->qty }} unit</p>
                </div>
            </div>

            <div class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order ID</span>
                    <span class="font-mono">#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tanggal Order</span>
                    <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $order->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 
                           ($order->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Metode Pembayaran</span>
                    <span>{{ $order->paymentMethod->name }}</span>
                </div>
                <div class="border-t pt-3">
                    <div class="flex justify-between font-semibold text-lg">
                        <span>Total Bayar</span>
                        <span class="text-blue-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('store.history') }}" class="text-blue-600 hover:underline">
            Lihat Semua Pesanan →
        </a>
    </div>
</div>
@endsection