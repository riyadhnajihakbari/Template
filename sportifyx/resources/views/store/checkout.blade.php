@extends('layouts.app')

@section('title', 'Checkout - SportifyX')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Checkout</h1>
        <p class="text-gray-600 mt-1">Langkah 1 dari 3: Pilih Jumlah</p>
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
        <!-- Product Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold mb-4">Detail Produk</h2>
                <div class="flex items-start space-x-4">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover rounded-lg">
                    @else
                        <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-3xl">👕</span>
                        </div>
                    @endif
                    <div class="flex-1">
                        <span class="text-xs font-semibold text-blue-600 uppercase">{{ $product->category }}</span>
                        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                        <div class="mt-2">
                            @if($product->discount > 0)
                                <span class="line-through text-gray-400 text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="text-red-600 font-bold text-xl ml-2">Rp {{ number_format($product->final_price, 0, ',', '.') }}</span>
                            @else
                                <span class="font-bold text-xl">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Stok: {{ $product->stock }} unit</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('store.payment', $product) }}" class="mt-6">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Pembelian</label>
                    <select name="qty" id="qty" onchange="updateTotal()" class="w-full sm:w-48 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @for($i = 1; $i <= min(10, $product->stock); $i++)
                            <option value="{{ $i }}">{{ $i }} unit</option>
                        @endfor
                    </select>
                    @error('qty')
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
                        <span class="text-gray-600">Harga Satuan</span>
                        <span>Rp {{ number_format($product->final_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah</span>
                        <span id="display-qty">1 unit</span>
                    </div>
                    <div class="border-t pt-3 mt-3">
                        <div class="flex justify-between font-semibold text-lg">
                            <span>Total</span>
                            <span id="display-total" class="text-blue-600">Rp {{ number_format($product->final_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const unitPrice = {{ $product->final_price }};
    
    function updateTotal() {
        const qty = document.getElementById('qty').value;
        const total = unitPrice * qty;
        document.getElementById('display-qty').textContent = qty + ' unit';
        document.getElementById('display-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endsection