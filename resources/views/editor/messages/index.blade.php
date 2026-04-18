@extends('layouts.dashboard')

@section('title', 'Messages')
@section('page-title', 'Messages')

@section('sidebar-nav')
@php
    $navItems = [
        ['route' => 'editor.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'editor.manuscripts.index', 'label' => 'Manuscripts', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
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
    <h2 class="text-lg font-semibold text-gray-800">Messages Inbox</h2>
    <p class="text-sm text-gray-400 mt-0.5">All messages sent and received</p>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="divide-y divide-gray-50">
        @forelse($messages as $message)
            <div class="p-5 hover:bg-gray-50 transition-colors {{ is_null($message->read_at) ? 'bg-blue-50 hover:bg-blue-50' : '' }}">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        <div class="w-9 h-9 bg-[#e8a020] bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-[#e8a020] text-xs font-semibold">
                                {{ strtoupper(substr($message->sender?->name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <p class="text-xs font-semibold text-gray-800">{{ $message->subject }}</p>
                                @if(is_null($message->read_at))
                                    <span class="bg-blue-500 text-white text-[9px] px-1.5 py-0.5 rounded font-medium">New</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">{{ $message->body }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <p class="text-[10px] text-gray-400">From: {{ $message->sender?->name }}</p>
                                @if($message->article)
                                    <span class="text-gray-300">·</span>
                                    <p class="text-[10px] text-gray-400">Re: {{ Str::limit($message->article?->title, 40) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 flex-shrink-0">
                        {{ $message->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @empty
            <div class="p-16 text-center text-gray-400">
                <p class="text-4xl mb-3">✉️</p>
                <p class="text-sm font-medium text-gray-500">No messages yet</p>
                <p class="text-xs mt-1">Messages sent to authors will appear here</p>
            </div>
        @endforelse
    </div>

    @if($messages->hasPages())
        <div class="px-5 py-4 border-t border-gray-50">
            {{ $messages->links() }}
        </div>
    @endif
</div>

@endsection