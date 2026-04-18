@extends('layouts.public')

@section('title', 'JournalSpace — Open Access Research Publishing')

@section('content')

{{-- HERO --}}
<section class="bg-gradient-to-br from-[#0f2744] via-[#1a3d5c] to-[#0f2744] py-20 px-4 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#e8a020] opacity-5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-400 opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>

    <div class="max-w-4xl mx-auto text-center relative z-10">
        <div class="inline-block bg-[#e8a020] bg-opacity-20 text-[#e8a020] text-xs font-medium px-3 py-1 rounded-full mb-4 border border-[#e8a020] border-opacity-30">
            Open Access · Peer Reviewed · Free to Read
        </div>
        <h1 class="text-4xl md:text-5xl font-semibold text-white mb-4 leading-tight">
            Discover Open Access<br>
            <span class="text-[#e8a020]">Research That Matters</span>
        </h1>
        <p class="text-[#a0b4cc] text-lg mb-10 max-w-2xl mx-auto">
            Search thousands of peer-reviewed articles across journals in science, technology, medicine, agriculture and more.
        </p>

        {{-- Search Bar --}}
        <form action="{{ route('search') }}" method="GET" class="max-w-2xl mx-auto">
            <div class="flex items-center bg-white rounded-xl shadow-2xl overflow-hidden">
                <input
                    type="text"
                    name="q"
                    placeholder="Search articles, journals, authors, keywords..."
                    class="flex-1 px-5 py-4 text-gray-700 text-sm outline-none border-none"
                    value="{{ request('q') }}"
                    autocomplete="off"
                >
                <button type="submit" class="bg-[#e8a020] hover:bg-[#d4911c] text-white px-7 py-4 text-sm font-medium transition-colors whitespace-nowrap">
                    Search
                </button>
            </div>
        </form>

        {{-- Quick Tags --}}
        <div class="flex flex-wrap justify-center gap-2 mt-5">
            @foreach(['Biology', 'Medicine', 'Agriculture', 'Computer Science', 'Environment', 'Education', 'Chemistry'] as $tag)
                <a href="{{ route('search') }}?q={{ $tag }}" class="bg-white bg-opacity-10 hover:bg-opacity-20 text-[#c5d5e8] text-xs px-3 py-1.5 rounded-full border border-white border-opacity-20 transition-all cursor-pointer">
                    {{ $tag }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- STATS BAR --}}
<section class="bg-[#e8a020]">
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center py-2">
                <div class="text-white text-2xl font-semibold">{{ number_format($stats['journals']) }}</div>
                <div class="text-white text-opacity-80 text-xs">Active Journals</div>
            </div>
            <div class="text-center py-2">
                <div class="text-white text-2xl font-semibold">{{ number_format($stats['articles']) }}+</div>
                <div class="text-white text-opacity-80 text-xs">Published Articles</div>
            </div>
            <div class="text-center py-2">
                <div class="text-white text-2xl font-semibold">{{ number_format($stats['authors']) }}+</div>
                <div class="text-white text-opacity-80 text-xs">Registered Authors</div>
            </div>
            <div class="text-center py-2">
                <div class="text-white text-2xl font-semibold">180+</div>
                <div class="text-white text-opacity-80 text-xs">Countries Reached</div>
            </div>
        </div>
    </div>
</section>

{{-- MAIN CONTENT --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

    {{-- JOURNALS SECTION --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
            <span class="w-1 h-6 bg-[#e8a020] rounded-full inline-block"></span>
            Browse Journals
        </h2>
        <a href="{{ route('journals.index') }}" class="text-[#e8a020] hover:text-[#d4911c] text-sm font-medium transition-colors">View all journals →</a>
    </div>

    @php
        $colors = [
            'bg-blue-50 text-blue-600',
            'bg-green-50 text-green-600',
            'bg-amber-50 text-amber-600',
            'bg-purple-50 text-purple-600',
            'bg-teal-50 text-teal-600',
            'bg-red-50 text-red-600',
            'bg-pink-50 text-pink-600',
            'bg-indigo-50 text-indigo-600',
        ];
        $icons = ['🔬', '🌱', '⚕️', '💻', '🌊', '📚', '🧬', '⚡'];
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-14">
        @forelse($journals as $index => $journal)
            <a href="{{ route('journals.show', $journal->slug) }}"
               class="bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-md hover:border-gray-200 transition-all group">
                <div class="h-24 flex items-center justify-center {{ explode(' ', $colors[$index % 8])[0] }}">
                    <span class="text-3xl">{{ $icons[$index % 8] }}</span>
                </div>
                <div class="p-3">
                    <h3 class="text-sm font-medium text-gray-800 leading-snug mb-1 group-hover:text-[#0f2744] transition-colors line-clamp-2">
                        {{ $journal->title }}
                    </h3>
                    <p class="text-xs text-gray-400">{{ $journal->published_articles_count ?? 0 }} articles · {{ ucfirst($journal->frequency) }}</p>
                    @if($journal->issn)
                        <p class="text-[10px] text-gray-300 mt-0.5">ISSN: {{ $journal->issn }}</p>
                    @endif
                </div>
            </a>
        @empty
            <div class="col-span-4 text-center py-12 text-gray-400">
                <p class="text-4xl mb-3">📚</p>
                <p class="text-sm">No journals available yet.</p>
            </div>
        @endforelse
    </div>

    {{-- ARTICLES + SIDEBAR --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Articles List --}}
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <span class="w-1 h-6 bg-[#e8a020] rounded-full inline-block"></span>
                    Latest Articles
                </h2>
                <a href="{{ route('articles.index') }}" class="text-[#e8a020] hover:text-[#d4911c] text-sm font-medium transition-colors">Browse all →</a>
            </div>

            <div class="flex flex-col gap-4">
                @forelse($latestArticles as $index => $article)
                    <a href="{{ route('articles.show', $article->slug) }}"
                       class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md hover:border-gray-200 transition-all flex gap-4 group">
                        <div class="w-11 h-11 rounded-lg flex items-center justify-center flex-shrink-0 {{ explode(' ', $colors[$index % 8])[0] }}">
                            <span class="text-lg">{{ $icons[$index % 8] }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-800 mb-1 leading-snug group-hover:text-[#0f2744] transition-colors line-clamp-2">
                                {{ $article->title }}
                            </h3>
                            <p class="text-xs text-gray-500 mb-2 line-clamp-2 leading-relaxed">
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
                @empty
                    <div class="bg-white border border-gray-100 rounded-xl p-12 text-center text-gray-400">
                        <p class="text-4xl mb-3">📄</p>
                        <p class="text-sm">No articles published yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">

            {{-- Search --}}
            <div class="bg-white border border-gray-100 rounded-xl p-5 mb-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-3">Quick Search</h3>
                <form action="{{ route('search') }}" method="GET">
                    <div class="flex gap-2">
                        <input type="text" name="q" placeholder="Search..." class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#e8a020]">
                        <button type="submit" class="bg-[#0f2744] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#1a3d5c] transition-colors">Go</button>
                    </div>
                </form>
            </div>

            {{-- Categories --}}
            <div class="bg-white border border-gray-100 rounded-xl p-5 mb-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Browse by Subject</h3>
                <div class="flex flex-col divide-y divide-gray-50">
                    @foreach(['Biological Sciences', 'Medical Sciences', 'Agricultural Science', 'Computer Science', 'Environmental Science', 'Education Research', 'Social Sciences'] as $category)
                        <a href="{{ route('search') }}?q={{ $category }}" class="flex items-center justify-between py-2.5 hover:text-[#e8a020] transition-colors group">
                            <span class="text-sm text-gray-600 group-hover:text-[#e8a020]">{{ $category }}</span>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-[#e8a020]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Submit CTA --}}
            <div class="bg-[#0f2744] rounded-xl p-6 text-center">
                <div class="text-3xl mb-3">✍️</div>
                <h3 class="text-white font-semibold text-sm mb-2">Publish Your Research</h3>
                <p class="text-[#a0b4cc] text-xs leading-relaxed mb-4">Join thousands of researchers sharing open-access work with the global academic community.</p>
                <a href="{{ route('register') }}" class="block bg-[#e8a020] hover:bg-[#d4911c] text-white text-sm font-medium py-2.5 rounded-lg transition-colors">
                    Submit a Manuscript
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Live search suggestions (basic)
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput) {
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    }
</script>
@endpush