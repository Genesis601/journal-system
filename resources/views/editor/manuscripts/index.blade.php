@extends('layouts.dashboard')

@section('title', 'Review Manuscripts')
@section('page-title', 'Review Manuscripts')

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

<div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-800">All Submissions</h2>
    <p class="text-sm text-gray-400 mt-0.5">Review and take action on submitted manuscripts</p>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">#</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Title</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Author</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Journal</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Status</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Submitted</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($manuscripts as $i => $manuscript)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $manuscripts->firstItem() + $i }}</td>
                        <td class="px-5 py-4">
                            <p class="text-xs font-medium text-gray-800 max-w-xs line-clamp-2">
                                {{ $manuscript->title }}
                            </p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-600">{{ $manuscript->author?->name }}</p>
                            <p class="text-[10px] text-gray-400">{{ $manuscript->author?->email }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-600">{{ $manuscript->journal?->title ?? 'N/A' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $statusColors = [
                                    'submitted'    => 'bg-blue-50 text-blue-700',
                                    'under_review' => 'bg-amber-50 text-amber-700',
                                    'published'    => 'bg-green-50 text-green-700',
                                    'rejected'     => 'bg-red-50 text-red-700',
                                ];
                            @endphp
                            <span class="text-[10px] font-medium px-2.5 py-1 rounded-full {{ $statusColors[$manuscript->status] ?? 'bg-gray-100 text-gray-500' }}">
                                {{ ucfirst(str_replace('_', ' ', $manuscript->status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-400">{{ $manuscript->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <a href="{{ route('editor.manuscripts.show', $manuscript->id) }}"
                               class="bg-[#0f2744] text-white text-xs px-3 py-1.5 rounded-lg hover:bg-[#1a3d5c] transition-colors">
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <p class="text-4xl mb-3">📭</p>
                            <p class="text-gray-500 text-sm font-medium">No manuscripts to review</p>
                            <p class="text-gray-400 text-xs mt-1">New submissions will appear here</p>
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