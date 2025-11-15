@extends('layouts.app')

@section('title', $news->title . ' - SportifyX')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <a href="{{ route('news.index') }}" class="text-blue-600 hover:underline text-sm sm:text-base mb-4 inline-block">
        ← Kembali ke Berita
    </a>

    <article class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($news->image)
            <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-48 sm:h-64 lg:h-80 object-cover">
        @else
            <div class="w-full h-48 sm:h-64 lg:h-80 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                <span class="text-white text-6xl sm:text-8xl">📰</span>
            </div>
        @endif

        <div class="p-4 sm:p-6 lg:p-8">
            <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-sm text-gray-500 mb-4">
                @if($news->category)
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                        {{ $news->category }}
                    </span>
                @endif
                <span>{{ $news->created_at->format('d F Y') }}</span>
                <span>{{ $news->created_at->diffForHumans() }}</span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 sm:mb-6">{{ $news->title }}</h1>

            <div class="prose prose-sm sm:prose lg:prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($news->content)) !!}
            </div>

            <!-- Share Buttons -->
            <div class="mt-6 sm:mt-8 pt-6 border-t">
                <h4 class="font-semibold mb-3 text-sm sm:text-base">Bagikan Berita:</h4>
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                       target="_blank"
                       class="bg-blue-600 text-white px-3 sm:px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
                        Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" 
                       target="_blank"
                       class="bg-sky-500 text-white px-3 sm:px-4 py-2 rounded text-sm hover:bg-sky-600 transition">
                        Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . request()->url()) }}" 
                       target="_blank"
                       class="bg-green-500 text-white px-3 sm:px-4 py-2 rounded text-sm hover:bg-green-600 transition">
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </article>
</div>
@endsection