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
                <a href="/#features" class="text-[13px] font-medium text-gray-500 hover:text-black transition-colors tracking-wide">Features</a>
                <a href="/#pricing" class="text-[13px] font-medium text-gray-500 hover:text-black transition-colors tracking-wide">Pricing</a>
            </div>

            <!-- Right: User Menu -->
            <div class="flex items-center gap-2">
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
