@extends('layouts.app')

@section('title', 'Checkout - SportifyX')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout Tiket</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Detail Event</h2>
        <p class="font-semibold">{{ $event->title }}</p>
        <p class="text-gray-600">{{ $event->tanggal_mulai->format('d F Y, H:i') }}</p>
        <p class="text-gray-600">{{ $event->lokasi }}</p>
        
        <div class="mt-4 p-4 bg-blue-50 rounded">
            <p class="font-semibold">Kategori: {{ $ticket->kategori }}</p>
            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($ticket->harga, 0, ',', '.') }} / tiket</p>
        </div>
    </div>

    <form method="POST" action="{{ route('orders.store', [$event, $ticket]) }}" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        
        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Jumlah Tiket</label>
            <select name="jumlah" class="w-full border rounded px-3 py-2" id="jumlah" onchange="updateTotal()">
                @for($i = 1; $i <= min(10, $ticket->availableQuota()); $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            @error('jumlah')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Metode Pembayaran</label>
            <select name="payment_method" class="w-full border rounded px-3 py-2" required>
                <option value="qris">QRIS</option>
                <option value="transfer">Transfer Bank</option>
                <option value="midtrans">Midtrans</option>
                <option value="xendit">Xendit</option>
            </select>
            @error('payment_method')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t pt-4">
            <div class="flex justify-between text-xl font-bold">
                <span>Total:</span>
                <span id="total">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <button type="submit" class="mt-6 w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
            Bayar Sekarang
        </button>
    </form>
</div>

<script>
    const ticketPrice = {{ $ticket->harga }};
    
    function updateTotal() {
        const qty = document.getElementById('jumlah').value;
        const total = ticketPrice * qty;
        document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endsection