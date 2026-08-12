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

        <!-- Google Fonts: Plus Jakarta Sans, JetBrains Mono & Material Symbols -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        <!-- Schema.org SoftwareApplication Markup -->
        <script type="application/ld+json">
        {
          "@@context": "https://schema.org",
          "@type": "SoftwareApplication",
          "name": "@yield('tool_name', 'Free Social Media Tool')",
          "description": "@yield('meta_description', 'Free social media tool by PostPilot.')",
          "url": "{{ url()->current() }}",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "Web Browser",
          "browserRequirements": "Requires JavaScript. Works in all modern browsers.",
          "author": {
            "@type": "Organization",
            "name": "PostPilot",
            "url": "{{ route('home') }}"
          },
          "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
          },
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "ratingCount": "127",
            "bestRating": "5",
            "worstRating": "1"
          }
        }
        </script>

        @yield('schema_json')

        <!-- Speculation Rules API: Prerender related tool pages -->
        <script type="speculationrules">
        {
          "prerender": [{
            "where": { "href_matches": "/tools/*" },
            "eagerness": "moderate"
          }],
          "prefetch": [{
            "where": { "href_matches": "/tools/*" },
            "eagerness": "moderate"
          }]
        }
        </script>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @yield('head')
    </head>
    <body class="font-inter bg-gradient-to-b from-white via-gray-50/80 to-gray-100/60 text-gray-900 min-h-screen flex flex-col selection:bg-black selection:text-white antialiased overflow-x-hidden">
        <!-- Editorial Minimalist Top Navigation -->
        <header class="border-b border-gray-200 bg-white/90 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 rounded bg-black flex items-center justify-center transition-transform group-hover:rotate-6 shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-[18px] font-extrabold text-black tracking-tight">PostPilot</span>
                    </a>
                    <span class="text-gray-300">/</span>
                    <a href="{{ route('tools.index') }}" class="text-[11px] font-extrabold uppercase tracking-widest text-black bg-gray-100 hover:bg-gray-200 transition-colors px-2.5 py-1 border border-gray-200 font-mono">
                        Free Tools
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center text-[13px] font-medium text-gray-500 hover:text-black transition-colors">
                        How PostPilot Works
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-5 py-2 text-[13px] font-bold text-white bg-black hover:bg-gray-800 transition-colors shadow-sm">
                        <span>Start Free Trial</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content Area with Subtle SVG Grid -->
        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 py-8 sm:py-12 relative">
            <x-seo.breadcrumbs :tool-name="View::yieldContent('tool_name', '')" />
            @yield('content')

            {{-- Related Tools Internal Linking Widget --}}
            <x-tools.related-tools :current="View::yieldContent('tool_route', '')" />

            {{-- Share Buttons --}}
            <div class="max-w-4xl mx-auto mt-8">
                <x-tools.share-buttons
                    :tool-name="View::yieldContent('tool_name', 'Free Social Media Tool')"
                    :tool-description="View::yieldContent('meta_description', '')" />
            </div>
        </main>

        <!-- Global Value Bridge CTA Section (PostPilot Editorial Style) -->
        <section class="border-t border-gray-200 bg-white py-16 px-4 sm:px-6">
            <div class="max-w-4xl mx-auto bg-white border-2 border-black p-8 sm:p-12 text-center relative shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-900 text-[11px] font-extrabold tracking-widest uppercase font-mono mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Autopilot Marketing Engine
                </span>
                
                <h3 class="text-3xl sm:text-4xl font-extrabold text-black tracking-tighter mb-4">
                    30 Days of Content. <span class="text-gray-400">Published On Autopilot.</span>
                </h3>
                
                <p class="text-base sm:text-lg font-medium text-gray-600 max-w-2xl mx-auto mb-8 leading-relaxed">
                    Don't waste time on manual posting. Input your brand once, and PostPilot automatically generates and schedules an entire month of content for LinkedIn, X, and Facebook.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-black text-white text-[15px] font-bold transition-all hover:bg-gray-800 shadow-md">
                        <span>Start Generating Content</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-white text-black border-2 border-black text-[15px] font-bold transition-all hover:bg-gray-50">
                        Learn How It Works
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-gray-200 bg-white py-8 text-center text-xs text-gray-500">
            <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4 font-medium">
                <p>&copy; {{ date('Y') }} PostPilot. All rights reserved. Free satellite tools run 100% client-side with zero tracking overhead.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('tools.index') }}" class="text-gray-600 hover:text-black transition-colors font-bold">All Free Tools</a>
                    <a href="{{ route('legal.terms') }}" class="hover:text-black transition-colors">Terms</a>
                    <a href="{{ route('legal.privacy') }}" class="hover:text-black transition-colors">Privacy</a>
                </div>
            </div>
        </footer>

        @if(!request()->routeIs('embed.*'))
            <x-tools.slide-in-cta />
        @endif

        @yield('scripts')
    </body>
</html>
