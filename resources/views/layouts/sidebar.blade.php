<aside class="w-[280px] bg-[#030305] border-r border-white/[0.05] flex flex-col h-full z-20 shrink-0 font-sans text-white/60 shadow-[8px_0_30px_rgba(0,0,0,0.5)] transition-all duration-500 relative overflow-hidden">
    <!-- Subtle Ambient Glow -->
    <div class="absolute top-0 left-0 w-full h-[300px] bg-gradient-to-b from-white/[0.03] to-transparent pointer-events-none"></div>

    <!-- Brand / Logo Area -->
    <div class="h-[100px] flex items-center px-8 shrink-0 relative z-10">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-4 group">
            <!-- Dramatic Logo Mark -->
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-white/10 to-white/0 border border-white/10 flex items-center justify-center shadow-[0_0_15px_rgba(255,255,255,0.05)] group-hover:shadow-[0_0_20px_rgba(255,255,255,0.15)] group-hover:scale-110 transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]">
                <svg class="w-3.5 h-3.5 text-white group-hover:rotate-90 transition-transform duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16v16H4z"></path>
                    <path d="M4 12h16"></path>
                    <path d="M12 4v16"></path>
                </svg>
            </div>
            <!-- Typographic Logo -->
            <span class="text-[19px] font-extrabold tracking-tighter text-white">
                Post<span class="text-white/40 font-normal">Pilot</span>
            </span>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto px-5 py-6 scrollbar-hide relative z-10">
        @if(request()->routeIs('profile.*') || request()->is('settings*'))
            @php
                $activeTab = request()->query('tab', 'profile');
            @endphp
            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="flex items-center text-[12px] font-bold tracking-widest uppercase text-white/40 hover:text-white mb-8 px-3 group transition-all duration-300">
                    <svg class="w-4 h-4 mr-3 text-white/30 group-hover:text-white group-hover:-translate-x-1 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
            
            <div class="text-[10px] font-bold text-white/20 uppercase tracking-[0.2em] mb-4 px-3">Settings</div>
            <nav class="space-y-1">
                <a href="?tab=profile" 
                   class="flex items-center px-4 py-3 rounded-xl text-[14px] font-medium transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] relative group {{ $activeTab === 'profile' ? 'bg-white/5 text-white shadow-sm ring-1 ring-white/10' : 'text-white/50 hover:bg-white/[0.02] hover:text-white hover:translate-x-1' }}">
                    <svg class="w-[18px] h-[18px] mr-4 transition-colors duration-300 {{ $activeTab === 'profile' ? 'text-white' : 'text-white/30 group-hover:text-white/70' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Profile & General
                    @if($activeTab === 'profile') <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-1/2 bg-white rounded-r-full shadow-[0_0_10px_rgba(255,255,255,0.5)]"></div> @endif
                </a>

                <a href="?tab=security" 
                   class="flex items-center px-4 py-3 rounded-xl text-[14px] font-medium transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] relative group {{ $activeTab === 'security' ? 'bg-white/5 text-white shadow-sm ring-1 ring-white/10' : 'text-white/50 hover:bg-white/[0.02] hover:text-white hover:translate-x-1' }}">
                    <svg class="w-[18px] h-[18px] mr-4 transition-colors duration-300 {{ $activeTab === 'security' ? 'text-white' : 'text-white/30 group-hover:text-white/70' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Security & Access
                    @if($activeTab === 'security') <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-1/2 bg-white rounded-r-full shadow-[0_0_10px_rgba(255,255,255,0.5)]"></div> @endif
                </a>

                <a href="?tab=socials" 
                   class="flex items-center px-4 py-3 rounded-xl text-[14px] font-medium transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] relative group {{ $activeTab === 'socials' ? 'bg-white/5 text-white shadow-sm ring-1 ring-white/10' : 'text-white/50 hover:bg-white/[0.02] hover:text-white hover:translate-x-1' }}">
                    <svg class="w-[18px] h-[18px] mr-4 transition-colors duration-300 {{ $activeTab === 'socials' ? 'text-white' : 'text-white/30 group-hover:text-white/70' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    Social Accounts
                    @if($activeTab === 'socials') <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-1/2 bg-white rounded-r-full shadow-[0_0_10px_rgba(255,255,255,0.5)]"></div> @endif
                </a>

                <a href="?tab=billing" 
                   class="flex items-center px-4 py-3 rounded-xl text-[14px] font-medium transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] relative group {{ $activeTab === 'billing' ? 'bg-white/5 text-white shadow-sm ring-1 ring-white/10' : 'text-white/50 hover:bg-white/[0.02] hover:text-white hover:translate-x-1' }}">
                    <svg class="w-[18px] h-[18px] mr-4 transition-colors duration-300 {{ $activeTab === 'billing' ? 'text-white' : 'text-white/30 group-hover:text-white/70' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    Billing
                    @if($activeTab === 'billing') <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-1/2 bg-white rounded-r-full shadow-[0_0_10px_rgba(255,255,255,0.5)]"></div> @endif
                </a>
            </nav>
        @else
            <div class="text-[10px] font-bold text-white/20 uppercase tracking-[0.2em] mb-4 px-3">Main Menu</div>
            <nav class="space-y-1.5">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-white/10 to-transparent text-white ring-1 ring-white/10' : 'text-white/50 hover:text-white hover:bg-white/[0.03] hover:translate-x-1' }} rounded-xl font-medium text-[14px] transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] relative group">
                    <svg class="w-[18px] h-[18px] transition-transform duration-500 group-hover:scale-110 {{ request()->routeIs('dashboard') ? 'text-white drop-shadow-[0_0_8px_rgba(255,255,255,0.6)]' : 'text-white/30 group-hover:text-white/70' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                    @if(request()->routeIs('dashboard'))
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-2/3 bg-white rounded-r-full shadow-[0_0_12px_rgba(255,255,255,0.8)]"></div>
                    @endif
                </a>

                <!-- My Campaigns -->
                <a href="{{ route('campaigns.index') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('campaigns.*') ? 'bg-gradient-to-r from-white/10 to-transparent text-white ring-1 ring-white/10' : 'text-white/50 hover:text-white hover:bg-white/[0.03] hover:translate-x-1' }} rounded-xl font-medium text-[14px] transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] relative group">
                    <svg class="w-[18px] h-[18px] transition-transform duration-500 group-hover:scale-110 {{ request()->routeIs('campaigns.*') ? 'text-white drop-shadow-[0_0_8px_rgba(255,255,255,0.6)]' : 'text-white/30 group-hover:text-white/70' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>
                    My Campaigns
                    @if(request()->routeIs('campaigns.*'))
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-2/3 bg-white rounded-r-full shadow-[0_0_12px_rgba(255,255,255,0.8)]"></div>
                    @endif
                </a>

                <!-- Social Accounts Link -->
                <a href="{{ route('profile.edit', ['tab' => 'socials']) }}" class="flex items-center gap-4 px-4 py-3 text-white/50 hover:text-white hover:bg-white/[0.03] hover:translate-x-1 rounded-xl font-medium text-[14px] transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] relative group">
                    <svg class="w-[18px] h-[18px] transition-transform duration-500 group-hover:scale-110 text-white/30 group-hover:text-white/70" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    Social Accounts
                </a>

                <!-- Home -->
                <a href="{{ url('/welcome') }}" class="flex items-center gap-4 px-4 py-3 text-white/50 hover:text-white hover:bg-white/[0.03] hover:translate-x-1 rounded-xl font-medium text-[14px] transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] relative group">
                    <svg class="w-[18px] h-[18px] transition-transform duration-500 group-hover:scale-110 text-white/30 group-hover:text-white/70" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12V10.5a3 3 0 013-3h3.375c.621 0 1.125-.504 1.125-1.125V3h3c1.657 0 3 1.343 3 3v15c0 1.657-1.343 3-3 3h-12c-1.657 0-3-1.343-3-3v-6zm3-4.5h6" />
                    </svg>
                    Home
                </a>
            </nav>
        @endif
    </div>

    <!-- Minimalist User Profile Dropdown (Redesigned) -->
    <div class="p-6 relative z-10 before:content-[''] before:absolute before:top-0 before:left-6 before:right-6 before:h-px before:bg-gradient-to-r before:from-transparent before:via-white/10 before:to-transparent">
        <div class="dropdown dropdown-top w-full">
            <div tabindex="0" role="button" class="flex items-center gap-4 p-3 hover:bg-white/[0.03] rounded-2xl transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] w-full group cursor-pointer border border-transparent hover:border-white/[0.05]">
                <div class="avatar placeholder shrink-0">
                    <!-- High-end Monogram -->
                    <div class="bg-gradient-to-tr from-white/10 to-white/5 text-white rounded-full w-10 h-10 flex items-center justify-center ring-1 ring-white/20 group-hover:ring-white/40 shadow-[0_0_15px_rgba(255,255,255,0.05)] transition-all duration-500">
                        <span class="text-[13px] font-bold tracking-wider">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    </div>
                </div>
                <div class="flex flex-col text-left flex-1 min-w-0 transition-transform duration-500 group-hover:translate-x-1">
                    <span class="text-[14px] font-bold text-white truncate leading-tight">{{ Auth::user()->name }}</span>
                    <span class="text-[12px] font-medium text-white/40 truncate mt-0.5">{{ Auth::user()->email ?? 'Admin' }}</span>
                </div>
                <svg class="w-4 h-4 text-white/30 group-hover:text-white/70 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                </svg>
            </div>
            
            <!-- Dropdown Menu -->
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-[0_20px_50px_rgba(0,0,0,0.7)] bg-[#0A0A0C] border border-white/10 rounded-2xl w-[240px] mb-4 backdrop-blur-xl">
                <li>
                    <a href="{{ route('profile.edit') }}" class="py-2.5 px-4 text-[13px] text-white/70 hover:text-white hover:bg-white/5 font-medium rounded-xl transition-colors">
                        <svg class="w-4 h-4 mr-3 text-white/40" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                </li>
                <div class="h-px bg-white/10 my-2 mx-2"></div>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="w-full m-0 p-0 block">
                        @csrf
                        <button type="submit" class="w-full text-left py-2.5 px-4 text-[13px] text-[#FF4B4B] hover:bg-[#FF4B4B]/10 flex items-center font-medium rounded-xl transition-colors">
                            <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</aside>
