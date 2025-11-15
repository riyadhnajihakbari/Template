@extends('layouts.app')

@section('title', 'Store Merchandise - SportifyX')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8">Store Merchandise</h1>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow flex flex-col h-full">
                <!-- Image Container - Fixed Height -->
                <div class="relative bg-gray-50 h-40 sm:h-48 lg:h-52 flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-300 text-5xl">👕</span>
                    @endif
                </div>
                
                <!-- Content - Flex Grow -->
                <div class="p-4 flex flex-col flex-grow">
                    <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider">{{ $product->category }}</span>
                    <h3 class="font-bold text-sm sm:text-base mt-1 line-clamp-2 flex-grow">{{ $product->name }}</h3>
                    
                    <!-- Price - Fixed Position -->
                    <div class="mt-3">
                        @if($product->discount > 0)
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="line-through text-gray-400 text-xs">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="bg-red-100 text-red-600 text-xs px-2 py-0.5 rounded-full font-medium">
                                    -{{ $product->discount }}%
                                </span>
                            </div>
                            <span class="text-red-600 font-bold text-base sm:text-lg block">
                                Rp {{ number_format($product->final_price, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="font-bold text-base sm:text-lg block">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <div class="text-xs text-gray-500 mt-2">
                        Stok: {{ $product->stock }}
                    </div>

                    <!-- Button - Always at Bottom -->
                    <a href="{{ route('store.show', $product) }}" 
                       class="mt-4 block text-center bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">
                        Beli Sekarang
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 text-5xl mb-4">🛍️</div>
                <p class="text-gray-500">Belum ada produk tersedia.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6 sm:mt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection