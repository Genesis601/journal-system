 
@extends('layouts.dashboard')

@section('title', 'Author Dashboard')
@section('page-title', 'Author Dashboard')

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

{{-- STATS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <p class="text-xs text-gray-400 mb-1">Total Manuscripts</p>
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <p class="text-xs text-gray-400 mb-1">Under Review</p>
        <p class="text-2xl font-semibold text-amber-500">{{ $stats['submitted'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <p class="text-xs text-gray-400 mb-1">Published</p>
        <p class="text-2xl font-semibold text-green-500">{{ $stats['published'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <p class="text-xs text-gray-400 mb-1">Rejected</p>
        <p class="text-2xl font-semibold text-red-500">{{ $stats['rejected'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- MANUSCRIPTS TABLE --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-50">
            <h2 class="text-sm font-semibold text-gray-800">My Manuscripts</h2>
            <a href="{{ route('author.manuscripts.create') }}"
               class="bg-[#e8a020] text-white text-xs px-3 py-1.5 rounded-lg hover:bg-[#d4911c] transition-colors">
                + Submit New
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Title</th>
                        <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Journal</th>
                        <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Status</th>
                        <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Date</th>
                        <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($manuscripts->take(6) as $manuscript)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3">
                                <p class="text-xs font-medium text-gray-800 line-clamp-1 max-w-[200px]">
                                    {{ $manuscript->title }}
                                </p>
                            </td>
                            <td class="px-5 py-3">
                                <p class="text-xs text-gray-500">{{ $manuscript->journal?->title ?? 'N/A' }}</p>
                            </td>
                            <td class="px-5 py-3">
                                @php
                                    $statusColors = [
                                        'draft'        => 'bg-gray-100 text-gray-600',
                                        'submitted'    => 'bg-blue-50 text-blue-700',
                                        'under_review' => 'bg-amber-50 text-amber-700',
                                        'published'    => 'bg-green-50 text-green-700',
                                        'rejected'     => 'bg-red-50 text-red-700',
                                    ];
                                @endphp
                                <span class="text-[10px] font-medium px-2 py-1 rounded {{ $statusColors[$manuscript->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst(str_replace('_', ' ', $manuscript->status)) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <p class="text-xs text-gray-400">{{ $manuscript->created_at->format('M d, Y') }}</p>
                            </td>
                            <td class="px-5 py-3">
                                @if(in_array($manuscript->status, ['draft', 'rejected']))
                                    <a href="{{ route('author.manuscripts.edit', $manuscript->id) }}"
                                       class="text-[#e8a020] hover:underline text-xs font-medium">Edit</a>
                                @else
                                    <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">
                                No manuscripts yet.
                                <a href="{{ route('author.manuscripts.create') }}"
                                   class="text-[#e8a020] hover:underline">Submit your first one →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MESSAGES --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-50">
            <h2 class="text-sm font-semibold text-gray-800">Messages from Editors</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($messages as $message)
                <div class="p-4 {{ is_null($message->read_at) ? 'bg-blue-50' : '' }}">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <p class="text-xs font-medium text-gray-800 line-clamp-1">{{ $message->subject }}</p>
                        @if(is_null($message->read_at))
                            <span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-1"></span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ $message->body }}</p>
                    <p class="text-[10px] text-gray-400 mt-2">
                        From: {{ $message->sender?->name }} · {{ $message->created_at->diffForHumans() }}
                    </p>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400">
                    <p class="text-3xl mb-2">✉️</p>
                    <p class="text-xs">No messages yet</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

@endsection