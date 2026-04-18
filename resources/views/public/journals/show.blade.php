@extends('layouts.public')

@section('title', $journal->title)

@section('content')

{{-- PAGE HEADER --}}
<section class="bg-[#0f2744] py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-[#a0b4cc] text-sm mb-3">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span class="mx-2">›</span>
            <a href="{{ route('journals.index') }}" class="hover:text-white transition-colors">Journals</a>
            <span class="mx-2">›</span>
            <span class="text-white">{{ $journal->title }}</span>
        </div>
        <div class="flex items-start gap-5">
            <div class="w-16 h-16 bg-[#e8a020] bg-opacity-20 rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="text-3xl">📘</span>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-white mb-1">{{ $journal->title }}</h1>
                <div class="flex flex-wrap items-center gap-3 text-sm text-[#a0b4cc]">
                    @if($journal->issn)
                        <span>ISSN: {{ $journal->issn }}</span>
                        <span>·</span>
                    @endif
                    <span>{{ ucfirst($journal->frequency) }}</span>
                    <span>·</span>
                    <span>{{ $articles->total() }} Articles</span>
                    <span class="bg-green-500 bg-opacity-20 text-green-400 text-xs px-2 py-0.5 rounded">Open Access</span>
                </div>
                @if($journal->description)
                    <p class="text-[#a0b4cc] text-sm mt-2 max-w-2xl leading-relaxed">{{ $journal->description }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ARTICLES --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h2 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <span class="w-1 h-5 bg-[#e8a020] rounded-full inline-block"></span>
        Published Articles
    </h2>

    <div class="flex flex-col gap-4">
        @forelse($articles as $article)
            <a href="{{ route('articles.show', $article->slug) }}"
               class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md hover:border-gray-200 transition-all group">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2 leading-snug group-hover:text-[#0f2744] transition-colors">
                            {{ $article->title }}
                        </h3>
                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-3">
                            {{ $article->abstract }}
                        </p>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="bg-green-50 text-green-700 text-[10px] font-medium px-2 py-0.5 rounded">Open Access</span>
                            @if($article->keywords)
                                @foreach(array_slice(explode(',', $article->keywords), 0, 3) as $keyword)
                                    <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded">{{ trim($keyword) }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0">
                        @if($article->author)
                            <p class="text-xs font-medium text-gray-700">{{ $article->author->name }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">{{ $article->published_at?->format('M d, Y') }}</p>
                        <span class="inline-block mt-2 text-[#e8a020] text-xs font-medium group-hover:underline">Read →</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white border border-gray-100 rounded-xl p-16 text-center text-gray-400">
                <p class="text-5xl mb-4">📄</p>
                <p class="text-base font-medium text-gray-500">No articles published yet</p>
                <p class="text-sm mt-1">Articles will appear here once published</p>
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