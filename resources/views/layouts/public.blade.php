<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JournalSpace') — Open Access Publishing</title>
    <meta name="description" content="@yield('description', 'Discover open access peer-reviewed research across journals in science, technology, medicine and more.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">

{{-- NAVBAR --}}
<nav class="bg-[#0f2744] sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#e8a020] rounded-lg flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">JS</span>
                </div>
                <div>
                    <div class="text-white font-semibold text-base leading-tight">JournalSpace</div>
                    <div class="text-[#a0b4cc] text-[10px] leading-tight">Open Access Publishing</div>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('journals.index') }}" class="text-[#c5d5e8] hover:text-white text-sm transition-colors {{ request()->routeIs('journals*') ? 'text-white border-b-2 border-[#e8a020] pb-1' : '' }}">Journals</a>
                <a href="{{ route('articles.index') }}" class="text-[#c5d5e8] hover:text-white text-sm transition-colors {{ request()->routeIs('articles*') ? 'text-white border-b-2 border-[#e8a020] pb-1' : '' }}">Articles</a>
                <a href="{{ route('search') }}" class="text-[#c5d5e8] hover:text-white text-sm transition-colors">Search</a>
                <a href="{{ route('about') }}" class="text-[#c5d5e8] hover:text-white text-sm transition-colors {{ request()->routeIs('about') ? 'text-white border-b-2 border-[#e8a020] pb-1' : '' }}">About</a>
                <a href="{{ route('contact') }}" class="text-[#c5d5e8] hover:text-white text-sm transition-colors {{ request()->routeIs('contact') ? 'text-white border-b-2 border-[#e8a020] pb-1' : '' }}">Contact</a>
            </div>

            {{-- Right Side --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                    {{-- Redirect to correct dashboard based on role --}}
                    @if(auth()->user()->hasRole('super_admin'))
                        <a href="{{ route('admin.dashboard') }}" class="text-[#c5d5e8] hover:text-white text-sm transition-colors">Dashboard</a>
                    @elseif(auth()->user()->hasRole('editor'))
                        <a href="{{ route('editor.dashboard') }}" class="text-[#c5d5e8] hover:text-white text-sm transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('author.dashboard') }}" class="text-[#c5d5e8] hover:text-white text-sm transition-colors">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-transparent border border-[#3a5a7a] text-[#c5d5e8] hover:text-white text-sm px-4 py-1.5 rounded-lg transition-colors">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="border border-[#3a5a7a] text-[#c5d5e8] hover:text-white text-sm px-4 py-1.5 rounded-lg transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-[#e8a020] hover:bg-[#d4911c] text-white text-sm px-4 py-1.5 rounded-lg transition-colors font-medium">Submit Manuscript</a>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <button id="mobile-menu-btn" class="md:hidden text-[#c5d5e8] hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="md:hidden hidden pb-4">
            <div class="flex flex-col gap-3 pt-3 border-t border-[#1e3a5a]">
                <a href="{{ route('journals.index') }}" class="text-[#c5d5e8] hover:text-white text-sm px-2">Journals</a>
                <a href="{{ route('articles.index') }}" class="text-[#c5d5e8] hover:text-white text-sm px-2">Articles</a>
                <a href="{{ route('search') }}" class="text-[#c5d5e8] hover:text-white text-sm px-2">Search</a>
                <a href="{{ route('about') }}" class="text-[#c5d5e8] hover:text-white text-sm px-2">About</a>
                <a href="{{ route('contact') }}" class="text-[#c5d5e8] hover:text-white text-sm px-2">Contact</a>
                <a href="{{ route('login') }}" class="text-[#c5d5e8] hover:text-white text-sm px-2">Login</a>
                <a href="{{ route('register') }}" class="bg-[#e8a020] text-white text-sm px-4 py-2 rounded-lg text-center font-medium">Submit Manuscript</a>
            </div>
        </div>
    </div>
</nav>

{{-- FLASH MESSAGES --}}
@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-3 text-sm flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 ml-4">✕</button>
    </div>
@endif
@if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-6 py-3 text-sm flex items-center justify-between">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 ml-4">✕</button>
    </div>
@endif

{{-- PAGE CONTENT --}}
@yield('content')

{{-- FOOTER --}}
<footer class="bg-[#0a1e35] pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

            {{-- Brand --}}
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-[#e8a020] rounded-lg flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">JS</span>
                    </div>
                    <div>
                        <div class="text-white font-semibold text-base leading-tight">JournalSpace</div>
                        <div class="text-[#a0b4cc] text-[10px]">Open Access Publishing</div>
                    </div>
                </a>
                <p class="text-[#6b8aaa] text-sm leading-relaxed mb-4">Accelerating the dissemination of knowledge through high quality, open-access peer-reviewed research.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-8 h-8 bg-[#1e3a5a] rounded-lg flex items-center justify-center hover:bg-[#2a4a6a] transition-colors">
                        <span class="text-[#6b8aaa] text-xs font-medium">tw</span>
                    </a>
                    <a href="#" class="w-8 h-8 bg-[#1e3a5a] rounded-lg flex items-center justify-center hover:bg-[#2a4a6a] transition-colors">
                        <span class="text-[#6b8aaa] text-xs font-medium">fb</span>
                    </a>
                    <a href="#" class="w-8 h-8 bg-[#1e3a5a] rounded-lg flex items-center justify-center hover:bg-[#2a4a6a] transition-colors">
                        <span class="text-[#6b8aaa] text-xs font-medium">in</span>
                    </a>
                </div>
            </div>

            {{-- Journals --}}
            <div>
                <h5 class="text-[#c5d5e8] font-medium text-sm mb-4">Journals</h5>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('journals.index') }}" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">Browse All Journals</a>
                    <a href="{{ route('journals.index') }}" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">By Subject Area</a>
                    <a href="{{ route('articles.index') }}" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">Latest Articles</a>
                    <a href="{{ route('search') }}" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">Search Articles</a>
                </div>
            </div>

            {{-- Authors --}}
            <div>
                <h5 class="text-[#c5d5e8] font-medium text-sm mb-4">Authors</h5>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('register') }}" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">Submit Manuscript</a>
                    <a href="#" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">Author Guidelines</a>
                    <a href="{{ route('login') }}" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">Author Login</a>
                    <a href="#" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">Track Submission</a>
                </div>
            </div>

            {{-- About --}}
            <div>
                <h5 class="text-[#c5d5e8] font-medium text-sm mb-4">About</h5>
                <div class="flex flex-col gap-2">
                    <a href="#" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">About Us</a>
                    <a href="#" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">Editorial Board</a>
                    <a href="#" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">Contact Us</a>
                    <a href="#" class="text-[#6b8aaa] hover:text-[#a0b4cc] text-sm transition-colors">Privacy Policy</a>
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-[#1e3a5a] pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[#3d5a75] text-xs">© {{ date('Y') }} JournalSpace. All rights reserved. Open Access Publishing Platform.</p>
            <p class="text-[#3d5a75] text-xs">Built with Laravel · Powered by Open Access</p>
        </div>
    </div>
</footer>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>

@stack('scripts')
</body>
</html>