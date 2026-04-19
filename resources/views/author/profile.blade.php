 
@extends('layouts.dashboard')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

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
        <h2 class="text-lg font-semibold text-gray-800">My Profile</h2>
        <p class="text-sm text-gray-400 mt-0.5">Update your personal information and account settings</p>
    </div>

    <form method="POST" action="{{ route('author.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-5">

            {{-- Profile Card --}}
            <div class="bg-white rounded-xl border border-gray-100 p-6">

                {{-- Avatar Display --}}
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-50">
                    <div class="w-16 h-16 bg-[#e8a020] bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-[#e8a020] text-2xl font-semibold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-gray-800">{{ $user->name }}</p>
                        <p class="text-sm text-gray-400">{{ $user->email }}</p>
                        <span class="inline-block mt-1 bg-green-50 text-green-700 text-xs font-medium px-2 py-0.5 rounded">
                            Author
                        </span>
                    </div>
                </div>

                <h3 class="text-sm font-semibold text-gray-800 mb-4">Personal Information</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-1 focus:ring-[#e8a020] transition-colors @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Email Address <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-1 focus:ring-[#e8a020] transition-colors @error('email') border-red-300 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Institution</label>
                        <input type="text" name="institution" value="{{ old('institution', $user->institution) }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors"
                               placeholder="University or Organization">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Country</label>
                        <input type="text" name="country" value="{{ old('country', $user->country) }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors"
                               placeholder="e.g. Nigeria">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors"
                               placeholder="+234 800 000 0000">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Bio</label>
                        <textarea name="bio" rows="4"
                                  class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors resize-none"
                                  placeholder="Tell us about yourself, your research interests and expertise...">{{ old('bio', $user->bio) }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Max 1000 characters</p>
                    </div>

                </div>
            </div>

            {{-- Change Password --}}
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Change Password</h3>
                <p class="text-xs text-gray-400 mb-4">Leave blank if you don't want to change your password</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">New Password</label>
                        <input type="password" name="password"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors @error('password') border-red-300 @enderror"
                               placeholder="Min 8 characters">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors"
                               placeholder="Repeat new password">
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">My Statistics</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-semibold text-gray-800">{{ $user->articles()->count() }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Total Submissions</p>
                    </div>
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <p class="text-2xl font-semibold text-green-600">{{ $user->articles()->where('status', 'published')->count() }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Published</p>
                    </div>
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <p class="text-2xl font-semibold text-blue-600">{{ $user->articles()->where('status', 'published')->sum('views') }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Total Views</p>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="bg-[#e8a020] hover:bg-[#d4911c] text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-colors">
                    Save Changes
                </button>
                <a href="{{ route('author.dashboard') }}"
                   class="text-gray-400 hover:text-gray-600 text-sm transition-colors">
                    Cancel
                </a>
            </div>

        </div>
    </form>
</div>

@endsection