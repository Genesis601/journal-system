 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — JournalSpace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside id="sidebar" class="w-64 bg-[#0f2744] flex flex-col flex-shrink-0 transition-all duration-300">

        {{-- Logo --}}
        <div class="p-5 border-b border-[#1e3a5a]">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#e8a020] rounded-lg flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">JS</span>
                </div>
                <div>
                    <div class="text-white font-semibold text-sm leading-tight">JournalSpace</div>
                    <div class="text-[#a0b4cc] text-[10px]">
                        @if(auth()->user()->hasRole('super_admin')) Super Admin
                        @elseif(auth()->user()->hasRole('editor')) Editor Portal
                        @else Author Portal
                        @endif
                    </div>
                </div>
            </a>
        </div>

        {{-- User Info --}}
        <div class="p-4 border-b border-[#1e3a5a]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#e8a020] bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-[#e8a020] text-sm font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
                <div class="min-w-0">
                    <p class="text-white text-xs font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[#a0b4cc] text-[10px] truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-4 overflow-y-auto">
            @yield('sidebar-nav')
        </nav>

        {{-- Bottom --}}
        <div class="p-4 border-t border-[#1e3a5a]">
            <a href="{{ route('home') }}"
               class="flex items-center gap-3 text-[#a0b4cc] hover:text-white text-xs py-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Public Site
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 text-[#a0b4cc] hover:text-red-400 text-xs py-2 transition-colors w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- MAIN AREA --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- TOP BAR --}}
        <header class="bg-white border-b border-gray-100 h-14 flex items-center justify-between px-6 flex-shrink-0">
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-sm font-semibold text-gray-700">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                {{-- Notification Bell --}}
                <button class="text-gray-400 hover:text-gray-600 transition-colors relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @php $unread = auth()->user()->unreadMessages()->count(); @endphp
                    @if($unread > 0)
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] rounded-full flex items-center justify-center font-medium">
                            {{ $unread }}
                        </span>
                    @endif
                </button>

                {{-- Avatar --}}
                <div class="w-8 h-8 bg-[#e8a020] bg-opacity-20 rounded-full flex items-center justify-center">
                    <span class="text-[#e8a020] text-xs font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
            </div>
        </header>

        {{-- FLASH MESSAGES --}}
        @if(session('success'))
            <div class="bg-green-50 border-b border-green-100 text-green-800 px-6 py-3 text-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-b border-red-100 text-red-800 px-6 py-3 text-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0zm1-4a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">✕</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-b border-red-100 text-red-800 px-6 py-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- PAGE CONTENT --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>
</div>

<script>
    document.getElementById('sidebar-toggle').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-0');
        sidebar.classList.toggle('overflow-hidden');
    });
</script>

@stack('scripts')
</body>
</html>