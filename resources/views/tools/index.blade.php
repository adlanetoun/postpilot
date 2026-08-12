@extends('layouts.tool')

@section('title', '100% Free Social Media Tools Directory - PostPilot')
@section('meta_description', 'Free, zero-signup micro-tools for creators, marketers, and SaaS founders. Preview posts, split Twitter threads, format LinkedIn text, and calculate ROI instantly.')

@section('content')
<main class="flex-grow w-full font-sans py-4">
    <!-- Hero Section -->
    <section class="text-center max-w-3xl mx-auto mb-16 space-y-6">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gray-300/60 bg-white/80 backdrop-blur-sm shadow-md">
            <span class="w-2 h-2 rounded-full bg-[#006c49]"></span>
            <span class="font-mono text-xs text-[#4c4546] tracking-widest uppercase font-semibold">100% FREE • NO SIGNUP REQUIRED • CLIENT-SIDE</span>
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-[#000000] tracking-tight font-sans leading-tight">
            Growth Marketing <span class="text-[#006c49] relative whitespace-nowrap"><span class="relative z-10">Superpowers.</span><svg class="absolute -bottom-2 left-0 w-full h-3 text-[#006c49]/20" preserveAspectRatio="none" viewBox="0 0 100 10"><path d="M0 5 Q 50 10 100 5" fill="none" stroke="currentColor" stroke-width="4"></path></svg></span>
        </h1>
        <p class="text-base sm:text-lg md:text-xl text-[#4c4546] max-w-2xl mx-auto leading-relaxed">
            Purpose-built utilities for founders, marketers, and creators to format, preview, analyze, and optimize content.
        </p>
    </section>

    <!-- Tools Grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Tool Card 1: LinkedIn Preview -->
        <a class="group block p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative overflow-hidden" href="{{ route('tools.linkedin-preview') }}">
            <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="material-symbols-outlined text-[#006c49]">arrow_outward</span>
            </div>
            <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center mb-6 group-hover:bg-[#006c49]/10 transition-colors">
                <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">work</span>
            </div>
            <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans">LinkedIn Post Preview</h3>
            <p class="text-sm text-[#4c4546] mb-6 flex-grow leading-relaxed">
                Visualize how your posts will appear in the feed before hitting publish. Ensure your formatting is perfect.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">ZERO SIGNUP</span>
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">DESKTOP &amp; MOBILE</span>
            </div>
        </a>

        <!-- Tool Card 2: X / Twitter Splitter -->
        <a class="group block p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative overflow-hidden" href="{{ route('tools.twitter-thread-splitter') }}">
            <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="material-symbols-outlined text-[#006c49]">arrow_outward</span>
            </div>
            <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center mb-6 group-hover:bg-[#006c49]/10 transition-colors">
                <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">flutter_dash</span>
            </div>
            <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans">X / Twitter Splitter</h3>
            <p class="text-sm text-[#4c4546] mb-6 flex-grow leading-relaxed">
                Automatically break down long text into a perfectly threaded sequence.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">ZERO SIGNUP</span>
            </div>
        </a>

        <!-- Tool Card 3: Bold & Italic Formatter -->
        <a class="group block p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative overflow-hidden" href="{{ route('tools.linkedin-bold-italic') }}">
            <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="material-symbols-outlined text-[#006c49]">arrow_outward</span>
            </div>
            <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center mb-6 group-hover:bg-[#006c49]/10 transition-colors">
                <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">format_bold</span>
            </div>
            <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans">Bold &amp; Italic Formatter</h3>
            <p class="text-sm text-[#4c4546] mb-6 flex-grow leading-relaxed">
                Convert standard text into Unicode bold and italic styles for use on platforms that don't support native formatting.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">CLIENT-SIDE</span>
            </div>
        </a>

        <!-- Tool Card 4: Character Limit Counter -->
        <a class="group block p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative overflow-hidden" href="{{ route('tools.social-character-counter') }}">
            <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="material-symbols-outlined text-[#006c49]">arrow_outward</span>
            </div>
            <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center mb-6 group-hover:bg-[#006c49]/10 transition-colors">
                <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">pin</span>
            </div>
            <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans">Character Limit Counter</h3>
            <p class="text-sm text-[#4c4546] mb-6 flex-grow leading-relaxed">
                Real-time character and word counts tailored to platform-specific limits.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">MULTI-PLATFORM</span>
            </div>
        </a>

        <!-- Tool Card 5: Time Saved & ROI -->
        <a class="group block p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative overflow-hidden" href="{{ route('tools.social-roi-calculator') }}">
            <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="material-symbols-outlined text-[#006c49]">arrow_outward</span>
            </div>
            <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center mb-6 group-hover:bg-[#006c49]/10 transition-colors">
                <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">calculate</span>
            </div>
            <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans">Time Saved &amp; ROI</h3>
            <p class="text-sm text-[#4c4546] mb-6 flex-grow leading-relaxed">
                Calculate the true value of your automated workflows and marketing efforts.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">ANALYTICS</span>
            </div>
        </a>

        <!-- Tool Card 6: Spacing & Line Breaks -->
        <a class="group block p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative overflow-hidden" href="{{ route('tools.linkedin-line-break') }}">
            <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="material-symbols-outlined text-[#006c49]">arrow_outward</span>
            </div>
            <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center mb-6 group-hover:bg-[#006c49]/10 transition-colors">
                <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">format_line_spacing</span>
            </div>
            <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans">Spacing &amp; Line Breaks</h3>
            <p class="text-sm text-[#4c4546] mb-6 flex-grow leading-relaxed">
                Fix awkward formatting and preserve clean line breaks for Instagram and LinkedIn.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">FORMATTING</span>
            </div>
        </a>

        <!-- Tool Card 7: GA4 UTM Link Builder -->
        <a class="group block p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative overflow-hidden" href="{{ route('tools.utm-builder') }}">
            <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="material-symbols-outlined text-[#006c49]">arrow_outward</span>
            </div>
            <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center mb-6 group-hover:bg-[#006c49]/10 transition-colors">
                <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">link</span>
            </div>
            <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans">GA4 UTM Link Builder</h3>
            <p class="text-sm text-[#4c4546] mb-6 flex-grow leading-relaxed">
                Standardize your campaign tracking links quickly and accurately.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">TRACKING</span>
            </div>
        </a>

        <!-- Tool Card 8: Engagement Rate Calculator -->
        <a class="group block p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative overflow-hidden" href="{{ route('tools.engagement-calculator') }}">
            <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="material-symbols-outlined text-[#006c49]">arrow_outward</span>
            </div>
            <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center mb-6 group-hover:bg-[#006c49]/10 transition-colors">
                <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">query_stats</span>
            </div>
            <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans">Engagement Rate</h3>
            <p class="text-sm text-[#4c4546] mb-6 flex-grow leading-relaxed">
                Instantly calculate true engagement rates across different platforms.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">METRICS</span>
            </div>
        </a>

        <!-- Tool Card 9: Content Calendar Matrix -->
        <a class="group block p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative overflow-hidden" href="{{ route('tools.content-calendar-template') }}">
            <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="material-symbols-outlined text-[#006c49]">arrow_outward</span>
            </div>
            <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center mb-6 group-hover:bg-[#006c49]/10 transition-colors">
                <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">calendar_month</span>
            </div>
            <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans">Calendar Matrix</h3>
            <p class="text-sm text-[#4c4546] mb-6 flex-grow leading-relaxed">
                Plan your content themes and cadence with a visual strategy matrix.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">PLANNING</span>
            </div>
        </a>
    </section>
</main>
@endsection
