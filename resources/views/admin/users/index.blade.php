 
@extends('layouts.dashboard')

@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

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

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-800">All Users</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage users and assign roles</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">#</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">User</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Role</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Institution</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Joined</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $i => $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $users->firstItem() + $i }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-[#e8a020] bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#e8a020] text-xs font-semibold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-800">{{ $user->name }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @foreach($user->roles as $role)
                                <span class="text-[10px] font-medium px-2 py-1 rounded
                                    {{ $role->name === 'super_admin' ? 'bg-purple-50 text-purple-700' :
                                       ($role->name === 'editor' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700') }}">
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                </span>
                            @endforeach
                            @if($user->roles->isEmpty())
                                <span class="text-[10px] text-gray-400">No role</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-500">{{ $user->institution ?? '—' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-400">{{ $user->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                   class="text-xs text-[#e8a020] hover:underline font-medium">
                                    Edit Role
                                </a>
                                @if(!$user->hasRole('super_admin'))
                                    <form method="POST"
                                          action="{{ route('admin.users.destroy', $user->id) }}"
                                          onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs text-red-400 hover:text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <p class="text-4xl mb-3">👥</p>
                            <p class="text-gray-500 text-sm">No users found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="px-5 py-4 border-t border-gray-50">
            {{ $users->links() }}
        </div>
    @endif
</div>

@endsection