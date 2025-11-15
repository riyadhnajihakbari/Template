@extends('layouts.app')

@section('title', $product->name . ' - SportifyX Store')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <a href="{{ route('store.index') }}" class="text-blue-600 hover:underline text-sm sm:text-base mb-4 inline-block">
        ← Kembali ke Store
    </a>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
            <!-- Product Image -->
            <div class="bg-gray-50 flex items-center justify-center p-8 lg:p-12 min-h-[400px]">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="max-w-full max-h-[400px] object-contain">
                @else
                    <div class="text-center">
                        <span class="text-gray-300 text-[120px]">👕</span>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="p-6 sm:p-8 lg:p-10 flex flex-col justify-center">
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">{{ $product->category }}</span>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-2">{{ $product->name }}</h1>

                <div class="mt-6">
                    @if($product->discount > 0)
                        <div class="flex items-center gap-3 mb-2">
                            <span class="line-through text-gray-400 text-lg">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                                Hemat {{ $product->discount }}%
                            </span>
                        </div>
                        <div class="text-3xl sm:text-4xl font-bold text-red-600">
                            Rp {{ number_format($product->final_price, 0, ',', '.') }}
                        </div>
                    @else
                        <div class="text-3xl sm:text-4xl font-bold text-gray-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    @endif
                </div>

                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">Stok tersedia:</span>
                    <span class="font-semibold {{ $product->stock > 10 ? 'text-emerald-600' : 'text-orange-600' }} ml-2">
                        {{ $product->stock }} unit
                    </span>
                </div>

                @if($product->description)
                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                @auth
                    @if($product->stock > 0)
                        <div class="mt-8">
                            <a href="{{ route('store.checkout', $product) }}" 
                               class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 transform hover:scale-[1.02]">
                                Beli Sekarang
                            </a>
                        </div>
                    @else
                        <div class="mt-8">
                            <button disabled class="block w-full bg-gray-400 text-white px-8 py-4 rounded-xl font-semibold cursor-not-allowed">
                                Stok Habis
                            </button>
                        </div>
                    @endif
                @else
                    <div class="mt-8">
                        <a href="{{ route('login') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-semibold transition-colors">
                            Login untuk Membeli
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection