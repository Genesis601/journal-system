 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — JournalSpace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

<div class="min-h-screen flex">

    {{-- LEFT PANEL --}}
    <div class="hidden lg:flex lg:w-1/2 bg-[#0f2744] flex-col justify-between p-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#e8a020] opacity-5 rounded-full -translate-y-1/2 translate-x-1/2"></div>

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
            <div class="text-6xl mb-6">🔐</div>
            <h1 class="text-4xl font-semibold text-white leading-tight mb-4">
                Create a new<br>
                <span class="text-[#e8a020]">password</span>
            </h1>
            <p class="text-[#a0b4cc] text-base leading-relaxed max-w-md">
                Choose a strong password that is at least 8 characters long. Your account will be secured immediately.
            </p>
            <div class="mt-8 bg-[#1e3a5a] rounded-xl p-5 flex flex-col gap-2">
                <p class="text-[#a0b4cc] text-xs flex items-center gap-2">
                    <span class="text-green-400">✓</span> At least 8 characters
                </p>
                <p class="text-[#a0b4cc] text-xs flex items-center gap-2">
                    <span class="text-green-400">✓</span> Mix of letters and numbers
                </p>
                <p class="text-[#a0b4cc] text-xs flex items-center gap-2">
                    <span class="text-green-400">✓</span> Avoid common passwords
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

            <a href="{{ route('home') }}" class="flex items-center gap-3 mb-8 lg:hidden">
                <div class="w-9 h-9 bg-[#e8a020] rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">JS</span>
                </div>
                <div>
                    <div class="text-gray-800 font-semibold text-base">JournalSpace</div>
                    <div class="text-gray-400 text-xs">Open Access Publishing</div>
                </div>
            </a>

            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-1">Set New Password</h2>
                <p class="text-gray-400 text-sm">Enter and confirm your new password below</p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0zm1-4a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.reset.update') }}" class="flex flex-col gap-4">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        New Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                               required
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
                    {{-- Strength bar --}}
                    <div class="mt-2">
                        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div id="strength-fill" class="h-full rounded-full transition-all duration-300" style="width:0%"></div>
                        </div>
                        <p id="strength-text" class="text-xs mt-1 text-gray-400"></p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Confirm New Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation"
                               id="password_confirmation" required
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
                    <p id="match-text" class="text-xs mt-1"></p>
                </div>

                <button type="submit"
                        class="w-full bg-[#e8a020] hover:bg-[#d4911c] text-white font-medium py-3 rounded-xl text-sm transition-colors mt-1">
                    Reset Password
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-6">
                <a href="{{ route('login') }}" class="hover:text-gray-600 transition-colors">
                    ← Back to Sign In
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

    // Password strength
    document.getElementById('password').addEventListener('input', function() {
        const val    = this.value;
        const fill   = document.getElementById('strength-fill');
        const text   = document.getElementById('strength-text');
        let strength = 0;

        if (val.length >= 8)           strength++;
        if (/[A-Z]/.test(val))         strength++;
        if (/[0-9]/.test(val))         strength++;
        if (/[^A-Za-z0-9]/.test(val))  strength++;

        const levels = [
            { width: '0%',   color: '',         label: '' },
            { width: '25%',  color: '#ef4444',  label: 'Weak' },
            { width: '50%',  color: '#f97316',  label: 'Fair' },
            { width: '75%',  color: '#eab308',  label: 'Good' },
            { width: '100%', color: '#22c55e',  label: 'Strong ✓' },
        ];

        fill.style.width           = levels[strength].width;
        fill.style.backgroundColor = levels[strength].color;
        text.textContent           = levels[strength].label;
        text.style.color           = levels[strength].color;
    });

    // Password match check
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const match = document.getElementById('match-text');
        if (this.value === document.getElementById('password').value) {
            match.textContent = '✓ Passwords match';
            match.style.color = '#22c55e';
        } else {
            match.textContent = '✗ Passwords do not match';
            match.style.color = '#ef4444';
        }
    });
</script>

</body>
</html>