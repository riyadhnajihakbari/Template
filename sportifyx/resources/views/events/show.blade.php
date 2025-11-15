@extends('layouts.app')

@section('title', $event->title . ' - SportifyX')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <a href="{{ route('events.index') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">
        ← Kembali ke Events
    </a>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
            <div class="bg-gray-50">
                @if($event->poster)
                    <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="w-full h-64 sm:h-80 lg:h-full object-cover">
                @else
                    <div class="w-full h-64 sm:h-80 lg:h-full min-h-[400px] bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-8xl opacity-50">{{ $event->sport->icon }}</span>
                    </div>
                @endif
            </div>
            <div class="p-6 sm:p-8 lg:p-10">
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">{{ $event->sport->name }}</span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mt-2 text-gray-900">{{ $event->title }}</h1>
                
                <div class="mt-6 space-y-4">
                    <div class="flex items-start">
                        <span class="text-xl mr-3 mt-0.5">📅</span>
                        <div>
                            <p class="font-medium text-gray-900">{{ $event->tanggal_mulai->format('d F Y') }}</p>
                            <p class="text-gray-600">{{ $event->tanggal_mulai->format('H:i') }} - {{ $event->tanggal_selesai->format('H:i') }} WIB</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <span class="text-xl mr-3 mt-0.5">📍</span>
                        <div>
                            <p class="font-medium text-gray-900">{{ $event->lokasi }}</p>
                        </div>
                    </div>
                </div>

                @if($event->description)
                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Deskripsi Event</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $event->description }}</p>
                    </div>
                @endif

                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-600 font-medium">Harga tiket mulai dari</p>
                    @if($event->tickets->count() > 0)
                        <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($event->tickets->min('harga'), 0, ',', '.') }}</p>
                    @else
                        <p class="text-gray-500">Tiket belum tersedia</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-900">Pilih Kategori Tiket</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($event->tickets as $ticket)
                <div class="bg-white rounded-xl shadow-sm p-6 {{ $ticket->availableQuota() <= 0 ? 'opacity-50' : 'hover:shadow-md transition-shadow' }}">
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $ticket->kategori }}</h3>
                        <p class="text-3xl font-bold text-blue-600">
                            Rp {{ number_format($ticket->harga, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">per tiket</p>
                    </div>
                    
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg text-center">
                        <p class="text-sm text-gray-600">
                            Tersedia: <span class="font-semibold {{ $ticket->availableQuota() > 50 ? 'text-emerald-600' : 'text-orange-600' }}">{{ $ticket->availableQuota() }}</span> / {{ $ticket->kuota }}
                        </p>
                    </div>

                    @auth
                        @if($ticket->availableQuota() > 0)
                            <a href="{{ route('tickets.checkout', [$event, $ticket]) }}" 
                               class="mt-4 block text-center bg-emerald-600 text-white py-3 rounded-lg font-semibold hover:bg-emerald-700 transition-colors">
                                Beli Tiket
                            </a>
                        @else
                            <button disabled class="mt-4 block w-full text-center bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed">
                                Habis
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="mt-4 block text-center bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Login untuk Beli
                        </a>
                    @endauth
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection