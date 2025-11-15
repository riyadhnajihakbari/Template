@extends('layouts.app')

@section('title', 'Detail Tiket - SportifyX')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">E-Ticket</h1>
            <p class="text-gray-600">Order #{{ $order->id }}</p>
        </div>

        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-bold">{{ $order->event->title }}</h2>
            <div class="mt-4 space-y-2">
                <p><strong>Tanggal:</strong> {{ $order->event->tanggal_mulai->format('d F Y, H:i') }}</p>
                <p><strong>Lokasi:</strong> {{ $order->event->lokasi }}</p>
                <p><strong>Kategori:</strong> {{ $order->ticket->kategori }}</p>
                <p><strong>Jumlah:</strong> {{ $order->jumlah }} tiket</p>
                <p><strong>Total:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- QR Code -->
        <div class="text-center">
            <h3 class="font-semibold mb-4">QR Code Tiket</h3>
            <div class="inline-block bg-white p-4 border rounded">
                <!-- Simple QR representation -->
                <div class="w-48 h-48 bg-gray-100 flex items-center justify-center border">
                    <div class="text-center">
                        <p class="text-xs text-gray-500">QR Code</p>
                        <p class="text-sm font-mono mt-2">{{ $order->qr_code }}</p>
                    </div>
                </div>
            </div>
            <p class="text-sm text-gray-600 mt-4">Tunjukkan QR Code ini saat masuk venue</p>
        </div>

        <div class="mt-8 text-center">
            <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Cetak Tiket
            </button>
        </div>
    </div>
</div>
@endsection