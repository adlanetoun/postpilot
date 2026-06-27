<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="auto30">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PostPilot') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-inter antialiased text-[#111827] bg-[#FAFAFA] min-h-screen relative">
        <!-- Removed generic grid background to ensure absolute cleanliness (Vercel/Linear aesthetic) -->

        <div class="flex h-screen overflow-hidden relative z-10">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col h-screen overflow-y-auto">
                <!-- Page Heading (Contextual Command Header) -->
                @isset($header)
                    <header class="bg-white/80 backdrop-blur-md border-b border-[#E5E7EB] shrink-0 sticky top-0 z-40 transition-all">
                        <div class="px-6 lg:px-8 h-14 flex items-center justify-between w-full">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 relative h-full">
                    @if($attributes->has('full-width'))
                        <div class="w-full h-full relative">
                            {{ $slot }}
                        </div>
                    @else
                        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                            {{ $slot }}
                        </div>
                    @endif
                </main>
            </div>
        </div>

        <!-- Global Notifications -->
        <x-toast type="success" />
        <x-toast type="error" />
        <x-toast type="warning" />
        <x-toast type="info" />
    </body>
</html>

