<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Free Social Media Tools - PostPilot')</title>
        <meta name="description" content="@yield('meta_description', '100% free, zero-signup social media tools for LinkedIn, Twitter/X, and Facebook by PostPilot.')">
        <link rel="canonical" href="{{ url()->current() }}">

        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=4">
        <link rel="shortcut icon" href="{{ asset('favicon.svg') }}?v=4">

        <!-- OpenGraph & Social Media Cards -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', 'Free Social Media Tools - PostPilot')">
        <meta property="og:description" content="@yield('meta_description', '100% free, zero-signup social media tools for creators and founders.')">
        <meta property="og:image" content="{{ asset('logo.png') }}">

        <!-- Twitter Card Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('title', 'Free Social Media Tools - PostPilot')">
        <meta name="twitter:description" content="@yield('meta_description', '100% free social media tools by PostPilot.')">

        <!-- Google Tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-6Z2EJ5BCR3"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-6Z2EJ5BCR3');
        </script>

        <!-- Google Fonts: Inter and Manrope -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

        <!-- Schema.org WebApplication Markup -->
        <script type="application/ld+json">
        {
          "@@context": "https://schema.org",
          "@type": "WebApplication",
          "name": "@yield('tool_name', 'Free Social Media Tool')",
          "url": "{{ url()->current() }}",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "All",
          "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
          }
        }
        </script>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @yield('head')
    </head>
    <body class="font-inter bg-slate-950 text-slate-100 min-h-screen flex flex-col selection:bg-indigo-500 selection:text-white antialiased overflow-x-hidden">
        <!-- Minimal Top Navigation -->
        <header class="border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center transition-transform group-hover:scale-105 shadow-md shadow-indigo-600/30">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-lg font-extrabold text-white tracking-tight">PostPilot</span>
                    </a>
                    <span class="text-slate-600">/</span>
                    <a href="{{ route('tools.index') }}" class="text-xs font-semibold uppercase tracking-wider text-indigo-400 hover:text-indigo-300 transition-colors bg-indigo-950/50 px-2.5 py-1 rounded-md border border-indigo-800/50">
                        Free Tools Directory
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center text-xs font-medium text-slate-400 hover:text-white transition-colors">
                        How PostPilot Works
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white text-xs font-semibold shadow-md shadow-indigo-600/20 transition-all transform hover:-translate-y-0.5">
                        <span>Try PostPilot Full App</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 max-w-5xl w-full mx-auto px-4 sm:px-6 py-8 sm:py-12">
            @yield('content')
        </main>

        <!-- Global Value Bridge CTA Section -->
        <section class="border-t border-slate-800/80 bg-gradient-to-b from-slate-950 to-slate-900 py-12 px-4 sm:px-6">
            <div class="max-w-4xl mx-auto bg-slate-900/90 rounded-2xl border border-indigo-500/30 p-6 sm:p-10 text-center relative overflow-hidden shadow-2xl shadow-indigo-950/50">
                <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-950 text-indigo-400 border border-indigo-800/60 text-xs font-semibold mb-4">
                    🚀 Turn Micro-Wins into 30-Day Growth
                </span>
                
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight mb-3">
                    Don't stop at single posts. Autopilot your entire social media marketing.
                </h3>
                
                <p class="text-sm sm:text-base text-slate-400 max-w-2xl mx-auto mb-6 leading-relaxed">
                    PostPilot turns your product context into automated 30-day marketing campaigns tailored for LinkedIn, X/Twitter, and Facebook.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm shadow-lg shadow-indigo-600/30 transition-all transform hover:-translate-y-0.5">
                        <span>Start Free Trial on PostPilot</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm border border-slate-700 transition-colors">
                        Learn How PostPilot Works
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-slate-800/80 bg-slate-950 py-8 text-center text-xs text-slate-500">
            <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} PostPilot. All rights reserved. Free tools run 100% client-side with zero tracking overhead.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('tools.index') }}" class="hover:text-slate-300 transition-colors">All Free Tools</a>
                    <a href="{{ route('legal.terms') }}" class="hover:text-slate-300 transition-colors">Terms</a>
                    <a href="{{ route('legal.privacy') }}" class="hover:text-slate-300 transition-colors">Privacy</a>
                </div>
            </div>
        </footer>

        @yield('scripts')
    </body>
</html>
