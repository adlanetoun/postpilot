<!-- Navigation (Tier-1 Minimalist & Brutalist - Dashboard Version) -->
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
                <a href="/" class="text-[13px] font-medium text-gray-500 hover:text-black transition-colors tracking-wide">Home</a>
                <a href="{{ route('dashboard') }}" class="text-[13px] font-bold text-black tracking-wide">Dashboard</a>
                <a href="{{ route('tools.index') }}" class="text-[13px] font-medium text-gray-500 hover:text-black transition-colors tracking-wide">Tools</a>
                <a href="/#features" class="text-[13px] font-medium text-gray-500 hover:text-black transition-colors tracking-wide">Features</a>
                <a href="/#pricing" class="text-[13px] font-medium text-gray-500 hover:text-black transition-colors tracking-wide">Pricing</a>
            </div>

            <!-- Right: User Menu & Credits -->
            <div class="flex items-center gap-4">
                
                <!-- Credit Pill Badge (CRO: Tiered urgency state + monthly usage bar) -->
                @php
                    $credits = (int) auth()->user()->campaign_credits;
                    $softCap = 10;
                    $usedThisMonth = max(0, $softCap - $credits);
                    $usedPct = min(100, (int) round(($usedThisMonth / $softCap) * 100));
                @endphp
                <div class="flex items-center gap-2" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ route('profile.edit', ['tab' => 'billing']) }}"
                       class="px-3 py-1.5 rounded-full border flex items-center transition-all duration-300
                              {{ $credits === 0 ? 'bg-rose-50 border-rose-200 text-rose-700 animate-[creditPulse_1.6s_ease-in-out_infinite]' :
                                 ($credits <= 2 ? 'bg-amber-50 border-amber-200 text-amber-700 hover:bg-amber-100' :
                                  'bg-emerald-50 border-emerald-200 text-emerald-700 hover:bg-emerald-100') }}">
                        @if ($credits === 0)
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                            <span class="text-[13px] font-bold whitespace-nowrap">🚫 Out of Credits — Recharge</span>
                        @elseif ($credits <= 2)
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" /></svg>
                            <span class="text-[13px] font-bold whitespace-nowrap">⚠️ {{ $credits }} <span class="hidden sm:inline font-medium">{{ \Illuminate\Support\Str::plural('Credit', $credits) }}</span> Left</span>
                        @else
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            <span class="text-[13px] font-bold whitespace-nowrap">⚡ {{ $credits }} <span class="hidden sm:inline font-medium">{{ \Illuminate\Support\Str::plural('Credit', $credits) }} Available</span></span>
                        @endif
                    </a>
                    <!-- Hover mini panel: monthly usage bar -->
                    <div x-show="open" x-cloak x-transition.opacity.duration.200ms
                         class="absolute mt-2 top-full right-0 w-56 bg-white border border-[#edeef1] rounded-2xl shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] p-4 z-50 pointer-events-none"
                         style="display:none;">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-extrabold text-[#434656] uppercase tracking-widest">Monthly Usage</span>
                            <span class="text-[11px] font-black text-[#191c1e]">{{ $usedThisMonth }} / {{ $softCap }}</span>
                        </div>
                        <div class="w-full h-2 bg-[#f8f9fc] rounded-full overflow-hidden border border-[#edeef1]">
                            <div class="h-full rounded-full transition-all duration-500
                                {{ $usedPct >= 80 ? 'bg-rose-500' : ($usedPct >= 50 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                style="width: {{ $usedPct }}%"></div>
                        </div>
                        <p class="text-[10px] font-medium text-[#434656] mt-2 leading-snug">
                            @if($credits === 0)
                                Top up now to keep generating.
                            @elseif($credits <= 2)
                                Running low. Consider a credit pack.
                            @else
                                You're in good shape. Keep building.
                            @endif
                        </p>
                    </div>
                </div>

                <style>
                    @keyframes creditPulse {
                        0%, 100% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.45); }
                        50%      { box-shadow: 0 0 0 8px rgba(244, 63, 94, 0); }
                    }
                    [x-cloak] { display: none !important; }
                </style>

                <div class="dropdown dropdown-end flex items-center">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle flex items-center justify-center hover:bg-gray-100 transition-colors">
                        <div class="avatar placeholder">
                            <div class="bg-black text-white rounded-full w-8 h-8 flex items-center justify-center">
                                <span class="text-[10px] font-bold tracking-widest">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}</span>
                            </div>
                        </div>
                    </div>
                    <ul tabindex="0" class="mt-3 z-[1] p-0 shadow-xl menu menu-sm dropdown-content bg-white border border-gray-200 rounded-none w-56">
                        <li class="px-4 py-3 border-b border-gray-100">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest font-mono block mb-1">Signed in as</span>
                            <span class="text-[13px] font-bold text-black truncate">{{ Auth::user()->name ?? 'User' }}</span>
                        </li>
                        <div class="p-2">
                            <li>
                                <a href="{{ route('profile.edit') }}" class="py-2.5 text-[13px] font-bold text-gray-600 hover:text-black hover:bg-gray-50 rounded-none transition-colors">
                                    Account Settings
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="w-full m-0 p-0">
                                    @csrf
                                    <button type="submit" class="w-full text-left py-2.5 px-3 text-[13px] font-bold text-gray-600 hover:text-black hover:bg-gray-50 rounded-none transition-colors">
                                        Log Out
                                    </button>
                                </form>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</nav>
