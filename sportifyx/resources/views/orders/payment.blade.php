@extends('layouts.app')

@section('title', 'Pilih Pembayaran - SportifyX')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Pilih Metode Pembayaran</h1>
        <p class="text-gray-600 mt-1">Langkah 2 dari 3: Pilih cara pembayaran</p>
    </div>

    <!-- Progress Bar -->
    <div class="flex items-center mb-8">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-emerald-600 text-white rounded-full flex items-center justify-center font-semibold">✓</div>
            <span class="ml-2 font-medium text-emerald-600">Jumlah</span>
        </div>
        <div class="flex-1 h-1 bg-emerald-600 mx-4"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold">2</div>
            <span class="ml-2 font-medium text-blue-600">Pembayaran</span>
        </div>
        <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">3</div>
            <span class="ml-2 text-gray-500">Selesai</span>
        </div>
    </div>

    <form method="POST" action="{{ route('tickets.process', [$event, $ticket]) }}">
        @csrf
        <input type="hidden" name="jumlah" value="{{ $jumlah }}">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Methods -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4">Metode Pembayaran</h2>

                    <!-- Bank Transfer -->
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-700 mb-3">Transfer Bank</h3>
                        <div class="space-y-3">
                            @foreach($paymentMethods->where('type', 'bank') as $method)
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                                    <input type="radio" name="payment_method_id" value="{{ $method->id }}" class="w-5 h-5 text-blue-600" required>
                                    <div class="ml-4 flex-1">
                                        <div class="font-semibold">{{ $method->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $method->account_number }} - {{ $method->account_name }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- E-Wallet -->
                    <div>
                        <h3 class="font-medium text-gray-700 mb-3">E-Wallet</h3>
                        <div class="space-y-3">
                            @foreach($paymentMethods->where('type', 'ewallet') as $method)
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                                    <input type="radio" name="payment_method_id" value="{{ $method->id }}" class="w-5 h-5 text-blue-600" required>
                                    <div class="ml-4 flex-1">
                                        <div class="font-semibold">{{ $method->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $method->account_number }} - {{ $method->account_name }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                    <h2 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h2>
                    
                    <div class="pb-4 border-b mb-4">
                        <p class="font-medium">{{ $event->title }}</p>
                        <p class="text-sm text-gray-600">{{ $event->tanggal_mulai->format('d M Y, H:i') }}</p>
                        <p class="text-sm text-gray-600">{{ $event->lokasi }}</p>
                        <div class="mt-2">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">{{ $ticket->kategori }}</span>
                            <span class="text-sm ml-2">x {{ $jumlah }} tiket</span>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span>Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Layanan</span>
                            <span class="text-emerald-600">Gratis</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total Bayar</span>
                                <span class="text-blue-600">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="mt-6 w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-lg font-semibold transition-colors">
                        Konfirmasi Pesanan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection