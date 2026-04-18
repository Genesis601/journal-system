@extends('layouts.public')

@section('title', 'All Journals')

@section('content')

{{-- PAGE HEADER --}}
<section class="bg-[#0f2744] py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-[#a0b4cc] text-sm mb-2">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span class="mx-2">›</span>
            <span class="text-white">Journals</span>
        </div>
        <h1 class="text-3xl font-semibold text-white mb-2">All Journals</h1>
        <p class="text-[#a0b4cc] text-sm">Browse our complete collection of peer-reviewed open access journals</p>
    </div>
</section>

{{-- CONTENT --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    @php
        $colors = [
            'bg-blue-50', 'bg-green-50', 'bg-amber-50', 'bg-purple-50',
            'bg-teal-50', 'bg-red-50', 'bg-pink-50', 'bg-indigo-50',
        ];
        $icons = ['🔬', '🌱', '⚕️', '💻', '🌊', '📚', '🧬', '⚡'];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @forelse($journals as $index => $journal)
            <a href="{{ route('journals.show', $journal->slug) }}"
               class="bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-md hover:border-gray-200 transition-all group">
                <div class="h-28 flex items-center justify-center {{ $colors[$index % 8] }}">
                    <span class="text-4xl">{{ $icons[$index % 8] }}</span>
                </div>
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-gray-800 leading-snug mb-2 group-hover:text-[#0f2744] transition-colors line-clamp-2">
                        {{ $journal->title }}
                    </h3>
                    @if($journal->description)
                        <p class="text-xs text-gray-400 line-clamp-2 mb-3 leading-relaxed">{{ $journal->description }}</p>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">{{ $journal->published_articles_count ?? 0 }} articles</span>
                        <span class="bg-[#e8a020] bg-opacity-10 text-[#e8a020] text-[10px] px-2 py-0.5 rounded font-medium">{{ ucfirst($journal->frequency) }}</span>
                    </div>
                    @if($journal->issn)
                        <p class="text-[10px] text-gray-300 mt-2">ISSN: {{ $journal->issn }}</p>
                    @endif
                </div>
            </a>
        @empty
            <div class="col-span-4 text-center py-20 text-gray-400">
                <p class="text-5xl mb-4">📚</p>
                <p class="text-base font-medium text-gray-500">No journals available yet</p>
                <p class="text-sm mt-1">Check back soon for new journals</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($journals->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $journals->links() }}
        </div>
    @endif

</div>

@endsection