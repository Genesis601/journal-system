@extends('layouts.public')

@section('title', $article->title)

@section('content')

{{-- BREADCRUMB --}}
<section class="bg-[#0f2744] py-10 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-[#a0b4cc] text-sm mb-3">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span class="mx-2">›</span>
            @if($article->journal)
                <a href="{{ route('journals.show', $article->journal->slug) }}" class="hover:text-white transition-colors">{{ $article->journal->title }}</a>
                <span class="mx-2">›</span>
            @endif
            <span class="text-white">Article</span>
        </div>
        <h1 class="text-2xl font-semibold text-white leading-snug max-w-3xl">{{ $article->title }}</h1>
        <div class="flex flex-wrap items-center gap-3 mt-3 text-sm text-[#a0b4cc]">
            @if($article->author)
                <span>By <strong class="text-white">{{ $article->author->name }}</strong></span>
                <span>·</span>
            @endif
            <span>{{ $article->published_at?->format('F d, Y') }}</span>
            @if($article->journal)
                <span>·</span>
                <span>{{ $article->journal->title }}</span>
            @endif
            <span class="bg-green-500 bg-opacity-20 text-green-400 text-xs px-2 py-0.5 rounded">Open Access</span>
        </div>
    </div>
</section>

{{-- CONTENT --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Content --}}
        <div class="lg:col-span-2">

            {{-- Abstract --}}
            <div class="bg-white border border-gray-100 rounded-xl p-6 mb-5">
                <h2 class="text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-1 h-5 bg-[#e8a020] rounded-full"></span>
                    Abstract
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $article->abstract }}</p>
            </div>

            {{-- Keywords --}}
            @if($article->keywords)
                <div class="bg-white border border-gray-100 rounded-xl p-5 mb-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Keywords</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $article->keywords) as $keyword)
                            <a href="{{ route('search') }}?q={{ trim($keyword) }}"
                               class="bg-gray-100 hover:bg-[#e8a020] hover:text-white text-gray-600 text-xs px-3 py-1.5 rounded-lg transition-colors">
                                {{ trim($keyword) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Download --}}
            @if($article->file_path)
                <div class="bg-[#0f2744] rounded-xl p-5 mb-5 flex items-center justify-between">
                    <div>
                        <p class="text-white font-medium text-sm">Full Article (PDF)</p>
                        <p class="text-[#a0b4cc] text-xs mt-0.5">Download the complete research paper</p>
                    </div>
                    <a href="{{ asset('storage/' . $article->file_path) }}"
                       target="_blank"
                       class="bg-[#e8a020] hover:bg-[#d4911c] text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors">
                        Download PDF
                    </a>
                </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">

            {{-- Article Info --}}
            <div class="bg-white border border-gray-100 rounded-xl p-5 mb-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Article Info</h3>
                <div class="flex flex-col gap-3">
                    @if($article->author)
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Author</p>
                            <p class="text-sm font-medium text-gray-700">{{ $article->author->name }}</p>
                            @if($article->author->institution)
                                <p class="text-xs text-gray-400">{{ $article->author->institution }}</p>
                            @endif
                        </div>
                    @endif
                    @if($article->journal)
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Journal</p>
                            <a href="{{ route('journals.show', $article->journal->slug) }}" class="text-sm font-medium text-[#e8a020] hover:underline">
                                {{ $article->journal->title }}
                            </a>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Published</p>
                        <p class="text-sm text-gray-700">{{ $article->published_at?->format('F d, Y') }}</p>
                    </div>
                    <div>
                         <p class="text-xs text-gray-400 mb-0.5">Views</p>
                         <p class="text-sm text-gray-700">{{ number_format($article->views) }} reads</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Access</p>
                        <span class="bg-green-50 text-green-700 text-xs font-medium px-2 py-1 rounded">Open Access</span>
                    </div>
                </div>
            </div>

            {{-- Related Articles --}}
            @if($related->count())
                <div class="bg-white border border-gray-100 rounded-xl p-5">
                    <h3 class="text-sm font-semibold text-gray-800 mb-4">Related Articles</h3>
                    <div class="flex flex-col gap-3">
                        @foreach($related as $rel)
                            <a href="{{ route('articles.show', $rel->slug) }}" class="group">
                                <p class="text-xs font-medium text-gray-700 group-hover:text-[#e8a020] transition-colors leading-snug line-clamp-2">{{ $rel->title }}</p>
                                <p class="text-[10px] text-gray-400 mt-1">{{ $rel->published_at?->format('M Y') }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection