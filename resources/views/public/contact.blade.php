 
@extends('layouts.public')

@section('title', 'Contact Us')

@section('content')

{{-- HEADER --}}
<section class="bg-[#0f2744] py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-[#a0b4cc] text-sm mb-3">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span class="mx-2">›</span>
            <span class="text-white">Contact</span>
        </div>
        <h1 class="text-3xl font-semibold text-white mb-2">Contact Us</h1>
        <p class="text-[#a0b4cc] text-sm">Get in touch with our editorial team</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        {{-- CONTACT FORM --}}
        <div class="lg:col-span-2">
            <div class="bg-white border border-gray-100 rounded-xl p-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-1">Send us a Message</h2>
                <p class="text-sm text-gray-400 mb-6">We typically respond within 24-48 hours</p>

                <form class="flex flex-col gap-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">Full Name</label>
                            <input type="text"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-1 focus:ring-[#e8a020] transition-colors"
                                   placeholder="Your full name">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">Email Address</label>
                            <input type="email"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] focus:ring-1 focus:ring-[#e8a020] transition-colors"
                                   placeholder="you@example.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Subject</label>
                        <select class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors">
                            <option value="">Select a subject</option>
                            <option>Manuscript Submission Inquiry</option>
                            <option>Editorial Process Question</option>
                            <option>Technical Support</option>
                            <option>Journal Information</option>
                            <option>Partnership Inquiry</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Message</label>
                        <textarea rows="6"
                                  class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#e8a020] transition-colors resize-none"
                                  placeholder="Write your message here..."></textarea>
                    </div>

                    <button type="submit"
                            class="bg-[#e8a020] hover:bg-[#d4911c] text-white text-sm font-medium px-6 py-3 rounded-lg transition-colors w-full sm:w-auto">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        {{-- CONTACT INFO --}}
        <div class="flex flex-col gap-5">

            {{-- Info Cards --}}
            @foreach([
                ['icon' => '📧', 'title' => 'Email Us', 'lines' => ['editorial@journalspace.com', 'support@journalspace.com']],
                ['icon' => '📞', 'title' => 'Call Us', 'lines' => ['+234 800 000 0000', 'Mon-Fri, 9am - 5pm WAT']],
                ['icon' => '📍', 'title' => 'Our Office', 'lines' => ['123 Research Avenue', 'Lagos, Nigeria']],
            ] as $info)
                <div class="bg-white border border-gray-100 rounded-xl p-5">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-[#e8a020] bg-opacity-10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-lg">{{ $info['icon'] }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 mb-1">{{ $info['title'] }}</p>
                            @foreach($info['lines'] as $line)
                                <p class="text-xs text-gray-500">{{ $line }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- FAQ --}}
            <div class="bg-[#0f2744] rounded-xl p-5">
                <h3 class="text-white font-semibold text-sm mb-3">Quick Links</h3>
                <div class="flex flex-col gap-2">
                    @foreach([
                        ['label' => 'Author Guidelines', 'route' => 'home'],
                        ['label' => 'Submit a Manuscript', 'route' => 'register'],
                        ['label' => 'Browse Journals', 'route' => 'journals.index'],
                        ['label' => 'About Us', 'route' => 'about'],
                    ] as $link)
                        <a href="{{ route($link['route']) }}"
                           class="flex items-center justify-between text-[#a0b4cc] hover:text-white text-xs py-1.5 transition-colors group">
                            <span>{{ $link['label'] }}</span>
                            <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@endsection