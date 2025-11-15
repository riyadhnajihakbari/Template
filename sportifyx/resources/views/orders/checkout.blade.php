@extends('layouts.app')

@section('title', 'Checkout Tiket - SportifyX')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Checkout Tiket</h1>
        <p class="text-gray-600 mt-1">Langkah 1 dari 3: Pilih Jumlah Tiket</p>
    </div>

    <!-- Progress Bar -->
    <div class="flex items-center mb-8">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold">1</div>
            <span class="ml-2 font-medium text-blue-600">Jumlah</span>
        </div>
        <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">2</div>
            <span class="ml-2 text-gray-500">Pembayaran</span>
        </div>
        <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">3</div>
            <span class="ml-2 text-gray-500">Selesai</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Event Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold mb-4">Detail Event</h2>
                
                <div class="border-b pb-4 mb-4">
                    <span class="text-sm font-semibold text-blue-600">{{ $event->sport->name }}</span>
                    <h3 class="font-bold text-xl mt-1">{{ $event->title }}</h3>
                    <div class="mt-3 space-y-2 text-sm text-gray-600">
                        <p>📅 {{ $event->tanggal_mulai->format('d F Y, H:i') }}</p>
                        <p>📍 {{ $event->lokasi }}</p>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-600 font-medium">Kategori Tiket</p>
                    <p class="text-2xl font-bold text-blue-800">{{ $ticket->kategori }}</p>
                    <p class="text-lg font-semibold text-blue-700 mt-1">Rp {{ number_format($ticket->harga, 0, ',', '.') }} / tiket</p>
                    <p class="text-sm text-blue-600 mt-1">Tersedia: {{ $ticket->availableQuota() }} tiket</p>
                </div>

                <form method="POST" action="{{ route('tickets.payment', [$event, $ticket]) }}">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Tiket</label>
                    <select name="jumlah" id="jumlah" onchange="updateTotal()" class="w-full sm:w-48 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @for($i = 1; $i <= min(10, $ticket->availableQuota()); $i++)
                            <option value="{{ $i }}">{{ $i }} tiket</option>
                        @endfor
                    </select>
                    @error('jumlah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition-colors">
                            Lanjut ke Pembayaran →
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6 top-24">
                <h2 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Harga per Tiket</span>
                        <span>Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah</span>
                        <span id="display-qty">1 tiket</span>
                    </div>
                    <div class="border-t pt-3 mt-3">
                        <div class="flex justify-between font-semibold text-lg">
                            <span>Total</span>
                            <span id="display-total" class="text-blue-600">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ticketPrice = {{ $ticket->harga }};
    
    function updateTotal() {
        const qty = document.getElementById('jumlah').value;
        const total = ticketPrice * qty;
        document.getElementById('display-qty').textContent = qty + ' tiket';
        document.getElementById('display-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endsection