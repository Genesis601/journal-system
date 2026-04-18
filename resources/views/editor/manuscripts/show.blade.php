@extends('layouts.dashboard')

@section('title', 'Review Manuscript')
@section('page-title', 'Review Manuscript')

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

<div class="mb-5">
    <a href="{{ route('editor.manuscripts.index') }}"
       class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1 mb-3">
        ← Back to manuscripts
    </a>
    <h2 class="text-lg font-semibold text-gray-800">Review Manuscript</h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- MANUSCRIPT DETAILS --}}
    <div class="lg:col-span-2 flex flex-col gap-5">

        {{-- Info Card --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
                <h3 class="text-base font-semibold text-gray-800 leading-snug">
                    {{ $manuscript->title }}
                </h3>
                @php
                    $statusColors = [
                        'submitted'    => 'bg-blue-50 text-blue-700',
                        'under_review' => 'bg-amber-50 text-amber-700',
                        'published'    => 'bg-green-50 text-green-700',
                        'rejected'     => 'bg-red-50 text-red-700',
                    ];
                @endphp
                <span class="text-xs font-medium px-3 py-1 rounded-full flex-shrink-0 {{ $statusColors[$manuscript->status] ?? 'bg-gray-100 text-gray-500' }}">
                    {{ ucfirst(str_replace('_', ' ', $manuscript->status)) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5 pb-5 border-b border-gray-50">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Author</p>
                    <p class="text-sm font-medium text-gray-700">{{ $manuscript->author?->name }}</p>
                    <p class="text-xs text-gray-400">{{ $manuscript->author?->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Journal</p>
                    <p class="text-sm font-medium text-gray-700">{{ $manuscript->journal?->title }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Submitted</p>
                    <p class="text-sm text-gray-700">{{ $manuscript->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Keywords</p>
                    <p class="text-sm text-gray-700">{{ $manuscript->keywords ?? 'N/A' }}</p>
                </div>
            </div>

            <div>
                <p class="text-xs text-gray-400 mb-2">Abstract</p>
                <p class="text-sm text-gray-700 leading-relaxed">{{ $manuscript->abstract }}</p>
            </div>
        </div>

        {{-- File Download --}}
        @if($manuscript->file_path)
            <div class="bg-white rounded-xl border border-gray-100 p-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                        <span class="text-lg">📄</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Manuscript File</p>
                        <p class="text-xs text-gray-400">Click to download and review</p>
                    </div>
                </div>
                <a href="{{ asset('storage/' . $manuscript->file_path) }}"
                   target="_blank"
                   class="bg-[#0f2744] text-white text-xs px-4 py-2 rounded-lg hover:bg-[#1a3d5c] transition-colors">
                    Download File
                </a>
            </div>
        @endif

        {{-- Previous Reviews --}}
        @if($manuscript->reviews->count())
            <div class="bg-white rounded-xl border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Previous Reviews</h3>
                <div class="flex flex-col gap-3">
                    @foreach($manuscript->reviews as $review)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-gray-700">{{ $review->editor?->name }}</p>
                                <span class="text-[10px] px-2 py-0.5 rounded {{ $review->decision === 'approved' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                    {{ ucfirst($review->decision) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">{{ $review->comments }}</p>
                            <p class="text-[10px] text-gray-400 mt-2">{{ $review->reviewed_at?->format('M d, Y') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    {{-- ACTION PANEL --}}
    <div class="flex flex-col gap-5">

        {{-- Approve --}}
        @if(in_array($manuscript->status, ['submitted', 'under_review']))
            <div class="bg-white rounded-xl border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Approve & Publish</h3>
                <p class="text-xs text-gray-400 mb-4">This will publish the article immediately on the public site.</p>
                <form method="POST" action="{{ route('editor.manuscripts.approve', $manuscript->id) }}"
                      onsubmit="return confirm('Approve and publish this manuscript?')">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Comments <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <textarea name="comments" rows="3"
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-700 outline-none focus:border-green-400 transition-colors resize-none"
                                  placeholder="Add any feedback for the author..."></textarea>
                    </div>
                    <button type="submit"
                            class="w-full bg-green-500 hover:bg-green-600 text-white text-sm font-medium py-2.5 rounded-lg transition-colors">
                        Approve & Publish
                    </button>
                </form>
            </div>

            {{-- Reject --}}
            <div class="bg-white rounded-xl border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Reject Manuscript</h3>
                <p class="text-xs text-gray-400 mb-4">Author will be notified with your rejection reason.</p>
                <form method="POST" action="{{ route('editor.manuscripts.reject', $manuscript->id) }}"
                      onsubmit="return confirm('Reject this manuscript? The author will be notified.')">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Rejection Reason <span class="text-red-400">*</span>
                        </label>
                        <textarea name="comments" rows="4"
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-700 outline-none focus:border-red-400 transition-colors resize-none @error('comments') border-red-300 @enderror"
                                  placeholder="Explain clearly why this manuscript is being rejected. This message will be sent to the author..."
                                  required></textarea>
                        @error('comments')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2.5 rounded-lg transition-colors">
                        Reject & Notify Author
                    </button>
                </form>
            </div>
        @else
            <div class="bg-gray-50 rounded-xl border border-gray-100 p-5 text-center">
                <p class="text-sm text-gray-500 font-medium">No actions available</p>
                <p class="text-xs text-gray-400 mt-1">
                    This manuscript is already {{ $manuscript->status }}
                </p>
            </div>
        @endif

        {{-- Author Info --}}
        <div class="bg-white rounded-xl border border-gray-100 p-5">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Author Info</h3>
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-[#e8a020] bg-opacity-20 rounded-full flex items-center justify-center">
                    <span class="text-[#e8a020] text-sm font-semibold">
                        {{ strtoupper(substr($manuscript->author?->name ?? 'A', 0, 1)) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">{{ $manuscript->author?->name }}</p>
                    <p class="text-xs text-gray-400">{{ $manuscript->author?->email }}</p>
                </div>
            </div>
            @if($manuscript->author?->institution)
                <p class="text-xs text-gray-500">{{ $manuscript->author->institution }}</p>
            @endif
            @if($manuscript->author?->country)
                <p class="text-xs text-gray-400 mt-1">{{ $manuscript->author->country }}</p>
            @endif
        </div>

    </div>
</div>

@endsection