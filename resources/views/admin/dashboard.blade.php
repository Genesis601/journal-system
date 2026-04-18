 
@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Super Admin Dashboard')

@section('sidebar-nav')
@php
    $navItems = [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'admin.users.index', 'label' => 'Users', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ['route' => 'admin.journals.index', 'label' => 'Journals', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
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
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <p class="text-xs text-gray-400 mb-1">Total Users</p>
        <p class="text-2xl font-semibold text-gray-800">{{ $stats['total_users'] }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ $stats['authors'] }} authors · {{ $stats['editors'] }} editors</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <p class="text-xs text-gray-400 mb-1">Total Journals</p>
        <p class="text-2xl font-semibold text-[#e8a020]">{{ $stats['total_journals'] }}</p>
        <p class="text-xs text-gray-400 mt-1">Active journals</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <p class="text-xs text-gray-400 mb-1">Published Articles</p>
        <p class="text-2xl font-semibold text-green-500">{{ $stats['total_articles'] }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ $stats['pending'] }} pending review</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- RECENT USERS --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-50">
            <h2 class="text-sm font-semibold text-gray-800">Recent Users</h2>
            <a href="{{ route('admin.users.index') }}"
               class="text-[#e8a020] text-xs hover:underline">View all →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recentUsers as $user)
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-[#e8a020] bg-opacity-20 rounded-full flex items-center justify-center">
                            <span class="text-[#e8a020] text-xs font-semibold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-800">{{ $user->name }}</p>
                            <p class="text-[10px] text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @foreach($user->roles as $role)
                            <span class="text-[10px] bg-[#0f2744] text-white px-2 py-0.5 rounded font-medium">
                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                            </span>
                        @endforeach
                        <a href="{{ route('admin.users.show', $user->id) }}"
                           class="text-xs text-[#e8a020] hover:underline">Edit</a>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400 text-sm">No users yet</div>
            @endforelse
        </div>
    </div>

    {{-- RECENT ARTICLES --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-50">
            <h2 class="text-sm font-semibold text-gray-800">Recent Articles</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recentArticles as $article)
                <div class="p-4">
                    <p class="text-xs font-medium text-gray-800 line-clamp-1 mb-1">
                        {{ $article->title }}
                    </p>
                    <div class="flex items-center gap-2">
                        @php
                            $statusColors = [
                                'draft'        => 'bg-gray-100 text-gray-600',
                                'submitted'    => 'bg-blue-50 text-blue-700',
                                'under_review' => 'bg-amber-50 text-amber-700',
                                'published'    => 'bg-green-50 text-green-700',
                                'rejected'     => 'bg-red-50 text-red-700',
                            ];
                        @endphp
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded {{ $statusColors[$article->status] ?? 'bg-gray-100 text-gray-500' }}">
                            {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                        </span>
                        <span class="text-[10px] text-gray-400">{{ $article->journal?->title }}</span>
                        <span class="text-[10px] text-gray-400">· {{ $article->author?->name }}</span>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400 text-sm">No articles yet</div>
            @endforelse
        </div>
    </div>

</div>

@endsection