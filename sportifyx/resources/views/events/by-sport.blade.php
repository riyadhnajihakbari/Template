@extends('layouts.app')

@section('title', $sport->name . ' - SportifyX')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="flex items-center mb-6 sm:mb-8">
        <span class="text-3xl sm:text-4xl mr-3">{{ $sport->icon }}</span>
        <h1 class="text-2xl sm:text-3xl font-bold">Event {{ $sport->name }}</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        @forelse($events as $event)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($event->poster)
                    <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="w-full h-40 sm:h-48 object-cover">
                @else
                    <div class="w-full h-40 sm:h-48 bg-gradient-to-r from-blue-400 to-purple-400 flex items-center justify-center">
                        <span class="text-5xl sm:text-6xl">{{ $sport->icon }}</span>
                    </div>
                @endif
                <div class="p-4">
                    <h3 class="text-base sm:text-lg font-bold line-clamp-2">{{ $event->title }}</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        📅 {{ $event->tanggal_mulai->format('d M Y, H:i') }}<br>
                        📍 {{ $event->lokasi }}
                    </p>
                    @if($event->tickets->count() > 0)
                        <p class="text-green-600 font-semibold mt-2 text-sm sm:text-base">
                            Mulai Rp {{ number_format($event->tickets->min('harga'), 0, ',', '.') }}
                        </p>
                    @endif
                    <a href="{{ route('events.show', $event) }}" 
                       class="mt-4 block text-center bg-blue-600 text-white py-2 rounded text-sm font-medium hover:bg-blue-700 transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 text-5xl mb-4">{{ $sport->icon }}</div>
                <p class="text-gray-500">Belum ada event {{ $sport->name }} yang tersedia.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6 sm:mt-8">
        {{ $events->links() }}
    </div>
</div>
@endsection