 
@extends('layouts.dashboard')

@section('title', 'Submit Manuscript')
@section('page-title', 'Submit Manuscript')

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

<div class="max-w-3xl">

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Submit New Manuscript</h2>
        <p class="text-sm text-gray-400 mt-0.5">Fill in all details carefully before submitting</p>
    </div>

    <form method="POST" action="{{ route('author.manuscripts.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col gap-5">

            {{-- Title --}}
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                    Manuscript Title <span class="text-red-400">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-1 focus:ring-[#e8a020] transition-colors @error('title') border-red-300 @enderror"
                       placeholder="Enter the full title of your manuscript">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Journal --}}
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                    Select Journal <span class="text-red-400">*</span>
                </label>
                <select name="journal_id"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-1 focus:ring-[#e8a020] transition-colors @error('journal_id') border-red-300 @enderror">
                    <option value="">-- Select a Journal --</option>
                    @foreach($journals as $journal)
                        <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>
                            {{ $journal->title }}
                        </option>
                    @endforeach
                </select>
                @error('journal_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Abstract --}}
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                    Abstract <span class="text-red-400">*</span>
                </label>
                <textarea name="abstract" rows="6"
                          class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-1 focus:ring-[#e8a020] transition-colors resize-none @error('abstract') border-red-300 @enderror"
                          placeholder="Write a comprehensive abstract of at least 100 characters...">{{ old('abstract') }}</textarea>
                @error('abstract')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keywords --}}
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                    Keywords <span class="text-red-400">*</span>
                </label>
                <input type="text" name="keywords" value="{{ old('keywords') }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-1 focus:ring-[#e8a020] transition-colors @error('keywords') border-red-300 @enderror"
                       placeholder="e.g. biology, genetics, cell mutation, cancer research">
                <p class="text-[10px] text-gray-400 mt-1">Separate keywords with commas</p>
                @error('keywords')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- File Upload --}}
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                    Manuscript File <span class="text-red-400">*</span>
                </label>
                <div class="border-2 border-dashed border-gray-200 rounded-lg p-8 text-center hover:border-[#e8a020] transition-colors cursor-pointer"
                     onclick="document.getElementById('file-input').click()">
                    <p class="text-3xl mb-2">📎</p>
                    <p class="text-sm text-gray-500 font-medium">Click to upload your manuscript</p>
                    <p class="text-xs text-gray-400 mt-1">PDF, DOC or DOCX — Max 10MB</p>
                    <input type="file" id="file-input" name="file"
                           accept=".pdf,.doc,.docx" class="hidden"
                           onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''">
                </div>
                <p id="file-name" class="text-xs text-[#e8a020] mt-2 font-medium"></p>
                @error('file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-[#e8a020] hover:bg-[#d4911c] text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-colors">
                    Submit Manuscript
                </button>
                <a href="{{ route('author.manuscripts.index') }}"
                   class="text-gray-400 hover:text-gray-600 text-sm transition-colors">
                    Cancel
                </a>
            </div>

        </div>
    </form>
</div>

@endsection