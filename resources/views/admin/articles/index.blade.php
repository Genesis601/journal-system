 
@extends('layouts.dashboard')

@section('title', 'Manage Articles')
@section('page-title', 'Manage All Articles')

@section('sidebar-nav')
@php
    $navItems = [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'admin.users.index', 'label' => 'Users', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ['route' => 'admin.journals.index', 'label' => 'Journals', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['route' => 'admin.articles.index', 'label' => 'All Articles', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
        ['route' => 'admin.settings.index', 'label' => 'Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
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

{{-- STATS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
    <div class="bg-white rounded-xl border border-gray-100 p-4">
        <p class="text-xs text-gray-400 mb-1">Total Articles</p>
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4">
        <p class="text-xs text-gray-400 mb-1">Published</p>
        <p class="text-2xl font-semibold text-green-500">{{ $stats['published'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4">
        <p class="text-xs text-gray-400 mb-1">Under Review</p>
        <p class="text-2xl font-semibold text-amber-500">{{ $stats['under_review'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4">
        <p class="text-xs text-gray-400 mb-1">Rejected</p>
        <p class="text-2xl font-semibold text-red-500">{{ $stats['rejected'] }}</p>
    </div>
</div>

{{-- FILTERS --}}
<form method="GET" action="{{ route('admin.articles.index') }}"
      class="bg-white rounded-xl border border-gray-100 p-4 mb-5 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[180px]">
        <label class="block text-xs text-gray-500 mb-1">Search</label>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by title..."
               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#e8a020] transition-colors">
    </div>
    <div class="min-w-[140px]">
        <label class="block text-xs text-gray-500 mb-1">Status</label>
        <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#e8a020] transition-colors">
            <option value="">All Status</option>
            <option value="published"    {{ request('status') === 'published'    ? 'selected' : '' }}>Published</option>
            <option value="submitted"    {{ request('status') === 'submitted'    ? 'selected' : '' }}>Submitted</option>
            <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>Under Review</option>
            <option value="rejected"     {{ request('status') === 'rejected'     ? 'selected' : '' }}>Rejected</option>
            <option value="draft"        {{ request('status') === 'draft'        ? 'selected' : '' }}>Draft</option>
        </select>
    </div>
    <div class="min-w-[160px]">
        <label class="block text-xs text-gray-500 mb-1">Journal</label>
        <select name="journal_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#e8a020] transition-colors">
            <option value="">All Journals</option>
            @foreach($journals as $journal)
                <option value="{{ $journal->id }}" {{ request('journal_id') == $journal->id ? 'selected' : '' }}>
                    {{ Str::limit($journal->title, 30) }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit"
            class="bg-[#0f2744] text-white text-sm px-4 py-2 rounded-lg hover:bg-[#1a3d5c] transition-colors">
        Filter
    </button>
    @if(request()->hasAny(['search', 'status', 'journal_id']))
        <a href="{{ route('admin.articles.index') }}"
           class="text-sm text-gray-400 hover:text-gray-600 py-2">Clear</a>
    @endif
</form>

{{-- ARTICLES TABLE --}}
<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-800">All Articles</h2>
        <span class="text-xs text-gray-400">{{ $articles->total() }} results</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Title</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Author</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Journal</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Status</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Date</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($articles as $article)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4">
                            <p class="text-xs font-medium text-gray-800 max-w-xs line-clamp-2">
                                {{ $article->title }}
                            </p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-600">{{ $article->author?->name }}</p>
                            <p class="text-[10px] text-gray-400">{{ $article->author?->email }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-500">{{ Str::limit($article->journal?->title, 25) }}</p>
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $statusColors = [
                                    'draft'        => 'bg-gray-100 text-gray-600',
                                    'submitted'    => 'bg-blue-50 text-blue-700',
                                    'under_review' => 'bg-amber-50 text-amber-700',
                                    'published'    => 'bg-green-50 text-green-700',
                                    'rejected'     => 'bg-red-50 text-red-700',
                                ];
                            @endphp
                            <span class="text-[10px] font-medium px-2 py-1 rounded {{ $statusColors[$article->status] ?? 'bg-gray-100 text-gray-500' }}">
                                {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-400">{{ $article->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2 flex-wrap">

                                {{-- Message Button --}}
                                <button onclick="openModal('message-{{ $article->id }}')"
                                        class="text-xs bg-blue-50 text-blue-600 hover:bg-blue-100 px-2.5 py-1 rounded-lg transition-colors">
                                    Message
                                </button>

                                {{-- Unpublish (only for published) --}}
                                @if($article->status === 'published')
                                    <button onclick="openModal('unpublish-{{ $article->id }}')"
                                            class="text-xs bg-amber-50 text-amber-700 hover:bg-amber-100 px-2.5 py-1 rounded-lg transition-colors">
                                        Unpublish
                                    </button>
                                @endif

                                {{-- Delete --}}
                                <button onclick="openModal('delete-{{ $article->id }}')"
                                        class="text-xs bg-red-50 text-red-600 hover:bg-red-100 px-2.5 py-1 rounded-lg transition-colors">
                                    Delete
                                </button>
                            </div>

                            {{-- MESSAGE MODAL --}}
                            <div id="message-{{ $article->id }}"
                                 class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center p-4">
                                <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
                                    <h3 class="text-sm font-semibold text-gray-800 mb-1">Send Message to Author</h3>
                                    <p class="text-xs text-gray-400 mb-4">Re: {{ Str::limit($article->title, 50) }}</p>
                                    <form method="POST" action="{{ route('admin.articles.message', $article->id) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="text" name="subject"
                                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#e8a020] transition-colors mb-3"
                                                   placeholder="Subject..." required>
                                            <textarea name="body" rows="4" required
                                                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors resize-none"
                                                      placeholder="Write your message to the author..."></textarea>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit"
                                                    class="flex-1 bg-[#0f2744] hover:bg-[#1a3d5c] text-white text-sm py-2 rounded-lg transition-colors">
                                                Send Message
                                            </button>
                                            <button type="button" onclick="closeModal('message-{{ $article->id }}')"
                                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm py-2 rounded-lg transition-colors">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- UNPUBLISH MODAL --}}
                            <div id="unpublish-{{ $article->id }}"
                                 class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center p-4">
                                <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
                                    <h3 class="text-sm font-semibold text-gray-800 mb-1">Unpublish Article</h3>
                                    <p class="text-xs text-gray-400 mb-4">Author will be notified and asked to revise.</p>
                                    <form method="POST" action="{{ route('admin.articles.unpublish', $article->id) }}">
                                        @csrf
                                        <textarea name="reason" rows="4" required
                                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 outline-none focus:border-amber-400 transition-colors resize-none mb-3"
                                                  placeholder="Explain why this article is being unpublished..."></textarea>
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
                                    <p class="text-xs text-gray-400 mb-4">This is permanent. Author will be notified.</p>
                                    <form method="POST" action="{{ route('admin.articles.delete', $article->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <textarea name="reason" rows="4" required
                                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 outline-none focus:border-red-400 transition-colors resize-none mb-3"
                                                  placeholder="Explain why this article is being permanently deleted..."></textarea>
                                        <div class="flex gap-2">
                                            <button type="submit"
                                                    class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm py-2 rounded-lg transition-colors">
                                                Delete & Notify
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
                        <td colspan="6" class="px-5 py-16 text-center">
                            <p class="text-4xl mb-3">📄</p>
                            <p class="text-gray-500 text-sm">No articles found</p>
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
    // Close modal on backdrop click
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('fixed')) {
            e.target.classList.add('hidden');
        }
    });
</script>
@endpush