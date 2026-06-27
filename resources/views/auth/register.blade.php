<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PostPilot') }} - Register</title>

        <!-- Google Fonts: Inter and Manrope -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-inter antialiased h-full text-zinc-950 bg-zinc-50">
        <div class="min-h-screen flex flex-col lg:flex-row overflow-hidden">
            
            <!-- Left Side: Professional Studio Browser Mockup (Visible on lg and up) -->
            <section class="hidden lg:flex lg:w-5/12 bg-[#09090b] relative overflow-hidden flex-col justify-between p-12 border-r border-zinc-800">
                <!-- Exact Structural Grid Background (Matches Welcome Page Hero) -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIC41aDQwTTAgMjAuNWg0ME0yMC41IDB2NDBNLjUgMHY0MCIgc3Ryb2tlPSJyZ2JhKDI1NSwgMjU1LDI1NSwgMC4wMikiLz48L3N2Zz4=')] pointer-events-none z-0"></div>
                
                <!-- Logo & Brand Header -->
                <div class="relative z-10 flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-white flex items-center justify-center">
                        <svg class="w-5 h-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-manrope text-lg font-extrabold tracking-tight text-white">PostPilot</span>
                </div>

                <!-- Central Marketing & Browser Mockup -->
                <div class="relative z-10 my-auto flex flex-col gap-8 max-w-sm">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded bg-zinc-800 border border-zinc-700">
                            <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                            <span class="text-[10px] font-bold text-white tracking-widest uppercase font-mono">Engine 2.0</span>
                        </div>
                        <h2 class="font-extrabold text-[44px] leading-[1.05] text-white tracking-tighter">
                            Month of Content.<br />
                            <span class="text-zinc-500">Zero Writing.</span>
                        </h2>
                        <p class="text-zinc-400 text-sm font-medium leading-relaxed">
                            Input your brief once. PostPilot generates, formats, and schedules a full month of platform-native posts for LinkedIn and X.
                        </p>
                    </div>

                    <!-- Sleek Dashboard Browser Mockup (Studio Quality) -->
                    <div class="bg-[#121214] border border-zinc-800 rounded-xl overflow-hidden shadow-2xl">
                        <!-- Simulated browser title bar -->
                        <div class="bg-[#18181b] px-4 py-3 border-b border-zinc-800 flex items-center gap-2">
                            <div class="flex gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-[#ef4444]/60"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-[#eab308]/60"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-[#22c55e]/60"></div>
                            </div>
                            <div class="mx-auto bg-zinc-900 border border-zinc-800/80 px-4 py-0.5 rounded text-[9px] font-mono text-zinc-500 w-32 text-center truncate">
                                app.postpilot.co/queue
                            </div>
                        </div>

                        <!-- Mockup content workspace -->
                        <div class="p-4 space-y-4">
                            <!-- Queue Status Widget -->
                            <div class="flex items-center justify-between text-[10px] text-zinc-400 font-mono">
                                <span>30-DAY PIPELINE</span>
                                <span class="text-emerald-400 flex items-center gap-1">
                                    <span class="w-1 h-1 rounded-full bg-emerald-400 animate-ping"></span>
                                    Queue Synced
                                </span>
                            </div>

                            <!-- Scheduled Post Card -->
                            <div class="bg-zinc-950 border border-zinc-800/80 rounded-lg p-3.5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 bg-[#0077b5] rounded flex items-center justify-center text-white text-[9px] font-bold">in</div>
                                        <div class="text-[10px] font-bold text-white">LinkedIn Composer</div>
                                    </div>
                                    <span class="text-[9px] text-zinc-500 font-mono">Day 12 • 4:15 PM</span>
                                </div>
                                <p class="text-[11px] text-zinc-300 leading-relaxed font-medium">
                                    Writing social media posts is a waste of developer time. We built a system that generates a month of native content in seconds. Here's how... 🚀
                                </p>
                                <div class="flex items-center justify-between pt-1 border-t border-zinc-900 text-[9px] text-zinc-500 font-semibold font-mono">
                                    <span>Engagement: <span class="text-white">96%</span></span>
                                    <span>Tone: <span class="text-white">Witty</span></span>
                                </div>
                            </div>

                            <!-- Platforms indicator -->
                            <div class="flex gap-2">
                                <div class="h-1.5 w-12 bg-zinc-800 rounded-full"></div>
                                <div class="h-1.5 w-8 bg-zinc-800 rounded-full"></div>
                                <div class="h-1.5 w-16 bg-zinc-800 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer / Status -->
                <div class="relative z-10 border-t border-zinc-800 pt-6 flex items-center justify-between text-[11px] text-zinc-500 font-mono tracking-wider">
                    <span>&copy; {{ date('Y') }} PostPilot Inc.</span>
                    <div class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Systems Operational</span>
                    </div>
                </div>
            </section>
            
            <!-- Right Side: The Centered Brutalist Form Card -->
            <main class="flex-grow flex items-center justify-center p-6 sm:p-12 lg:p-16 bg-zinc-50">
                <!-- Beautiful Brutalist Border Card to anchor the form -->
                <div class="w-full max-w-sm bg-white border border-zinc-200 rounded-2xl p-8 sm:p-10 shadow-[0_8px_30px_rgba(0,0,0,0.02)] space-y-8" style="max-width: 380px;">
                    
                    <!-- Mobile Header (Logo & Brand) - Hidden on Desktop -->
                    <div class="flex lg:hidden items-center justify-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded bg-black flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="font-manrope text-lg font-extrabold tracking-tight text-zinc-950">PostPilot</span>
                    </div>

                    <!-- Heading Block -->
                    <div class="text-center lg:text-left space-y-1.5">
                        <h1 class="font-manrope text-2xl font-extrabold text-zinc-950 tracking-tighter">
                            Create Account
                        </h1>
                        <p class="text-zinc-500 text-xs font-medium">
                            Let's get started with your <span class="text-black font-bold underline decoration-2 underline-offset-2">30 days free trial</span>.
                        </p>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider font-mono">Full Name</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <!-- Safe Inline Padding to override autofill overlaps -->
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    style="padding-left: 2.75rem !important;"
                                    class="w-full h-11 pr-4 text-zinc-950 placeholder-zinc-400 text-sm font-medium rounded-xl border border-zinc-200 bg-white focus:bg-white focus:border-black focus:ring-1 focus:ring-black focus:outline-none transition-all duration-150 @error('name') border-red-500 focus:ring-red-500/10 @enderror"
                                    placeholder="John Doe"
                                />
                            </div>
                            @error('name')
                                <p class="text-red-600 text-xs font-semibold mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-2">
                            <label for="email" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider font-mono">Email Address</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </span>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="username"
                                    style="padding-left: 2.75rem !important;"
                                    class="w-full h-11 pr-4 text-zinc-950 placeholder-zinc-400 text-sm font-medium rounded-xl border border-zinc-200 bg-white focus:bg-white focus:border-black focus:ring-1 focus:ring-black focus:outline-none transition-all duration-150 @error('email') border-red-500 focus:ring-red-500/10 @enderror"
                                    placeholder="name@company.com"
                                />
                            </div>
                            @error('email')
                                <p class="text-red-600 text-xs font-semibold mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider font-mono">Password</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    style="padding-left: 2.75rem !important; padding-right: 2.75rem !important;"
                                    class="w-full h-11 text-zinc-950 placeholder-zinc-400 text-sm font-medium rounded-xl border border-zinc-200 bg-white focus:bg-white focus:border-black focus:ring-1 focus:ring-black focus:outline-none transition-all duration-150 @error('password') border-red-500 focus:ring-red-500/10 @enderror"
                                    placeholder="••••••••"
                                />
                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-zinc-400 hover:text-black transition-colors focus:outline-none"
                                >
                                    <svg id="eyeOpenIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eyeClosedIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.024 10.024 0 013.753-4.875M19 19L5 5m1.875 1.875A9.004 9.004 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.4M9.88 9.88a3 3 0 104.24 4.24" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-600 text-xs font-semibold mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2 pb-2">
                            <label for="password_confirmation" class="block text-xs font-bold text-zinc-700 uppercase tracking-wider font-mono">Confirm Password</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </span>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    style="padding-left: 2.75rem !important; padding-right: 2.75rem !important;"
                                    class="w-full h-11 text-zinc-950 placeholder-zinc-400 text-sm font-medium rounded-xl border border-zinc-200 bg-white focus:bg-white focus:border-black focus:ring-1 focus:ring-black focus:outline-none transition-all duration-150 @error('password_confirmation') border-red-500 focus:ring-red-500/10 @enderror"
                                    placeholder="••••••••"
                                />
                                <button
                                    type="button"
                                    id="togglePasswordConfirmation"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-zinc-400 hover:text-black transition-colors focus:outline-none"
                                >
                                    <svg id="eyeOpenIconConfirmation" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eyeClosedIconConfirmation" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.024 10.024 0 013.753-4.875M19 19L5 5m1.875 1.875A9.004 9.004 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.4M9.88 9.88a3 3 0 104.24 4.24" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="text-red-600 text-xs font-semibold mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="group relative w-full h-11 bg-black hover:bg-zinc-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-150 flex items-center justify-center gap-2 shadow-sm focus:outline-none active:scale-[0.99]"
                        >
                            <span>Register</span>
                            <svg class="w-4 h-4 text-zinc-400 group-hover:text-white group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Login Link -->
                        <div class="text-center pt-2">
                            <p class="text-zinc-500 text-sm font-medium">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-black hover:underline font-bold transition-colors">
                                    Log In
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </main>
        </div>

        <!-- Inline Javascript for Interactive UI Components -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Password Toggle
                const passwordInput = document.getElementById('password');
                const toggleButton = document.getElementById('togglePassword');
                const eyeOpenIcon = document.getElementById('eyeOpenIcon');
                const eyeClosedIcon = document.getElementById('eyeClosedIcon');

                if (toggleButton && passwordInput) {
                    toggleButton.addEventListener('click', function() {
                        const isPassword = passwordInput.getAttribute('type') === 'password';
                        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                        
                        if (isPassword) {
                            eyeOpenIcon.classList.add('hidden');
                            eyeClosedIcon.classList.remove('hidden');
                        } else {
                            eyeOpenIcon.classList.remove('hidden');
                            eyeClosedIcon.classList.add('hidden');
                        }
                    });
                }

                // Password Confirmation Toggle
                const passwordConfirmationInput = document.getElementById('password_confirmation');
                const toggleConfirmationButton = document.getElementById('togglePasswordConfirmation');
                const eyeOpenIconConfirmation = document.getElementById('eyeOpenIconConfirmation');
                const eyeClosedIconConfirmation = document.getElementById('eyeClosedIconConfirmation');

                if (toggleConfirmationButton && passwordConfirmationInput) {
                    toggleConfirmationButton.addEventListener('click', function() {
                        const isPassword = passwordConfirmationInput.getAttribute('type') === 'password';
                        passwordConfirmationInput.setAttribute('type', isPassword ? 'text' : 'password');
                        
                        if (isPassword) {
                            eyeOpenIconConfirmation.classList.add('hidden');
                            eyeClosedIconConfirmation.classList.remove('hidden');
                        } else {
                            eyeOpenIconConfirmation.classList.remove('hidden');
                            eyeClosedIconConfirmation.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    </body>
</html>
