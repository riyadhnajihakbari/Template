@extends('layouts.app')

@section('title', 'Hasil Pertandingan - SportifyX')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8">Hasil Pertandingan Bulan Ini</h1>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @forelse($matches as $match)
            <div class="border-b last:border-b-0 p-4 sm:p-6 hover:bg-gray-50 transition-colors">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Match Info -->
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <span class="text-2xl sm:text-3xl">{{ $match->sport->icon }}</span>
                        <div>
                            <div class="font-semibold text-base sm:text-lg">
                                {{ $match->team_a }} <span class="text-gray-400">vs</span> {{ $match->team_b }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600 mt-1">
                                <span class="inline-flex items-center">
                                    📅 {{ $match->tanggal->format('d M Y, H:i') }}
                                </span>
                                <span class="mx-2 hidden sm:inline">•</span>
                                <span class="block sm:inline mt-1 sm:mt-0">
                                    📍 {{ $match->lokasi }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Score -->
                    <div class="flex items-center justify-center sm:justify-end">
                        <div class="bg-gray-100 rounded-lg px-4 sm:px-6 py-2 sm:py-3 text-center">
                            <div class="text-xs text-gray-500 mb-1">SKOR AKHIR</div>
                            <div class="text-2xl sm:text-3xl font-bold">
                                <span class="{{ $match->score_a > $match->score_b ? 'text-green-600' : ($match->score_a < $match->score_b ? 'text-red-600' : 'text-gray-700') }}">
                                    {{ $match->score_a }}
                                </span>
                                <span class="mx-2 sm:mx-3 text-gray-400">-</span>
                                <span class="{{ $match->score_b > $match->score_a ? 'text-green-600' : ($match->score_b < $match->score_a ? 'text-red-600' : 'text-gray-700') }}">
                                    {{ $match->score_b }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($match->highlight_url)
                    <div class="mt-3">
                        <a href="{{ $match->highlight_url }}" target="_blank" class="text-blue-600 text-sm hover:underline">
                            🎥 Lihat Highlight
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <div class="p-8 sm:p-12 text-center">
                <div class="text-gray-400 text-5xl mb-4">🏆</div>
                <p class="text-gray-500">Belum ada hasil pertandingan bulan ini.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6 sm:mt-8">
        {{ $matches->links() }}
    </div>
</div>
@endsection