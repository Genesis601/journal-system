 
@extends('layouts.dashboard')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')

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

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Site Settings</h2>
        <p class="text-sm text-gray-400 mt-0.5">Configure your platform's general settings</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('POST')

        <div class="flex flex-col gap-5">

            {{-- General --}}
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-50">
                    General Information
                </h3>
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Site Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="site_name"
                               value="{{ old('site_name', $settings['site_name'] ?? 'JournalSpace') }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors">
                        @error('site_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Site Tagline</label>
                        <input type="text" name="site_tagline"
                               value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors"
                               placeholder="e.g. Open Access · Peer Reviewed · Free to Read">
                    </div>
                </div>
            </div>

            {{-- Contact --}}
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-50">
                    Contact Information
                </h3>
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Contact Email</label>
                        <input type="email" name="contact_email"
                               value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors"
                               placeholder="contact@journalspace.com">
                        @error('contact_email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Contact Phone</label>
                        <input type="text" name="contact_phone"
                               value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors"
                               placeholder="+1 234 567 8900">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Address</label>
                        <textarea name="contact_address" rows="3"
                                  class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors resize-none"
                                  placeholder="Physical address...">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="bg-[#e8a020] hover:bg-[#d4911c] text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-colors w-full">
                Save Settings
            </button>

        </div>
    </form>
</div>

@endsection