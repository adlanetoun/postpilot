<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Free Tool Embed')</title>
        <meta name="robots" content="noindex, nofollow">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @yield('head')
    </head>
    <body class="font-inter bg-white text-gray-900 min-h-screen flex flex-col selection:bg-black selection:text-white antialiased overflow-x-hidden">
        
        <!-- Main Content Area (No Header/Nav for Embed) -->
        <main class="flex-1 w-full mx-auto p-4 sm:p-6 relative">
            @yield('content')
        </main>

        <!-- Fixed Footer Branding for Viral Loop -->
        <div class="py-3 px-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider font-mono">
                100% Free Tool
            </span>
            <a href="{{ route('home') }}?utm_source=embed_widget&utm_medium=referral&utm_campaign=powered_by" target="_blank" rel="noopener" class="flex items-center gap-1.5 hover:opacity-80 transition-opacity">
                <span class="text-[11px] text-gray-500 font-medium">Powered by</span>
                <span class="text-[12px] font-extrabold text-black tracking-tight flex items-center gap-1">
                    <div class="w-3.5 h-3.5 rounded-sm bg-black flex items-center justify-center">
                        <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    PostPilot
                </span>
            </a>
        </div>
    </body>
</html>
