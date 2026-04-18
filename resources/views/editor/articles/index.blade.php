 
@extends('layouts.dashboard')

@section('title', 'Published Articles')
@section('page-title', 'Manage Articles')

@section('sidebar-nav')
@php
    $navItems = [
        ['route' => 'editor.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'editor.manuscripts.index', 'label' => 'Manuscripts', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['route' => 'editor.articles.index', 'label' => 'Published Articles', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
        ['route' => 'editor.messages.index', 'label' => 'Messages', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
    ];
@endphp
<div class="flex flex-col gap-1">
    @foreach($navItems as $item)
        <a href="{{ route($item['route']) }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs transition-colors
                  {{ request()->routeIs($item['route']) ? 'bg-[#e8a020] text-white' : 'text-[#a0b4cc] hover:text-white hover:bg-[#1e3a5a]' }}">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
            </svg>
            {{ $item['label'] }}
        </a>
    @endforeach
</div>
@endsection

@section('content')

{{-- FILTERS --}}
<form method="GET" action="{{ route('editor.articles.index') }}" class="bg-white rounded-xl border border-gray-100 p-4 mb-5 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[180px]">
        <label class="block text-xs text-gray-500 mb-1">Search</label>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search articles..."
               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#e8a020] transition-colors">
    </div>
    <div class="min-w-[160px]">
        <label class="block text-xs text-gray-500 mb-1">Journal</label>
        <select name="journal_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#e8a020] transition-colors">
            <option value="">All Journals</option>
            @foreach($journals as $journal)
                <option value="{{ $journal->id }}" {{ request('journal_id') == $journal->id ? 'selected' : '' }}>
                    {{ $journal->title }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="bg-[#0f2744] text-white text-sm px-4 py-2 rounded-lg hover:bg-[#1a3d5c] transition-colors">
        Filter
    </button>
    @if(request()->hasAny(['search', 'journal_id']))
        <a href="{{ route('editor.articles.index') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">Clear</a>
    @endif
</form>

{{-- ARTICLES TABLE --}}
<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-800">Published Articles</h2>
        <span class="text-xs text-gray-400">{{ $articles->total() }} total</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Title</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Author</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Journal</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Published</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($articles as $article)
                    <tr class="hover:bg-gray-50 transition-colors" id="article-{{ $article->id }}">
                        <td class="px-5 py-4">
                            <p class="text-xs font-medium text-gray-800 max-w-xs line-clamp-2">{{ $article->title }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-600">{{ $article->author?->name }}</p>
                            <p class="text-[10px] text-gray-400">{{ $article->author?->email }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-500">{{ $article->journal?->title }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-400">{{ $article->published_at?->format('M d, Y') }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                {{-- Unpublish --}}
                                <button onclick="openModal('unpublish-{{ $article->id }}')"
                                        class="text-xs bg-amber-50 text-amber-700 hover:bg-amber-100 px-2.5 py-1 rounded-lg transition-colors">
                                    Unpublish
                                </button>
                                {{-- Delete --}}
                                <button onclick="openModal('delete-{{ $article->id }}')"
                                        class="text-xs bg-red-50 text-red-600 hover:bg-red-100 px-2.5 py-1 rounded-lg transition-colors">
                                    Delete
                                </button>
                            </div>

                            {{-- UNPUBLISH MODAL --}}
                            <div id="unpublish-{{ $article->id }}"
                                 class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center p-4">
                                <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
                                    <h3 class="text-sm font-semibold text-gray-800 mb-1">Unpublish Article</h3>
                                    <p class="text-xs text-gray-400 mb-4">The author will be notified and asked to revise their work.</p>
                                    <form method="POST" action="{{ route('editor.articles.unpublish', $article->id) }}">
                                        @csrf
                                        <textarea name="reason" rows="4" required
                                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 outline-none focus:border-amber-400 transition-colors resize-none mb-3"
                                                  placeholder="Explain why this article needs revision..."></textarea>
                                        <div class="flex gap-2">
                                            <button type="submit"
                                                    class="flex-1 bg-amber-500 hover:bg-amber-600 text-white text-sm py-2 rounded-lg transition-colors">
                                                Unpublish & Notify
                                            </button>
                                            <button type="button" onclick="closeModal('unpublish-{{ $article->id }}')"
                                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm py-2 rounded-lg transition-colors">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- DELETE MODAL --}}
                            <div id="delete-{{ $article->id }}"
                                 class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center p-4">
                                <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
                                    <h3 class="text-sm font-semibold text-red-600 mb-1">Delete Article</h3>
                                    <p class="text-xs text-gray-400 mb-4">This is permanent. The author will be notified of the deletion.</p>
                                    <form method="POST" action="{{ route('editor.articles.delete', $article->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <textarea name="reason" rows="4" required
                                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 outline-none focus:border-red-400 transition-colors resize-none mb-3"
                                                  placeholder="Explain why this article is being permanently deleted..."></textarea>
                                        <div class="flex gap-2">
                                            <button type="submit"
                                                    class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm py-2 rounded-lg transition-colors">
                                                Delete & Notify Author
                                            </button>
                                            <button type="button" onclick="closeModal('delete-{{ $article->id }}')"
                                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm py-2 rounded-lg transition-colors">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <p class="text-4xl mb-3">📄</p>
                            <p class="text-gray-500 text-sm">No published articles yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($articles->hasPages())
        <div class="px-5 py-4 border-t border-gray-50">
            {{ $articles->links() }}
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endpush