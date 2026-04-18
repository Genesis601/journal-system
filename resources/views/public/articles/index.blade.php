@extends('layouts.public')

@section('title', 'All Articles')

@section('content')

{{-- PAGE HEADER --}}
<section class="bg-[#0f2744] py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-[#a0b4cc] text-sm mb-2">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span class="mx-2">›</span>
            <span class="text-white">Articles</span>
        </div>
        <h1 class="text-3xl font-semibold text-white mb-2">All Articles</h1>
        <p class="text-[#a0b4cc] text-sm">Browse all published open access research articles</p>
    </div>
</section>

{{-- CONTENT --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    @php
        $colors = ['bg-blue-50', 'bg-green-50', 'bg-amber-50', 'bg-purple-50', 'bg-teal-50', 'bg-red-50', 'bg-pink-50', 'bg-indigo-50'];
        $icons  = ['🔬', '🌱', '⚕️', '💻', '🌊', '📚', '🧬', '⚡'];
    @endphp

    <div class="flex flex-col gap-4">
        @forelse($articles as $index => $article)
            <a href="{{ route('articles.show', $article->slug) }}"
               class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md hover:border-gray-200 transition-all flex gap-4 group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 {{ $colors[$index % 8] }}">
                    <span class="text-xl">{{ $icons[$index % 8] }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-800 mb-1 leading-snug group-hover:text-[#0f2744] transition-colors">
                                {{ $article->title }}
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-2">
                                {{ $article->abstract }}
                            </p>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="bg-green-50 text-green-700 text-[10px] font-medium px-2 py-0.5 rounded">Open Access</span>
                                @if($article->journal)
                                    <span class="bg-[#e8f0fe] text-[#0f2744] text-[10px] px-2 py-0.5 rounded">{{ $article->journal->title }}</span>
                                @endif
                                @if($article->keywords)
                                    @foreach(array_slice(explode(',', $article->keywords), 0, 2) as $keyword)
                                        <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded">{{ trim($keyword) }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            @if($article->author)
                                <p class="text-xs font-medium text-gray-700">{{ $article->author->name }}</p>
                            @endif
                            <p class="text-xs text-gray-400 mt-1">{{ $article->published_at?->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white border border-gray-100 rounded-xl p-20 text-center text-gray-400">
                <p class="text-5xl mb-4">📄</p>
                <p class="text-base font-medium text-gray-500">No articles published yet</p>
            </div>
        @endforelse
    </div>

    @if($articles->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $articles->links() }}
        </div>
    @endif

</div>

@endsection