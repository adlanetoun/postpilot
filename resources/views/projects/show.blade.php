<x-app-layout>
    <!-- Alert Banner for Flash Messages & Validation Errors -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">

        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200 flex items-center gap-2" role="alert">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <div><span class="font-bold">Error:</span> {{ session('error') }}</div>
            </div>
        @endif

        @if (request()->query('error') && str_starts_with(request()->query('error'), 'duplicate_account_'))
            @php
                $platform = ucfirst(explode('_', request()->query('error'))[2] ?? 'Social');
            @endphp
            <div class="p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200 flex items-center gap-2 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <div><span class="font-bold">Security Notice:</span> This <strong>{{ $platform }}</strong> page is already connected to another project! To prevent quota abuse, you cannot connect the same page to multiple projects. Connection rejected.</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200 flex flex-col gap-2" role="alert">
                <div class="flex items-center gap-2 font-bold">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span>Validation Errors Detected:</span>
                </div>
                <ul class="list-disc pl-5 space-y-1 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Premium Google Fonts and Master Stylesheet -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <style>
        .premium-font {
            font-family: 'Outfit', 'Inter', sans-serif;
        }
        .body-font {
            font-family: 'Inter', sans-serif;
        }
        
        /* Master Glassmorphic Card */
        .glass-panel {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.04), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-panel:hover {
            border-color: rgba(99, 102, 241, 0.25);
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 30px 60px -15px rgba(99, 102, 241, 0.12), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }
        
        /* Background Mesh Orbs */
        .glow-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.12;
            z-index: -1;
            pointer-events: none;
            animation: floating 10s ease-in-out infinite alternate;
        }
        .glow-circle-1 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, #6366f1, #4f46e5);
            top: 10%;
            left: 5%;
        }
        .glow-circle-2 {
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, #a855f7, #7c3aed);
            bottom: 15%;
            right: 10%;
            animation-delay: -3s;
        }
        
        @keyframes floating {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, 20px) scale(1.1); }
        }

        /* Pulsing Dot Indicator */
        .pulse-indicator {
            position: relative;
            display: inline-flex;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        .pulse-indicator::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: inherit;
            animation: pulse-ring 1.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.33); opacity: 1; }
            80%, 100% { transform: scale(3); opacity: 0; }
        }

        /* Inputs & Interactive Components */
        .premium-input {
            background: rgba(248, 250, 252, 0.8);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .premium-input:focus {
            background: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        /* Buttons styling */
        .btn-action {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-action:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.25);
        }
    </style>

    @if ($state !== 'C')
        <x-slot name="header">
            <!-- Left Side: Breadcrumb & Context -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-[13px] font-medium text-slate-400">
                    <!-- Refined Command/Project Icon -->
                    <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="premium-font font-semibold tracking-wide">PostPilot</span>
                </div>
                <span class="text-slate-300 font-light">/</span>
                <h1 class="text-[14px] font-bold text-slate-800 tracking-tight premium-font">{{ __('Dashboard') }}</h1>
            </div>

            <!-- Right Side: Dynamic Indicators -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-[11px] font-bold text-slate-500 bg-slate-100 border border-slate-200/60 px-3 py-1.5 rounded-full uppercase tracking-wider premium-font">
                    <span class="pulse-indicator bg-emerald-500"></span>
                    Engine Operational
                </div>
            </div>
        </x-slot>
    @endif

    <!-- State A: Project Dashboard (No Active Campaign) -->
    @if ($state === 'A')
        <!-- Premium Workspace Styles applied natively via Tailwind utilities now -->

        <div class="min-h-[calc(100vh-64px)] w-full text-[#191c1e] selection:bg-[#dde1ff] selection:text-[#001356] relative overflow-hidden pb-12">
        <div class="min-h-[calc(100vh-64px)] w-full text-[#191c1e] selection:bg-[#dde1ff] selection:text-[#001356] relative overflow-hidden pb-12">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end w-full px-[20px] md:px-[64px] py-[24px] max-w-[1400px] mx-auto pt-8 border-b border-[#edeef1] mb-10 gap-4">
                <div class="flex flex-col pb-2 md:pb-6">
                    <h1 class="text-[32px] md:text-[44px] font-black text-[#191c1e] tracking-tight leading-none mb-3">{{ $project->name }}</h1>
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0040e0] opacity-50"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#0040e0]"></span>
                        </span>
                        <span class="text-[12px] font-extrabold text-[#434656] uppercase tracking-widest opacity-80">Project Workspace</span>
                    </div>
                </div>
                <div class="flex items-center gap-3 pb-2 md:pb-6">
                    <x-confirm-modal 
                        id="delete-empty-project-modal" 
                        :action="route('projects.destroy', $project->id)" 
                        title="Delete Project?" 
                        message="This will permanently delete this project and all its settings. This action is irreversible."
                        confirmText="Delete Project" 
                        triggerClass="h-11 px-5 text-[12px] font-bold border border-rose-100 bg-white rounded-xl text-rose-600 hover:bg-rose-50 hover:border-rose-300 transition-all duration-300 uppercase tracking-wider cursor-pointer shadow-sm flex items-center justify-center gap-2"
                    >
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </x-confirm-modal>
                    
                    <a href="{{ route('dashboard') }}" class="h-11 px-6 text-[12px] font-bold bg-[#191c1e] text-white rounded-xl hover:bg-[#2a2e33] hover:shadow-lg transition-all duration-300 flex items-center gap-2 cursor-pointer uppercase tracking-wider shadow-md">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                        Dashboard
                    </a>
                </div>
            </div>

            <!-- Main Canvas -->
            <div class="px-[20px] md:px-[64px] max-w-[1400px] mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch min-h-[500px]">
                    
                    <!-- Left Column: Connected Platforms -->
                    <div class="lg:col-span-7 flex flex-col w-full reveal active transition-all duration-700" style="transition-delay: 100ms;">
                        <div class="bg-white border border-[#edeef1] p-8 md:p-12 rounded-[32px] shadow-[0_15px_40px_-15px_rgba(25,28,30,0.05)] relative overflow-hidden group h-full flex flex-col">
                            <!-- Subtle Top Border Highlight -->
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#0040e0]/20 to-transparent"></div>

                            <div class="mb-10">
                                <h2 class="text-[28px] font-black text-[#191c1e] tracking-tight">Connected Platforms</h2>
                                <p class="text-[15px] text-[#434656] font-medium mt-2">Link social accounts to unlock AI-powered content generation.</p>
                            </div>
                            
                            <div class="space-y-4 flex-1">
                                @php
                                    $platforms = [
                                        'twitter' => ['name' => 'X (Twitter)', 'icon' => '<svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>', 'color' => '#191c1e', 'bg' => 'hover:bg-slate-50 hover:border-slate-300'],
                                        'linkedin' => ['name' => 'LinkedIn', 'icon' => '<svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>', 'color' => '#0077B5', 'bg' => 'hover:bg-blue-50 hover:border-blue-200'],
                                        'facebook' => ['name' => 'Facebook', 'icon' => '<svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>', 'color' => '#1877F2', 'bg' => 'hover:bg-blue-50 hover:border-blue-200'],
                                    ];
                                @endphp
                                @foreach ($platforms as $key => $info)
                                    @php
                                        $isConnected = $project->socialAccounts->contains('provider', $key);
                                    @endphp
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-5 border {{ $isConnected ? 'border-[#edeef1] bg-white shadow-sm' : 'border-transparent bg-[#f8f9fc]' }} rounded-[20px] transition-all duration-400 group/row {{ !$isConnected ? $info['bg'] : '' }}">
                                        <div class="flex items-center gap-5 mb-4 sm:mb-0">
                                            <div class="w-[52px] h-[52px] shrink-0 rounded-[16px] flex items-center justify-center transition-all duration-500 {{ $isConnected ? 'text-white shadow-md' : 'bg-white border border-[#edeef1] text-[#c4c5d9] group-hover/row:text-['.$info['color'].'] group-hover/row:shadow-sm group-hover/row:border-transparent' }}" style="{{ $isConnected ? 'background-color: ' . $info['color'] : '' }}">
                                                {!! $info['icon'] !!}
                                            </div>
                                             <div>
                                                 <div class="flex items-center gap-2">
                                                     <h3 class="text-[17px] font-black text-[#191c1e] leading-tight">{{ $info['name'] }}</h3>
                                                     @if ($key === 'twitter' && !$isConnected)
                                                         <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-800 bg-amber-50 border border-amber-200/90 px-2 py-0.5 rounded-full shadow-2xs">
                                                             ✨ Requires X Premium
                                                         </span>
                                                     @endif
                                                 </div>
                                                 @if ($isConnected)
                                                     <div class="flex items-center gap-1.5 mt-1">
                                                         <span class="relative flex h-2 w-2">
                                                             <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                             <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                         </span>
                                                         <span class="text-[11px] font-extrabold text-emerald-600 uppercase tracking-widest">Active Link</span>
                                                     </div>
                                                 @else
                                                     <span class="text-[11px] font-extrabold text-[#c4c5d9] uppercase tracking-widest mt-1 block group-hover/row:text-[#434656] transition-colors">Not Connected</span>
                                                 @endif
                                            </div>
                                        </div>
                                        
                                        <div class="flex shrink-0">
                                            @if ($isConnected)
                                                <form action="{{ route('social-accounts.disconnect', ['project' => $project->id, 'platform' => $key]) }}" method="POST" class="m-0 w-full sm:w-auto">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="h-10 px-5 text-[11px] font-extrabold border border-rose-100 bg-white text-rose-500 rounded-full hover:bg-rose-50 hover:border-rose-200 transition-all uppercase tracking-widest w-full sm:w-auto flex items-center justify-center shadow-sm hover:shadow">Disconnect</button>
                                                </form>
                                            @else
                                                <button onclick="openOAuthWindow('{{ URL::signedRoute('social-accounts.connect-popup', ['project' => $project->id, 'platform' => $key]) }}', '{{ $key }}')" class="h-10 px-6 text-[11px] font-extrabold bg-white border border-[#c4c5d9] text-[#191c1e] rounded-full group-hover/row:bg-[#191c1e] group-hover/row:border-[#191c1e] group-hover/row:text-white hover:scale-105 transition-all duration-300 uppercase tracking-widest w-full sm:w-auto flex items-center justify-center shadow-sm">
                                                    Connect
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Ready to Launch (AI Box) -->
                    <div class="lg:col-span-5 flex w-full reveal active transition-all duration-700 h-full" style="transition-delay: 300ms;">
                        <div class="bg-[#141517] text-white w-full p-10 md:p-12 rounded-[32px] flex flex-col items-center text-center relative overflow-hidden group shadow-[0_30px_60px_-15px_rgba(20,21,23,0.4)] h-full justify-center">
                            <!-- Premium Glow Effects -->
                            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-[#0040e0]/30 blur-[120px] rounded-full pointer-events-none transition-transform duration-1000 group-hover:scale-125 -translate-y-1/2 translate-x-1/3"></div>
                            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-[#0040e0]/20 blur-[100px] rounded-full pointer-events-none transition-transform duration-1000 group-hover:scale-150 translate-y-1/3 -translate-x-1/3 delay-150"></div>
                            
                            <!-- Subtle Grid Pattern -->
                            <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,0.08)_1px,transparent_1px)] [background-size:24px_24px] opacity-30 pointer-events-none mix-blend-overlay"></div>
                            
                            <div class="relative z-10 flex flex-col items-center w-full max-w-[320px] mx-auto">
                                <!-- Glowing Icon Container (FIXED SHRINK ISSUE) -->
                                <div class="w-20 h-20 shrink-0 rounded-[24px] bg-gradient-to-br from-white/10 to-transparent border border-white/10 flex items-center justify-center mb-8 group-hover:bg-white/20 group-hover:-translate-y-2 transition-all duration-500 shadow-[0_0_40px_rgba(0,64,224,0.3)] backdrop-blur-md relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:animate-[shimmer_2s_infinite]"></div>
                                    <span class="material-symbols-outlined text-[#8ca8ff] text-[40px] drop-shadow-[0_0_15px_rgba(140,168,255,0.8)]" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                                </div>
                                
                                <h1 class="text-[44px] font-black tracking-tight leading-[1.1] mb-5 text-white drop-shadow-sm">Ready to <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-[#e0e7ff] to-[#8ca8ff]">Launch?</span></h1>
                                
                                <p class="text-[15px] font-medium text-[#c4c5d9] mb-10 leading-relaxed opacity-90">
                                    You have no active campaigns. Connect at least one social account and let our AI craft your 30-day strategy.
                                </p>
                                
                                @if($project->socialAccounts->where('provider', '!=', 'postpeer')->isEmpty())
                                    <button onclick="document.getElementById('no-socials-warning-modal').showModal()" class="w-full h-14 bg-white/5 border border-white/10 text-white font-black text-[13px] uppercase tracking-[0.2em] rounded-2xl hover:bg-white/10 hover:border-white/20 transition-all duration-300 flex items-center justify-center gap-3 backdrop-blur-md shrink-0 cursor-pointer shadow-lg">
                                        <span class="material-symbols-outlined text-amber-400 text-[20px]">warning</span>
                                        Connect Channel First
                                    </button>
                                @else
                                        <button onclick="document.getElementById('create-campaign-modal').showModal()" class="relative w-full h-14 group/btn overflow-hidden rounded-2xl bg-[#0040e0] text-white shadow-[0_10px_30px_-10px_rgba(0,64,224,0.6)] hover:shadow-[0_20px_40px_-10px_rgba(0,64,224,0.8)] hover:-translate-y-1 transition-all duration-400 p-0 shrink-0 cursor-pointer">
                                            <!-- Inner Highlight -->
                                            <div class="absolute inset-0 rounded-2xl border-t border-white/30 border-b border-black/20 pointer-events-none mix-blend-overlay"></div>
                                            
                                            <!-- Animated Gradient Background -->
                                            <div class="absolute inset-0 bg-gradient-to-r from-[#0030a8] via-[#0040e0] to-[#0030a8] bg-[length:200%_auto] group-hover:animate-[shimmer_3s_linear_infinite] pointer-events-none"></div>
                                            
                                            <!-- Shine Effect -->
                                            <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/25 to-transparent animate-[shimmer_2.5s_infinite] pointer-events-none skew-x-12"></div>
                                            
                                            <div class="relative z-10 w-full h-full flex items-center justify-center gap-3">
                                                <span class="font-black text-[13px] uppercase tracking-[0.2em] drop-shadow-sm">Start Generating</span>
                                                <span class="material-symbols-outlined text-[20px] group-hover/btn:translate-x-2 transition-transform duration-400 drop-shadow-sm">arrow_forward</span>
                                            </div>
                                        </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Decorative Element -->
            <footer class="absolute bottom-[24px] left-0 right-0 flex justify-center opacity-30 pointer-events-none">
                <span class="font-label-md tracking-[0.4em] uppercase text-[#434656]">Executive Workspace v2.0</span>
            </footer>
        </div>

        <script>
            // Intersection Observer for reveal animations
            document.addEventListener('DOMContentLoaded', () => {
                const observerOptions = { threshold: 0.1 };
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                        }
                    });
                }, observerOptions);

                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            });
        </script>

        <!-- Campaign Creation Modal (Premium Elite View) -->
        <dialog id="create-campaign-modal" class="modal bg-[#141517]/80 backdrop-blur-xl">
            <div class="modal-box p-0 max-w-5xl w-[95%] max-h-[90vh] rounded-[32px] overflow-hidden bg-white shadow-[0_40px_100px_-20px_rgba(0,0,0,0.5)] border border-white/20 relative">
                <button class="absolute top-5 right-5 w-10 h-10 flex items-center justify-center rounded-full bg-black/10 text-white hover:bg-rose-500 hover:scale-110 transition-all duration-300 z-50 backdrop-blur-md border border-white/10 cursor-pointer shadow-lg" onclick="document.getElementById('create-campaign-modal').close()">✕</button>
                
                <div class="grid grid-cols-1 md:grid-cols-5 h-[85vh] max-h-[600px] relative">
                    
                    <!-- Left Side: Input Form -->
                    <div class="md:col-span-3 p-6 lg:p-10 h-full flex flex-col relative overflow-hidden bg-white">
                        
                        <!-- Progress Indicator -->
                        <div class="flex items-center gap-4 mb-10">
                            <div class="flex-1 h-2 bg-[#f8f9fc] rounded-full overflow-hidden border border-[#edeef1] shadow-inner">
                                <div id="wizard-progress" class="h-full bg-gradient-to-r from-[#0030a8] to-[#0040e0] rounded-full transition-all duration-500 ease-out relative overflow-hidden" style="width: 33%">
                                    <div class="absolute inset-0 bg-white/20 -translate-x-full animate-[shimmer_2s_infinite]"></div>
                                </div>
                            </div>
                            <span id="wizard-step-text" class="text-[11px] font-extrabold text-[#434656] uppercase tracking-widest w-16 text-right">Step 1/3</span>
                        </div>

                        <div class="mb-8">
                            <h3 id="wizard-title" class="text-[32px] font-black text-[#191c1e] mb-2 tracking-tight transition-opacity duration-300 leading-none">The Core</h3>
                            <p id="wizard-subtitle" class="text-[15px] font-medium text-[#434656] transition-opacity duration-300">Tell us what your product does and who it's for.</p>
                        </div>
                        <form id="campaign-wizard-form" action="{{ route('campaigns.store', $project->id) }}" method="POST" class="flex-1 flex flex-col relative" onsubmit="this.querySelectorAll('button[type=submit]').forEach(b => { b.disabled = true; b.innerHTML = 'Generating...'; b.classList.add('opacity-75', 'cursor-not-allowed'); })">
                            @csrf
                            
                            @if ($errors->any() && old('description'))
                                <div class="mb-6 p-4 text-[13px] text-rose-800 rounded-[16px] bg-rose-50 border border-rose-100 flex flex-col gap-2 shadow-sm">
                                    <div class="flex items-center gap-2 font-bold">
                                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                        <span>Please correct validation errors:</span>
                                    </div>
                                    <ul class="list-disc pl-5 space-y-1 font-medium">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 grid-rows-1 flex-1 relative overflow-y-auto overflow-x-hidden pr-2 custom-scrollbar">
                                <!-- STEP 1 -->
                                <div id="step-1" class="wizard-step absolute inset-0 w-full transition-all duration-500 transform scale-100 opacity-100 space-y-5">
                                    <div>
                                        <label class="block text-[11px] font-extrabold text-[#191c1e] uppercase tracking-widest mb-2">Product Description <span class="text-rose-500">*</span></label>
                                        <textarea name="description" id="campaign_desc_input" rows="4" placeholder="What does your product do? What problem does it solve?" required class="w-full bg-[#f8f9fc] border border-[#edeef1] text-[#191c1e] text-[15px] font-medium rounded-[20px] focus:ring-[4px] focus:ring-[#0040e0]/10 focus:border-[#0040e0] focus:bg-white block p-5 transition-all shadow-sm hover:shadow-md resize-none @error('description') border-rose-500 focus:ring-rose-500/20 @enderror">{{ old('description') }}</textarea>
                                        @error('description') <p class="text-rose-600 text-[12px] mt-2 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-extrabold text-[#191c1e] uppercase tracking-widest mb-2">Target Audience <span class="text-rose-500">*</span></label>
                                        <input type="text" name="target_audience" id="campaign_audience_input" placeholder="e.g. Indie Hackers, Solopreneurs" required class="w-full bg-[#f8f9fc] border border-[#edeef1] text-[#191c1e] text-[15px] font-medium rounded-[16px] focus:ring-[4px] focus:ring-[#0040e0]/10 focus:border-[#0040e0] focus:bg-white block p-5 transition-all shadow-sm hover:shadow-md @error('target_audience') border-rose-500 focus:ring-rose-500/20 @enderror" value="{{ old('target_audience') }}" />
                                        @error('target_audience') <p class="text-rose-600 text-[12px] mt-2 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <!-- STEP 2 -->
                                <div id="step-2" class="wizard-step absolute inset-0 w-full transition-all duration-500 transform scale-95 opacity-0 invisible space-y-5 pointer-events-none">
                                    <div>
                                        <label class="block text-[11px] font-extrabold text-[#191c1e] uppercase tracking-widest mb-3">Tone of Voice</label>
                                        <input type="text" name="tone_of_voice" id="campaign_tone_input" placeholder="e.g. Witty, Professional" class="w-full bg-[#f8f9fc] border border-[#edeef1] text-[#191c1e] text-[15px] font-medium rounded-[16px] focus:ring-[4px] focus:ring-[#0040e0]/10 focus:border-[#0040e0] block p-5 transition-all shadow-sm hover:shadow-md @error('tone_of_voice') border-rose-500 focus:ring-rose-500/20 @enderror" value="{{ old('tone_of_voice') }}" />
                                        @error('tone_of_voice') <p class="text-rose-600 text-[12px] mt-2 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-extrabold text-[#191c1e] uppercase tracking-widest mb-3">Value Proposition</label>
                                        <input type="text" name="value_proposition" id="campaign_value_input" placeholder="e.g. Save 10 hours a week" class="w-full bg-[#f8f9fc] border border-[#edeef1] text-[#191c1e] text-[15px] font-medium rounded-[16px] focus:ring-[4px] focus:ring-[#0040e0]/10 focus:border-[#0040e0] block p-5 transition-all shadow-sm hover:shadow-md @error('value_proposition') border-rose-500 focus:ring-rose-500/20 @enderror" value="{{ old('value_proposition') }}" />
                                        @error('value_proposition') <p class="text-rose-600 text-[12px] mt-2 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <!-- STEP 3 -->
                                <div id="step-3" class="wizard-step absolute inset-0 w-full transition-all duration-500 transform scale-95 opacity-0 invisible space-y-6 pointer-events-none">
                                    <div>
                                        <label class="block text-[11px] font-extrabold text-[#191c1e] uppercase tracking-widest mb-2">Output Language <span class="text-rose-500">*</span></label>
                                        <div class="relative">
                                            <select name="language" required class="w-full appearance-none bg-[#f8f9fc] border border-[#edeef1] text-[#191c1e] text-[15px] font-bold rounded-[16px] focus:ring-[4px] focus:ring-[#0040e0]/10 focus:border-[#0040e0] focus:bg-white block p-5 pr-10 transition-all shadow-sm hover:shadow-md cursor-pointer">
                                                <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>English</option>
                                                <option value="Arabic" {{ old('language') == 'Arabic' ? 'selected' : '' }}>Arabic (العربية)</option>
                                                <option value="French" {{ old('language') == 'French' ? 'selected' : '' }}>French (Français)</option>
                                                <option value="Spanish" {{ old('language') == 'Spanish' ? 'selected' : '' }}>Spanish (Español)</option>
                                                <option value="German" {{ old('language') == 'German' ? 'selected' : '' }}>German (Deutsch)</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-[#434656]">
                                                <span class="material-symbols-outlined text-[20px]">expand_more</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-extrabold text-[#191c1e] uppercase tracking-widest mb-2">Publishing Platforms</label>
                                        
                                        @php
                                            $isLinkedinConnected = in_array('linkedin', $connectedPlatforms);
                                            $isTwitterConnected = in_array('twitter', $connectedPlatforms);
                                            $isFacebookConnected = in_array('facebook', $connectedPlatforms);
                                            $hasAnyConnected = !empty($connectedPlatforms);
                                        @endphp

                                        @if(!$hasAnyConnected)
                                            <div class="p-6 bg-amber-50 border border-amber-200 text-amber-800 rounded-[20px] text-[14px] flex flex-col gap-3 shadow-sm">
                                                <div class="flex items-center gap-2 font-black text-amber-900 text-[16px]">
                                                    <span class="material-symbols-outlined text-[24px]">warning</span>
                                                    No Accounts Linked
                                                </div>
                                                <p class="font-medium text-amber-800/80">Connect accounts on the project workspace before generating.</p>
                                            </div>
                                        @else
                                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-2">
                                                <!-- Bento Card: LinkedIn -->
                                                <label class="group relative flex flex-col items-center justify-center p-4 bg-[#f8f9fc] border border-[#edeef1] rounded-[20px] cursor-pointer hover:bg-white hover:shadow-[0_10px_20px_-5px_rgba(0,0,0,0.08)] hover:-translate-y-0.5 hover:border-[#0040e0]/30 transition-all duration-300 {{ !$isLinkedinConnected ? 'opacity-40 grayscale cursor-not-allowed pointer-events-none' : '' }}">
                                                    <div class="absolute inset-0 bg-gradient-to-br from-[#0040e0]/0 to-[#0040e0]/5 opacity-0 group-hover:opacity-100 transition-opacity rounded-[20px]"></div>
                                                    <input type="checkbox" name="platforms[]" value="linkedin" {{ ($isLinkedinConnected && (is_array(old('platforms')) ? in_array('linkedin', old('platforms')) : true)) ? 'checked' : 'disabled' }} class="peer sr-only" />
                                                    <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-[#edeef1] peer-checked:border-[#0040e0] peer-checked:bg-[#0040e0] flex items-center justify-center transition-colors shadow-sm">
                                                        <span class="material-symbols-outlined text-white text-[12px] opacity-0 peer-checked:opacity-100 scale-50 peer-checked:scale-100 transition-all">check</span>
                                                    </div>
                                                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mb-2 group-hover:scale-110 transition-transform duration-300 relative z-10">
                                                        <span class="material-symbols-outlined text-[#0077b5] text-[24px]">work</span>
                                                    </div>
                                                    <span class="text-[14px] font-black text-[#191c1e] relative z-10">LinkedIn</span>
                                                    @if(!$isLinkedinConnected)
                                                        <span class="text-[9px] font-bold text-[#434656] uppercase tracking-widest mt-1 relative z-10">Disconnected</span>
                                                    @endif
                                                </label>
                                                
                                                <!-- Bento Card: Twitter -->
                                                <label class="group relative flex flex-col items-center justify-center p-4 bg-[#f8f9fc] border border-[#edeef1] rounded-[20px] cursor-pointer hover:bg-white hover:shadow-[0_10px_20px_-5px_rgba(0,0,0,0.08)] hover:-translate-y-0.5 hover:border-[#0040e0]/30 transition-all duration-300 {{ !$isTwitterConnected ? 'opacity-40 grayscale cursor-not-allowed pointer-events-none' : '' }}">
                                                    <div class="absolute inset-0 bg-gradient-to-br from-[#0040e0]/0 to-[#0040e0]/5 opacity-0 group-hover:opacity-100 transition-opacity rounded-[20px]"></div>
                                                    <input type="checkbox" name="platforms[]" value="twitter" {{ ($isTwitterConnected && (is_array(old('platforms')) ? in_array('twitter', old('platforms')) : true)) ? 'checked' : 'disabled' }} class="peer sr-only" />
                                                    <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-[#edeef1] peer-checked:border-[#0040e0] peer-checked:bg-[#0040e0] flex items-center justify-center transition-colors shadow-sm">
                                                        <span class="material-symbols-outlined text-white text-[12px] opacity-0 peer-checked:opacity-100 scale-50 peer-checked:scale-100 transition-all">check</span>
                                                    </div>
                                                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mb-2 group-hover:scale-110 transition-transform duration-300 relative z-10">
                                                        <span class="material-symbols-outlined text-[#1da1f2] text-[24px]">tag</span>
                                                    </div>
                                                    <span class="text-[14px] font-black text-[#191c1e] relative z-10">X (Twitter)</span>
                                                    @if(!$isTwitterConnected)
                                                        <span class="text-[9px] font-bold text-[#434656] uppercase tracking-widest mt-1 relative z-10">Disconnected</span>
                                                    @endif
                                                </label>

                                                <!-- Bento Card: Facebook -->
                                                <label class="group relative flex flex-col items-center justify-center p-4 bg-[#f8f9fc] border border-[#edeef1] rounded-[20px] cursor-pointer hover:bg-white hover:shadow-[0_10px_20px_-5px_rgba(0,0,0,0.08)] hover:-translate-y-0.5 hover:border-[#0040e0]/30 transition-all duration-300 {{ !$isFacebookConnected ? 'opacity-40 grayscale cursor-not-allowed pointer-events-none' : '' }}">
                                                    <div class="absolute inset-0 bg-gradient-to-br from-[#0040e0]/0 to-[#0040e0]/5 opacity-0 group-hover:opacity-100 transition-opacity rounded-[20px]"></div>
                                                    <input type="checkbox" name="platforms[]" value="facebook" {{ ($isFacebookConnected && (is_array(old('platforms')) ? in_array('facebook', old('platforms')) : true)) ? 'checked' : 'disabled' }} class="peer sr-only" />
                                                    <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-[#edeef1] peer-checked:border-[#0040e0] peer-checked:bg-[#0040e0] flex items-center justify-center transition-colors shadow-sm">
                                                        <span class="material-symbols-outlined text-white text-[12px] opacity-0 peer-checked:opacity-100 scale-50 peer-checked:scale-100 transition-all">check</span>
                                                    </div>
                                                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mb-2 group-hover:scale-110 transition-transform duration-300 relative z-10">
                                                        <span class="material-symbols-outlined text-[#1877f2] text-[24px]">facebook</span>
                                                    </div>
                                                    <span class="text-[14px] font-black text-[#191c1e] relative z-10">Facebook</span>
                                                    @if(!$isFacebookConnected)
                                                        <span class="text-[9px] font-bold text-[#434656] uppercase tracking-widest mt-1 relative z-10">Disconnected</span>
                                                    @endif
                                                </label>
                                            </div>
                                            @error('platforms')
                                                <p class="text-rose-600 text-[12px] mt-3 font-bold">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>
                                </div>

                                <!-- STEP 4: REVIEW SUMMARY -->
                                <div id="step-4" class="wizard-step absolute inset-0 w-full transition-all duration-500 transform scale-95 opacity-0 invisible space-y-6 pointer-events-none">
                                    <div class="p-8 rounded-[24px] border border-[#0040e0]/20 bg-[#0040e0]/5 space-y-5 shadow-inner">
                                        <h4 class="text-[12px] font-extrabold text-[#0040e0] uppercase tracking-widest flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[18px]">verified</span>
                                            Review Configuration
                                        </h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-[14px]">
                                            <div class="col-span-1 sm:col-span-2">
                                                <span class="block text-[10px] text-[#434656] font-bold uppercase tracking-widest">Product Description</span>
                                                <p id="review-desc" class="text-[#191c1e] font-bold mt-1.5 break-words line-clamp-3">Not provided</p>
                                            </div>
                                            <div>
                                                <span class="block text-[10px] text-[#434656] font-bold uppercase tracking-widest">Target Audience</span>
                                                <p id="review-audience" class="text-[#191c1e] font-bold mt-1.5 break-words">Not provided</p>
                                            </div>
                                            <div>
                                                <span class="block text-[10px] text-[#434656] font-bold uppercase tracking-widest">Tone of Voice</span>
                                                <p id="review-tone" class="text-[#191c1e] font-bold mt-1.5 break-words">Not provided</p>
                                            </div>
                                            <div>
                                                <span class="block text-[10px] text-[#434656] font-bold uppercase tracking-widest">Value Proposition</span>
                                                <p id="review-val" class="text-[#191c1e] font-bold mt-1.5 break-words">Not provided</p>
                                            </div>
                                            <div>
                                                <span class="block text-[10px] text-[#434656] font-bold uppercase tracking-widest">Language & Channels</span>
                                                <p class="text-[#191c1e] font-bold mt-1.5">
                                                    <span id="review-lang">English</span> <span class="text-[#c4c5d9] mx-1">/</span> <span id="review-platforms" class="text-[#0040e0] font-black">None</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if(!$hasAnyConnected)
                                        <div class="p-5 bg-rose-50 border border-rose-200 text-rose-800 rounded-[16px] text-[13px] flex items-start gap-3 shadow-sm">
                                            <span class="material-symbols-outlined text-rose-600 text-[20px]">error</span>
                                            <div>
                                                <span class="font-black block text-rose-900 mb-1">Action Required</span>
                                                <span class="font-medium">Please go back and link at least one channel to generate the campaign.</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                             <!-- Form Actions -->
                            <div class="mt-6 pt-5 border-t border-[#edeef1] flex items-center justify-between z-10 bg-white relative">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="text-[#434656] hover:text-[#191c1e] font-bold text-[11px] uppercase tracking-widest h-12 px-5 rounded-[16px] transition-all hover:bg-[#f8f9fc] cursor-pointer flex items-center gap-2" onclick="document.getElementById('create-campaign-modal').close()">Cancel</button>
                                    <button type="button" id="btn-back" class="hidden text-[#434656] hover:text-[#191c1e] font-bold text-[11px] uppercase tracking-widest h-12 px-5 rounded-[16px] transition-all hover:bg-[#f8f9fc] cursor-pointer flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                                        Back
                                    </button>
                                </div>
                                
                                <button type="button" id="btn-next" class="bg-[#191c1e] hover:bg-[#2a2e33] text-white font-bold h-14 px-8 rounded-[16px] shadow-[0_10px_20px_-10px_rgba(25,28,30,0.5)] transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer text-[12px] uppercase tracking-widest">
                                    Next Step
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </button>

                                <button type="submit" id="btn-submit" @if(!$hasAnyConnected) disabled @endif class="hidden relative group/submit overflow-hidden bg-[#0040e0] text-white font-black h-14 px-8 rounded-[16px] shadow-[0_10px_30px_-10px_rgba(0,64,224,0.6)] hover:shadow-[0_20px_40px_-10px_rgba(0,64,224,0.8)] hover:-translate-y-1 transition-all duration-400 cursor-pointer text-[12px] uppercase tracking-[0.1em] @if(!$hasAnyConnected) opacity-50 cursor-not-allowed @endif">
                                    <div class="absolute inset-0 rounded-[16px] border-t border-white/30 border-b border-black/20 pointer-events-none mix-blend-overlay"></div>
                                    <div class="absolute inset-0 bg-gradient-to-r from-[#0030a8] via-[#0040e0] to-[#0030a8] bg-[length:200%_auto] group-hover/submit:animate-[shimmer_3s_linear_infinite] pointer-events-none"></div>
                                    <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/25 to-transparent animate-[shimmer_2.5s_infinite] pointer-events-none skew-x-12"></div>
                                    <div class="relative z-10 flex items-center gap-2 h-full">
                                        <span class="material-symbols-outlined text-[20px] drop-shadow-sm">auto_awesome</span>
                                        <span class="drop-shadow-sm">Launch Engine</span>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Side: AI Preview (Dark Mode Premium) -->
                    <div class="md:col-span-2 bg-[#141517] p-8 lg:p-10 text-white relative overflow-hidden flex flex-col justify-center shadow-[inset_10px_0_30px_rgba(0,0,0,0.5)]">
                        <!-- Advanced Mesh Gradient Glow -->
                        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#0040e0]/30 blur-[120px] rounded-full pointer-events-none -mt-32 -mr-32 animate-[pulse_6s_ease-in-out_infinite_alternate]"></div>
                        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[#8ca8ff]/15 blur-[100px] rounded-full pointer-events-none -mb-32 -ml-32 animate-[pulse_8s_ease-in-out_infinite_alternate_reverse]"></div>
                        
                        <!-- Subtle Grid Pattern -->
                        <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,0.06)_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

                        <div class="relative z-10">
                            <!-- Live Status Pill -->
                            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-black/40 border border-[#0040e0]/50 text-[#8ca8ff] text-[11px] font-black tracking-[0.1em] uppercase mb-12 shadow-[0_0_30px_rgba(0,64,224,0.4)] backdrop-blur-md">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#8ca8ff] opacity-100"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-[#8ca8ff]"></span>
                                </span>
                                AI Live Sync
                            </div>

                            <h4 class="text-[32px] font-black mb-10 leading-tight tracking-tight drop-shadow-lg text-white">
                                Generating a 30-day <br/>strategy for <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#8ca8ff] to-white border-b-2 border-[#0040e0]/60 pb-1">{{ $project->name }}</span>.
                            </h4>

                            <div class="space-y-6 text-[#c4c5d9] text-[15px] font-medium leading-relaxed">
                                <p class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-[#8ca8ff] text-[20px] shrink-0 mt-0.5">group</span>
                                    <span>Targeting <span id="preview_audience" class="text-white font-black underline decoration-[#0040e0] underline-offset-4 decoration-2">your audience</span> with a <span id="preview_tone" class="text-white font-black underline decoration-[#0040e0] underline-offset-4 decoration-2">compelling</span> tone of voice.</span>
                                </p>
                                
                                <div class="relative bg-white/5 border border-white/10 rounded-[20px] p-5 backdrop-blur-sm">
                                    <span class="material-symbols-outlined absolute top-4 left-4 text-white/20 text-[40px]">format_quote</span>
                                    <p id="preview_desc_container" class="opacity-50 italic relative z-10 pl-10 text-[14px]">
                                        "Awaiting product description..."
                                    </p>
                                </div>
                                
                                <p id="preview_value_container" class="hidden flex items-start gap-3 transition-all duration-500">
                                    <span class="material-symbols-outlined text-[#8ca8ff] text-[20px] shrink-0 mt-0.5">verified</span>
                                    <span>Highlighting core value: <span id="preview_value" class="text-white font-black"></span>.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </dialog>

        <!-- Vanilla JS for Live Preview & Wizard -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Live preview logic
                const audIn = document.getElementById('campaign_audience_input');
                const toneIn = document.getElementById('campaign_tone_input');
                const descIn = document.getElementById('campaign_desc_input');
                const valIn = document.getElementById('campaign_value_input');

                const audOut = document.getElementById('preview_audience');
                const toneOut = document.getElementById('preview_tone');
                const descOut = document.getElementById('preview_desc_container');
                const valOut = document.getElementById('preview_value');
                const valOutCont = document.getElementById('preview_value_container');

                function updatePreview() {
                    if (audIn) audOut.textContent = audIn.value || 'your audience';
                    if (toneIn) toneOut.textContent = toneIn.value || 'compelling';
                    
                    if (descIn && descIn.value) {
                        descOut.textContent = `"${descIn.value.substring(0, 100)}${descIn.value.length > 100 ? '...' : ''}"`;
                        descOut.classList.remove('opacity-50', 'italic');
                        descOut.classList.add('text-gray-300');
                    } else if (descOut) {
                        descOut.textContent = '"Awaiting product description..."';
                        descOut.classList.add('opacity-50', 'italic');
                        descOut.classList.remove('text-gray-300');
                    }

                    if (valIn && valIn.value) {
                        valOut.textContent = valIn.value;
                        valOutCont.classList.remove('hidden');
                    } else if (valOutCont) {
                        valOutCont.classList.add('hidden');
                    }
                }

                [audIn, toneIn, descIn, valIn].forEach(el => {
                    if(el) el.addEventListener('input', updatePreview);
                });

                // Wizard logic
                let currentStep = 1;

                // Wizard Auto-Save in localStorage
                const cacheKey = 'postpilot_campaign_draft_{{ $project->id }}';
                
                function saveWizardDraft() {
                    const draftData = {
                        description: descIn ? descIn.value : '',
                        target_audience: audIn ? audIn.value : '',
                        tone_of_voice: toneIn ? toneIn.value : '',
                        value_proposition: valIn ? valIn.value : '',
                        language: document.querySelector('select[name="language"]')?.value || 'English',
                        platforms: Array.from(document.querySelectorAll('input[name="platforms[]"]:checked')).map(cb => cb.value)
                    };
                    localStorage.setItem(cacheKey, JSON.stringify(draftData));
                }

                function restoreWizardDraft() {
                    const saved = localStorage.getItem(cacheKey);
                    if (!saved) return;
                    try {
                        const draftData = JSON.parse(saved);
                        let restored = false;
                        if (descIn && !descIn.value && draftData.description) { descIn.value = draftData.description; restored = true; }
                        if (audIn && !audIn.value && draftData.target_audience) { audIn.value = draftData.target_audience; restored = true; }
                        if (toneIn && !toneIn.value && draftData.tone_of_voice) { toneIn.value = draftData.tone_of_voice; restored = true; }
                        if (valIn && !valIn.value && draftData.value_proposition) { valIn.value = draftData.value_proposition; restored = true; }
                        
                        const langSelect = document.querySelector('select[name="language"]');
                        if (langSelect && draftData.language) langSelect.value = draftData.language;
                        
                        if (draftData.platforms && Array.isArray(draftData.platforms)) {
                            document.querySelectorAll('input[name="platforms[]"]').forEach(cb => {
                                cb.checked = draftData.platforms.includes(cb.value);
                            });
                        }
                        updatePreview();
                        if (restored) {
                            setTimeout(() => {
                                if (typeof window.showToast === 'function') {
                                    window.showToast('✅ Campaign draft restored from previous session.', 'info');
                                }
                            }, 500);
                        }
                    } catch (e) {
                        console.error('Error restoring campaign draft:', e);
                    }
                }

                // Add event listeners for auto-save
                [audIn, toneIn, descIn, valIn].forEach(el => {
                    if (el) el.addEventListener('input', saveWizardDraft);
                });
                document.querySelector('select[name="language"]')?.addEventListener('change', saveWizardDraft);
                document.querySelectorAll('input[name="platforms[]"]').forEach(cb => cb.addEventListener('change', saveWizardDraft));
                
                // Clear draft on successful submit
                document.getElementById('campaign-wizard-form')?.addEventListener('submit', () => {
                    localStorage.removeItem(cacheKey);
                });

                // Load draft on load
                restoreWizardDraft();
                
                // Also trigger load when modal is opened manually
                const openCampaignBtn = document.querySelector('[onclick*="create-campaign-modal"]');
                if (openCampaignBtn) {
                    openCampaignBtn.addEventListener('click', restoreWizardDraft);
                }


                // UX-1: Automatically navigate to the wizard step containing errors
                @if ($errors->any() && old('description'))
                    @if ($errors->has('platforms') || $errors->has('language'))
                        currentStep = 3;
                    @elseif ($errors->has('tone_of_voice') || $errors->has('value_proposition'))
                        currentStep = 2;
                    @endif
                @endif
                
                const stepElements = [
                    document.getElementById('step-1'),
                    document.getElementById('step-2'),
                    document.getElementById('step-3'),
                    document.getElementById('step-4')
                ];
                
                const titles = ["The Core", "The Details", "The Strategy", "The Review"];
                const subtitles = [
                    "Tell us what your product does and who it's for.",
                    "Give your campaign a unique voice and highlight your main value.",
                    "Choose platforms and output language.",
                    "Verify everything is correct before generating."
                ];
                
                const titleEl = document.getElementById('wizard-title');
                const subtitleEl = document.getElementById('wizard-subtitle');
                const progressEl = document.getElementById('wizard-progress');
                const stepTextEl = document.getElementById('wizard-step-text');
                
                const btnBack = document.getElementById('btn-back');
                const btnNext = document.getElementById('btn-next');
                const btnSubmit = document.getElementById('btn-submit');
                const modal = document.getElementById('create-campaign-modal');

                // Set total steps count to 4
                const totalSteps = 4;

                function updateWizardUI() {
                    if(!titleEl) return;
                    // Update Text
                    titleEl.style.opacity = 0;
                    subtitleEl.style.opacity = 0;
                    
                    setTimeout(() => {
                        titleEl.textContent = titles[currentStep - 1];
                        subtitleEl.textContent = subtitles[currentStep - 1];
                        titleEl.style.opacity = 1;
                        subtitleEl.style.opacity = 1;
                    }, 200);

                    // Populate Step 4 review elements if active
                    if (currentStep === 4) {
                        const rDesc = document.getElementById('review-desc');
                        const rAud = document.getElementById('review-audience');
                        const rTone = document.getElementById('review-tone');
                        const rVal = document.getElementById('review-val');
                        const rLang = document.getElementById('review-lang');
                        const rPlat = document.getElementById('review-platforms');
                        
                        if (rDesc) rDesc.textContent = descIn && descIn.value.trim() ? descIn.value.trim() : 'Not provided';
                        if (rAud) rAud.textContent = audIn && audIn.value.trim() ? audIn.value.trim() : 'Not provided';
                        if (rTone) rTone.textContent = toneIn && toneIn.value.trim() ? toneIn.value.trim() : 'Not provided';
                        if (rVal) rVal.textContent = valIn && valIn.value.trim() ? valIn.value.trim() : 'Not provided';
                        
                        if (rLang) {
                            const langSelect = document.querySelector('select[name="language"]');
                            rLang.textContent = langSelect ? langSelect.value : 'English';
                        }
                        if (rPlat) {
                            const checkedPlats = Array.from(document.querySelectorAll('input[name="platforms[]"]:checked')).map(cb => cb.value.toUpperCase());
                            rPlat.textContent = checkedPlats.length > 0 ? checkedPlats.join(', ') : 'None';
                        }
                    }

                    // Update Progress
                    progressEl.style.width = `${(currentStep / totalSteps) * 100}%`;
                    stepTextEl.textContent = `Step ${currentStep}/${totalSteps}`;

                    // Update Steps Classes (Scale and Fade instead of Slide)
                    stepElements.forEach((el, index) => {
                        if (el) {
                            if (index + 1 === currentStep) {
                                el.classList.remove('scale-95', 'opacity-0', 'invisible', 'pointer-events-none');
                                el.classList.add('scale-100', 'opacity-100');
                            } else {
                                el.classList.remove('scale-100', 'opacity-100');
                                el.classList.add('scale-95', 'opacity-0', 'invisible', 'pointer-events-none');
                            }
                        }
                    });

                    // Update Buttons (UX-4: btnBack class show/hide, Cancel button is static)
                    if (currentStep === 1) {
                        btnBack.classList.add('hidden');
                    } else {
                        btnBack.classList.remove('hidden');
                        btnBack.onclick = (e) => {
                            e.preventDefault();
                            if (currentStep > 1) {
                                currentStep--;
                                updateWizardUI();
                            }
                        };
                    }

                    if (currentStep === totalSteps) {
                        btnNext.classList.add('hidden');
                        btnSubmit.classList.remove('hidden');
                    } else {
                        btnNext.classList.remove('hidden');
                        btnSubmit.classList.add('hidden');
                    }
                }

                // Check required fields before proceeding
                function validateCurrentStep() {
                    if(!stepElements[currentStep - 1]) return true;
                    const currentInputs = stepElements[currentStep - 1].querySelectorAll('input[required], textarea[required], select[required]');
                    let isValid = true;
                    currentInputs.forEach(input => {
                        if (!input.value.trim()) {
                            input.classList.add('border-red-500', 'ring-red-500');
                            isValid = false;
                        } else {
                            input.classList.remove('border-red-500', 'ring-red-500');
                        }
                    });
                    return isValid;
                }

                if(btnNext) {
                    btnNext.addEventListener('click', (e) => {
                        e.preventDefault();
                        if (validateCurrentStep() && currentStep < totalSteps) {
                            currentStep++;
                            updateWizardUI();
                        }
                    });
                }

                // Clear validation on input
                document.querySelectorAll('input[required], textarea[required], select[required]').forEach(input => {
                    input.addEventListener('input', () => {
                        input.classList.remove('border-red-500', 'ring-red-500');
                    });
                });
                
                // Initialize
                updateWizardUI();
            });
        </script>
    @endif

    <!-- State B: Campaign Generating (Legendary UI) -->
    @if ($state === 'B')
        <!-- Ambient Grid & Floating Meshes -->
        <div class="fixed inset-0 pointer-events-none -z-20 bg-[radial-gradient(rgba(0,64,224,0.05)_1px,transparent_1px)] [background-size:24px_24px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#0040e0]/5 rounded-full blur-[100px] pointer-events-none -z-10 animate-float"></div>

        <div class="max-w-3xl mx-auto my-6 px-4 sm:px-6 lg:px-8 font-sans relative z-0 flex flex-col items-center justify-center min-h-[calc(100vh-140px)]">
            
            <!-- Elite Glassmorphic Card -->
            <div class="w-full bg-white shadow-[0_30px_80px_rgba(0,0,0,0.08)] border border-[#edeef1] rounded-[32px] p-8 sm:p-12 relative overflow-hidden flex flex-col items-center text-center group">
                
                <!-- Shimmer Effect on Card Edge -->
                <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-[#0040e0]/5 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity duration-1000 pointer-events-none"></div>

                <!-- Custom Pulsing Orb Indicator (Stagger 1) -->
                <div class="relative w-24 h-24 mb-8 flex items-center justify-center stagger-1">
                    <div class="absolute inset-0 border border-[#0040e0]/20 rounded-full scale-[1.8] opacity-0 animate-[ping_4s_cubic-bezier(0,0,0.2,1)_infinite]"></div>
                    <div class="absolute inset-0 border border-[#0040e0]/40 rounded-full scale-[1.4] opacity-20 animate-[ping_3s_cubic-bezier(0,0,0.2,1)_infinite_0.5s]"></div>
                    <div class="absolute inset-0 border-2 border-[#f8f9fc] rounded-full shadow-inner"></div>
                    <div class="absolute inset-0 border-[4px] border-[#0040e0] rounded-full border-t-transparent border-l-transparent animate-spin" style="animation-duration: 1.2s; animation-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);"></div>
                    <!-- Inner Core -->
                    <div class="w-12 h-12 bg-gradient-to-br from-[#0030a8] to-[#0040e0] rounded-full animate-pulse shadow-[0_0_30px_rgba(0,64,224,0.6)] relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-[2px]"></div>
                        <span class="material-symbols-outlined text-white relative z-10 text-[20px]">auto_awesome</span>
                    </div>
                </div>

                <!-- Premium Typography (Stagger 2) -->
                <div class="stagger-2 relative z-10">
                    <h2 class="text-3xl md:text-[38px] leading-[1.1] font-black text-[#191c1e] tracking-tight mb-4 drop-shadow-sm">
                        Synthesizing Campaign
                    </h2>
                    <p class="text-[16px] md:text-[17px] text-[#434656] leading-relaxed max-w-xl mx-auto font-medium">
                        Our AI engine is architecting your 30-day strategy. Stand by while we generate cross-platform content and map optimal delivery windows.
                    </p>
                    <!-- Simulated Time Counter -->
                    <div class="mt-6 flex items-center justify-center gap-4 text-[#434656] text-[12px] uppercase tracking-widest font-bold">
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-[#f8f9fc] rounded-full border border-[#edeef1] shadow-sm">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0040e0] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#0040e0]"></span>
                            </span>
                            Processing
                        </span>
                        <span id="generation-timer" class="font-black text-[#191c1e]">⏱ Elapsed: 0:00</span>
                    </div>
                </div>
                
                <!-- World-Class Terminal UI (Stagger 3) -->
                <div class="mt-8 mb-4 w-full max-w-xl mx-auto text-left relative z-10 transform transition-all hover:-translate-y-1 hover:scale-[1.01] duration-700 ease-out stagger-3">
                    <!-- Terminal Glow -->
                    <div class="absolute -inset-2 bg-gradient-to-r from-[#0040e0] via-[#8ca8ff] to-[#0040e0] rounded-[24px] opacity-10 blur-xl mb-2 group-hover:opacity-30 transition-opacity duration-700"></div>
                    
                    <div class="bg-[#141517] shadow-2xl border border-white/10 rounded-[20px] overflow-hidden relative">
                        <!-- Terminal Header -->
                        <div class="bg-[#191c1e] border-b border-white/5 px-5 py-3 flex items-center justify-between backdrop-blur-md">
                            <div class="flex space-x-2.5 pl-1">
                                <div class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow-inner"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-amber-400 shadow-inner"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 shadow-inner"></div>
                            </div>
                            <div class="text-[#c4c5d9] text-[10px] uppercase font-mono tracking-[0.2em] font-bold select-none flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#8ca8ff] text-[12px]">terminal</span>
                                postpilot-ai-engine
                            </div>
                            <div class="w-10"></div> <!-- Spacer for balance -->
                        </div>
                        
                        <!-- Terminal Body -->
                        <div class="p-5 font-mono text-[12px] leading-[1.7] relative h-[160px] overflow-hidden flex flex-col justify-end" id="terminal-body">
                            <!-- Logs will be injected here via JS -->
                        </div>
                    </div>
                </div>

                <!-- Stealth Cancel Action (Stagger 4) -->
                <div class="mt-8 pt-6 border-t border-[#edeef1] w-full flex justify-center stagger-4 relative z-10">
                    <x-confirm-modal 
                        id="cancel-generation-modal" 
                        :action="route('campaigns.destroy', $campaign->id)" 
                        title="Halt Generation Sequence?" 
                        message="Are you sure you want to cancel? This will discard the current campaign generation. Your connected social accounts will remain untouched."
                        confirmText="Yes, Terminate" 
                        triggerClass="group inline-flex items-center justify-center px-6 py-2 text-[11px] font-black uppercase tracking-widest text-[#434656] hover:text-rose-600 transition-all duration-300 focus:outline-none relative overflow-hidden rounded-[16px]"
                    >
                        <span class="absolute inset-0 bg-rose-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-[16px] -z-10"></span>
                        <span class="material-symbols-outlined mr-2 text-[16px] opacity-60 group-hover:opacity-100 transition-opacity duration-300">cancel</span>
                        <span class="border-b border-transparent group-hover:border-rose-200 transition-colors duration-300 pb-0.5">Halt Sequence</span>
                    </x-confirm-modal>
                </div>
            </div>
        </div>

        <style>
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes float {
                0%, 100% { transform: translate(-50%, -50%) scale(1); }
                50% { transform: translate(-50%, -53%) scale(1.05); }
            }
            .stagger-1 { animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0s forwards; opacity: 0; }
            .stagger-2 { animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.15s forwards; opacity: 0; }
            .stagger-3 { animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards; opacity: 0; }
            .stagger-4 { animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.45s forwards; opacity: 0; }
            .animate-float { animation: float 12s ease-in-out infinite; }
        </style>

        <script>
            (function() {
                const campaignId = {{ $campaign->id }};
                
                // Elite Terminal Log Rotator
                const logMessages = [
                    "Engine operational. Initializing core parameters...",
                    "Analyzing brand tone and parsing psychological triggers...",
                    "Applying structural hooks (Loss Aversion)...",
                    "Generating Week 1: Pattern Interrupt...",
                    "Injecting structural diversity matrices into chunks...",
                    "Synthesizing Week 2: Deep Myth Destruction...",
                    "Mapping optimal cross-platform delivery windows...",
                    "Generating Week 3: Professional Authority Building...",
                    "Optimizing Call-to-Actions for maximum engagement...",
                    "Generating Week 4: Scarcity & Conversion events...",
                    "Running anti-repetition audits across all outputs...",
                    "Finalizing omnichannel formatting..."
                ];
                let logIndex = 0;
                const terminalBody = document.getElementById('terminal-body');
                
                function addLogLine(text, isNewest = true) {
                    if (!terminalBody) return;
                    
                    const line = document.createElement('div');
                    line.className = 'flex items-start mt-2 opacity-0 transition-all duration-500 transform translate-y-3';
                    
                    const timestamp = document.createElement('span');
                    timestamp.className = 'text-slate-500 mr-3 shrink-0 select-none';
                    const now = new Date();
                    timestamp.textContent = now.getHours().toString().padStart(2, '0') + ':' + 
                                          now.getMinutes().toString().padStart(2, '0') + ':' + 
                                          now.getSeconds().toString().padStart(2, '0');
                    
                    const content = document.createElement('span');
                    content.className = isNewest ? 'text-[#8ca8ff] font-bold' : 'text-[#c4c5d9]';
                    content.innerHTML = text;

                    // Add pulsing cursor
                    if (isNewest) {
                        const cursor = document.createElement('span');
                        cursor.className = 'inline-block w-2 h-4 ml-1.5 bg-[#8ca8ff] animate-pulse align-middle shadow-[0_0_10px_rgba(140,168,255,0.7)]';
                        cursor.id = 'terminal-cursor';
                        content.appendChild(cursor);
                    }
                    
                    line.appendChild(timestamp);
                    line.appendChild(content);
                    terminalBody.appendChild(line);
                    
                    // Trigger reflow for smooth animation
                    void line.offsetWidth;
                    line.classList.remove('opacity-0', 'translate-y-3');
                    
                    // Dim previous lines and remove old cursors
                    const previousLines = Array.from(terminalBody.children);
                    if (previousLines.length > 1) {
                        const prevLine = previousLines[previousLines.length - 2];
                        const prevContent = prevLine.children[1];
                        if (prevContent) {
                            prevContent.className = 'text-[#c4c5d9] transition-colors duration-700';
                            const oldCursor = prevLine.querySelector('#terminal-cursor');
                            if (oldCursor) oldCursor.remove();
                        }
                    }

                    // Keep only last 4 lines to prevent overflow, fade out oldest gracefully
                    if (previousLines.length > 4) {
                        const oldestLine = previousLines[0];
                        oldestLine.classList.add('opacity-0', '-translate-y-2');
                        setTimeout(() => oldestLine.remove(), 500);
                    }
                }

                if (terminalBody) {
                    addLogLine("Establishing secure connection to AI core...");
                    setTimeout(() => addLogLine(logMessages[0]), 1500);
                    
                    setInterval(() => {
                        logIndex = (logIndex + 1) % logMessages.length;
                        addLogLine(logMessages[logIndex]);
                    }, 3000);
                }

                let failureCount = 0;
                let startTime = Date.now();
                let timerInterval = setInterval(() => {
                    let elapsed = Math.floor((Date.now() - startTime) / 1000);
                    let mins = Math.floor(elapsed / 60);
                    let secs = elapsed % 60;
                    let timerEl = document.getElementById('generation-timer');
                    if (timerEl) {
                        timerEl.textContent = `⏱ Elapsed: ${mins}:${secs.toString().padStart(2, '0')}`;
                    }
                }, 1000);

                const performPoll = () => {
                    fetch('/campaigns/' + campaignId + '/status')
                        .then(response => {
                            failureCount = 0; // Reset failures on successful response
                            // Soft Timeout
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('text/html')) {
                                clearInterval(pollInterval);
                                clearInterval(timerInterval);
                                document.getElementById('terminal-body').innerHTML = `
                                    <div class="text-amber-400 flex items-center mt-2">
                                        <span class="mr-2">⚠️</span> Session expired. Please reload.
                                    </div>
                                `;
                                return;
                            }
                            
                            // Remove any persistent network warning row
                            const existingWarning = document.getElementById('term-conn-warning');
                            if (existingWarning) existingWarning.remove();
                            
                            return response.json();
                        })
                        .then(data => {
                            if (!data) return;
                            if (data.status === 'ready') {
                                clearInterval(pollInterval);
                                clearInterval(timerInterval);
                                addLogLine("<span class='text-emerald-400'>[SUCCESS] Generation complete. Redirecting...</span>", false);
                                setTimeout(() => window.location.reload(), 1000);
                            } else if (data.status === 'failed_generation') {
                                clearInterval(pollInterval);
                                clearInterval(timerInterval);
                                addLogLine("<span class='text-red-400'>[ERROR] Sequence failed. Restarting...</span>", false);
                                setTimeout(() => window.location.reload(), 1500);
                            }
                        })
                        .catch(err => {
                            console.error('Polling error:', err);
                            failureCount++;
                            
                            // UX-3: Alert user of API connection failure inside the terminal screen
                            if (failureCount >= 3) {
                                const term = document.getElementById('terminal-body');
                                if (term) {
                                    const warningId = 'term-conn-warning';
                                    let warnLine = document.getElementById(warningId);
                                    if (!warnLine) {
                                        warnLine = document.createElement('div');
                                        warnLine.id = warningId;
                                        warnLine.className = 'text-amber-500 font-mono mt-2 flex flex-col items-start gap-2 border border-amber-500/20 bg-amber-500/5 p-3 rounded-xl';
                                        term.appendChild(warnLine);
                                    }
                                    warnLine.innerHTML = `
                                        <div class="flex items-center gap-1.5">
                                            <span>⚠️ Connection interrupted. (Failure count: ${failureCount})</span>
                                        </div>
                                        <button type="button" id="btn-term-retry" class="mt-1 px-3 py-1 bg-amber-500 text-slate-900 rounded font-bold text-xs uppercase hover:bg-amber-600 active:scale-95 transition-all">Retry Now</button>
                                    `;
                                    const retryBtn = document.getElementById('btn-term-retry');
                                    if (retryBtn) {
                                        retryBtn.onclick = () => {
                                            warnLine.innerHTML = '<span>⚡ Retrying connection...</span>';
                                            failureCount = 0;
                                            performPoll();
                                        };
                                    }
                                }
                            }
                        });
                };
                let pollInterval = setInterval(performPoll, 5000);
            })();
        </script>
    @endif

    <!-- State FAILED: Campaign Generation Failed -->
    @if ($state === 'FAILED')
        <!-- Floating Ambient Background elements -->
        <div class="fixed inset-0 pointer-events-none -z-20 bg-[radial-gradient(#f1f5f9_1.5px,transparent_1.5px)] [background-size:32px_32px] opacity-70"></div>
        <div class="glow-circle glow-circle-1"></div>
        <div class="glow-circle glow-circle-2"></div>

        <div class="max-w-2xl mx-auto my-12 px-4 relative z-0">
            <div class="glass-panel border-rose-200/40 bg-rose-50/20 backdrop-blur-md rounded-[32px] p-8 sm:p-12 flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/10 flex items-center justify-center shrink-0 text-rose-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-15h.008v.008H12V6.75Z" />
                    </svg>
                </div>
                <div class="flex-grow">
                    <h3 class="premium-font font-black text-xl text-slate-800 tracking-tight">Campaign Generation Failed</h3>
                    <p class="body-font text-sm text-slate-500 mt-2 leading-relaxed">
                        An error occurred while generating the campaign. This is usually due to temporary API rate limits or LLM parsing errors.
                    </p>
                    @if ($campaign->error_message)
                        <div class="bg-slate-900/90 text-slate-200 rounded-2xl p-4 mt-4 font-mono text-[13px] leading-relaxed border border-slate-800 shadow-xl max-h-40 overflow-y-auto">
                            {{ $campaign->error_message }}
                        </div>
                    @endif
                    <div class="mt-6 flex items-center gap-3">
                        {{-- UX FIX UX-1: Clear campaign instead of deleting project --}}
                        <x-confirm-modal 
                            id="failed-clear-campaign-modal" 
                            :action="route('campaigns.destroy', $campaign->id)" 
                            title="Clear Failed Campaign?" 
                            message="This will discard the failed campaign and allow you to configure a new one. Your connected social accounts will remain untouched."
                            confirmText="Clear Campaign" 
                            triggerClass="btn-action px-6 py-2.5 bg-rose-600 hover:bg-rose-700 active:scale-95 text-white text-xs font-bold rounded-xl tracking-wide uppercase transition-all shadow-md inline-flex items-center"
                        >
                            Clear Campaign & Retry
                        </x-confirm-modal>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- State C: Ready/Scheduled - The Master Calendar -->
    @if ($state === 'C')
        @php 
            $groupedPosts = $posts->groupBy('day_number'); 
            $firstPost = $posts->sortBy('scheduled_at')->first();
            $startDayOfWeek = 1; 
            $startDate = null;
            if ($firstPost) {
                $userTimezone = Auth::user()->timezone ?? 'UTC';
                $startDate = \Carbon\Carbon::parse($firstPost->scheduled_at)->timezone($userTimezone);
                $startDayOfWeek = $startDate->dayOfWeekIso;
            }
            $offset = $startDayOfWeek - 1;
            $totalCells = 30 + $offset;
            $gridCellsCount = (int) ceil($totalCells / 7) * 7;
        @endphp
        
        <style>
            .maestro-calendar-wrapper {
                font-family: 'Inter', sans-serif;
                animation: m-fadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                padding-bottom: 4rem;
            }
            /* The Command Center (Redesigned from the dark pill) */
            /* The Command Center (Executive Ultra-Harmonious Dark Theme) */
            .m-command-dock {
                background: linear-gradient(180deg, #181b1d 0%, #131517 100%);
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                border-radius: 32px;
                padding: 2.5rem 3rem;
                display: flex;
                flex-direction: column;
                gap: 2rem;
                box-shadow: 0 24px 48px -12px rgba(0, 0, 0, 0.5), 
                            inset 0 1px 0 rgba(255, 255, 255, 0.08);
                margin-bottom: 4rem;
                margin-top: 1rem;
                color: #FFFFFF;
                border: 1px solid rgba(255, 255, 255, 0.07);
                transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .m-command-dock:hover {
                border-color: rgba(255, 255, 255, 0.15);
                box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.65), 
                            inset 0 1px 0 rgba(255, 255, 255, 0.12);
            }
            .m-command-dock-top { display: flex; justify-content: space-between; align-items: flex-start; }
            .m-command-info { display: flex; align-items: flex-start; gap: 1.5rem; }
            .m-status-icon {
                width: 44px; height: 44px; border-radius: 14px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
                flex-shrink: 0; color: #FFFFFF; transition: all 0.3s;
            }
            .m-status-icon.is-active { background: rgba(16, 185, 129, 0.12); border-color: rgba(16, 185, 129, 0.25); color: #34D399; box-shadow: 0 0 15px rgba(16, 185, 129, 0.2); }
            
            .m-command-title { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 900; letter-spacing: -0.03em; display: flex; align-items: center; gap: 1rem; line-height: 1.1; margin-bottom: 0.5rem; color: #FFFFFF; }
            .m-command-subtitle { font-size: 0.95rem; color: #94A3B8; font-weight: 500; max-width: 500px; line-height: 1.5; }
            .m-command-badge { padding: 0.3rem 0.8rem; border-radius: 100px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; transform: translateY(-2px); }
            .m-badge-draft { background: rgba(217, 119, 6, 0.15); color: #FBBF24; border: 1px solid rgba(251, 191, 36, 0.25); }
            .m-badge-active { background: rgba(16, 185, 129, 0.12); color: #34D399; border: 1px solid rgba(52, 211, 153, 0.25); }
            .m-badge-paused { background: rgba(217, 119, 6, 0.15); color: #FBBF24; border: 1px solid rgba(251, 191, 36, 0.25); }

            .m-command-actions { display: flex; align-items: center; gap: 1rem; }
            .m-btn-approve {
                background: linear-gradient(135deg, #10B981 0%, #059669 100%);
                color: #fff;
                padding: 1rem 2.5rem;
                border-radius: 16px;
                font-family: 'Outfit', sans-serif;
                font-weight: 800;
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border: none;
                cursor: pointer;
                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .m-btn-approve:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 40px -10px rgba(16, 185, 129, 0.35);
            }
            .m-btn-delete {
                width: 42px; height: 42px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; color: #94A3B8; transition: all 0.3s; cursor: pointer; background: rgba(255,255,255,0.03); flex-shrink: 0;
            }
            .m-btn-delete:hover { background: rgba(220, 38, 38, 0.15); color: #F87171; border-color: rgba(220, 38, 38, 0.3); transform: scale(1.05); }

            /* Sleek Progress Bar for Active Mode */
            .m-progress-container { width: 100%; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.07); }
            .m-progress-stats { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 0.8rem; }
            .m-progress-label { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #94A3B8; }
            .m-progress-value { font-size: 1.25rem; font-weight: 900; font-family: 'Inter', monospace; color: #FFFFFF; }
            .m-progress-track { width: 100%; height: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.05); border-radius: 100px; overflow: hidden; }
            .m-progress-fill { height: 100%; background: linear-gradient(90deg, #10B981 0%, #2DD4BF 100%); border-radius: 100px; transition: width 1s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 0 15px rgba(16, 185, 129, 0.4); }

            /* Infinity Grid Calendar */
            .m-cal-container {
                display: flex;
                flex-direction: column;
                background: transparent;
            }
            
            .m-cal-header {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                margin-bottom: 2rem;
            }
             .m-cal-day-label {
                text-align: center;
                font-size: 0.75rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                color: #A1A1AA;
            }

            .m-cal-grid {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 1px;
                background: rgba(0,0,0,0.06);
                border: 1px solid rgba(0,0,0,0.04);
                border-radius: 32px;
                overflow: hidden;
            }
            
            .m-cal-cell {
                background: #fff;
                min-height: 160px;
                padding: 1.5rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                cursor: pointer;
                position: relative;
                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .m-cal-cell:hover {
                background: #050505;
                transform: scale(1.05);
                z-index: 10;
                border-radius: 24px;
                box-shadow: 0 30px 60px rgba(0,0,0,0.3);
            }
            .m-cal-cell.is-empty { background: #F8F9FA; pointer-events: none; }
            
            .m-cal-date {
                font-size: 1.5rem;
                font-weight: 900;
                color: #0A0A0A;
                transition: color 0.5s;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .m-cal-cell:hover .m-cal-date { color: #fff; }

            .m-cal-posts-badge {
                font-size: 0.65rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: rgba(255,255,255,0.6);
                background: rgba(255,255,255,0.1);
                padding: 0.3rem 0.8rem;
                border-radius: 100px;
                opacity: 0;
                transform: translateY(10px);
                transition: all 0.4s;
            }
            .m-cal-cell:hover .m-cal-posts-badge { opacity: 1; transform: translateY(0); }

            .m-cal-platforms {
                display: flex;
                gap: 0.5rem;
                align-items: flex-end;
            }
            .m-platform-dot {
                width: 6px; height: 6px; border-radius: 50%;
                background: #D4D4D8;
                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .m-cal-cell:hover .m-platform-dot { width: 14px; height: 14px; }
            .m-cal-cell:hover .m-dot-linkedin { background: #0a66c2; box-shadow: 0 0 15px rgba(10,102,194,0.6); }
            .m-cal-cell:hover .m-dot-twitter, .m-cal-cell:hover .m-dot-x { background: #fff; box-shadow: 0 0 15px rgba(255,255,255,0.6); }
            .m-cal-cell:hover .m-dot-facebook { background: #1877F2; box-shadow: 0 0 15px rgba(24,119,242,0.6); }
            
            .m-cal-check {
                width: 24px; height: 24px; border-radius: 50%; background: #10B981; display: flex; align-items: center; justify-content: center; color: #fff;
                opacity: 0; transform: scale(0); transition: all 0.4s;
            }
            .m-cal-cell:hover .m-cal-check.is-published { opacity: 1; transform: scale(1); }

            @keyframes m-fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
            @keyframes m-pulse { 0% { transform: scale(1); opacity: 0.4; } 70% { transform: scale(2.5); opacity: 0; } 100% { transform: scale(1); opacity: 0; } }

            @media (max-width: 768px) {
                .m-command-dock { flex-direction: column; gap: 2rem; padding: 2rem; border-radius: 24px; align-items: flex-start; }
                .m-command-actions { width: 100%; justify-content: space-between; }
                .m-cal-header { display: none; }
                .m-cal-grid { grid-template-columns: 1fr; gap: 1rem; background: transparent; border: none; }
                .m-cal-cell { border: 1px solid rgba(0,0,0,0.1); border-radius: 24px; min-height: 120px; }
                .m-cal-cell:hover { transform: translateY(-5px); }
            }
        </style>

        <!-- Floating Ambient Background elements -->
        <div class="fixed inset-0 pointer-events-none -z-20 bg-[radial-gradient(#f1f5f9_1.5px,transparent_1.5px)] [background-size:32px_32px] opacity-70"></div>
        <div class="glow-circle glow-circle-1"></div>
        <div class="glow-circle glow-circle-2"></div>

        <div class="maestro-calendar-wrapper max-w-7xl mx-auto relative z-0">
            <!-- Dynamic Command Center -->
            <div class="m-command-dock">
                @if ($campaign->status === 'completed')
                    <!-- Draft Mode -->
                    <div class="m-command-dock-top">
                        <div class="m-command-info">
                            <div class="m-status-icon">✨</div>
                            <div>
                                <h2 class="m-command-title">
                                    {{ $project->name }}
                                    <span class="m-command-badge m-badge-draft">Draft</span>
                                </h2>
                                @php
                                    $platformCounts = $posts->groupBy(function($post) { return strtolower($post->platform); })->map->count();
                                @endphp
                                <p class="m-command-subtitle">
                                    30 days of content generated. Review below.
                                </p>
                            </div>
                        </div>
                        <div class="m-command-actions">
                            @if(auth()->user()->hasCampaignCredits(1))
                                <x-confirm-modal 
                                    id="approve-campaign-modal" 
                                    :action="route('campaigns.approve', $campaign->id)" 
                                    method="POST"
                                    type="approve"
                                    title="Confirm Campaign Launch (1 Credit)" 
                                    message="Launching this 30-day campaign will consume 1 Campaign Credit ($9.99 value) from your balance. Your 30 days of omnichannel posts will be scheduled for autopilot publishing. Are you sure you want to proceed?"
                                    confirmText="Yes, Launch Campaign (1 Credit)" 
                                    triggerClass="m-btn-approve cursor-pointer"
                                >
                                    Approve & Launch (1 Credit)
                                </x-confirm-modal>
                            @else
                                <a href="{{ route('profile.edit', ['tab' => 'billing', 'error' => 'credits_required']) }}" class="m-btn-approve flex items-center gap-2 text-center no-underline">
                                    <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
                                    Buy 1 Credit to Launch
                                </a>
                            @endif
                            <x-confirm-modal 
                                id="delete-project-modal" 
                                :action="route('projects.destroy', $project->id)" 
                                title="Delete Project?" 
                                message="This will permanently delete the project and all campaigns. Irreversible. Note: Deleting an active campaign will NOT refund your credit."
                                confirmText="Delete Project" 
                                triggerClass="m-btn-delete"
                            >
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </x-confirm-modal>
                        </div>
                    </div>
                @else
                    <!-- Active Mode -->
                    <div class="m-command-dock-top">
                        <div class="m-command-info">
                            <div class="m-status-icon {{ $campaign->status === 'active' ? 'is-active' : '' }}" style="{{ $campaign->status === 'paused' ? 'background: #FEF3C7; border-color: #FDE68A; color: #D97706;' : '' }}">
                                @if ($campaign->status === 'active')
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" /></svg>
                                @endif
                            </div>
                            <div>
                                <h2 class="m-command-title">
                                    {{ $project->name }}
                                    @if ($campaign->status === 'active')
                                        <span class="m-command-badge m-badge-active">Active</span>
                                    @elseif ($campaign->status === 'paused')
                                        <span class="m-command-badge m-badge-paused">Paused</span>
                                    @else
                                        <span class="m-command-badge m-badge-draft">{{ ucfirst($campaign->status) }}</span>
                                    @endif
                                </h2>
                                @php
                                    $publishedDaysCount = $groupedPosts->filter(function($dayPosts) {
                                        return $dayPosts->contains('status', 'published');
                                    })->count();
                                @endphp
                                @if ($campaign->status === 'active')
                                    <p class="m-command-subtitle">
                                        Autopilot is running. Your audience is being engaged automatically.
                                    </p>
                                @elseif ($campaign->status === 'paused')
                                    <p class="m-command-subtitle">
                                        Autopilot is paused. Publishing has been suspended.
                                    </p>
                                @else
                                    <p class="m-command-subtitle">
                                        Autopilot is in {{ $campaign->status }} mode.
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="m-command-actions flex items-center gap-3">
                            <form action="{{ route('campaigns.togglePause', $campaign->id) }}" method="POST" class="m-0 p-0" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                                @csrf
                                @if ($campaign->status === 'active')
                                    <button type="submit" class="btn-action inline-flex items-center px-4 py-2 bg-amber-500/10 border border-amber-500/25 text-amber-300 rounded-xl font-bold text-xs uppercase tracking-wider shadow-sm hover:bg-amber-500/20 hover:border-amber-500/40 active:scale-95 transition-all cursor-pointer">
                                        ⏸ Pause Autopilot
                                    </button>
                                @elseif ($campaign->status === 'paused')
                                    <button type="submit" class="btn-action inline-flex items-center px-4 py-2 bg-emerald-500/10 border border-emerald-500/25 text-emerald-300 rounded-xl font-bold text-xs uppercase tracking-wider shadow-sm hover:bg-emerald-500/20 hover:border-emerald-500/40 active:scale-95 transition-all cursor-pointer">
                                        ▶ Resume Autopilot
                                    </button>
                                @endif
                            </form>

                            @php
                                $hasPublishedOrPublishing = $posts->contains(function($post) {
                                    return in_array($post->status, ['published', 'publishing']);
                                });
                            @endphp
                            @if (!$hasPublishedOrPublishing)
                                <form action="{{ route('campaigns.revokeApproval', $campaign->id) }}" method="POST" class="m-0 p-0" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                                    @csrf
                                    <button type="submit" class="btn-action inline-flex items-center px-4 py-2 bg-white/[0.05] border border-white/10 text-slate-300 rounded-xl font-bold text-xs uppercase tracking-wider shadow-sm hover:bg-white/10 hover:text-white active:scale-95 transition-all cursor-pointer" title="Revert all posts to draft to allow editing">
                                        ↩ Revoke Approval
                                    </button>
                                </form>
                            @endif

                            @php
                                $publishedCount = $posts->whereIn('status', ['published', 'publishing'])->count();
                            @endphp

                            @if($publishedCount > 0)
                                <x-confirm-modal 
                                    id="delete-project-modal-active" 
                                    :action="route('projects.destroy', $project->id)" 
                                    type="delete"
                                    title="Delete Project & Active Campaign?" 
                                    message="Warning: {{ $publishedCount }} post(s) have already been published on your social channels. Deleting this campaign now will NOT refund the 1 Credit spent. Are you sure you want to proceed?"
                                    confirmText="Delete Project" 
                                    triggerClass="m-btn-delete"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </x-confirm-modal>
                            @else
                                <x-confirm-modal 
                                    id="delete-project-modal-active" 
                                    :action="route('projects.destroy', $project->id)" 
                                    type="refund"
                                    title="Delete & Refund 1 Credit?" 
                                    message="Notice: 0 posts have been published yet. Deleting this campaign will AUTOMATICALLY refund 1 Campaign Credit back to your balance!"
                                    confirmText="Delete & Refund Credit" 
                                    triggerClass="m-btn-delete"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </x-confirm-modal>
                            @endif
                        </div>
                    </div>
                    
                    <div class="m-progress-container">
                        <div class="m-progress-stats">
                            <span class="m-progress-label">Campaign Progress</span>
                            <span class="m-progress-value">{{ $publishedDaysCount }} / 30 <span style="font-size: 0.75rem; color: #94A3B8; font-weight: 700; margin-left: 0.2rem;">DAYS</span></span>
                        </div>
                        <div class="m-progress-track">
                            <div class="m-progress-fill" style="width: {{ ($publishedDaysCount / 30) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- UX-2: Persistent Connection Outage/Alert Bar inside Active Command Dock -->
                    <div class="mt-6 pt-5 border-t border-white/10 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider premium-font">Active Channels:</span>
                            <div class="flex items-center gap-3">
                                @foreach (['twitter', 'linkedin', 'facebook'] as $plat)
                                    @php
                                        $acc = $project->socialAccounts->firstWhere('provider', $plat);
                                        $isConn = (bool)$acc;
                                        $isQuar = $acc && $acc->quarantined_until && $acc->quarantined_until->isFuture();
                                        $isNonPremium = $acc && strtolower($plat) === 'twitter' && $acc->is_premium === false;
                                    @endphp
                                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-xs font-medium backdrop-blur-md transition-all {{ $isConn ? ($isNonPremium ? 'bg-amber-500/10 text-amber-200 border-amber-500/30' : ($isQuar ? 'bg-rose-500/15 text-rose-300 border-rose-500/30 animate-pulse' : 'bg-white/[0.04] text-slate-200 border-white/[0.08] hover:border-white/20')) : 'opacity-40 bg-white/[0.02] text-slate-500 border-white/[0.05]' }}">
                                        @if($plat === 'twitter')
                                            <svg class="w-3.5 h-3.5 fill-current text-slate-300" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        @elseif($plat === 'linkedin')
                                            <svg class="w-3.5 h-3.5 fill-current text-slate-300" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                        @elseif($plat === 'facebook')
                                            <svg class="w-3.5 h-3.5 fill-current text-slate-300" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        @endif
                                        <span class="capitalize font-semibold text-[10px]">{{ $plat }}</span>
                                        @if($isConn && $acc && $acc->username)
                                            <span class="text-slate-400 font-normal text-[10px]">({{ $acc->username }})</span>
                                        @endif
                                        @if($isConn)
                                            @if($isNonPremium)
                                                <button type="button" onclick="alert('⚠️ X (Twitter) Premium Required:\n\nYour connected Twitter account (@{{ $acc->username }}) is a standard Free Twitter account (280-character limit).\n\nYour 30-day AI campaign posts are published seamlessly to Facebook and LinkedIn. To enable automated publishing on X (Twitter), please upgrade your account to X Premium / Blue.')" class="text-amber-300 hover:text-amber-100 font-extrabold ml-1 inline-flex items-center gap-0.5 cursor-pointer bg-amber-500/20 px-1.5 py-0.5 rounded text-[9px] border border-amber-500/30 transition-colors" title="Click for details: X Premium Required">
                                                    ⚠️ <span class="underline">Non-Premium</span>
                                                </button>
                                            @elseif($isQuar)
                                                <span class="text-rose-400 font-bold ml-1" title="OAuth Interrupted">Outage</span>
                                            @else
                                                <span class="text-emerald-400 font-bold ml-1">✓</span>
                                            @endif
                                        @else
                                            <span class="text-slate-600 ml-1">(-)</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @php
                            $twitterAcc = $project->socialAccounts->firstWhere('provider', 'twitter');
                        @endphp
                        @if($twitterAcc && $twitterAcc->is_premium === false)
                            <div class="w-full flex items-center justify-between bg-amber-500/[0.08] border border-amber-500/20 rounded-2xl px-4 py-3 text-xs text-amber-200 mt-3 backdrop-blur-md">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-base">⚠️</span>
                                    <div>
                                        <span class="font-bold text-amber-200">X (Twitter) Account @<span>{{ $twitterAcc->username }}</span> is Standard Free (280-char limit).</span>
                                        <span class="text-[11px] text-amber-300/80 block mt-0.5">Long-form AI campaign posts are published to Facebook & LinkedIn. Upgrade @<span>{{ $twitterAcc->username }}</span> to X Premium to enable Twitter publishing.</span>
                                    </div>
                                </div>
                                <button type="button" onclick="document.getElementById('twitter-premium-modal').showModal()" class="bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 font-bold px-3 py-1.5 rounded-xl text-[10px] uppercase tracking-wider shrink-0 border border-amber-500/30 transition-all cursor-pointer">
                                    Why Twitter Skipped?
                                </button>
                            </div>
                        @endif

                        @if ($project->socialAccounts->contains(function($account) { return $account->quarantined_until && $account->quarantined_until->isFuture(); }))
                            <div class="flex flex-col gap-2 mt-4">
                                @foreach ($project->socialAccounts as $account)
                                    @if ($account->quarantined_until && $account->quarantined_until->isFuture())
                                        <div class="flex items-center justify-between bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 text-xs text-amber-800 animate-pulse">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                <span>Your <strong>{{ ucfirst($account->provider) }}</strong> token has expired and requires re-authorization.</span>
                                            </div>
                                            <a href="javascript:void(0)" onclick="openOAuthWindow('{{ URL::signedRoute('social-accounts.connect-popup', ['project' => $project->id, 'platform' => $account->provider]) }}', '{{ $account->provider }}'); return false;" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-3 py-1 rounded-lg shadow-sm transition-colors uppercase tracking-wider text-[10px]">Reconnect</a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Infinity Grid Calendar -->
            <div class="m-cal-container">
                <div class="m-cal-header">
                    <div class="m-cal-day-label">Mon</div>
                    <div class="m-cal-day-label">Tue</div>
                    <div class="m-cal-day-label">Wed</div>
                    <div class="m-cal-day-label">Thu</div>
                    <div class="m-cal-day-label">Fri</div>
                    <div class="m-cal-day-label">Sat</div>
                    <div class="m-cal-day-label">Sun</div>
                </div>

                <div class="m-cal-grid">
                    @for ($i = 1; $i <= $gridCellsCount; $i++)
                        @php
                            $dayNumber = $i - $offset;
                        @endphp
                        @if ($i > $offset && $dayNumber <= 30)
                            @php 
                                $dayPosts = $groupedPosts->get($dayNumber, collect()); 
                                $hasPublished = !$dayPosts->isEmpty() && $dayPosts->contains('status', 'published');
                                $hasFailed = !$dayPosts->isEmpty() && $dayPosts->contains('status', 'failed');
                                $currentDate = $startDate ? $startDate->copy()->addDays($dayNumber - 1) : null;
                            @endphp
                            <div class="m-cal-cell relative {{ $hasFailed ? 'border-2 border-rose-300 hover:border-rose-500 bg-rose-50/20' : '' }}" onclick="openDayDrawer({{ $dayNumber }})">
                                @if($hasFailed)
                                    <span class="absolute top-2 right-2 flex h-2 w-2" title="Action Required: Publishing Failed">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                    </span>
                                @endif
                                <div class="m-cal-date flex items-baseline justify-between w-full">
                                    @if ($currentDate)
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">
                                                {{ $currentDate->day }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest">{{ $currentDate->format('M') }}</span>
                                        </div>
                                    @else
                                        <span class="text-2xl font-extrabold text-slate-900 tracking-tight leading-none">{{ $dayNumber }}</span>
                                    @endif
                                    
                                    @if (!$dayPosts->isEmpty())
                                        <span class="m-cal-posts-badge">{{ $dayPosts->count() }} Posts</span>
                                    @endif
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                                    <div class="m-cal-platforms">
                                        @if (!$dayPosts->isEmpty())
                                            @php
                                                $dots = [];
                                                foreach($dayPosts as $dp) {
                                                    if ($dp->platform === 'omnichannel') {
                                                        $dots = array_merge($dots, $project->platforms ?? []);
                                                    } else {
                                                        $dots[] = $dp->platform;
                                                    }
                                                }
                                                $uniqueDots = collect($dots)->map(function($p) { return strtolower($p); })->unique()->take(4);
                                            @endphp
                                            @foreach ($uniqueDots as $platform)
                                                <div class="m-platform-dot m-dot-{{ $platform }}" title="{{ ucfirst($platform) }}"></div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="m-cal-check {{ $hasPublished ? 'is-published' : '' }}">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="m-cal-cell is-empty"></div>
                        @endif
                    @endfor
                </div>
            </div>
        </div>

        <!-- The Editorial Brutalist Side-Drawer -->
        <style>
            @keyframes slideUpFadeManifest {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
        <div id="day-drawer-overlay" class="fixed inset-0 bg-black/45 backdrop-blur-md z-[60] hidden opacity-0 transition-opacity duration-300" onclick="closeDayDrawer()"></div>
        
        <div id="day-drawer" class="fixed top-0 right-0 h-full w-full max-w-lg bg-white/75 backdrop-blur-xl shadow-[-20px_0_50px_rgba(0,0,0,0.15)] z-[70] transform translate-x-full transition-transform duration-500 ease-out flex flex-col border-l-2 border-black">
            <!-- Drawer Header (Brutalist) -->
            <div class="px-8 py-8 border-b-2 border-black bg-transparent flex flex-col relative z-10">
                <!-- Top Row: Meta & Close -->
                <div class="flex justify-between items-start mb-8">
                    <div class="inline-flex items-center gap-2">
                        <div class="w-3 h-3 bg-black"></div>
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest font-mono">Flight Manifest</span>
                    </div>
                    <button onclick="closeDayDrawer()" class="text-gray-400 hover:text-black transition-colors focus:outline-none">
                        <span class="text-[12px] font-bold font-mono tracking-widest uppercase border-b border-transparent hover:border-black transition-all">[ CLOSE ]</span>
                    </button>
                </div>
                
                <!-- Title Row -->
                <div class="flex items-end gap-6">
                    <div class="flex items-baseline gap-2">
                        <span class="text-[24px] font-bold text-black uppercase tracking-tighter">Day</span>
                        <div id="drawer-day-badge" class="text-[72px] font-extrabold text-black leading-[0.8] tracking-tighter font-mono">1</div>
                    </div>
                    <div class="mb-2">
                        <h3 class="text-[20px] font-extrabold text-black tracking-tight">Scheduled Output</h3>
                        <p id="drawer-post-count" class="text-[13px] font-mono text-gray-500 uppercase tracking-widest mt-1">0 payloads ready</p>
                    </div>
                </div>
            </div>

            <!-- Drawer Content (Scrollable) -->
            <div class="flex-1 overflow-y-auto bg-transparent relative">
                <!-- Exact Grid Background (Subtle) -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIC41aDQwTTAgMjAuNWg0ME0yMC41IDB2NDBNLjUgMHY0MCIgc3Ryb2tlPSJyZ2JhKDAsIDAsIDAsIDAuMDMpIi8+PC9zdmc+')] pointer-events-none z-0"></div>

                <div id="drawer-content-container" class="relative z-10 flex flex-col p-6 pt-0">
                    <!-- Brutalist AI Warning Alert inside Drawer -->
                    <div class="mb-6 bg-yellow-50 border-2 border-black p-4 relative shadow-[4px_4px_0px_rgba(0,0,0,1)] flex items-start gap-3">
                        <span class="material-symbols-outlined text-black shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">warning</span>
                        <div>
                            <h4 class="text-[13px] font-black text-black uppercase tracking-tight mb-1">Human Review Required</h4>
                            <p class="text-[12px] font-medium text-gray-800 leading-relaxed">
                                AI may hallucinate offers (like "Free Shipping"). Review and edit this content to match your real business before launching.
                            </p>
                        </div>
                    </div>

                    <!-- Dynamic content will be injected here via JS -->
                </div>
            </div>
            
            <!-- Brutalist Footer/Colophon inside drawer -->
            <div class="border-t-2 border-black bg-white/40 backdrop-blur-md p-5 flex justify-between items-center z-10">
                <span class="text-[11px] font-bold text-gray-400 font-mono uppercase tracking-widest">Engine // Active</span>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-black animate-pulse"></div>
                    <span class="text-[11px] font-bold text-black font-mono uppercase tracking-widest">System Ready</span>
                </div>
            </div>
        </div>

        <!-- Hidden JSON Data for JS -->
        @php
            $userTimezone = Auth::user()->timezone ?? 'UTC';
            $campaignDataArray = $groupedPosts->map(function($posts) use ($project, $userTimezone) {
                return $posts->map(function($post) use ($project, $userTimezone) {
                    $platforms = $post->platform === 'omnichannel' ? ($project->platforms ?? []) : [$post->platform];
                    return [
                        'id' => $post->id,
                        'platform' => $post->platform,
                        'platforms' => $platforms,
                        'content' => $post->content,
                        'time' => $post->scheduled_at ? \Carbon\Carbon::parse($post->scheduled_at)->timezone($userTimezone)->format('h:i A') : 'TBD',
                        'status' => $post->status,
                    ];
                });
            });
        @endphp
        <script>
            const campaignData = @json($campaignDataArray);

            const updateRouteBase = "{{ url('/posts') }}"; // Base URL for updates

            function getPlatformIcon(platform) {
                const p = platform.toLowerCase();
                if (p === 'facebook') {
                    return `<svg class="w-3.5 h-3.5 fill-[#1877F2] shrink-0" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>`;
                }
                if (p === 'linkedin') {
                    return `<svg class="w-3.5 h-3.5 fill-[#0A66C2] shrink-0" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>`;
                }

                if (p === 'twitter' || p === 'x') {
                    return `<svg class="w-3.5 h-3.5 fill-black shrink-0" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>`;
                }
                return '';
            }

            function openDayDrawer(day) {
                const drawer = document.getElementById('day-drawer');
                const overlay = document.getElementById('day-drawer-overlay');
                const container = document.getElementById('drawer-content-container');
                const badge = document.getElementById('drawer-day-badge');
                const count = document.getElementById('drawer-post-count');

                badge.textContent = day.toString().padStart(2, '0');
                const posts = campaignData[day] || [];
                count.textContent = `${posts.length} payload${posts.length !== 1 ? 's' : ''} ready`;

                // UX-12: Render skeleton loader blocks for 250ms
                container.innerHTML = `
                    <div class="p-8 space-y-8 animate-pulse">
                        <div class="space-y-3">
                            <div class="h-4 bg-slate-200 rounded-full w-2/5"></div>
                            <div class="h-10 bg-slate-100 rounded-xl w-full"></div>
                        </div>
                        <div class="space-y-3">
                            <div class="h-4 bg-slate-200 rounded-full w-1/3"></div>
                            <div class="h-20 bg-slate-100 rounded-xl w-full"></div>
                        </div>
                    </div>
                `;

                // Show Drawer
                overlay.classList.remove('hidden');
                // Trigger reflow
                void overlay.offsetWidth;
                overlay.classList.remove('opacity-0');
                
                drawer.classList.remove('translate-x-full');

                // Delay populating actual posts content to allow smooth transition
                setTimeout(() => {
                    let html = '';
                    if (posts.length === 0) {
                        html = `
                            <div class="p-12 flex flex-col items-center justify-center text-center border-b border-gray-200">
                                <div class="w-16 h-16 border-2 border-black flex items-center justify-center mb-6 bg-white/80">
                                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                <h4 class="text-[18px] font-extrabold text-black uppercase tracking-widest mb-2">Rest Day</h4>
                                <p class="text-gray-500 text-[14px] font-medium max-w-xs">Zero payloads scheduled. System resting to avoid audience fatigue.</p>
                            </div>
                        `;
                    } else {
                        posts.forEach((post, index) => {
                            const delay = index * 50; // ms
                            
                            let platformBadges = '';
                            if (post.platform === 'omnichannel') {
                                post.platforms.forEach(p => {
                                    platformBadges += `
                                        <div class="border-2 border-black px-2.5 py-1 bg-white/90 rounded-md flex items-center gap-2 shadow-sm">
                                            ${getPlatformIcon(p)}
                                            <span class="text-[10px] font-bold text-black uppercase tracking-wider font-mono">${p.toUpperCase()}</span>
                                        </div>
                                    `;
                                });
                            } else {
                                platformBadges = `
                                    <div class="border-2 border-black px-2.5 py-1 bg-white/90 rounded-md flex items-center gap-2 shadow-sm">
                                        ${getPlatformIcon(post.platform)}
                                        <span class="text-[10px] font-bold text-black uppercase tracking-wider font-mono">${post.platform.toUpperCase()}</span>
                                    </div>
                                `;
                            }

                            html += `
                                <div 
                                    class="group relative border-b border-black/10 bg-white/50 hover:bg-white/75 backdrop-blur-sm p-8 transition-colors duration-200"
                                    style="animation: slideUpFadeManifest 0.4s ease-out ${delay}ms forwards; opacity: 0; transform: translateY(10px);"
                                    data-content="${escapeHtml(post.content)}"
                                >
                                    <!-- Brutalist Post Header -->
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="inline-flex flex-wrap items-center gap-3">
                                            <span class="font-mono text-gray-400 font-bold text-[13px] tracking-wider">[ DAY ${post.day < 10 ? '0' + post.day : post.day} ]</span>
                                            ${platformBadges}
                                            <span class="text-[11px] font-bold text-gray-700 bg-gray-100 px-2.5 py-0.5 border border-gray-200 font-mono uppercase tracking-widest flex items-center gap-1">
                                                <svg class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                ${post.time}
                                            </span>
                                        </div>

                                        <!-- Micro Actions -->
                                        <div class="flex items-center gap-2 transition-opacity duration-200">
                                            <button onclick="const btn=this; navigator.clipboard.writeText(btn.closest('.group').dataset.content); const original=btn.innerHTML; btn.innerHTML='<span class=\'material-symbols-outlined text-[14px]\'>check</span><span class=\'hidden sm:inline\'>Copied</span>'; btn.classList.add('bg-green-50','text-green-700','border-green-200'); setTimeout(()=>{btn.innerHTML=original; btn.classList.remove('bg-green-50','text-green-700','border-green-200');}, 2000);" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-[#edeef1] text-[11px] font-extrabold text-[#434656] hover:bg-[#f8f9fc] hover:text-black hover:border-gray-300 hover:shadow-sm uppercase tracking-widest transition-all">
                                                <span class="material-symbols-outlined text-[14px]">content_copy</span>
                                                <span class="hidden sm:inline">Copy</span>
                                            </button>
                                            ${(post.status === 'published' || post.status === 'publishing') ? `
                                                <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-50 border border-gray-100 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest cursor-not-allowed select-none">
                                                    <span class="material-symbols-outlined text-[14px]">lock</span>
                                                    <span class="hidden sm:inline">Locked</span>
                                                </span>
                                            ` : `
                                                <button onclick="triggerEditModal(${post.id}, this.closest('.group').dataset.content, '${post.platform}')" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-[#edeef1] text-[11px] font-extrabold text-[#434656] hover:bg-black hover:text-white hover:border-black hover:shadow-sm uppercase tracking-widest transition-all">
                                                    <span class="material-symbols-outlined text-[14px]">edit</span>
                                                    <span class="hidden sm:inline">Edit</span>
                                                </button>
                                            `}
                                        </div>
                                    </div>
                                    
                                    <!-- Modern Autopilot Status Badge -->
                                    <div class="mb-4 flex items-center justify-between gap-2">
                                        <span class="text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5
                                            ${post.status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 
                                              post.status === 'publishing' ? 'bg-sky-50 text-sky-700 border border-sky-200/60 animate-pulse' : 
                                              post.status === 'failed' ? 'bg-rose-50 text-rose-700 border border-rose-200/60' :
                                              post.status === 'approved' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/60' : 'bg-slate-100 text-slate-600 border border-slate-200/60'}">
                                            ${post.status === 'published' ? '⚡ Published Automatically via Autopilot' : 
                                              post.status === 'publishing' ? '🚀 Publishing via Autopilot...' : 
                                              post.status === 'approved' ? '🕒 Scheduled for Autopilot' : 
                                              '📝 Strategy Draft'}
                                        </span>
                                    </div>
                                    
                                    <!-- Content Typography -->
                                    <div class="relative">
                                        <p class="text-black text-[15px] font-medium leading-relaxed whitespace-pre-wrap selection:bg-black selection:text-white">${escapeHtml(post.content)}</p>
                                    </div>
                                </div>
                            `;
                        });
                    }
                    container.innerHTML = html;
                }, 250);
            }

            function closeDayDrawer() {
                const drawer = document.getElementById('day-drawer');
                const overlay = document.getElementById('day-drawer-overlay');
                
                drawer.classList.add('translate-x-full');
                overlay.classList.add('opacity-0');
                
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }

            // Helper to escape HTML for dataset attributes
            function escapeHtml(unsafe) {
                return unsafe
                     .replace(/&/g, "&amp;")
                     .replace(/</g, "&lt;")
                     .replace(/>/g, "&gt;")
                     .replace(/"/g, "&quot;")
                     .replace(/'/g, "&#039;");
            }

            // Helper to unescape and trigger modal
            function triggerEditModal(id, content, platform) {
                const modal = document.getElementById('edit-post-modal');
                // Force modal to be on top of the drawer
                modal.classList.add('z-[80]');
                
                const url = updateRouteBase + '/' + id;
                if(typeof openEditModal === 'function') {
                    openEditModal(id, content, url, platform);
                }
            }
        </script>

        <style>
            @keyframes slideUpFade {
                0% { opacity: 0; transform: translateY(20px); }
                100% { opacity: 1; transform: translateY(0); }
            }
        </style>

        <dialog id="edit-post-modal" class="modal bg-slate-950/80 backdrop-blur-lg">
                <div class="modal-box !bg-[#191c1e] !text-white border border-white/10 rounded-[24px] max-w-5xl w-[95vw] p-0 overflow-hidden shadow-2xl flex flex-col" style="background-color: #191c1e !important; color: #ffffff !important; height: 80vh !important; max-height: 80vh !important; display: flex !important; flex-direction: column !important;">
                    <header class="flex items-center justify-between px-7 py-4 border-b border-white/10 relative z-10 bg-[#16181a] shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                            <h3 class="text-base font-bold text-white tracking-tight">Refine Content</h3>
                        </div>
                        <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white transition-all border border-white/10" onclick="document.getElementById('edit-post-modal').close()">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                            </svg>
                        </button>
                    </header>
                    
                    <main class="p-6 relative z-0 bg-[#191c1e] flex-1 flex flex-col overflow-hidden" style="background-color: #191c1e !important; flex: 1 1 auto !important; display: flex !important; flex-direction: column !important; overflow: hidden !important;">
                        <form 
                            id="edit-post-form" 
                            method="POST" 
                            action="{{ old('modal_post_id') ? route('posts.update', old('modal_post_id')) : '#' }}" 
                            onsubmit="this.querySelectorAll('button[type=submit]').forEach(b => { b.disabled = true; b.classList.add('opacity-50', 'cursor-not-allowed'); b.innerHTML = '<span class=\'material-symbols-outlined text-[16px] animate-spin\'>progress_activity</span> Saving...'; })"
                            class="flex-1 flex flex-col gap-4 overflow-hidden"
                            style="flex: 1 1 auto !important; display: flex !important; flex-direction: column !important;"
                        >
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="modal_post_id" id="edit-post-id" value="{{ old('modal_post_id') }}" />
                            
                            <div class="flex-1 flex flex-col w-full relative overflow-hidden" style="flex: 1 1 auto !important; display: flex !important;">
                                <textarea 
                                    name="content"
                                    id="content"
                                    dir="auto"
                                    style="background-color: #111315 !important; color: #ffffff !important; outline: none !important; border: 1px solid rgba(255, 255, 255, 0.12) !important; height: 500px !important; min-height: 500px !important; flex: 1 1 auto !important;"
                                    class="w-full h-full min-h-[500px] !bg-[#111315] !text-white rounded-[16px] p-6 text-[16px] leading-[1.75] font-normal tracking-wide focus:border-emerald-500/60 focus:ring-1 focus:ring-emerald-500/40 outline-none transition-all placeholder-slate-500 custom-scrollbar resize-none relative z-10 @error('content') border-rose-500 ring-2 ring-rose-500/20 @enderror"
                                    placeholder="Craft your AI-generated narrative..."
                                    required
                                >{{ old('content') }}</textarea>
                                @error('content')
                                    <span class="text-rose-500 text-xs mt-1 block font-semibold body-font flex items-center gap-1.5 z-20">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="flex justify-between items-center pt-2 shrink-0">
                                <div class="text-xs text-slate-300 font-mono flex items-center gap-1 bg-[#111315] px-3.5 py-1.5 rounded-[10px] border border-white/10">
                                    <span id="char-count" class="text-emerald-400 font-bold">0</span>
                                    <span class="opacity-40">/</span>
                                    <span id="char-limit-display" class="text-slate-400">3000</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button type="button" class="px-5 py-2 rounded-[12px] border border-white/15 text-slate-300 text-sm font-medium hover:bg-white/5 hover:text-white transition-all" onclick="document.getElementById('edit-post-modal').close()">Cancel</button>
                                    <button type="submit" class="px-6 py-2 rounded-[12px] bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold shadow-lg shadow-emerald-900/30 transition-all flex items-center gap-2 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </main>
                </div>
            </dialog>

            <script>
                let editModalOriginalContent = '';
                let editModalDirty = false;

                function openEditModal(postId, content, actionUrl, platform) {
                    editModalOriginalContent = content;
                    editModalDirty = false;

                    document.getElementById('edit-post-id').value = postId;
                    const textarea = document.getElementById('content');
                    if (textarea) textarea.value = content;
                    document.getElementById('edit-post-form').action = actionUrl;
                    
                    let normalizedPlatform = platform ? platform.toLowerCase() : '';
                    let charLimit = (normalizedPlatform === 'twitter' || normalizedPlatform === 'x') ? 280 : 3000;
                    
                    const charLimitDisplay = document.getElementById('char-limit-display');
                    if (charLimitDisplay) charLimitDisplay.textContent = charLimit;
                    
                    const updatePreview = () => {
                        if (textarea) {
                            const charCount = textarea.value.length;
                            const charCountEl = document.getElementById('char-count');
                            if (charCountEl) {
                                charCountEl.textContent = charCount;
                                charCountEl.className = charCount > charLimit ? 'text-rose-400 font-bold' : 'text-emerald-400 font-bold';
                            }
                            
                            editModalDirty = textarea.value !== editModalOriginalContent;
                            if (editModalDirty) {
                                try {
                                    sessionStorage.setItem('edit_post_backup_' + postId, textarea.value);
                                } catch(e) {}
                            }
                        }
                    };
                    
                    try {
                        const backup = sessionStorage.getItem('edit_post_backup_' + postId);
                        if (backup && backup !== content) {
                            if (confirm('A previous unsaved edit for this post was found. Would you like to restore it?')) {
                                if (textarea) textarea.value = backup;
                            } else {
                                sessionStorage.removeItem('edit_post_backup_' + postId);
                            }
                        }
                    } catch(e) {}
                    
                    if (textarea) textarea.oninput = updatePreview;
                    updatePreview();
                    document.getElementById('edit-post-modal').showModal();
                }
            </script>
        </div>
    @endif

    {{-- UX FIX UX-2: Styled modal warning when no social accounts are linked --}}
    <dialog id="no-socials-warning-modal" class="modal bg-slate-950/40 backdrop-blur-md">
        <div class="modal-box p-10 max-w-md rounded-[32px] bg-white border border-slate-100 shadow-2xl relative text-center">
            <button class="btn btn-sm btn-circle btn-ghost text-slate-400 hover:text-slate-900 bg-slate-50/80 border border-slate-100 shadow-sm" style="position: absolute !important; right: 24px !important; top: 24px !important; left: auto !important; width: 32px !important; height: 32px !important; min-height: 32px !important; padding: 0 !important; display: flex !important; align-items: center !important; justify-content: center !important; z-index: 50 !important;" onclick="document.getElementById('no-socials-warning-modal').close()">✕</button>
            
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 ring-1 ring-inset ring-amber-100 shadow-sm mb-6">
                <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <h3 class="premium-font text-2xl font-black text-slate-900 tracking-tight">Social Accounts Required</h3>
            <p class="body-font text-slate-500 text-sm mt-3 leading-relaxed">
                Please connect at least one social media channel (X, LinkedIn, or Facebook) on the left panel before creating your campaign.
            </p>
            
            <div class="mt-8 pt-6 border-t border-slate-100">
                <button type="button" class="btn-premium bg-slate-900 hover:bg-black text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition-all w-full" onclick="document.getElementById('no-socials-warning-modal').close()">
                    Understood, Let's Connect
                </button>
            </div>
        </div>
    </dialog>

    {{-- Custom Styled Executive Dark Modal for X (Twitter) Premium Warning --}}
    <dialog id="twitter-premium-modal" class="modal bg-slate-950/85 backdrop-blur-md">
        <div class="modal-box !bg-[#191c1e] !text-white border border-amber-500/20 rounded-[28px] max-w-lg w-[90vw] p-8 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9)] relative text-center overflow-hidden" style="background-color: #191c1e !important; color: #ffffff !important;">
            <div class="h-1 w-full bg-gradient-to-r from-amber-500 via-orange-500 to-amber-400 absolute top-0 left-0"></div>
            
            <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white transition-all border border-white/10 absolute right-5 top-5 z-20" onclick="document.getElementById('twitter-premium-modal').close()">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                </svg>
            </button>

            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 border border-amber-500/20 shadow-inner mb-5">
                <span class="text-2xl">⚠️</span>
            </div>

            <h3 class="text-xl font-bold text-white tracking-tight flex items-center justify-center gap-2">
                X (Twitter) Premium Requirement
            </h3>
            
            <div class="mt-4 space-y-3 text-sm text-slate-300 leading-relaxed text-left bg-[#111315] p-5 rounded-2xl border border-white/10" style="background-color: #111315 !important;">
                <p>
                    Standard (Free) X accounts are limited to <strong class="text-amber-400 font-semibold">280 characters</strong> per post.
                </p>
                <p>
                    Automated 30-day AI campaign narratives average <strong class="text-emerald-400 font-semibold">1,300+ characters</strong> for high conversion and maximum audience reach.
                </p>
                <div class="pt-3 border-t border-white/10 text-xs text-slate-400 flex items-start gap-2">
                    <span class="text-amber-400 shrink-0">💡</span>
                    <span>To enable automated X publishing, upgrade your X account to <strong class="text-white font-semibold">X Premium / Blue</strong>, or continue automated publishing to Facebook & LinkedIn.</span>
                </div>
            </div>

            <div class="mt-6">
                <button type="button" class="w-full py-3 rounded-xl bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 font-semibold text-sm border border-amber-500/30 transition-all cursor-pointer shadow-lg shadow-amber-900/20" onclick="document.getElementById('twitter-premium-modal').close()">
                    Understood
                </button>
            </div>
        </div>
    </dialog>

    <!-- OAuth Connection Modal Overlay (Strategy 2: Hybrid UX Bridge) -->
    <div id="oauth-overlay" class="fixed inset-0 z-[9999] hidden">
        <!-- Backdrop with blur -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-md transition-opacity duration-500"></div>
        
        <!-- Centered glass panel -->
        <div class="absolute inset-0 flex items-center justify-center p-6">
            <div class="relative w-full max-w-md bg-white/90 backdrop-blur-2xl border border-white/60 rounded-3xl shadow-2xl overflow-hidden transition-all duration-500 transform">
                <!-- Decorative blobs -->
                <div class="absolute -top-20 -left-20 w-56 h-56 rounded-full bg-[#0040e0]/15 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -right-20 w-56 h-56 rounded-full bg-[#0040e0]/10 blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10 p-10 text-center">
                    <!-- Platform icon container -->
                    <div id="oauth-overlay-icon" class="inline-flex items-center justify-center w-20 h-20 rounded-[1.25rem] shadow-xl mb-6 transition-all duration-500"></div>
                    
                    <!-- Title -->
                    <h2 id="oauth-overlay-title" class="text-2xl font-extrabold text-[#191c1e] tracking-tight mb-2"></h2>
                    
                    <!-- Subtitle / Status -->
                    <p id="oauth-overlay-status" class="text-[#191c1e]/60 text-sm font-medium mb-8 max-w-xs mx-auto leading-relaxed"></p>
                    
                    <!-- Progress / Spinner (shown during waiting) -->
                    <div id="oauth-overlay-spinner" class="flex items-center justify-center gap-3 text-[#0040e0] text-sm font-bold bg-[#0040e0]/5 py-3 px-6 rounded-xl w-max mx-auto mb-6">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="oauth-overlay-spinner-text">Waiting for authorization...</span>
                    </div>

                    <!-- Facebook Specific Warning -->
                    <div id="oauth-facebook-warning" class="hidden mb-6 text-left bg-amber-50 border border-amber-200 rounded-xl p-4 shadow-inner">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <p class="text-amber-800 text-sm font-medium leading-relaxed">
                                <strong>Important:</strong> On the Facebook screen, click <span class="bg-amber-100 px-1.5 py-0.5 rounded border border-amber-200 font-bold whitespace-nowrap">Edit Settings</span> and select <strong>ALL</strong> your pages, or they will be hidden from our system!
                            </p>
                        </div>
                    </div>
                    
                    <!-- Action Button (hidden during waiting, shown on success/error) -->
                    <button id="oauth-overlay-btn" class="hidden w-full py-4 text-white font-bold text-base rounded-2xl transition-all shadow-lg active:scale-95 duration-300 hover:-translate-y-0.5">
                    </button>
                    
                    <!-- Cancel link -->
                    <button id="oauth-overlay-cancel" onclick="dismissOAuthOverlay(true)" class="mt-4 text-sm text-[#191c1e]/50 hover:text-[#191c1e]/80 font-medium transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Global UX Enhancements & Context Retention Scripts -->
    <script>
        // 0. Global showToast utility
        window.showToast = function(message, type = 'success') {
            const alertClass = type === 'error' ? 'alert-error' : (type === 'warning' ? 'alert-warning' : (type === 'info' ? 'alert-info' : 'alert-success'));
            const toast = document.createElement('div');
            toast.className = 'toast toast-top toast-end z-[999] mt-16';
            toast.innerHTML = `
                <div class="alert ${alertClass} shadow-lg text-white font-bold">
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        };

        // OAuth Popup communication message handler (UX-4)
        window.addEventListener('message', (event) => {
            if (event.data && event.data.type === 'oauth-complete') {
                const success = event.data.success;
                const provider = event.data.provider;
                const msg = event.data.message || '';
                if (success) {
                    window.showToast(`✅ ${provider} connected successfully!`, 'success');
                    setTimeout(() => window.location.reload(), 1200);
                } else {
                    window.showToast(`❌ Connection failed: ${msg}`, 'error');
                }
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            // 1. Re-open Day Drawer if redirected back with open_day session variable
            @if (session('open_day'))
                if (typeof openDayDrawer === 'function') {
                    openDayDrawer({{ session('open_day') }});
                }
            @endif

            // 2. Re-open Campaign Wizard if validation fails during creation
            @if ($errors->any() && old('description'))
                const campaignModal = document.getElementById('create-campaign-modal');
                if (campaignModal) {
                    campaignModal.showModal();
                }
            @endif

            // 3. Re-open Edit Post Modal modally (with backdrop, preview, char count initialized)
            @if (old('modal_post_id'))
                const oldId = "{{ old('modal_post_id') }}";
                const oldContent = `{!! addslashes(old('content')) !!}`;
                let oldPlatform = 'twitter';
                
                if (typeof campaignData !== 'undefined') {
                    for (const day in campaignData) {
                        const posts = campaignData[day];
                        const post = posts.find(p => p.id == oldId);
                        if (post) {
                            oldPlatform = post.platform;
                            break;
                        }
                    }
                }
                const actionUrl = "{{ url('/posts') }}/" + oldId;
                if (typeof openEditModal === 'function') {
                    openEditModal(oldId, oldContent, actionUrl, oldPlatform);
                }
            @endif

            // 4. Modal Intercepts and Close Confirmations (UX-1, UX-3)
            const campaignModal = document.getElementById('create-campaign-modal');
            let wizardDirty = false;
            const wizardForm = document.getElementById('campaign-wizard-form');
            if (wizardForm) {
                wizardForm.querySelectorAll('input, textarea, select').forEach(input => {
                    input.addEventListener('input', () => { wizardDirty = true; });
                    input.addEventListener('change', () => { wizardDirty = true; });
                });
                
                // UX-2: Disable cancel/back buttons during form submissions
                wizardForm.addEventListener('submit', () => {
                    wizardDirty = false; // Reset on submit
                    document.querySelectorAll('#campaign-wizard-form button:not([type=submit]), #create-campaign-modal button').forEach(b => {
                        b.disabled = true;
                        b.classList.add('opacity-50', 'cursor-not-allowed');
                        b.style.pointerEvents = 'none';
                    });
                });
            }

            if (campaignModal) {
                campaignModal.addEventListener('cancel', (e) => {
                    if (wizardDirty) {
                        if (!confirm('You have unsaved changes in the campaign wizard. Are you sure you want to close?')) {
                            e.preventDefault();
                        } else {
                            wizardDirty = false;
                        }
                    }
                });

                // Bind close button prompt
                campaignModal.querySelectorAll('[onclick*="create-campaign-modal"]').forEach(btn => {
                    btn.onclick = (e) => {
                        if (wizardDirty) {
                            if (confirm('You have unsaved changes in the campaign wizard. Are you sure you want to close?')) {
                                wizardDirty = false;
                                campaignModal.close();
                            }
                        } else {
                            campaignModal.close();
                        }
                    };
                });
            }

            const editModal = document.getElementById('edit-post-modal');
            const editForm = document.getElementById('edit-post-form');
            if (editModal) {
                editModal.addEventListener('cancel', (e) => {
                    if (typeof editModalDirty !== 'undefined' && editModalDirty) {
                        if (!confirm('You have unsaved changes to this post. Are you sure you want to close?')) {
                            e.preventDefault();
                        } else {
                            editModalDirty = false;
                        }
                    }
                });

                // Bind close buttons
                editModal.querySelectorAll('[onclick*="edit-post-modal"]').forEach(btn => {
                    btn.onclick = (e) => {
                        if (typeof editModalDirty !== 'undefined' && editModalDirty) {
                            if (confirm('You have unsaved changes to this post. Are you sure you want to close?')) {
                                const postId = document.getElementById('edit-post-id').value;
                                sessionStorage.removeItem('edit_post_backup_' + postId);
                                editModalDirty = false;
                                editModal.close();
                            }
                        } else {
                            editModal.close();
                        }
                    };
                });
            }

            if (editForm) {
                editForm.addEventListener('submit', () => {
                    if (typeof editModalDirty !== 'undefined') editModalDirty = false;
                    const postId = document.getElementById('edit-post-id').value;
                    sessionStorage.removeItem('edit_post_backup_' + postId);
                    
                    // UX-2: Disable cancel/back buttons during form submissions
                    const submitBtn = editForm.querySelector('button[type=submit]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block align-middle" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Saving...
                        `;
                    }
                    document.querySelectorAll('#edit-post-form button:not([type=submit]), #edit-post-modal button').forEach(b => {
                        b.disabled = true;
                        b.classList.add('opacity-50', 'cursor-not-allowed');
                        b.style.pointerEvents = 'none';
                    });
                });
            }
        });

    // --- PostPeer OAuth: Hybrid UX Bridge + Visual Perimeter Minimization ---
    // Strategy 2+3: Opens popup minimized at bottom-right, shows glassmorphism overlay
    // in parent window, and uses user-gesture-driven cleanup on success/error.
    
    let _oauthPopupRef = null;
    let _oauthWindowName = null;
    let _oauthPollTimer = null;
    
    const platformMeta = {
        facebook: {
            name: 'Facebook',
            gradient: 'background: linear-gradient(135deg, #1877F2, #42A5F5)',
            icon: '<svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
            shadow: 'box-shadow: 0 15px 35px -5px rgba(24,119,242,0.4)'
        },
        linkedin: {
            name: 'LinkedIn',
            gradient: 'background: linear-gradient(135deg, #0077b5, #00a0dc)',
            icon: '<svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
            shadow: 'box-shadow: 0 15px 35px -5px rgba(0,119,181,0.4)'
        },
        x: {
            name: 'X (Twitter)',
            gradient: 'background: linear-gradient(135deg, #191c1e, #434656)',
            icon: '<svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
            shadow: 'box-shadow: 0 15px 35px -5px rgba(25,28,30,0.4)'
        }
    };

    function showOAuthOverlay(platform, state) {
        const meta = platformMeta[platform] || platformMeta.x;
        const overlay = document.getElementById('oauth-overlay');
        const iconEl = document.getElementById('oauth-overlay-icon');
        const titleEl = document.getElementById('oauth-overlay-title');
        const statusEl = document.getElementById('oauth-overlay-status');
        const spinnerEl = document.getElementById('oauth-overlay-spinner');
        const spinnerTextEl = document.getElementById('oauth-overlay-spinner-text');
        const btnEl = document.getElementById('oauth-overlay-btn');
        const cancelEl = document.getElementById('oauth-overlay-cancel');

        iconEl.innerHTML = meta.icon;
        iconEl.style.cssText = meta.gradient + ';' + meta.shadow;

        const fbWarningEl = document.getElementById('oauth-facebook-warning');
        if (fbWarningEl) {
            if (platform === 'facebook' && state === 'waiting') {
                fbWarningEl.classList.remove('hidden');
            } else {
                fbWarningEl.classList.add('hidden');
            }
        }

        if (state === 'waiting') {
            titleEl.textContent = 'Connecting to ' + meta.name;
            statusEl.textContent = 'Please complete the authentication in the secondary window. This overlay will update automatically.';
            spinnerEl.classList.remove('hidden');
            spinnerTextEl.textContent = 'Waiting for authorization...';
            btnEl.classList.add('hidden');
            cancelEl.classList.remove('hidden');
        } else if (state === 'success') {
            titleEl.textContent = meta.name + ' Connected!';
            statusEl.textContent = 'Your account has been linked successfully. Click below to continue setting up your page.';
            spinnerEl.classList.add('hidden');
            btnEl.classList.remove('hidden');
            btnEl.textContent = 'Continue to Page Selection →';
            btnEl.className = btnEl.className.replace(/hidden/g, '').trim();
            btnEl.classList.add('w-full', 'py-4', 'text-white', 'font-bold', 'text-base', 'rounded-2xl', 'transition-all', 'shadow-lg', 'active:scale-95', 'duration-300', 'hover:-translate-y-0.5');
            btnEl.style.cssText = 'background: linear-gradient(135deg, #22c55e, #16a34a); box-shadow: 0 10px 25px -5px rgba(34,197,94,0.4);';
            cancelEl.classList.add('hidden');
        } else if (state === 'connected') {
            titleEl.textContent = meta.name + ' Reconnected!';
            statusEl.textContent = 'Your account token has been refreshed successfully.';
            spinnerEl.classList.add('hidden');
            btnEl.classList.remove('hidden');
            btnEl.textContent = 'Return to Dashboard →';
            btnEl.className = btnEl.className.replace(/hidden/g, '').trim();
            btnEl.classList.add('w-full', 'py-4', 'text-white', 'font-bold', 'text-base', 'rounded-2xl', 'transition-all', 'shadow-lg', 'active:scale-95', 'duration-300', 'hover:-translate-y-0.5');
            btnEl.style.cssText = 'background: linear-gradient(135deg, #22c55e, #16a34a); box-shadow: 0 10px 25px -5px rgba(34,197,94,0.4);';
            cancelEl.classList.add('hidden');
        } else if (state === 'error') {
            titleEl.textContent = 'Connection Issue';
            statusEl.textContent = 'This account is already connected to another project. Please disconnect it first.';
            spinnerEl.classList.add('hidden');
            btnEl.classList.remove('hidden');
            btnEl.textContent = 'Return to Dashboard';
            btnEl.className = btnEl.className.replace(/hidden/g, '').trim();
            btnEl.classList.add('w-full', 'py-4', 'text-white', 'font-bold', 'text-base', 'rounded-2xl', 'transition-all', 'shadow-lg', 'active:scale-95', 'duration-300', 'hover:-translate-y-0.5');
            btnEl.style.cssText = 'background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 10px 25px -5px rgba(239,68,68,0.4);';
            cancelEl.classList.add('hidden');
        } else if (state === 'timeout') {
            titleEl.textContent = 'Connection Timed Out';
            statusEl.textContent = 'The authorization took too long. Please try again.';
            spinnerEl.classList.add('hidden');
            btnEl.classList.remove('hidden');
            btnEl.textContent = 'Close';
            btnEl.className = btnEl.className.replace(/hidden/g, '').trim();
            btnEl.classList.add('w-full', 'py-4', 'text-white', 'font-bold', 'text-base', 'rounded-2xl', 'transition-all', 'shadow-lg', 'active:scale-95', 'duration-300', 'hover:-translate-y-0.5');
            btnEl.style.cssText = 'background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 10px 25px -5px rgba(245,158,11,0.4);';
            cancelEl.classList.add('hidden');
        }

        overlay.classList.remove('hidden');
        // Trigger entrance animation
        requestAnimationFrame(() => {
            overlay.style.opacity = '1';
        });
    }

    function dismissOAuthOverlay(cancelPolling = false) {
        if (cancelPolling && _oauthPollTimer) {
            clearInterval(_oauthPollTimer);
            _oauthPollTimer = null;
        }
        const overlay = document.getElementById('oauth-overlay');
        overlay.style.opacity = '0';
        setTimeout(() => {
            overlay.classList.add('hidden');
            overlay.style.opacity = '';
        }, 400);
    }

    // Attempt to close the orphaned popup using Transient Activation (user gesture)
    function attemptPopupCleanup() {
        // Method 1: Direct reference
        try {
            if (_oauthPopupRef && !_oauthPopupRef.closed) {
                _oauthPopupRef.close();
            }
        } catch (e) {}
        
        // Method 2: Fixed named window targeting
        try {
            const popupNames = ['PostPeerOAuthWindow', 'PostPeerAuthWin'];
            popupNames.forEach(name => {
                try {
                    const winRef = window.open('', name);
                    if (winRef) {
                        winRef.close();
                    }
                } catch (e) {}
            });
        } catch (e) {}
    }

    function openOAuthWindow(url, platform) {
        const popupWidth = 600;
        const popupHeight = 750;
        
        // Calculate center position
        const left = (window.screen.availWidth / 2) - (popupWidth / 2);
        const top = (window.screen.availHeight / 2) - (popupHeight / 2);
        
        _oauthWindowName = 'PostPeerOAuthWindow';
        const features = `width=${popupWidth},height=${popupHeight},left=${left},top=${top},menubar=no,toolbar=no,location=yes,status=no,resizable=yes`;
        _oauthPopupRef = window.open(url, _oauthWindowName, features);
        
        if (!_oauthPopupRef || _oauthPopupRef.closed || typeof _oauthPopupRef.closed === 'undefined') {
            alert('Popup blocker is active. Please allow popups for this site to connect your account.');
            return false;
        }

        // Strategy 2: Show the Hybrid UX Bridge overlay
        showOAuthOverlay(platform, 'waiting');

        const checkStatusUrl = '{{ route("social-accounts.check-status", ["project" => $project->id]) }}';
        let attempts = 0;
        const maxAttempts = 150; // Poll for up to 5 minutes
        
        _oauthPollTimer = setInterval(() => {
            attempts++;
            if (attempts > maxAttempts) {
                clearInterval(_oauthPollTimer);
                _oauthPollTimer = null;
                showOAuthOverlay(platform, 'timeout');
                const btn = document.getElementById('oauth-overlay-btn');
                btn.onclick = function() {
                    attemptPopupCleanup();
                    dismissOAuthOverlay();
                };
                return;
            }
            
            checkIntegrationStatus(checkStatusUrl, platform);
        }, 2000);
        
        return false;
    }

    function checkIntegrationStatus(url, platform) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                const btn = document.getElementById('oauth-overlay-btn');

                // CASE 1: Rejected (duplicate account on another project)
                if (data.rejected && data.rejected.includes(platform)) {
                    if (_oauthPollTimer) { clearInterval(_oauthPollTimer); _oauthPollTimer = null; }
                    attemptPopupCleanup();
                    showOAuthOverlay(platform, 'error');
                    btn.onclick = function() {
                        dismissOAuthOverlay();
                        window.location.href = window.location.pathname + '?error=duplicate_account_' + platform;
                    };
                    return;
                }

                // CASE 2: Needs page selection (new integration detected)
                if (data.needs_selection && data.needs_selection.includes(platform)) {
                    if (_oauthPollTimer) { clearInterval(_oauthPollTimer); _oauthPollTimer = null; }
                    // Auto-close popup immediately so the user isn't stuck viewing raw JSON
                    attemptPopupCleanup();
                    dismissOAuthOverlay();
                    window.location.href = '/projects/{{ $project->id }}/socials/' + platform + '/select-page';
                    return;
                }
                
                // CASE 3: Already connected (existing integration confirmed)
                if (data.connected && data.connected.includes(platform)) {
                    if (_oauthPollTimer) { clearInterval(_oauthPollTimer); _oauthPollTimer = null; }
                    // Auto-close popup immediately
                    attemptPopupCleanup();
                    dismissOAuthOverlay();
                    window.location.reload();
                    return;
                }
            })
            .catch(err => console.error('Polling error:', err));
    }
    </script>
</x-app-layout>
