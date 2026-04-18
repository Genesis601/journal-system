@extends('layouts.dashboard')

@section('title', 'Edit Journal')
@section('page-title', 'Edit Journal')

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

<div class="max-w-2xl">

    <a href="{{ route('admin.journals.index') }}"
       class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1 mb-5">
        ← Back to journals
    </a>

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Edit Journal</h2>
        <p class="text-sm text-gray-400 mt-0.5">Update journal details</p>
    </div>

    <form method="POST"
          action="{{ route('admin.journals.update', $journal->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col gap-5">

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                    Journal Title <span class="text-red-400">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $journal->title) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors @error('title') border-red-300 @enderror">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">ISSN</label>
                <input type="text" name="issn" value="{{ old('issn', $journal->issn) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="4"
                          class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors resize-none">{{ old('description', $journal->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                    Publication Frequency <span class="text-red-400">*</span>
                </label>
                <select name="frequency"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors">
                    @foreach(['monthly', 'quarterly', 'bi-monthly', 'annual'] as $freq)
                        <option value="{{ $freq }}" {{ old('frequency', $journal->frequency) === $freq ? 'selected' : '' }}>
                            {{ ucfirst($freq) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">Cover Image</label>
                @if($journal->cover_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $journal->cover_image) }}"
                             class="w-24 h-24 object-cover rounded-lg border border-gray-100">
                        <p class="text-xs text-gray-400 mt-1">Current cover image</p>
                    </div>
                @endif
                <div class="border-2 border-dashed border-gray-200 rounded-lg p-5 text-center hover:border-[#e8a020] transition-colors cursor-pointer"
                     onclick="document.getElementById('cover-input').click()">
                    <p class="text-sm text-gray-500">Click to upload new cover image</p>
                    <p class="text-xs text-gray-400 mt-1">Leave empty to keep current image</p>
                    <input type="file" id="cover-input" name="cover_image"
                           accept="image/*" class="hidden"
                           onchange="document.getElementById('cover-name').textContent = this.files[0]?.name || ''">
                </div>
                <p id="cover-name" class="text-xs text-[#e8a020] mt-2 font-medium"></p>
            </div>

            <div class="flex items-center gap-3">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $journal->is_active) ? 'checked' : '' }}
                           class="rounded text-[#e8a020]">
                    <span class="text-sm text-gray-700">Active (visible on public site)</span>
                </label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-[#e8a020] hover:bg-[#d4911c] text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-colors">
                    Update Journal
                </button>
                <a href="{{ route('admin.journals.index') }}"
                   class="text-gray-400 hover:text-gray-600 text-sm transition-colors">Cancel</a>
            </div>

        </div>
    </form>
</div>

@endsection 
