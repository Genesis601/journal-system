 
@extends('layouts.dashboard')

@section('title', 'Edit User Role')
@section('page-title', 'Edit User Role')

@section('sidebar-nav')
@php
    $navItems = [
    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
    ['route' => 'admin.users.index', 'label' => 'Users', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
    ['route' => 'admin.journals.index', 'label' => 'Journals', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
    ['route' => 'admin.articles.index', 'label' => 'All Articles', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
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

<div class="max-w-xl">

    <a href="{{ route('admin.users.index') }}"
       class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1 mb-5">
        ← Back to users
    </a>

    {{-- User Info --}}
    <div class="bg-white rounded-xl border border-gray-100 p-6 mb-5">
        <div class="flex items-center gap-4 mb-5">
            <div class="w-14 h-14 bg-[#e8a020] bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-[#e8a020] text-xl font-semibold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
            <div>
                <p class="text-base font-semibold text-gray-800">{{ $user->name }}</p>
                <p class="text-sm text-gray-400">{{ $user->email }}</p>
                @if($user->institution)
                    <p class="text-xs text-gray-400 mt-0.5">{{ $user->institution }}</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-50">
            <div>
                <p class="text-xs text-gray-400">Country</p>
                <p class="text-sm text-gray-700 mt-0.5">{{ $user->country ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Joined</p>
                <p class="text-sm text-gray-700 mt-0.5">{{ $user->created_at->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Current Role</p>
                <div class="flex gap-1 mt-0.5">
                    @foreach($user->roles as $role)
                        <span class="text-xs font-medium px-2 py-0.5 rounded
                            {{ $role->name === 'super_admin' ? 'bg-purple-50 text-purple-700' :
                               ($role->name === 'editor' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700') }}">
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </span>
                    @endforeach
                    @if($user->roles->isEmpty())
                        <span class="text-xs text-gray-400">No role assigned</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Role Assignment --}}
    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <h3 class="text-sm font-semibold text-gray-800 mb-1">Assign Role</h3>
        <p class="text-xs text-gray-400 mb-5">Changing the role will update the user's access immediately.</p>

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-3 mb-5">
                @foreach($roles as $role)
                    <label class="flex items-center gap-3 p-3 border border-gray-100 rounded-lg cursor-pointer hover:border-[#e8a020] transition-colors {{ $user->hasRole($role->name) ? 'border-[#e8a020] bg-orange-50' : '' }}">
                        <input type="radio" name="role" value="{{ $role->name }}"
                               {{ $user->hasRole($role->name) ? 'checked' : '' }}
                               class="text-[#e8a020]">
                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                            </p>
                            <p class="text-xs text-gray-400">
                                @if($role->name === 'super_admin') Full system access and control
                                @elseif($role->name === 'editor') Review and publish manuscripts
                                @else Submit and manage manuscripts
                                @endif
                            </p>
                        </div>
                    </label>
                @endforeach
            </div>

            <button type="submit"
                    class="w-full bg-[#e8a020] hover:bg-[#d4911c] text-white text-sm font-medium py-2.5 rounded-lg transition-colors">
                Update Role
            </button>
        </form>
    </div>

</div>

@endsection