<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — JournalSpace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

<div class="min-h-screen flex">

    {{-- LEFT PANEL --}}
    <div class="hidden lg:flex lg:w-1/2 bg-[#0f2744] flex-col justify-between p-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#e8a020] opacity-5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-400 opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>

        <a href="{{ route('home') }}" class="flex items-center gap-3 relative z-10">
            <div class="w-10 h-10 bg-[#e8a020] rounded-xl flex items-center justify-center">
                <span class="text-white font-bold text-base">JS</span>
            </div>
            <div>
                <div class="text-white font-semibold text-lg leading-tight">JournalSpace</div>
                <div class="text-[#a0b4cc] text-xs">Open Access Publishing</div>
            </div>
        </a>

        <div class="relative z-10">
            <div class="text-6xl mb-6">🔑</div>
            <h1 class="text-4xl font-semibold text-white leading-tight mb-4">
                Reset your<br>
                <span class="text-[#e8a020]">password</span>
            </h1>
            <p class="text-[#a0b4cc] text-base leading-relaxed max-w-md">
                Enter your registered email address and choose a new password. Your account will be updated immediately.
            </p>
            <div class="mt-8 bg-[#1e3a5a] rounded-xl p-5">
                <p class="text-[#a0b4cc] text-sm leading-relaxed">
                    <strong class="text-white">Note:</strong> Only author accounts can self-reset passwords.
                    Editors should contact the Super Admin for password assistance.
                </p>
            </div>
        </div>

        <div class="relative z-10">
            <p class="text-[#3d5a75] text-xs">© {{ date('Y') }} JournalSpace. All rights reserved.</p>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md">

            {{-- Mobile Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 mb-8 lg:hidden">
                <div class="w-9 h-9 bg-[#e8a020] rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">JS</span>
                </div>
                <div>
                    <div class="text-gray-800 font-semibold text-base leading-tight">JournalSpace</div>
                    <div class="text-gray-400 text-xs">Open Access Publishing</div>
                </div>
            </a>

            {{-- Heading --}}
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-1">Reset Your Password</h2>
                <p class="text-gray-400 text-sm">Enter your email and choose a new password</p>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0zm1-4a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('password.simple.update') }}" class="flex flex-col gap-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Email Address <span class="text-red-400">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-2 focus:ring-[#e8a020] focus:ring-opacity-20 transition-all @error('email') border-red-300 @enderror"
                           placeholder="Enter your registered email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        New Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-2 focus:ring-[#e8a020] focus:ring-opacity-20 transition-all pr-11 @error('password') border-red-300 @enderror"
                               placeholder="Min 8 characters">
                        <button type="button" onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Confirm New Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-2 focus:ring-[#e8a020] focus:ring-opacity-20 transition-all pr-11"
                               placeholder="Repeat your new password">
                        <button type="button" onclick="togglePassword('password_confirmation')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-[#e8a020] hover:bg-[#d4911c] text-white font-medium py-3 rounded-xl text-sm transition-colors mt-1">
                    Reset Password
                </button>

            </form>

            {{-- Back to login --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gray-100"></div>
                <span class="text-xs text-gray-400">Remember your password?</span>
                <div class="flex-1 h-px bg-gray-100"></div>
            </div>

            <a href="{{ route('login') }}"
               class="block w-full border border-gray-200 hover:border-[#e8a020] text-gray-700 hover:text-[#e8a020] font-medium py-3 rounded-xl text-sm text-center transition-all">
                Back to Sign In
            </a>

            <p class="text-center text-xs text-gray-400 mt-6">
                <a href="{{ route('home') }}" class="hover:text-gray-600 transition-colors">
                    ← Back to public site
                </a>
            </p>

        </div>
    </div>

</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

</body>
</html>