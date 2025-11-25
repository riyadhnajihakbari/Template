@extends('layouts.app')

@section('title', 'SportifyX - Platform Tiket Olahraga')

@section('content')
<!-- Hero Section dengan Animasi -->
@include('components.hero-animated')

<!-- Sports Categories -->
<section class="relative bg-gradient-to-br from-white via-blue-50 to-purple-50 py-16 overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-blue-200/30 to-purple-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-indigo-200/30 to-pink-200/30 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
    <div class="text-center mb-12">
        <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Pilih Kategori Olahraga</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Temukan event olahraga favoritmu dari berbagai kategori</p>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6">
        @foreach($sports as $sport)
            <a href="{{ route('events.by-sport', $sport->slug) }}" 
               class="group bg-white rounded-2xl shadow-sm hover:shadow-xl p-6 text-center transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                <div class="text-4xl sm:text-5xl mb-3 group-hover:scale-110 transition-transform duration-300">
                    {{ $sport->icon }}
                </div>
                <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                    {{ $sport->name }}
                </h3>
            </a>
        @endforeach
    </div>
    </div>
</section>

<!-- Upcoming Events -->
<section class="relative bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-16 overflow-hidden">
    <!-- Animated background shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-20 -left-20 w-80 h-80 bg-gradient-to-br from-blue-300/20 to-indigo-300/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-gradient-to-tr from-purple-300/20 to-pink-300/20 rounded-full blur-3xl animate-blob" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-indigo-200/15 to-purple-200/15 rounded-full blur-3xl animate-blob" style="animation-delay: 4s;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Event Mendatang</h2>
                <p class="text-gray-600">Jangan lewatkan event olahraga seru!</p>
            </div>
            <a href="{{ route('events.index') }}" class="mt-4 sm:mt-0 text-blue-600 hover:text-blue-700 font-medium flex items-center">
                Lihat Semua <span class="ml-2">→</span>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($upcomingEvents as $event)
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover border border-gray-100">
                    @if($event->poster)
                        <div class="relative">
                            <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="w-full h-48 sm:h-56 object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $event->sport->name }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="relative w-full h-48 sm:h-56 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-6xl opacity-50">{{ $event->sport->icon }}</span>
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $event->sport->name }}
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="p-5 sm:p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2">{{ $event->title }}</h3>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <p class="flex items-center">
                                <span class="w-5">📅</span>
                                <span>{{ $event->tanggal_mulai->format('d M Y, H:i') }}</span>
                            </p>
                            <p class="flex items-center">
                                <span class="w-5">📍</span>
                                <span class="line-clamp-1">{{ $event->lokasi }}</span>
                            </p>
                        </div>
                        @if($event->tickets->count() > 0)
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-gray-500">Mulai dari</span>
                                    <p class="text-lg font-bold text-emerald-600">
                                        Rp {{ number_format($event->tickets->min('harga'), 0, ',', '.') }}
                                    </p>
                                </div>
                                <a href="{{ route('events.show', $event) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition-colors">
                                    Beli Tiket
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Latest News -->
<section class="relative bg-gradient-to-br from-white via-purple-50 to-pink-50 py-16 overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-10 w-72 h-72 bg-gradient-to-br from-purple-200/25 to-pink-200/25 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-72 h-72 bg-gradient-to-tr from-rose-200/25 to-orange-200/25 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10">
        <div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Berita Terkini</h2>
            <p class="text-gray-600">Update informasi dunia olahraga</p>
        </div>
        <a href="{{ route('news.index') }}" class="mt-4 sm:mt-0 text-blue-600 hover:text-blue-700 font-medium flex items-center">
            Semua Berita <span class="ml-2">→</span>
        </a>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($latestNews as $news)
            <article class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover border border-gray-100">
                @if($news->image)
                    <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-44 object-cover">
                @else
                    <div class="w-full h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <span class="text-gray-400 text-4xl">📰</span>
                    </div>
                @endif
                <div class="p-5">
                    @if($news->category)
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider">{{ $news->category }}</span>
                    @endif
                    <h3 class="font-bold text-gray-900 mt-2 mb-3 line-clamp-2 leading-snug">{{ $news->title }}</h3>
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                    <a href="{{ route('news.show', $news) }}" class="text-blue-600 text-sm font-medium hover:text-blue-700 inline-flex items-center">
                        Baca selengkapnya <span class="ml-1">→</span>
                    </a>
                </div>
            </article>
        @endforeach
    </div>
    </div>
