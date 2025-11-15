@extends('layouts.app')

@section('title', 'Detail Pesanan Tiket - SportifyX')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('my-tickets.index') }}" class="text-blue-600 hover:underline text-sm mb-2 inline-block">
            ← Kembali ke Tiket Saya
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Pesanan Tiket</h1>
        <p class="text-gray-600 mt-1">Order ID: #{{ $order->id }}</p>
    </div>

    <!-- Status Alert -->
    @if($order->status === 'pending')
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
            <div class="flex items-start">
                <span class="text-2xl mr-3">⏳</span>
                <div>
                    <h3 class="font-semibold text-amber-800">Menunggu Pembayaran</h3>
                    <p class="text-amber-700 text-sm mt-1">
                        Silakan transfer sesuai instruksi di bawah. QR Code tiket akan muncul setelah pembayaran dikonfirmasi.
                    </p>
                </div>
            </div>
        </div>
    @elseif($order->status === 'paid')
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-6">
            <div class="flex items-start">
                <span class="text-2xl mr-3">✅</span>
                <div>
                    <h3 class="font-semibold text-emerald-800">Pembayaran Dikonfirmasi - Tiket Aktif</h3>
                    <p class="text-emerald-700 text-sm mt-1">
                        Tunjukkan QR Code di bawah saat masuk venue. Pastikan QR Code terlihat jelas.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Payment Instructions / QR Code -->
            @if($order->status === 'pending')
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4">Instruksi Pembayaran</h2>
                    
                    @if($order->paymentMethod)
                        <div class="bg-blue-50 rounded-lg p-4 mb-4">
                            <p class="text-sm text-blue-600 font-medium mb-1">Transfer ke:</p>
                            <p class="text-2xl font-bold text-blue-800">{{ $order->paymentMethod->name }}</p>
                            <p class="text-lg font-mono mt-2">{{ $order->paymentMethod->account_number }}</p>
                            <p class="text-sm text-blue-700">a.n. {{ $order->paymentMethod->account_name }}</p>
                        </div>
                    @endif

                    <div class="bg-red-50 rounded-lg p-4 mb-4">
                        <p class="text-sm text-red-600 font-medium mb-1">Total yang harus dibayar:</p>
                        <p class="text-3xl font-bold text-red-700">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    </div>

                    <div class="space-y-3 text-sm">
                        <p class="font-medium">Catatan Penting:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600">
                            <li>Transfer sesuai nominal di atas</li>
                            <li>Admin akan memverifikasi pembayaranmu</li>
                            <li>QR Code tiket akan muncul setelah pembayaran dikonfirmasi</li>
                            <li>Pembayaran hangus jika tidak dilakukan dalam 24 jam</li>
                        </ul>
                    </div>
                </div>
            @else
                <!-- QR Code untuk tiket yang sudah dibayar -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4 text-center">🎫 E-Ticket QR Code</h2>
                    
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <!-- QR Code Image -->
                        <div class="inline-block bg-white p-4 rounded-lg shadow-sm">
                            {!! QrCode::size(200)->generate($order->qr_code) !!}
                        </div>
                        <p class="text-xs text-gray-500 mt-3 font-mono break-all">{{ $order->qr_code }}</p>
                    </div>

                    <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-800 font-medium">Cara Penggunaan:</p>
                        <ul class="text-sm text-blue-700 mt-2 space-y-1">
                            <li>• Tunjukkan QR Code ini di pintu masuk venue</li>
                            <li>• Petugas akan scan QR Code untuk verifikasi</li>
                            <li>• Pastikan layar HP cukup terang</li>
                            <li>• 1 QR Code berlaku untuk {{ $order->jumlah }} orang</li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column - Order Details -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4">Detail Pesanan</h2>
            
            <div class="pb-4 border-b">
                <span class="text-sm font-semibold text-blue-600">{{ $order->event->sport->name }}</span>
                <p class="font-bold text-lg mt-1">{{ $order->event->title }}</p>
                <div class="mt-3 space-y-2 text-sm text-gray-600">
                    <p class="flex items-center">
                        <span class="w-6">📅</span>
                        {{ $order->event->tanggal_mulai->format('d F Y, H:i') }} WIB
                    </p>
                    <p class="flex items-center">
                        <span class="w-6">📍</span>
                        {{ $order->event->lokasi }}
                    </p>
                </div>
            </div>

            <div class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order ID</span>
                    <span class="font-mono font-medium">#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Kategori Tiket</span>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">{{ $order->ticket->kategori }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Jumlah</span>
                    <span class="font-medium">{{ $order->jumlah }} tiket</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Harga per Tiket</span>
                    <span>Rp {{ number_format($order->ticket->harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tanggal Order</span>
                    <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $order->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $order->status === 'paid' ? 'Lunas' : 'Menunggu Pembayaran' }}
                    </span>
                </div>
                @if($order->paymentMethod)
                <div class="flex justify-between">
                    <span class="text-gray-600">Metode Pembayaran</span>
                    <span>{{ $order->paymentMethod->name }}</span>
                </div>
                @endif
                <div class="border-t pt-3">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total Bayar</span>
                        <span class="text-blue-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection