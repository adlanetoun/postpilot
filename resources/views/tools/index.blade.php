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
        <div class="group p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center group-hover:bg-[#006c49]/10 transition-colors">
                    <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">work</span>
                </div>
                <a href="{{ route('tools.linkedin-preview') }}" class="p-2 text-gray-400 hover:text-[#006c49] transition-colors">
                    <span class="material-symbols-outlined">arrow_outward</span>
                </a>
            </div>
            <a href="{{ route('tools.linkedin-preview') }}" class="block">
                <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans hover:text-[#006c49] transition-colors">LinkedIn Post Preview</h3>
            </a>
            <p class="text-sm text-[#4c4546] mb-4 flex-grow leading-relaxed">
                Visualize how your posts appear in the feed before publishing. Check the "...see more" fold cutoff.
            </p>
            <!-- Sub-Use-Cases Pills (Internal Linking Hub) -->
            <div class="flex flex-wrap items-center gap-1.5 mb-4 pt-3 border-t border-gray-100">
                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider mr-1">Variations:</span>
                <a href="{{ url('/tools/linkedin-post-preview/for-company-pages') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">Company Pages</a>
                <a href="{{ url('/tools/linkedin-post-preview/with-images') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">Image Crops</a>
            </div>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">ZERO SIGNUP</span>
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">DESKTOP &amp; MOBILE</span>
            </div>
        </div>

        <!-- Tool Card 2: X / Twitter Splitter -->
        <div class="group p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center group-hover:bg-[#006c49]/10 transition-colors">
                    <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">flutter_dash</span>
                </div>
                <a href="{{ route('tools.twitter-thread-splitter') }}" class="p-2 text-gray-400 hover:text-[#006c49] transition-colors">
                    <span class="material-symbols-outlined">arrow_outward</span>
                </a>
            </div>
            <a href="{{ route('tools.twitter-thread-splitter') }}" class="block">
                <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans hover:text-[#006c49] transition-colors">X / Twitter Splitter</h3>
            </a>
            <p class="text-sm text-[#4c4546] mb-4 flex-grow leading-relaxed">
                Automatically break down long text, blogs, and essays into a perfectly numbered 280-character thread.
            </p>
            <div class="flex flex-wrap items-center gap-1.5 mb-4 pt-3 border-t border-gray-100">
                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider mr-1">Variations:</span>
                <a href="{{ url('/tools/twitter-thread-splitter/from-blog-post') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">Blog to Thread</a>
                <a href="{{ url('/tools/twitter-thread-splitter/no-login') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">No Login</a>
            </div>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">ZERO SIGNUP</span>
            </div>
        </div>

        <!-- Tool Card 3: Bold & Italic Formatter -->
        <div class="group p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center group-hover:bg-[#006c49]/10 transition-colors">
                    <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">format_bold</span>
                </div>
                <a href="{{ route('tools.linkedin-bold-italic') }}" class="p-2 text-gray-400 hover:text-[#006c49] transition-colors">
                    <span class="material-symbols-outlined">arrow_outward</span>
                </a>
            </div>
            <a href="{{ route('tools.linkedin-bold-italic') }}" class="block">
                <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans hover:text-[#006c49] transition-colors">Bold &amp; Italic Formatter</h3>
            </a>
            <p class="text-sm text-[#4c4546] mb-4 flex-grow leading-relaxed">
                Convert standard text into Unicode bold and italic styles for use on platforms without native formatting.
            </p>
            <div class="flex flex-wrap items-center gap-1.5 mb-4 pt-3 border-t border-gray-100">
                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider mr-1">Variations:</span>
                <a href="{{ url('/tools/linkedin-bold-italic-generator/for-headlines') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">For Headlines</a>
                <a href="{{ url('/tools/linkedin-bold-italic-generator/for-comments') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">For Comments</a>
            </div>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">CLIENT-SIDE</span>
            </div>
        </div>

        <!-- Tool Card 4: Character Limit Counter -->
        <div class="group p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center group-hover:bg-[#006c49]/10 transition-colors">
                    <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">pin</span>
                </div>
                <a href="{{ route('tools.social-character-counter') }}" class="p-2 text-gray-400 hover:text-[#006c49] transition-colors">
                    <span class="material-symbols-outlined">arrow_outward</span>
                </a>
            </div>
            <a href="{{ route('tools.social-character-counter') }}" class="block">
                <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans hover:text-[#006c49] transition-colors">Character Limit Counter</h3>
            </a>
            <p class="text-sm text-[#4c4546] mb-4 flex-grow leading-relaxed">
                Real-time character, word, and reading time limits across LinkedIn, Threads, X, Instagram, and Facebook.
            </p>
            <div class="flex flex-wrap items-center gap-1.5 mb-4 pt-3 border-t border-gray-100">
                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider mr-1">Variations:</span>
                <a href="{{ url('/tools/social-character-counter/for-threads') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">Threads (500 chars)</a>
                <a href="{{ url('/tools/social-character-counter/for-instagram-reels') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">Instagram Reels</a>
                <a href="{{ url('/tools/social-character-counter/for-youtube-shorts') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">YouTube Shorts</a>
            </div>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">MULTI-PLATFORM</span>
            </div>
        </div>

        <!-- Tool Card 5: Time Saved & ROI -->
        <div class="group p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center group-hover:bg-[#006c49]/10 transition-colors">
                    <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">calculate</span>
                </div>
                <a href="{{ route('tools.social-roi-calculator') }}" class="p-2 text-gray-400 hover:text-[#006c49] transition-colors">
                    <span class="material-symbols-outlined">arrow_outward</span>
                </a>
            </div>
            <a href="{{ route('tools.social-roi-calculator') }}" class="block">
                <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans hover:text-[#006c49] transition-colors">Time Saved &amp; ROI</h3>
            </a>
            <p class="text-sm text-[#4c4546] mb-4 flex-grow leading-relaxed">
                Calculate the financial labor waste on manual posting and measure annual hours reclaimed with automation.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">ANALYTICS &amp; ROI</span>
            </div>
        </div>

        <!-- Tool Card 6: Spacing & Line Breaks -->
        <div class="group p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center group-hover:bg-[#006c49]/10 transition-colors">
                    <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">format_line_spacing</span>
                </div>
                <a href="{{ route('tools.linkedin-line-break') }}" class="p-2 text-gray-400 hover:text-[#006c49] transition-colors">
                    <span class="material-symbols-outlined">arrow_outward</span>
                </a>
            </div>
            <a href="{{ route('tools.linkedin-line-break') }}" class="block">
                <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans hover:text-[#006c49] transition-colors">Spacing &amp; Line Breaks</h3>
            </a>
            <p class="text-sm text-[#4c4546] mb-4 flex-grow leading-relaxed">
                Fix awkward formatting and preserve clean line breaks for LinkedIn and Instagram with zero-width spaces.
            </p>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">FORMATTING</span>
            </div>
        </div>

        <!-- Tool Card 7: GA4 UTM Link Builder -->
        <div class="group p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center group-hover:bg-[#006c49]/10 transition-colors">
                    <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">link</span>
                </div>
                <a href="{{ route('tools.utm-builder') }}" class="p-2 text-gray-400 hover:text-[#006c49] transition-colors">
                    <span class="material-symbols-outlined">arrow_outward</span>
                </a>
            </div>
            <a href="{{ route('tools.utm-builder') }}" class="block">
                <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans hover:text-[#006c49] transition-colors">GA4 UTM Link Builder</h3>
            </a>
            <p class="text-sm text-[#4c4546] mb-4 flex-grow leading-relaxed">
                Standardize your campaign tracking links quickly with automatic GA4 sanitization and QR codes.
            </p>
            <div class="flex flex-wrap items-center gap-1.5 mb-4 pt-3 border-t border-gray-100">
                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider mr-1">Variations:</span>
                <a href="{{ url('/tools/utm-link-builder/for-facebook-ads') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">Facebook Ads</a>
                <a href="{{ url('/tools/utm-link-builder/for-email-campaigns') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">Email Campaigns</a>
            </div>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">TRACKING</span>
            </div>
        </div>

        <!-- Tool Card 8: Engagement Rate Calculator -->
        <div class="group p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center group-hover:bg-[#006c49]/10 transition-colors">
                    <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">query_stats</span>
                </div>
                <a href="{{ route('tools.engagement-calculator') }}" class="p-2 text-gray-400 hover:text-[#006c49] transition-colors">
                    <span class="material-symbols-outlined">arrow_outward</span>
                </a>
            </div>
            <a href="{{ route('tools.engagement-calculator') }}" class="block">
                <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans hover:text-[#006c49] transition-colors">Engagement Rate</h3>
            </a>
            <p class="text-sm text-[#4c4546] mb-4 flex-grow leading-relaxed">
                Instantly calculate and benchmark true engagement rates and letter grades across all social platforms.
            </p>
            <div class="flex flex-wrap items-center gap-1.5 mb-4 pt-3 border-t border-gray-100">
                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider mr-1">Variations:</span>
                <a href="{{ url('/tools/engagement-rate-calculator/for-tiktok') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">TikTok Rate</a>
                <a href="{{ url('/tools/engagement-rate-calculator/for-influencers') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">Influencer Audit</a>
            </div>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">METRICS</span>
            </div>
        </div>

        <!-- Tool Card 9: Content Calendar Matrix -->
        <div class="group p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center group-hover:bg-[#006c49]/10 transition-colors">
                    <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">calendar_month</span>
                </div>
                <a href="{{ route('tools.content-calendar-template') }}" class="p-2 text-gray-400 hover:text-[#006c49] transition-colors">
                    <span class="material-symbols-outlined">arrow_outward</span>
                </a>
            </div>
            <a href="{{ route('tools.content-calendar-template') }}" class="block">
                <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans hover:text-[#006c49] transition-colors">Calendar Matrix</h3>
            </a>
            <p class="text-sm text-[#4c4546] mb-4 flex-grow leading-relaxed">
                Generate a 30-day social media schedule with the proven 40/30/20/10 pillar matrix and instant CSV export.
            </p>
            <div class="flex flex-wrap items-center gap-1.5 mb-4 pt-3 border-t border-gray-100">
                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider mr-1">Variations:</span>
                <a href="{{ url('/tools/30-day-content-calendar-template/for-startups') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">For Startups</a>
                <a href="{{ url('/tools/30-day-content-calendar-template/for-real-estate') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">For Real Estate</a>
            </div>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">PLANNING</span>
            </div>
        </div>

        <!-- Tool Card 10: LinkedIn Hook Templates -->
        <div class="group p-6 bg-white rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col h-full relative">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-lg bg-[#f3f3f3] flex items-center justify-center group-hover:bg-[#006c49]/10 transition-colors">
                    <span class="material-symbols-outlined text-[#000000] group-hover:text-[#006c49] transition-colors text-2xl">bolt</span>
                </div>
                <a href="{{ route('tools.linkedin-hooks') }}" class="p-2 text-gray-400 hover:text-[#006c49] transition-colors">
                    <span class="material-symbols-outlined">arrow_outward</span>
                </a>
            </div>
            <a href="{{ route('tools.linkedin-hooks') }}" class="block">
                <h3 class="text-xl font-bold text-[#000000] mb-2 font-sans hover:text-[#006c49] transition-colors">LinkedIn Hook Matrix</h3>
            </a>
            <p class="text-sm text-[#4c4546] mb-4 flex-grow leading-relaxed">
                Browse and customize 25+ viral LinkedIn post hooks across Contrarian, Metric, and Story categories.
            </p>
            <div class="flex flex-wrap items-center gap-1.5 mb-4 pt-3 border-t border-gray-100">
                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider mr-1">Variations:</span>
                <a href="{{ url('/tools/linkedin-hook-templates/for-b2b-sales') }}" class="text-[11px] font-medium bg-gray-100 hover:bg-[#006c49]/10 hover:text-[#006c49] px-2 py-0.5 rounded transition-colors">B2B Sales Hooks</a>
            </div>
            <div class="flex items-center gap-2 mt-auto font-mono text-[11px]">
                <span class="text-[#000000] bg-[#f3f3f3] px-2.5 py-1 rounded font-semibold uppercase tracking-wider">COPYWRITING</span>
            </div>
        </div>
    </section>
</main>
@endsection

