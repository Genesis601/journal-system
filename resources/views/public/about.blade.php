 
@extends('layouts.public')

@section('title', 'About Us')

@section('content')

{{-- HEADER --}}
<section class="bg-[#0f2744] py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <div class="inline-block bg-[#e8a020] bg-opacity-20 text-[#e8a020] text-xs font-medium px-3 py-1 rounded-full mb-4 border border-[#e8a020] border-opacity-30">
            About JournalSpace
        </div>
        <h1 class="text-4xl font-semibold text-white mb-4">Accelerating the Dissemination<br>of Knowledge</h1>
        <p class="text-[#a0b4cc] text-base max-w-2xl mx-auto leading-relaxed">
            JournalSpace is an open access publishing platform dedicated to making peer-reviewed research freely available to everyone, everywhere.
        </p>
    </div>
</section>

{{-- MISSION --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-1 h-7 bg-[#e8a020] rounded-full inline-block"></span>
                Our Mission
            </h2>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                JournalSpace was founded with a single mission — to make high quality academic research freely accessible to researchers, students and practitioners around the world, regardless of their location or institutional affiliation.
            </p>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                We believe that knowledge should have no borders. By operating on an open access model, we ensure that groundbreaking research in science, technology, medicine, agriculture, education and social sciences reaches the people who need it most.
            </p>
            <p class="text-gray-600 text-sm leading-relaxed">
                Every article published on JournalSpace undergoes a rigorous peer review process managed by our team of expert editors, ensuring the highest standards of academic integrity and quality.
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @foreach([
                ['num' => '48+', 'label' => 'Active Journals', 'color' => 'bg-blue-50 text-blue-600'],
                ['num' => '12K+', 'label' => 'Published Articles', 'color' => 'bg-green-50 text-green-600'],
                ['num' => '6K+', 'label' => 'Registered Authors', 'color' => 'bg-amber-50 text-amber-600'],
                ['num' => '180+', 'label' => 'Countries Reached', 'color' => 'bg-purple-50 text-purple-600'],
            ] as $stat)
                <div class="bg-white border border-gray-100 rounded-xl p-6 text-center">
                    <p class="text-3xl font-semibold {{ explode(' ', $stat['color'])[1] }} mb-1">{{ $stat['num'] }}</p>
                    <p class="text-xs text-gray-500">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- VALUES --}}
    <div class="mb-16">
        <h2 class="text-2xl font-semibold text-gray-800 mb-8 text-center flex items-center justify-center gap-2">
            <span class="w-1 h-7 bg-[#e8a020] rounded-full inline-block"></span>
            Our Core Values
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['icon' => '🔓', 'title' => 'Open Access', 'desc' => 'All articles are freely available to read, download and share. We believe research should be accessible to everyone without paywalls or subscription fees.'],
                ['icon' => '🔬', 'title' => 'Scientific Rigor', 'desc' => 'Every manuscript undergoes thorough peer review by expert editors. We maintain the highest standards of academic integrity and scientific quality.'],
                ['icon' => '🌍', 'title' => 'Global Impact', 'desc' => 'We actively seek to publish research from developing nations and underrepresented regions, amplifying voices from across the globe.'],
                ['icon' => '⚡', 'title' => 'Fast Publication', 'desc' => 'Our streamlined editorial process ensures manuscripts are reviewed and published quickly, getting important research out to the world faster.'],
                ['icon' => '🤝', 'title' => 'Author Support', 'desc' => 'We provide comprehensive support to authors throughout the submission and review process, from first submission to final publication.'],
                ['icon' => '📊', 'title' => 'Transparency', 'desc' => 'We maintain transparent editorial processes and clear communication between editors and authors at every stage of review.'],
            ] as $value)
                <div class="bg-white border border-gray-100 rounded-xl p-6 hover:shadow-md transition-all">
                    <div class="text-3xl mb-3">{{ $value['icon'] }}</div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">{{ $value['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- HOW IT WORKS --}}
    <div class="bg-[#0f2744] rounded-2xl p-10 mb-16">
        <h2 class="text-2xl font-semibold text-white mb-8 text-center">How It Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach([
                ['step' => '01', 'title' => 'Register', 'desc' => 'Create a free author account on JournalSpace'],
                ['step' => '02', 'title' => 'Submit', 'desc' => 'Upload your manuscript and select the appropriate journal'],
                ['step' => '03', 'title' => 'Review', 'desc' => 'Expert editors review your work and provide feedback'],
                ['step' => '04', 'title' => 'Publish', 'desc' => 'Approved articles are published and freely accessible worldwide'],
            ] as $step)
                <div class="text-center">
                    <div class="w-12 h-12 bg-[#e8a020] rounded-xl flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold text-sm">{{ $step['step'] }}</span>
                    </div>
                    <h3 class="text-white font-semibold text-sm mb-1">{{ $step['title'] }}</h3>
                    <p class="text-[#a0b4cc] text-xs leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="text-center">
        <h2 class="text-2xl font-semibold text-gray-800 mb-3">Ready to Publish Your Research?</h2>
        <p class="text-gray-500 text-sm mb-6 max-w-lg mx-auto">Join thousands of researchers who have published with JournalSpace and made their work available to the world.</p>
        <div class="flex items-center justify-center gap-3">
            <a href="{{ route('register') }}"
               class="bg-[#e8a020] hover:bg-[#d4911c] text-white text-sm font-medium px-6 py-3 rounded-xl transition-colors">
                Submit a Manuscript
            </a>
            <a href="{{ route('journals.index') }}"
               class="border border-gray-200 hover:border-[#e8a020] text-gray-700 hover:text-[#e8a020] text-sm font-medium px-6 py-3 rounded-xl transition-all">
                Browse Journals
            </a>
        </div>
    </div>

</div>

@endsection