@extends('layouts.dashboard')

@section('title', 'Manage Journals')
@section('page-title', 'Manage Journals')

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
        <h2 class="text-lg font-semibold text-gray-800">All Journals</h2>
        <p class="text-sm text-gray-400 mt-0.5">Create and manage journals on the platform</p>
    </div>
    <a href="{{ route('admin.journals.create') }}"
       class="bg-[#e8a020] text-white text-sm px-4 py-2 rounded-lg hover:bg-[#d4911c] transition-colors font-medium">
        + Add Journal
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">#</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Title</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">ISSN</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Frequency</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Articles</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Status</th>
                    <th class="text-left text-xs text-gray-400 font-medium px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($journals as $i => $journal)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $journals->firstItem() + $i }}</td>
                        <td class="px-5 py-4">
                            <p class="text-xs font-medium text-gray-800">{{ $journal->title }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $journal->slug }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-500">{{ $journal->issn ?? '—' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-500">{{ ucfirst($journal->frequency) }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-xs text-gray-500">{{ $journal->articles_count }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-[10px] font-medium px-2 py-1 rounded {{ $journal->is_active ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ $journal->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.journals.edit', $journal->id) }}"
                                   class="text-xs text-[#e8a020] hover:underline font-medium">Edit</a>
                                <form method="POST"
                                      action="{{ route('admin.journals.destroy', $journal->id) }}"
                                      onsubmit="return confirm('Delete this journal? All articles will also be deleted.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs text-red-400 hover:text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <p class="text-4xl mb-3">📚</p>
                            <p class="text-gray-500 text-sm font-medium">No journals yet</p>
                            <p class="text-gray-400 text-xs mt-1 mb-4">Create your first journal to get started</p>
                            <a href="{{ route('admin.journals.create') }}"
                               class="bg-[#e8a020] text-white text-xs px-4 py-2 rounded-lg hover:bg-[#d4911c] transition-colors">
                                Add Journal
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($journals->hasPages())
        <div class="px-5 py-4 border-t border-gray-50">
            {{ $journals->links() }}
        </div>
    @endif
</div>

@endsection 
