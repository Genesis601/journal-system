@extends('layouts.public')

@section('title', $query ? 'Search: ' . $query : 'Search Articles')

@section('content')

{{-- SEARCH HEADER --}}
<section class="bg-[#0f2744] py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-semibold text-white mb-5">Search Articles</h1>
        <form action="{{ route('search') }}" method="GET" class="max-w-2xl">
            <div class="flex items-center bg-white rounded-xl overflow-hidden shadow-lg">
                <input
                    type="text"
                    name="q"
                    value="{{ $query }}"
                    placeholder="Search articles, keywords, authors..."
                    class="flex-1 px-5 py-3.5 text-gray-700 text-sm outline-none border-none"
                    autofocus
                >
                <button type="submit" class="bg-[#e8a020] hover:bg-[#d4911c] text-white px-6 py-3.5 text-sm font-medium transition-colors">
                    Search
                </button>
            </div>
        </form>
        @if($query)
            <p class="text-[#a0b4cc] text-sm mt-3">
                @if($results instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $results->total() }} result(s) for <strong class="text-white">"{{ $query }}"</strong>
                @endif
            </p>
        @endif
    </div>
</section>

{{-- RESULTS --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if(!$query)
        {{-- No query yet --}}
        <div class="text-center py-20">
            <p class="text-5xl mb-4">🔍</p>
            <p class="text-gray-500 text-base">Enter a search term above to find articles</p>
            <div class="flex flex-wrap justify-center gap-2 mt-5">
                @foreach(['Biology', 'Medicine', 'Agriculture', 'Computer Science', 'Environment', 'Education'] as $tag)
                    <a href="{{ route('search') }}?q={{ $tag }}"
                       class="bg-gray-100 hover:bg-[#e8a020] hover:text-white text-gray-600 text-sm px-4 py-2 rounded-lg transition-colors">
                        {{ $tag }}
                    </a>
                @endforeach
            </div>
        </div>

    @elseif($results->isEmpty())
        {{-- No results --}}
        <div class="text-center py-20">
            <p class="text-5xl mb-4">😔</p>
            <p class="text-gray-700 text-base font-medium">No results found for "{{ $query }}"</p>
            <p class="text-gray-400 text-sm mt-2">Try different keywords or browse our journals</p>
            <a href="{{ route('journals.index') }}" class="inline-block mt-5 bg-[#0f2744] text-white text-sm px-6 py-2.5 rounded-lg hover:bg-[#1a3d5c] transition-colors">
                Browse Journals
            </a>
        </div>

    @else
        {{-- Results --}}
        @php
            $colors = ['bg-blue-50', 'bg-green-50', 'bg-amber-50', 'bg-purple-50', 'bg-teal-50', 'bg-red-50'];
            $icons  = ['🔬', '🌱', '⚕️', '💻', '🌊', '📚'];
        @endphp

        <div class="flex flex-col gap-4">
            @foreach($results as $index => $article)
                <a href="{{ route('articles.show', $article->slug) }}"
                   class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md hover:border-gray-200 transition-all flex gap-4 group">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 {{ $colors[$index % 6] }}">
                        <span class="text-lg">{{ $icons[$index % 6] }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-800 mb-1 leading-snug group-hover:text-[#0f2744] transition-colors">
                            {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark class="bg-yellow-100 rounded px-0.5">$1</mark>', e($article->title)) !!}
                        </h3>
                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-2">
                            {{ $article->abstract }}
                        </p>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="bg-green-50 text-green-700 text-[10px] font-medium px-2 py-0.5 rounded">Open Access</span>
                            @if($article->journal)
                                <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded">{{ $article->journal->title }}</span>
                            @endif
                            @if($article->author)
                                <span class="text-[10px] text-gray-400">{{ $article->author->name }}</span>
                            @endif
                            <span class="text-[10px] text-gray-400">{{ $article->published_at?->format('M Y') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($results->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $results->links() }}
            </div>
        @endif
    @endif

</div>

@endsection