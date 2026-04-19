<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — JournalSpace</title>
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

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 relative z-10">
            <div class="w-10 h-10 bg-[#e8a020] rounded-xl flex items-center justify-center">
                <span class="text-white font-bold text-base">JS</span>
            </div>
            <div>
                <div class="text-white font-semibold text-lg leading-tight">JournalSpace</div>
                <div class="text-[#a0b4cc] text-xs">Open Access Publishing</div>
            </div>
        </a>

        {{-- Center Content --}}
        <div class="relative z-10">
            <div class="inline-block bg-[#e8a020] bg-opacity-20 text-[#e8a020] text-xs font-medium px-3 py-1 rounded-full mb-6 border border-[#e8a020] border-opacity-30">
                Join Thousands of Researchers
            </div>
            <h1 class="text-4xl font-semibold text-white leading-tight mb-4">
                Share your research<br>
                <span class="text-[#e8a020]">with the world</span>
            </h1>
            <p class="text-[#a0b4cc] text-base leading-relaxed mb-10 max-w-md">
                Join thousands of researchers publishing open-access work across science, medicine, agriculture, technology and more.
            </p>

            {{-- Benefits --}}
            <div class="flex flex-col gap-4">
                @foreach([
                    ['icon' => '📤', 'title' => 'Easy Submission', 'desc' => 'Submit manuscripts in minutes with our simple form'],
                    ['icon' => '🔍', 'title' => 'Peer Review', 'desc' => 'Expert editors review and provide feedback on your work'],
                    ['icon' => '🌍', 'title' => 'Global Reach', 'desc' => 'Your research reaches readers in 180+ countries'],
                ] as $benefit)
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-[#e8a020] bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-base">{{ $benefit['icon'] }}</span>
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">{{ $benefit['title'] }}</p>
                            <p class="text-[#a0b4cc] text-xs mt-0.5 leading-relaxed">{{ $benefit['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Bottom --}}
        <div class="relative z-10">
            <p class="text-[#3d5a75] text-xs">© {{ date('Y') }} JournalSpace. All rights reserved.</p>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 overflow-y-auto">
        <div class="w-full max-w-md py-6">

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
                <h2 class="text-2xl font-semibold text-gray-800 mb-1">Create your account</h2>
                <p class="text-gray-400 text-sm">Register as an author to start submitting manuscripts</p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Full Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-2 focus:ring-[#e8a020] focus:ring-opacity-20 transition-all @error('name') border-red-300 @enderror"
                           placeholder="Your full name">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Email Address <span class="text-red-400">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-2 focus:ring-[#e8a020] focus:ring-opacity-20 transition-all @error('email') border-red-300 @enderror"
                           placeholder="you@example.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Password <span class="text-red-400">*</span>
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
                        Confirm Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-2 focus:ring-[#e8a020] focus:ring-opacity-20 transition-all pr-11"
                               placeholder="Repeat your password">
                        <button type="button" onclick="togglePassword('password_confirmation')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Terms --}}
                <div class="flex items-start gap-2">
                    <input type="checkbox" id="terms" required
                           class="rounded border-gray-300 text-[#e8a020] focus:ring-[#e8a020] mt-0.5 flex-shrink-0">
                    <label for="terms" class="text-xs text-gray-500 cursor-pointer leading-relaxed">
                        I agree to the
                        <a href="#" class="text-[#e8a020] hover:underline">Terms of Service</a>
                        and
                        <a href="#" class="text-[#e8a020] hover:underline">Privacy Policy</a>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-[#e8a020] hover:bg-[#d4911c] text-white font-medium py-3 rounded-xl text-sm transition-colors mt-1">
                    Create Account
                </button>

            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gray-100"></div>
                <span class="text-xs text-gray-400">Already have an account?</span>
                <div class="flex-1 h-px bg-gray-100"></div>
            </div>

            {{-- Login Link --}}
            <a href="{{ route('login') }}"
               class="block w-full border border-gray-200 hover:border-[#e8a020] text-gray-700 hover:text-[#e8a020] font-medium py-3 rounded-xl text-sm text-center transition-all">
                Sign In Instead
            </a>

            {{-- Back to site --}}
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