</section>

<!-- Recent Matches -->
<section class="relative bg-gradient-to-br from-gray-900 via-slate-900 to-indigo-950 text-white py-16 overflow-hidden">
    <!-- Subtle light effects for dark background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold mb-2">Hasil Pertandingan</h2>
                <p class="text-gray-400">Update skor terbaru bulan ini</p>
            </div>
            <a href="{{ route('matches.index') }}" class="mt-4 sm:mt-0 text-blue-400 hover:text-blue-300 font-medium flex items-center">
                Lihat Semua <span class="ml-2">→</span>
            </a>
        </div>
        
        <div class="bg-gray-800 rounded-2xl overflow-hidden">
            @foreach($recentMatches as $match)
                <div class="border-b border-gray-700 last:border-b-0 p-5 sm:p-6 hover:bg-gray-750 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <span class="text-3xl">{{ $match->sport->icon }}</span>
                            <div>
                                <div class="font-semibold text-lg">
                                    {{ $match->team_a }} <span class="text-gray-500 mx-2">vs</span> {{ $match->team_b }}
                                </div>
                                <div class="text-sm text-gray-400 mt-1">
                                    {{ $match->tanggal->format('d M Y') }} • {{ $match->lokasi }}
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-700 rounded-xl px-6 py-3 text-center">
                            <div class="text-xs text-gray-400 mb-1">SKOR</div>
                            <div class="text-2xl font-bold">
                                <span class="{{ $match->score_a > $match->score_b ? 'text-emerald-400' : '' }}">{{ $match->score_a }}</span>
                                <span class="mx-3 text-gray-500">-</span>
                                <span class="{{ $match->score_b > $match->score_a ? 'text-emerald-400' : '' }}">{{ $match->score_b }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="relative bg-gradient-to-br from-teal-50 via-cyan-50 to-blue-50 py-16 overflow-hidden">
    <!-- Decorative background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-teal-200/30 to-cyan-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-blue-200/30 to-indigo-200/30 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10">
        <div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Store Merchandise</h2>
            <p class="text-gray-600">Koleksi merchandise olahraga terbaru</p>
        </div>
        <a href="{{ route('store.index') }}" class="mt-4 sm:mt-0 text-blue-600 hover:text-blue-700 font-medium flex items-center">
            Lihat Semua <span class="ml-2">→</span>
        </a>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($featuredProducts as $product)
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover border border-gray-100">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-40 sm:h-52 object-cover">
                @else
                    <div class="w-full h-40 sm:h-52 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <span class="text-gray-400 text-4xl">👕</span>
                    </div>
                @endif
                <div class="p-4 sm:p-5">
                    <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider">{{ $product->category }}</span>
                    <h3 class="font-bold text-gray-900 mt-2 mb-3 line-clamp-2 text-sm sm:text-base">{{ $product->name }}</h3>
                    <div class="mb-4">
                        @if($product->discount > 0)
                            <div class="flex items-center gap-2">
                                <span class="line-through text-gray-400 text-xs sm:text-sm">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="bg-red-100 text-red-600 text-xs px-2 py-0.5 rounded-full font-medium">
                                    -{{ $product->discount }}%
                                </span>
                            </div>
                            <span class="text-red-600 font-bold text-base sm:text-lg">
                                Rp {{ number_format($product->final_price, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="font-bold text-gray-900 text-base sm:text-lg">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>
                    <a href="{{ route('store.show', $product) }}" 
                       class="block text-center bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">
                        Beli Sekarang
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    </div>
</section>

<!-- CTA Section -->
<section class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 py-16 overflow-hidden">
    <!-- Animated background effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-blob" style="animation-delay: 2s;"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Siap Nonton Event Olahraga Favoritmu?</h2>
        <p class="text-white/90 text-lg mb-8">Daftar sekarang dan dapatkan akses ke ribuan event olahraga!</p>
        <a href="{{ route('register') }}" class="inline-flex items-center bg-white text-purple-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg shadow-black/20">
            Daftar Gratis Sekarang
        </a>
    </div>
</section>

<!-- Add animation styles -->
<style>
@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(20px, -50px) scale(1.1); }
    50% { transform: translate(-20px, 20px) scale(0.9); }
    75% { transform: translate(50px, 50px) scale(1.05); }
}

.animate-blob {
    animation: blob 20s ease-in-out infinite;
}
</style>

@endsection