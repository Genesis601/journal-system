<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Page Not Found | JournalSpace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

<div class="min-h-screen flex flex-col items-center justify-center px-4 text-center">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-12">
        <div class="w-10 h-10 bg-[#e8a020] rounded-xl flex items-center justify-center">
            <span class="text-white font-bold text-base">JS</span>
        </div>
        <div class="text-left">
            <div class="text-gray-800 font-semibold text-base leading-tight">JournalSpace</div>
            <div class="text-gray-400 text-xs">Open Access Publishing</div>
        </div>
    </a>

    {{-- 404 Illustration --}}
    <div class="mb-6">
        <div class="text-8xl font-bold text-gray-100 leading-none select-none">404</div>
        <div class="text-5xl -mt-8 relative z-10">🔍</div>
    </div>

    {{-- Message --}}
    <h1 class="text-2xl font-semibold text-gray-800 mb-3">Page Not Found</h1>
    <p class="text-gray-500 text-sm max-w-md leading-relaxed mb-8">
        The page you're looking for doesn't exist or may have been moved. Try searching for what you need or head back to the homepage.
    </p>

    {{-- Search --}}
    <form action="{{ route('search') }}" method="GET" class="w-full max-w-md mb-6">
        <div class="flex items-center bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <input type="text" name="q" placeholder="Search articles and journals..."
                   class="flex-1 px-4 py-3 text-sm text-gray-700 outline-none border-none">
            <button type="submit"
                    class="bg-[#e8a020] hover:bg-[#d4911c] text-white px-5 py-3 text-sm font-medium transition-colors">
                Search
            </button>
        </div>
    </form>

    {{-- Quick Links --}}
    <div class="flex flex-wrap items-center justify-center gap-3">
        <a href="{{ route('home') }}"
           class="bg-[#0f2744] text-white text-sm px-5 py-2.5 rounded-lg hover:bg-[#1a3d5c] transition-colors">
            ← Go Home
        </a>
        <a href="{{ route('journals.index') }}"
           class="border border-gray-200 text-gray-600 hover:border-[#e8a020] hover:text-[#e8a020] text-sm px-5 py-2.5 rounded-lg transition-all">
            Browse Journals
        </a>
        <a href="{{ route('articles.index') }}"
           class="border border-gray-200 text-gray-600 hover:border-[#e8a020] hover:text-[#e8a020] text-sm px-5 py-2.5 rounded-lg transition-all">
            Browse Articles
        </a>
    </div>

</div>

</body>
</html>