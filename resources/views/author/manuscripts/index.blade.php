 
@extends('layouts.dashboard')

@section('title', 'My Manuscripts')
@section('page-title', 'My Manuscripts')

@section('sidebar-nav')
@php
    $navItems = [
    ['route' => 'author.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
    ['route' => 'author.manuscripts.index', 'label' => 'My Manuscripts', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
    ['route' => 'author.manuscripts.create', 'label' => 'Submit Manuscript', 'icon' => 'M12 4v16m8-8H4'],
    ['route' => 'author.profile.edit', 'label' => 'My Profile', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
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

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-800">All Manuscripts</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage and track all your submitted manuscripts</p>
    </div>
    <a href="{{ route('author.manuscripts.create') }}"
       class="bg-[#e8a020] text-white text-sm px-4 py-2 rounded-lg hover:bg-[#d4911c] transition-colors font-medium">
        + Submit New
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">#</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Title</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Journal</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Status</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Submitted</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($manuscripts as $i => $manuscript)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $manuscripts->firstItem() + $i }}</td>
                        <td class="px-5 py-4">
                            <p class="text-xs font-medium text-gray-800 max-w-xs line-clamp-2">{{ $manuscript->title }}</p>
                            @if($manuscript->keywords)
                                <p class="text-[10px] text-gray-400 mt-1">{{ Str::limit($manuscript->keywords, 50) }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-600">{{ $manuscript->journal?->title ?? 'N/A' }}</p>
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
                            <span class="text-[10px] font-medium px-2.5 py-1 rounded-full {{ $statusColors[$manuscript->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst(str_replace('_', ' ', $manuscript->status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-400">{{ $manuscript->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if(in_array($manuscript->status, ['draft', 'rejected']))
                                    <a href="{{ route('author.manuscripts.edit', $manuscript->id) }}"
                                       class="text-xs text-[#e8a020] hover:underline font-medium">Edit</a>
                                    <form method="POST" action="{{ route('author.manuscripts.destroy', $manuscript->id) }}"
                                          onsubmit="return confirm('Delete this manuscript?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-400 hover:text-red-600 hover:underline">Delete</button>
                                    </form>
                                @elseif($manuscript->status === 'published')
                                    <a href="{{ route('articles.show', $manuscript->slug) }}"
                                       target="_blank"
                                       class="text-xs text-green-600 hover:underline font-medium">View Live →</a>
                                @else
                                    <span class="text-xs text-gray-300">Under Review</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <p class="text-4xl mb-3">📄</p>
                            <p class="text-gray-500 text-sm font-medium">No manuscripts yet</p>
                            <p class="text-gray-400 text-xs mt-1 mb-4">Start by submitting your first manuscript</p>
                            <a href="{{ route('author.manuscripts.create') }}"
                               class="bg-[#e8a020] text-white text-xs px-4 py-2 rounded-lg hover:bg-[#d4911c] transition-colors">
                                Submit Manuscript
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($manuscripts->hasPages())
        <div class="px-5 py-4 border-t border-gray-50">
            {{ $manuscripts->links() }}
        </div>
    @endif
</div>

@endsection