<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="auto30">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PostPilot') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=4">
        <link rel="shortcut icon" href="{{ asset('favicon.svg') }}?v=4">

        <!-- Global Premium Fonts & Styles -->
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
        <style>
            .mesh-gradient {
                background: radial-gradient(at 0% 0%, #ffffff 0%, transparent 60%),
                            radial-gradient(at 100% 0%, #f1f5f9 0%, transparent 60%),
                            radial-gradient(at 100% 100%, #e2e8f0 0%, transparent 60%),
                            radial-gradient(at 0% 100%, #f8fafc 0%, transparent 60%);
                background-color: #f8fafc;
                background-attachment: fixed;
            }
            .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        </style>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Paddle V2 SDK -->
        <script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>
        <script>
            @if(config('services.paddle.client_side_token'))
                Paddle.Initialize({
                    token: "{{ config('services.paddle.client_side_token') }}",
                    environment: "{{ config('services.paddle.mode') === 'live' ? 'production' : 'sandbox' }}"
                });
            @endif

            function openPaddleCheckout(priceId, creditsAmount) {
                if (typeof Paddle !== 'undefined' && priceId) {
                    Paddle.Checkout.open({
                        items: [{ priceId: priceId, quantity: 1 }],
                        customData: {
                            user_id: {{ Auth::id() ?? 'null' }},
                            credits: creditsAmount
                        },
                        customer: {
                            email: "{{ Auth::user()->email ?? '' }}"
                        }
                    });
                } else {
                    console.warn('Paddle is not initialized or price ID is missing.');
                }
            }
        </script>
    </head>
    <body class="font-inter bg-white text-gray-900 min-h-screen overflow-x-hidden relative selection:bg-black selection:text-white">
        <div class="flex h-screen overflow-hidden relative z-10">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col h-screen overflow-y-auto bg-white">
                <!-- Page Heading (Contextual Command Header) -->
                @isset($header)
                    <header class="bg-white border-b border-gray-200 shrink-0 sticky top-0 z-40">
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

        {{-- CRO: In-app insufficient credits modal (replaces redirect-to-billing) --}}
        @if (session('insufficient_credits'))
            <x-insufficient-credits-modal />
        @endif

    </body>
</html>

