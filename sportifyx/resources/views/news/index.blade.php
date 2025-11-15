@extends('layouts.app')

@section('title', 'Berita Olahraga - SportifyX')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8">Berita Terkini</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
        @forelse($news as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-40 sm:h-48 object-cover">
                @else
                    <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                        <span class="text-white text-4xl sm:text-5xl">📰</span>
                    </div>
                @endif
                <div class="p-4">
                    @if($item->category)
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">{{ $item->category }}</span>
                    @endif
                    <h3 class="font-bold text-base sm:text-lg mt-1 line-clamp-2">{{ $item->title }}</h3>
                    <p class="text-gray-600 text-sm mt-2 line-clamp-3">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                    <div class="mt-3 flex justify-between items-center">
                        <span class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</span>
                        <a href="{{ route('news.show', $item) }}" class="text-blue-600 text-sm font-medium hover:underline">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 text-5xl mb-4">📭</div>
                <p class="text-gray-500">Belum ada berita.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6 sm:mt-8">
        {{ $news->links() }}
    </div>
</div>
@endsection