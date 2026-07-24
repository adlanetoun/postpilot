<x-app-layout>
    <!-- Premium Styles (Global mesh-gradient and fonts now handle the base) -->

    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-[13px] font-medium text-[#434656]">
                    <span class="material-symbols-outlined animate-spin-slow text-[#c4c5d9]">sync</span>
                    <span class="font-bold tracking-wider uppercase text-[#191c1e]">PostPilot</span>
                </div>
                <span class="text-[#c4c5d9] font-light">/</span>
                <h1 class="text-[14px] font-bold text-[#191c1e] tracking-tight">{{ __('Dashboard') }}</h1>
            </div>
        </div>
    </x-slot>

    <!-- Alert Banner for Flash Messages & Validation Errors -->
    <div class="max-w-[1400px] mx-auto px-6 sm:px-12 lg:px-16 pt-6 relative z-10">
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50/50 backdrop-blur-md border border-emerald-200/50 flex items-center gap-2" role="alert">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <div class="premium-font font-semibold"><span class="font-bold">Success:</span> {{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50/50 backdrop-blur-md border border-rose-200/50 flex items-center gap-2" role="alert">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <div class="premium-font font-semibold"><span class="font-bold">Error:</span> {{ session('error') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50/50 backdrop-blur-md border border-rose-200/50 flex flex-col gap-2" role="alert">
                <div class="flex items-center gap-2 font-bold premium-font text-rose-700">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span>Validation Error:</span>
                </div>
                <ul class="list-disc pl-5 space-y-1 text-xs body-font text-rose-600 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    @if ($state === 'A')
        <!-- Removed overlay backgrounds to let global mesh-gradient shine -->

        <div class="max-w-[1400px] mx-auto my-16 px-6 sm:px-12 lg:px-16 relative z-0">
            <!-- Staggered Hero Section -->
            <div class="flex flex-col xl:flex-row items-start xl:items-end justify-between gap-8 xl:gap-12 mb-20 relative z-10">
                <div class="max-w-3xl">
                    <h2 class="text-[56px] lg:text-[76px] leading-[1.05] font-black tracking-tighter text-[#191c1e]">
                        Welcome to <br/>
                        <span class="text-[#0040e0] relative inline-block">
                            PostPilot
                        </span>
                    </h2>
                </div>
                <div class="max-w-md xl:pb-6">
                    <p class="text-[17px] text-[#434656] font-medium leading-relaxed border-l-2 border-[#0040e0]/30 pl-6">
                        Initialize your first project to start automating your social presence across all major platforms with unparalleled precision.
                    </p>
                </div>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">
                <!-- Main CTA -->
                <div class="lg:col-span-7 bg-[#191c1e] text-white rounded-[24px] p-12 sm:p-16 relative overflow-hidden group hover:shadow-2xl transition-all duration-300 flex flex-col justify-between min-h-[400px]">
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-[#2a2d3e] rounded-[16px] flex items-center justify-center mb-8">
                            <span class="material-symbols-outlined text-[32px] text-white">bolt</span>
                        </div>
                        
                        <h3 class="text-[40px] lg:text-[48px] leading-[1.1] font-black tracking-tighter mb-4 text-white">
                            Automate <span class="text-[#0040e0]">30 Days</span><br/>of Content.
                        </h3>
                        <p class="text-[16px] text-[#c4c5d9] max-w-md leading-relaxed font-medium">
                            Create a project, connect your social accounts, and let our AI engine generate a full month of highly-targeted posts.
                        </p>
                    </div>

                    <div class="mt-12 relative z-10">
                        <button onclick="document.getElementById('create-project-modal').showModal()" class="bg-white text-[#191c1e] hover:bg-[#0040e0] hover:text-white inline-flex items-center justify-center px-8 py-4 text-[16px] font-bold rounded-xl transition-colors w-max">
                            Create First Project
                        </button>
                    </div>
                </div>

                <!-- Right Side Bento Tiles -->
                <div class="lg:col-span-5 flex flex-col gap-8">
                    <div class="bg-[#ffffff] border border-[#c4c5d9] rounded-[24px] p-10 flex-1 flex flex-col justify-center transition-all duration-300 shadow-[20px_40px_60px_-15px_rgba(26,26,45,0.04)] hover:border-[#0040e0]">
                        <div class="w-14 h-14 rounded-xl bg-[#edeef1] text-[#434656] flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-[28px]">folder_open</span>
                        </div>
                        <h4 class="text-[20px] font-bold text-[#191c1e] mb-3 tracking-tight">Project-Based Architecture</h4>
                        <p class="text-[15px] text-[#434656] font-medium leading-relaxed">
                            Organize multiple brands, clients, or products into separate spaces. Each project has its own social connections and campaigns.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($state === 'LIST')
        <!-- Removed overlay backgrounds to let global mesh-gradient shine -->

        <div class="max-w-[1400px] mx-auto py-12 px-6 sm:px-12 lg:px-16 relative">
            
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-6 relative z-10">
                <div>
                    <h2 class="text-[36px] lg:text-[46px] font-extrabold text-black tracking-tighter mb-2 leading-tight">Projects Workspace</h2>
                    <p class="text-gray-600 text-[16px] font-medium leading-relaxed">Manage your brand spaces & 30-day automated publishing pipelines.</p>
                </div>
                
                <button onclick="document.getElementById('create-project-modal').showModal()" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-black text-white text-[14px] font-bold transition-all hover:bg-gray-800 cursor-pointer">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    <span>Create Project</span>
                </button>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($projects as $proj)
                    @php
                        $campaign = $proj->campaigns->first();
                        $socials = $proj->socialAccounts->pluck('provider')->toArray();
                        $hasTwitter = in_array('twitter', $socials);
                        $hasLinkedin = in_array('linkedin', $socials);
                        $hasFacebook = in_array('facebook', $socials);
                    @endphp
                    
                    <a href="{{ route('projects.show', $proj->id) }}" class="group relative bg-white rounded-[24px] border border-[#edeef1] overflow-hidden flex flex-col hover:border-[#0040e0]/40 transition-all duration-500 hover:shadow-[0_20px_40px_-15px_rgba(25,28,30,0.08)] hover:-translate-y-1 z-10">
                    
                    <!-- Background Hover Pattern (Subtle Dots) -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none bg-[radial-gradient(#0040e0_1px,transparent_1px)] [background-size:24px_24px] opacity-[0.03]"></div>

                    <!-- Top Glow Accent -->
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#0040e0]/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    <div class="p-7 flex-1 flex flex-col relative z-10">
                        <!-- Header Row -->
                        <div class="flex justify-between items-start mb-5">
                            <div class="w-12 h-12 rounded-[16px] bg-[#f8f9fc] text-[#0040e0] flex items-center justify-center group-hover:bg-[#0040e0] group-hover:text-white transition-all duration-500 shadow-sm border border-[#edeef1] group-hover:border-[#0040e0] group-hover:shadow-[0_8px_16px_-6px_rgba(0,64,224,0.4)]">
                                <span class="material-symbols-outlined text-[22px]">auto_awesome_mosaic</span>
                            </div>
                            
                            <!-- Campaign Status Badge (Refined) -->
                            @if ($campaign)
                                @if ($campaign->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-extrabold bg-[#eef2ff] text-[#0040e0] uppercase tracking-widest ring-1 ring-[#0040e0]/10 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#0040e0] animate-pulse"></span>
                                        Active
                                    </span>
                                @elseif ($campaign->status === 'generating')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-extrabold bg-[#f8f9fc] text-[#434656] uppercase tracking-widest ring-1 ring-[#edeef1] shadow-sm">
                                        <span class="material-symbols-outlined text-[14px] animate-spin">sync</span>
                                        Generating
                                    </span>
                                @elseif ($campaign->status === 'failed_generation')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-extrabold bg-rose-50 text-rose-700 uppercase tracking-widest ring-1 ring-rose-200 shadow-sm">
                                        <span class="material-symbols-outlined text-[14px]">error</span>
                                        Failed
                                    </span>
                                @elseif ($campaign->status === 'paused')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-700 uppercase tracking-widest ring-1 ring-amber-200 shadow-sm">
                                        Paused
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-extrabold bg-[#f8f9fc] text-[#434656] uppercase tracking-widest ring-1 ring-[#edeef1] shadow-sm">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-extrabold bg-white text-[#434656] uppercase tracking-widest ring-1 ring-[#edeef1] shadow-sm transition-colors group-hover:bg-[#f8f9fc] group-hover:text-[#0040e0] group-hover:ring-[#0040e0]/20">
                                    <span class="material-symbols-outlined text-[12px]">tune</span>
                                    Setup Required
                                </span>
                            @endif
                        </div>

                        <!-- Project Title & Meta -->
                        <div class="mb-6">
                            <h3 class="text-[20px] font-black text-[#191c1e] mb-1 truncate group-hover:text-[#0040e0] transition-colors">{{ $proj->name }}</h3>
                            <p class="text-[12px] text-[#434656] font-medium opacity-70 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                Created {{ $proj->created_at->format('M d, Y') }}
                            </p>
                        </div>

                        <!-- Social Integrations (Inline & Elegant) -->
                        <div class="mt-auto pt-6 border-t border-[#edeef1] flex items-center justify-between group-hover:border-[#0040e0]/10 transition-colors">
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] font-extrabold text-[#434656] uppercase tracking-widest opacity-70">Integrations</span>
                                <div class="flex items-center gap-1.5">
                                    <!-- Twitter -->
                                    <div class="w-7 h-7 rounded-[8px] flex items-center justify-center transition-all duration-300 {{ $hasTwitter ? 'bg-[#191c1e] text-white shadow-sm' : 'bg-[#f8f9fc] border border-[#edeef1] text-[#c4c5d9]' }}" title="{{ $hasTwitter ? 'X (Twitter)' : 'Not Connected' }}">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </div>
                                    <!-- LinkedIn -->
                                    <div class="w-7 h-7 rounded-[8px] flex items-center justify-center transition-all duration-300 {{ $hasLinkedin ? 'bg-[#0040e0] text-white shadow-sm' : 'bg-[#f8f9fc] border border-[#edeef1] text-[#c4c5d9]' }}" title="{{ $hasLinkedin ? 'LinkedIn' : 'Not Connected' }}">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    </div>
                                    <!-- Facebook -->
                                    <div class="w-7 h-7 rounded-[8px] flex items-center justify-center transition-all duration-300 {{ $hasFacebook ? 'bg-[#1877F2] text-white shadow-sm' : 'bg-[#f8f9fc] border border-[#edeef1] text-[#c4c5d9]' }}" title="{{ $hasFacebook ? 'Facebook' : 'Not Connected' }}">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Arrow -->
                            <div class="w-8 h-8 rounded-full bg-[#f8f9fc] border border-[#edeef1] flex items-center justify-center group-hover:bg-[#0040e0] group-hover:border-[#0040e0] group-hover:text-white text-[#c4c5d9] transition-all duration-300 shadow-sm">
                                <span class="material-symbols-outlined text-[16px] -rotate-45 group-hover:rotate-0 transition-transform duration-500">arrow_forward</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Project Creation Modal -->
    <dialog id="create-project-modal" class="modal bg-[#191c1e]/60 backdrop-blur-md">
        <div class="modal-box p-10 max-w-md rounded-[24px] bg-white border border-[#c4c5d9] shadow-2xl relative">
            <button class="btn btn-sm btn-circle btn-ghost text-[#434656] hover:text-[#191c1e] bg-[#edeef1] border border-[#c4c5d9]" style="position: absolute !important; right: 24px !important; top: 24px !important; left: auto !important; width: 32px !important; height: 32px !important; min-height: 32px !important; padding: 0 !important; display: flex !important; align-items: center !important; justify-content: center !important; z-index: 50 !important;" onclick="document.getElementById('create-project-modal').close()">✕</button>
            
            <div class="mb-8">
                <h3 class="text-2xl font-black text-[#191c1e] tracking-tight">Create a Project</h3>
                <p class="text-[#434656] text-sm mt-2 leading-relaxed">Start by naming your project. You'll connect your social accounts on the next page.</p>
            </div>
            
            <form action="{{ route('projects.store') }}" method="POST" onsubmit="this.querySelector('button[type=submit]').disabled = true; this.querySelector('button[type=submit]').innerHTML = 'Creating...';">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-[#434656] uppercase tracking-wider mb-2">Project Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" placeholder="e.g. Acme Corp" required class="w-full bg-[#f8f9fc] border border-[#c4c5d9] text-[#191c1e] text-lg rounded-xl focus:ring-2 focus:ring-[#0040e0]/20 focus:border-[#0040e0] block p-4 transition-colors shadow-sm @error('name') border-rose-500 ring-2 ring-rose-500/20 @enderror" autofocus value="{{ old('name') }}" />
                        @error('name')
                            <p class="mt-2 text-sm text-rose-600 font-semibold flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-[#edeef1] flex items-center justify-between">
                    <button type="button" class="text-[#434656] hover:text-[#191c1e] font-bold text-sm px-4 py-2 rounded-xl transition-colors hover:bg-[#edeef1]" onclick="document.getElementById('create-project-modal').close()">Cancel</button>
                    <button type="submit" class="bg-[#191c1e] hover:bg-[#0040e0] text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-[#0040e0]/20 transition-all">
                        Create Project
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <!-- Auto-open modal on validation errors -->
    @if ($errors->has('name'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('create-project-modal');
                if (modal) {
                    modal.showModal();
                }
            });
        </script>
    @endif
</x-app-layout>
