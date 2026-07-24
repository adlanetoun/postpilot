<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="auto30">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'PostPilot') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=4">
        <link rel="shortcut icon" href="{{ asset('favicon.svg') }}?v=4">

        <!-- Google Fonts: Inter and Manrope -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-inter bg-white text-gray-900 min-h-screen overflow-x-hidden">
        <!-- Navigation (Tier-1 Minimalist & Brutalist) -->
        <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    
                    <!-- Left: Logo -->
                    <div class="flex shrink-0 items-center">
                        <a href="/" class="flex items-center gap-2 group">
                            <div class="w-8 h-8 rounded bg-black flex items-center justify-center transition-transform group-hover:rotate-6">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="text-[18px] font-extrabold text-black tracking-tight">PostPilot</span>
                        </a>
                    </div>

                    <!-- Center: Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8 absolute left-1/2 -translate-x-1/2">
                        <a href="#" class="text-[13px] font-bold text-black tracking-wide">Home</a>
                        <a href="#features" class="text-[13px] font-medium text-gray-500 hover:text-black transition-colors tracking-wide">Features</a>
                        <a href="#how-it-works" class="text-[13px] font-medium text-gray-500 hover:text-black transition-colors tracking-wide">How it Works</a>
                        <a href="#pricing" class="text-[13px] font-medium text-gray-500 hover:text-black transition-colors tracking-wide">Pricing</a>
                    </div>

                    <!-- Right: Auth / CTA -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2 text-[13px] font-bold text-white bg-black hover:bg-gray-800 transition-colors">
                                Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-[13px] font-bold text-gray-600 hover:text-black transition-colors">
                                Log in
                            </a>
                            <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2 text-[13px] font-bold text-white bg-black hover:bg-gray-800 transition-colors">
                                Start Free
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </nav>

        <!-- Hero Section (Tier-1 Editorial Brutalist - Zero Glows) -->
        <section class="relative pt-24 pb-24 lg:pt-32 lg:pb-32 bg-white overflow-hidden border-b border-gray-200">
            
            <!-- Exact Grid Background (Subtle, Structural, Not Glowing) -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIC41aDQwTTAgMjAuNWg0ME0yMC41IDB2NDBNLjUgMHY0MCIgc3Ryb2tlPSJyZ2JhKDAsIDAsIDAsIDAuMDMpIi8+PC9zdmc+')] pointer-events-none -z-10"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                    
                    <!-- Left: Copy & CTA -->
                    <div class="lg:col-span-6 flex flex-col items-start text-left">
                        
                        <!-- High-contrast engineering badge -->
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 mb-8">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span class="text-[11px] font-extrabold text-emerald-900 tracking-widest uppercase font-mono">Autopilot Marketing Engine</span>
                        </div>

                        <h1 class="font-extrabold text-[52px] leading-[1.05] sm:text-[64px] lg:text-[76px] text-black tracking-tighter mb-6">
                            30 Days of Content.<br />
                            <span class="text-gray-400">Published On Autopilot.</span>
                        </h1>

                        <p class="text-[18px] sm:text-[20px] font-medium leading-relaxed text-gray-600 mb-10 max-w-lg">
                            Input your brand once. Our AI generates a full 30-day omnichannel strategy and automatically publishes your posts to X, LinkedIn, and Facebook on scheduled autopilot.
                        </p>

                        <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                            @auth
                                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-black text-white text-[15px] font-bold transition-all hover:bg-gray-800">
                                    Open Dashboard &rarr;
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-black text-white text-[15px] font-bold transition-all hover:bg-gray-800">
                                    Start Generating
                                </a>
                                <a href="#how-it-works" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-white text-black border-2 border-black text-[15px] font-bold transition-all hover:bg-gray-50">
                                    View Output
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Right: Visual Metaphor (Input -> Output) -->
                    <div class="lg:col-span-6 relative h-[500px] w-full flex items-center justify-center lg:justify-end">
                        
                        <!-- Connecting Line (SVG) -->
                        <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full hidden lg:block" fill="none" viewBox="0 0 500 500" preserveAspectRatio="none">
                            <path d="M 100 250 C 250 250, 250 100, 400 100" stroke="#E5E7EB" stroke-width="2" stroke-dasharray="4 4" />
                            <path d="M 100 250 C 250 250, 250 400, 400 400" stroke="#E5E7EB" stroke-width="2" stroke-dasharray="4 4" />
                        </svg>

                        <!-- Input Box (Brand Brief) -->
                        <div class="absolute left-0 lg:left-10 top-1/2 -translate-y-1/2 w-[240px] bg-white border border-gray-200 shadow-xl p-5 z-20">
                            <div class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-3 border-b border-gray-100 pb-2">1. Brand Brief</div>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-[10px] font-semibold text-gray-500 mb-1">Product Name</div>
                                    <div class="h-6 w-full bg-gray-100 rounded-sm"></div>
                                </div>
                                <div>
                                    <div class="text-[10px] font-semibold text-gray-500 mb-1">Target Audience</div>
                                    <div class="h-6 w-5/6 bg-gray-100 rounded-sm"></div>
                                </div>
                                <div>
                                    <div class="text-[10px] font-semibold text-gray-500 mb-1">Value Prop</div>
                                    <div class="h-12 w-full bg-gray-100 rounded-sm"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Output Card 1 (LinkedIn) -->
                        <div class="absolute right-0 lg:right-4 top-10 w-[280px] bg-white border border-gray-200 shadow-lg p-5 z-20 transition-transform hover:-translate-y-1">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-5 h-5 bg-[#0A66C2] rounded flex items-center justify-center text-white text-[10px] font-bold">in</div>
                                <div class="text-[11px] font-bold text-gray-900">Day 1: The Hook</div>
                            </div>
                            <div class="text-[12px] text-gray-600 leading-relaxed mb-3">
                                Stop struggling with manual posting. We built a system that generates an entire month of content in exactly 5 minutes...
                            </div>
                            <div class="h-2 w-16 bg-gray-100"></div>
                        </div>

                        <!-- Output Card 2 (X/Twitter) -->
                        <div class="absolute right-10 lg:right-14 bottom-10 w-[260px] bg-white border border-gray-200 shadow-xl p-5 z-30 transition-transform hover:-translate-y-1">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-5 h-5 bg-black rounded-full flex items-center justify-center text-white text-[10px] font-bold">X</div>
                                <div class="text-[11px] font-bold text-gray-900">Day 12: Hot Take</div>
                            </div>
                            <div class="text-[13px] text-black font-medium leading-snug mb-3">
                                Writing social media posts is a waste of developer time. Automate it or get left behind. 🚀
                            </div>
                            <div class="flex gap-2">
                                <div class="h-1.5 w-8 bg-gray-200 rounded-full"></div>
                                <div class="h-1.5 w-6 bg-gray-200 rounded-full"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section (Tier-1 Editorial Brutalist) -->
        <section class="py-24 lg:py-32 bg-white border-b border-gray-200" id="features">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="mb-16 lg:mb-24 flex flex-col md:flex-row md:items-end justify-between gap-8">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 mb-6">
                            <div class="w-2 h-2 bg-black"></div>
                            <span class="text-[11px] font-bold text-gray-500 tracking-widest uppercase font-mono">System Capabilities</span>
                        </div>
                        <h2 class="font-extrabold text-[40px] leading-[1.1] sm:text-[52px] text-black tracking-tighter">
                            Supercharge your <br class="hidden sm:block" />
                            <span class="text-gray-400">social presence.</span>
                        </h2>
                    </div>
                    <div class="max-w-md">
                        <p class="text-[16px] text-gray-600 leading-relaxed font-medium mb-6">
                            We provide the architectural tools you need to automate your social media marketing and save hours of manual labor every single week.
                        </p>
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-[13px] font-bold text-black border-b-2 border-black pb-1 hover:text-gray-600 hover:border-gray-600 transition-colors uppercase tracking-wide">
                                Open Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center text-[13px] font-bold text-black border-b-2 border-black pb-1 hover:text-gray-600 hover:border-gray-600 transition-colors uppercase tracking-wide">
                                Start Generating &rarr;
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Architectural Grid (2x2) -->
                <div class="grid grid-cols-1 md:grid-cols-2 border-t border-l border-gray-200">
                    
                    <!-- Feature 1 -->
                    <div class="group relative bg-white border-b border-r border-gray-200 p-8 lg:p-12 hover:bg-[#FAFAFA] transition-colors">
                        <div class="flex justify-between items-start mb-16">
                            <div class="w-12 h-12 bg-black flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <span class="text-[13px] font-mono font-bold text-gray-300">[ 01 ]</span>
                        </div>
                        <h4 class="text-[22px] font-extrabold text-black mb-4 tracking-tight">AI-Powered Generation</h4>
                        <p class="text-[15px] font-medium text-gray-500 leading-relaxed max-w-sm">
                            Instantly create 30 days of tailored content for multiple platforms from a simple brief. No prompt engineering required.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="group relative bg-white border-b border-r border-gray-200 p-8 lg:p-12 hover:bg-[#FAFAFA] transition-colors">
                        <div class="flex justify-between items-start mb-16">
                            <div class="w-12 h-12 border-2 border-black flex items-center justify-center">
                                <svg class="w-5 h-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                            </div>
                            <span class="text-[13px] font-mono font-bold text-gray-300">[ 02 ]</span>
                        </div>
                        <h4 class="text-[22px] font-extrabold text-black mb-4 tracking-tight">Platform Optimized</h4>
                        <p class="text-[15px] font-medium text-gray-500 leading-relaxed max-w-sm">
                            Every post is structurally tailored for maximum engagement on specific native platforms like X, LinkedIn, or Facebook.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="group relative bg-white border-b border-r border-gray-200 p-8 lg:p-12 hover:bg-[#FAFAFA] transition-colors">
                        <div class="flex justify-between items-start mb-16">
                            <div class="w-12 h-12 bg-gray-100 flex items-center justify-center">
                                <div class="w-5 h-5 border-[3px] border-black rounded-full"></div>
                            </div>
                            <span class="text-[13px] font-mono font-bold text-gray-300">[ 03 ]</span>
                        </div>
                        <h4 class="text-[22px] font-extrabold text-black mb-4 tracking-tight">Consistent Posting</h4>
                        <p class="text-[15px] font-medium text-gray-500 leading-relaxed max-w-sm">
                            Keep your audience engaged continuously with a full month of scheduled, high-quality, sequential content.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="group relative bg-white border-b border-r border-gray-200 p-8 lg:p-12 hover:bg-[#FAFAFA] transition-colors">
                        <div class="flex justify-between items-start mb-16">
                            <div class="w-12 h-12 border border-gray-300 flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIC41aDQwTTAgMjAuNWg0ME0yMC41IDB2NDBNLjUgMHY0MCIgc3Ryb2tlPSJyZ2JhKDAsIDAsIDAsIDAuMSkiLz48L3N2Zz4=')]"></div>
                                <svg class="w-5 h-5 text-black relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-[13px] font-mono font-bold text-gray-300">[ 04 ]</span>
                        </div>
                        <h4 class="text-[22px] font-extrabold text-black mb-4 tracking-tight">Save Time & Effort</h4>
                        <p class="text-[15px] font-medium text-gray-500 leading-relaxed max-w-sm">
                            Say goodbye to writer's block and tedious manual posting. Let our algorithmic Engine handle the heavy lifting.
                        </p>
                    </div>

                </div>
            </div>
        </section>
        <!-- How It Works Section (Tier-1 Editorial Brutalist) -->
        <section class="py-24 lg:py-32 bg-[#FAFAFA] border-b border-gray-200" id="how-it-works">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="mb-16 lg:mb-24">
                    <div class="inline-flex items-center gap-2 mb-6">
                        <div class="w-2 h-2 bg-black"></div>
                        <span class="text-[11px] font-bold text-gray-500 tracking-widest uppercase font-mono">Operational Flow</span>
                    </div>
                    <h2 class="font-extrabold text-[40px] leading-[1.1] sm:text-[52px] text-black tracking-tighter max-w-2xl">
                        Three steps to put your <br />
                        <span class="text-gray-400">content on autopilot.</span>
                    </h2>
                </div>

                <!-- Architectural Timeline -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-16">
                    
                    <!-- Step 1 -->
                    <div class="relative pt-8 border-t-4 border-black group hover:-translate-y-2 transition-transform">
                        <div class="text-[64px] font-extrabold text-gray-200 leading-none mb-6 font-mono group-hover:text-black transition-colors">01</div>
                        <h3 class="font-extrabold text-[22px] text-black mb-3 tracking-tight">Set Your Preferences</h3>
                        <p class="text-[15px] font-medium text-gray-500 leading-relaxed">
                            Input your target audience, tone of voice, and the core message or product you want to promote.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative pt-8 border-t-4 border-gray-300 group hover:-translate-y-2 transition-transform hover:border-black">
                        <div class="text-[64px] font-extrabold text-gray-200 leading-none mb-6 font-mono group-hover:text-black transition-colors">02</div>
                        <h3 class="font-extrabold text-[22px] text-black mb-3 tracking-tight">Let AI Generate</h3>
                        <p class="text-[15px] font-medium text-gray-500 leading-relaxed">
                            Our Engine creates 30 days of unique, platform-optimized content tailored for X, LinkedIn, and Facebook.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative pt-8 border-t-4 border-gray-300 group hover:-translate-y-2 transition-transform hover:border-black">
                        <div class="text-[64px] font-extrabold text-gray-200 leading-none mb-6 font-mono group-hover:text-black transition-colors">03</div>
                        <h3 class="font-extrabold text-[22px] text-black mb-3 tracking-tight">Review & Schedule</h3>
                        <p class="text-[15px] font-medium text-gray-500 leading-relaxed">
                            Approve or edit the generated posts, then schedule them directly to your platforms with one click.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Pricing Section (Tier-1 Editorial Brutalist) -->
        <section class="py-24 lg:py-32 bg-white border-b border-gray-200" id="pricing">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <!-- Header & Toggle -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16 lg:mb-24">
                    <div>
                        <div class="inline-flex items-center gap-2 mb-6">
                            <div class="w-2 h-2 bg-black"></div>
                            <span class="text-[11px] font-bold text-gray-500 tracking-widest uppercase font-mono">Investment</span>
                        </div>
                        <h2 class="font-extrabold text-[40px] leading-[1.1] sm:text-[52px] text-black tracking-tighter">
                            Pay per campaign.<br />
                            <span class="text-gray-400">No subscriptions.</span>
                        </h2>
                    </div>

                    <!-- Toggle (Brutalist) -->
                    <div class="flex flex-col items-end gap-3">
                        <span class="text-[11px] font-bold text-gray-500 tracking-widest uppercase font-mono">[ BUY IN BULK TO SAVE ]</span>
                    </div>
                </div>

                <!-- Pricing Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-3 border-t border-l border-gray-200">
                    <!-- Starter Plan -->
                    <div class="bg-white border-b border-r border-gray-200 p-8 lg:p-12 flex flex-col hover:bg-[#FAFAFA] transition-colors">
                        <h3 class="text-[22px] font-extrabold text-black mb-2 tracking-tight">Starter</h3>
                        <p class="text-[13px] font-medium text-gray-500 mb-12">1 Campaign Credit. Perfect to test the waters.</p>
                        <div class="mb-12">
                            <span class="text-[56px] font-extrabold text-black leading-none tracking-tighter">$9.99</span>
                            <span class="text-[15px] font-medium text-gray-400 ml-2">/ one-time</span>
                        </div>
                        <a href="{{ auth()->check() ? url('/settings?tab=billing') : route('register') }}" class="mt-auto block w-full py-4 border-2 border-black text-[13px] font-bold tracking-wide text-center text-black uppercase hover:bg-black hover:text-white transition-colors">
                            Buy Credit
                        </a>
                    </div>
                    <!-- Pro Plan -->
                    <div class="bg-black border-b border-r border-black p-8 lg:p-12 flex flex-col relative transform lg:scale-105 z-10 shadow-2xl">
                        <div class="absolute top-0 right-8 transform -translate-y-1/2 bg-white px-3 py-1 border-2 border-black">
                            <span class="text-[10px] font-bold text-black uppercase tracking-widest">Popular</span>
                        </div>
                        <h3 class="text-[22px] font-extrabold text-white mb-2 tracking-tight">Pro</h3>
                        <p class="text-[13px] font-medium text-gray-400 mb-12">3 Campaign Credits. Full automation suite for professionals.</p>
                        <div class="mb-12">
                            <span class="text-[56px] font-extrabold text-white leading-none tracking-tighter">$25.99</span>
                            <span class="text-[15px] font-medium text-gray-400 ml-2">/ one-time</span>
                        </div>
                        <a href="{{ auth()->check() ? url('/settings?tab=billing') : route('register') }}" class="mt-auto block w-full py-4 bg-white border-2 border-white text-[13px] font-bold tracking-wide text-center text-black uppercase hover:bg-gray-200 transition-colors">
                            Buy Credits
                        </a>
                    </div>
                    <!-- Agency Plan -->
                    <div class="bg-white border-b border-r border-gray-200 p-8 lg:p-12 flex flex-col hover:bg-[#FAFAFA] transition-colors">
                        <h3 class="text-[22px] font-extrabold text-black mb-2 tracking-tight">Agency</h3>
                        <p class="text-[13px] font-medium text-gray-500 mb-12">10 Campaign Credits. Maximum value for heavy users.</p>
                        <div class="mb-12">
                            <span class="text-[56px] font-extrabold text-black leading-none tracking-tighter">$69.99</span>
                            <span class="text-[15px] font-medium text-gray-400 ml-2">/ one-time</span>
                        </div>
                        <a href="{{ auth()->check() ? url('/settings?tab=billing') : route('register') }}" class="mt-auto block w-full py-4 border-2 border-black text-[13px] font-bold tracking-wide text-center text-black uppercase hover:bg-black hover:text-white transition-colors">
                            Buy Credits
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section (Tier-1 Editorial Brutalist - Light Mode v2) -->
        <section class="py-24 lg:py-32 bg-white border-t border-gray-200" id="faq">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col lg:flex-row gap-16 lg:gap-24">
                    
                    <!-- Left: Header -->
                    <div class="lg:w-1/3">
                        <div class="inline-flex items-center gap-2 mb-6">
                            <div class="w-3 h-3 bg-black"></div>
                            <span class="text-[12px] font-bold text-gray-500 tracking-widest uppercase font-mono">Knowledge Base</span>
                        </div>
                        <h2 class="font-extrabold text-[44px] leading-[1.05] sm:text-[64px] text-black tracking-tighter sticky top-24">
                            Questions.<br />
                            <span class="text-gray-400">Answered.</span>
                        </h2>
                    </div>

                    <!-- Right: Interactive Brutalist Accordion -->
                    <div class="lg:w-2/3 flex flex-col border-t-2 border-gray-200">
                        
                        <!-- FAQ Item 1 -->
                        <details class="group border-b-2 border-gray-200">
                            <summary class="flex items-center justify-between cursor-pointer py-8 list-none marker:hidden hover:text-gray-600 transition-colors">
                                <div class="flex items-start gap-6">
                                    <span class="text-[18px] font-mono font-bold text-gray-400 mt-1">01</span>
                                    <h4 class="text-[22px] sm:text-[28px] font-extrabold text-black tracking-tight group-hover:text-gray-600">Which platforms are supported?</h4>
                                </div>
                                <span class="text-[20px] font-mono font-bold text-gray-400 group-open:hidden">[+]</span>
                                <span class="text-[20px] font-mono font-bold text-gray-400 hidden group-open:block">[-]</span>
                            </summary>
                            <div class="pb-8 pl-[46px] pr-8 text-[16px] font-medium text-gray-600 leading-relaxed max-w-2xl animate-[fadeIn_0.2s_ease-out]">
                                Currently, we support generating and scheduling posts for X (formerly Twitter), LinkedIn, and Facebook. We are constantly adding new platforms based on user feedback.
                            </div>
                        </details>

                        <!-- FAQ Item 2 -->
                        <details class="group border-b-2 border-gray-200">
                            <summary class="flex items-center justify-between cursor-pointer py-8 list-none marker:hidden hover:text-gray-600 transition-colors">
                                <div class="flex items-start gap-6">
                                    <span class="text-[18px] font-mono font-bold text-gray-400 mt-1">02</span>
                                    <h4 class="text-[22px] sm:text-[28px] font-extrabold text-black tracking-tight group-hover:text-gray-600">Do I need my own OpenAI API key?</h4>
                                </div>
                                <span class="text-[20px] font-mono font-bold text-gray-400 group-open:hidden">[+]</span>
                                <span class="text-[20px] font-mono font-bold text-gray-400 hidden group-open:block">[-]</span>
                            </summary>
                            <div class="pb-8 pl-[46px] pr-8 text-[16px] font-medium text-gray-600 leading-relaxed max-w-2xl animate-[fadeIn_0.2s_ease-out]">
                                No, all AI generation costs are included when you spend a Campaign Credit. You don't need to bring your own API key or worry about token limits.
                            </div>
                        </details>

                        <!-- FAQ Item 3 -->
                        <details class="group border-b-2 border-gray-200">
                            <summary class="flex items-center justify-between cursor-pointer py-8 list-none marker:hidden hover:text-gray-600 transition-colors">
                                <div class="flex items-start gap-6">
                                    <span class="text-[18px] font-mono font-bold text-gray-400 mt-1">03</span>
                                    <h4 class="text-[22px] sm:text-[28px] font-extrabold text-black tracking-tight group-hover:text-gray-600">Can I edit the posts before they go live?</h4>
                                </div>
                                <span class="text-[20px] font-mono font-bold text-gray-400 group-open:hidden">[+]</span>
                                <span class="text-[20px] font-mono font-bold text-gray-400 hidden group-open:block">[-]</span>
                            </summary>
                            <div class="pb-8 pl-[46px] pr-8 text-[16px] font-medium text-gray-600 leading-relaxed max-w-2xl animate-[fadeIn_0.2s_ease-out]">
                                Absolutely. You have full control over the content. You can edit text, swap images, or completely rewrite any post in the dashboard before scheduling it.
                            </div>
                        </details>

                        <!-- FAQ Item 4 -->
                        <details class="group border-b-2 border-gray-200">
                            <summary class="flex items-center justify-between cursor-pointer py-8 list-none marker:hidden hover:text-gray-600 transition-colors">
                                <div class="flex items-start gap-6">
                                    <span class="text-[18px] font-mono font-bold text-gray-400 mt-1">04</span>
                                    <h4 class="text-[22px] sm:text-[28px] font-extrabold text-black tracking-tight group-hover:text-gray-600">Do Campaign Credits expire?</h4>
                                </div>
                                <span class="text-[20px] font-mono font-bold text-gray-400 group-open:hidden">[+]</span>
                                <span class="text-[20px] font-mono font-bold text-gray-400 hidden group-open:block">[-]</span>
                            </summary>
                            <div class="pb-8 pl-[46px] pr-8 text-[16px] font-medium text-gray-600 leading-relaxed max-w-2xl animate-[fadeIn_0.2s_ease-out]">
                                No, your Campaign Credits never expire. You can purchase them in bulk to save money and use them whenever you are ready to launch a new project.
                            </div>
                        </details>

                    </div>
                </div>

            </div>
        </section>

        <!-- Footer Section (Tier-1 Editorial Brutalist - Dark Mode) -->
        <footer class="bg-black py-16 lg:py-24 border-t-2 border-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row justify-between items-start gap-16 mb-16">
                    
                    <!-- Brand -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-4 h-4 bg-white"></div>
                            <span class="text-3xl font-extrabold tracking-tighter text-white uppercase">Post<span class="text-gray-500">Pilot</span></span>
                        </div>
                        <p class="text-[13px] font-mono text-gray-500 max-w-xs uppercase tracking-widest leading-relaxed">
                            The architectural engine for automated social presence.
                        </p>
                    </div>

                    <!-- Navigation Matrix -->
                    <div class="flex gap-16">
                        <div class="flex flex-col gap-4">
                            <span class="text-[11px] font-bold text-gray-600 tracking-widest uppercase font-mono mb-2">Platform</span>
                            <a href="#features" class="text-[14px] font-bold text-white uppercase tracking-wide hover:underline decoration-2 underline-offset-4 transition-all">Features</a>
                            <a href="#how-it-works" class="text-[14px] font-bold text-white uppercase tracking-wide hover:underline decoration-2 underline-offset-4 transition-all">How it Works</a>
                            <a href="#pricing" class="text-[14px] font-bold text-white uppercase tracking-wide hover:underline decoration-2 underline-offset-4 transition-all">Pricing</a>
                            <a href="#faq" class="text-[14px] font-bold text-white uppercase tracking-wide hover:underline decoration-2 underline-offset-4 transition-all">FAQ</a>
                        </div>
                        <div class="flex flex-col gap-4">
                            <span class="text-[11px] font-bold text-gray-600 tracking-widest uppercase font-mono mb-2">Legal</span>
                            <a href="#" class="text-[14px] font-bold text-gray-400 uppercase tracking-wide hover:text-white transition-colors">Privacy</a>
                            <a href="#" class="text-[14px] font-bold text-gray-400 uppercase tracking-wide hover:text-white transition-colors">Terms</a>
                        </div>
                    </div>
                </div>

                <!-- Footer Bottom (Colophon) -->
                <div class="pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-[11px] font-bold text-gray-600 uppercase font-mono tracking-widest">
                        &copy; {{ date('Y') }} PostPilot Inc. // All Rights Reserved.
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-white animate-pulse"></div>
                        <span class="text-[11px] font-bold text-gray-600 uppercase font-mono tracking-widest">System Operational</span>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Mobile Menu Toggle Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.querySelector('[data-collapse-toggle="navbar"]');
                const navbar = document.getElementById('navbar');
                if (toggleBtn && navbar) {
                    toggleBtn.addEventListener('click', function() {
                        navbar.classList.toggle('hidden');
                        navbar.classList.toggle('block');
                    });
                }
            });
        </script>
    </body>
</html>


