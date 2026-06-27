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
    <body class="font-sans text-base-content antialiased bg-base-200 min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6">
                <a href="/">
                    <img src="{{ asset('logo.png') }}" alt="PostPilot Logo" class="mx-auto object-contain h-24 w-auto rounded-2xl shadow-sm" />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-8 bg-base-100 shadow-xl border border-base-300 rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

