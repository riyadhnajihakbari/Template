@extends('layouts.app')

@section('title', 'Events - SportifyX')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Semua Event</h1>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('events.index') }}" class="grid md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kategori Olahraga</label>
                <select name="sport" class="w-full border rounded px-3 py-2">
                    <option value="">Semua</option>
                    @foreach($sports as $sport)
                        <option value="{{ $sport->slug }}" {{ request('sport') == $sport->slug ? 'selected' : '' }}>
                            {{ $sport->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Lokasi</label>
                <input type="text" name="location" value="{{ request('location') }}" placeholder="Cari lokasi..." class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Events Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($event->poster)
                    <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-purple-400 flex items-center justify-center">
                        <span class="text-6xl">{{ $event->sport->icon }}</span>
                    </div>
                @endif
                <div class="p-4">
                    <span class="text-sm text-blue-600 font-semibold">{{ $event->sport->name }}</span>
                    <h3 class="text-lg font-bold mt-1">{{ $event->title }}</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        📅 {{ $event->tanggal_mulai->format('d M Y, H:i') }}<br>
                        📍 {{ $event->lokasi }}
                    </p>
                    @if($event->tickets->count() > 0)
                        <p class="text-green-600 font-semibold mt-2">
                            Mulai Rp {{ number_format($event->tickets->min('harga'), 0, ',', '.') }}
                        </p>
                    @endif
                    <a href="{{ route('events.show', $event) }}" 
                       class="mt-4 block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Tidak ada event yang ditemukan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $events->links() }}
    </div>
</div>
@endsection