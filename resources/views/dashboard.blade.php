<x-app-layout>
    @if ($state !== 'C')
        <x-slot name="header">
            <!-- Left Side: Breadcrumb & Context -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-[13px] font-medium text-[#6B7280]">
                    <!-- Refined Command/Project Icon -->
                    <svg class="w-4 h-4 text-[#9CA3AF]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>PostPilot</span>
                </div>
                <span class="text-[#D1D5DB] font-light">/</span>
                <h1 class="text-[14px] font-bold text-[#111827] tracking-tight">{{ __('Dashboard') }}</h1>
            </div>

            <!-- Right Side: Dynamic Indicators -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-[11px] font-semibold text-[#4B5563] bg-[#F3F4F6] border border-[#E5E7EB] px-2.5 py-1 rounded-full uppercase tracking-wider">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                    Engine Operational
                </div>
            </div>
        </x-slot>
    @endif

    <!-- State A: No Project Exists (Ambient Glassmorphic Design) -->
    @if ($state === 'A')
        <div class="max-w-[1400px] mx-auto my-20 px-6 sm:px-12 lg:px-16 font-sans relative z-0">
            <!-- Dramatic Ambient Illumination -->
            <div class="absolute top-[-10%] left-1/2 -translate-x-1/2 w-full max-w-[1000px] h-[800px] bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-indigo-100/40 via-transparent to-transparent pointer-events-none -z-10 blur-3xl"></div>

            <!-- Staggered Hero Section -->
            <div class="flex flex-col xl:flex-row items-start xl:items-end justify-between gap-8 xl:gap-12 mb-20 relative z-10">
                <div class="max-w-3xl">
                    <h2 class="text-[56px] lg:text-[84px] leading-[1.05] font-black text-[#050505] tracking-tighter">
                        Welcome to <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">PostPilot</span>
                    </h2>
                </div>
                <div class="max-w-md xl:pb-4">
                    <p class="text-[18px] text-gray-500 font-medium leading-relaxed border-l-2 border-indigo-600/30 pl-6">
                        Initialize your first project to start automating your social presence across all major platforms.
                    </p>
                </div>
            </div>

            <!-- Avant-Garde Bento Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">
                
                <!-- Main CTA (The Anchor) -->
                <div class="lg:col-span-7 bg-[#030305] text-white rounded-[40px] p-12 sm:p-16 relative overflow-hidden group hover:shadow-[0_40px_80px_-20px_rgba(0,0,0,0.3)] transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] flex flex-col justify-between min-h-[500px]">
                    
                    <!-- Decorative Mesh Gradient -->
                    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-gradient-to-br from-indigo-500/20 to-purple-600/20 blur-[80px] rounded-full group-hover:scale-110 group-hover:opacity-70 transition-all duration-1000 ease-[cubic-bezier(0.16,1,0.3,1)] pointer-events-none translate-x-1/3 -translate-y-1/3"></div>

                    <div class="relative z-10">
                        <!-- Refined Icon -->
                        <div class="w-16 h-16 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl flex items-center justify-center mb-12 group-hover:-translate-y-2 group-hover:rotate-6 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        
                        <h3 class="text-[48px] lg:text-[56px] leading-[1.05] font-black tracking-tighter mb-6">
                            Automate <span class="text-indigo-400">30 Days</span><br/>of Content.
                        </h3>
                        <p class="text-[17px] text-white/60 max-w-md leading-relaxed font-medium">
                            Define your brand architecture once. Let our AI engine generate, format, and schedule a full month of highly-targeted posts across all your active channels.
                        </p>
                    </div>

                    <!-- Magnetic-style Button -->
                    <div class="mt-14 relative z-10">
                        <button onclick="document.getElementById('create-project-modal').showModal()" class="inline-flex items-center justify-center px-10 py-5 bg-white text-black text-[16px] font-extrabold rounded-[20px] transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] hover:scale-105 hover:shadow-[0_0_40px_rgba(255,255,255,0.3)] group/btn">
                            Initialize Campaign
                            <svg class="w-5 h-5 ml-3 text-black group-hover/btn:translate-x-2 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Right Side Bento Tiles -->
                <div class="lg:col-span-5 flex flex-col gap-8">
                    
                    <!-- Top Tile: Engineered Precision (Stark White) -->
                    <div class="bg-white rounded-[40px] p-10 flex-1 flex flex-col justify-center shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] border border-gray-100 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] group hover:-translate-y-2">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09l2.846.813-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" />
                            </svg>
                        </div>
                        <h4 class="text-[24px] font-black text-gray-900 mb-4 tracking-tight">Engineered Precision</h4>
                        <p class="text-[16px] text-gray-500 leading-relaxed font-medium">
                            Our models bypass generic outputs by analyzing your specific audience demographics and brand voice parameters.
                        </p>
                    </div>

                    <!-- Bottom Tile: Omnichannel (Premium Gray) -->
                    <div class="bg-[#F3F4F6] rounded-[40px] p-10 flex-1 relative overflow-hidden flex flex-col justify-center group hover:bg-[#E5E7EB] transition-colors duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] cursor-default">
                        <div class="relative z-10">
                            <h4 class="text-[24px] font-black text-gray-900 mb-4 tracking-tight">Omnichannel Ready</h4>
                            <p class="text-[16px] text-gray-500 leading-relaxed font-medium mb-10">
                                Formatted natively for exact platform specifications.
                            </p>
                        </div>
                        
                        <!-- Premium Social Icons -->
                        <div class="relative z-10 flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center group-hover:-translate-y-1 transition-transform duration-500 delay-100">
                                <svg class="w-6 h-6 text-[#0077b5]" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </div>
                            <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center group-hover:-translate-y-1 transition-transform duration-500 delay-200">
                                <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Creation Modal (Split View Live Preview) -->
        <dialog id="create-project-modal" class="modal bg-gray-900/40 backdrop-blur-sm">
            <div class="modal-box p-0 max-w-5xl rounded-3xl overflow-hidden bg-white shadow-2xl border border-gray-200">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-50 text-gray-400 hover:text-gray-900 bg-white shadow-sm" onclick="document.getElementById('create-project-modal').close()">✕</button>
                
                <div class="grid grid-cols-1 md:grid-cols-5 h-full">
                    
                    <!-- Left Side: Input Form -->
                    <div class="md:col-span-3 p-8 lg:p-12 h-full flex flex-col relative overflow-hidden">
                        
                        <!-- Progress Indicator -->
                        <div class="flex items-center gap-2 mb-8">
                            <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div id="wizard-progress" class="h-full bg-indigo-600 rounded-full transition-all duration-500 ease-out" style="width: 33%"></div>
                            </div>
                            <span id="wizard-step-text" class="text-xs font-bold text-gray-400 uppercase tracking-wider w-16 text-right">Step 1/3</span>
                        </div>

                        <div class="mb-8">
                            <h3 id="wizard-title" class="text-3xl font-black text-gray-900 mb-2 tracking-tight transition-opacity duration-300">The Basics</h3>
                            <p id="wizard-subtitle" class="text-gray-500 text-sm transition-opacity duration-300">Let's start with the name and where we can find your project.</p>
                        </div>
                        
                        <form id="project-wizard-form" action="{{ route('projects.store') }}" method="POST" class="flex-1 flex flex-col" onsubmit="this.querySelectorAll('button[type=submit]').forEach(b => { b.disabled = true; b.innerHTML = 'Generating...'; b.classList.add('opacity-75', 'cursor-not-allowed'); })">
                            @csrf
                            
                            <div class="grid grid-cols-1 grid-rows-1 flex-1">
                                <!-- STEP 1 -->
                                <div id="step-1" class="wizard-step col-start-1 row-start-1 transition-all duration-500 transform translate-x-0 opacity-100 space-y-6">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Project Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" id="project_name_input" placeholder="e.g. PostPilot SaaS" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-lg rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-4 transition-colors shadow-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Website URL</label>
                                        <input type="text" name="website_url" placeholder="https://..." class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-lg rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-4 transition-colors shadow-sm" />
                                    </div>
                                </div>

                                <!-- STEP 2 -->
                                <div id="step-2" class="wizard-step col-start-1 row-start-1 transition-all duration-500 transform translate-x-full opacity-0 invisible space-y-6 pointer-events-none">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Product Description <span class="text-red-500">*</span></label>
                                        <textarea name="description" id="project_desc_input" rows="4" placeholder="What does your product do? What problem does it solve?" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-lg rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-4 transition-colors shadow-sm resize-none"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Target Audience <span class="text-red-500">*</span></label>
                                        <input type="text" name="target_audience" id="project_audience_input" placeholder="e.g. Indie Hackers, Solopreneurs" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-lg rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-4 transition-colors shadow-sm" />
                                    </div>
                                </div>

                                <!-- STEP 3 -->
                                <div id="step-3" class="wizard-step col-start-1 row-start-1 transition-all duration-500 transform translate-x-full opacity-0 invisible space-y-6 pointer-events-none">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Output Language <span class="text-red-500">*</span></label>
                                        <select name="language" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-lg rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-4 transition-colors shadow-sm">
                                            <option value="English">English</option>
                                            <option value="Arabic">Arabic (العربية)</option>
                                            <option value="French">French (Français)</option>
                                            <option value="Spanish">Spanish (Español)</option>
                                            <option value="German">German (Deutsch)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tone of Voice</label>
                                        <input type="text" name="tone_of_voice" id="project_tone_input" placeholder="e.g. Witty, Professional" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-lg rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-4 transition-colors shadow-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Value Proposition</label>
                                        <input type="text" name="value_proposition" id="project_value_input" placeholder="e.g. Save 10 hours a week" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-lg rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-4 transition-colors shadow-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Publishing Platforms</label>
                                        
                                        @php
                                            $isLinkedinConnected = in_array('linkedin', $connectedPlatforms);
                                            $isTwitterConnected = in_array('twitter', $connectedPlatforms);
                                            $isFacebookConnected = in_array('facebook', $connectedPlatforms);
                                            $hasAnyConnected = !empty($connectedPlatforms);
                                        @endphp

                                        @if(!$hasAnyConnected)
                                            <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs mt-2 flex flex-col gap-2">
                                                <div class="flex items-center gap-2 font-bold">
                                                    <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                                    No Accounts Linked
                                                </div>
                                                <p>You must link at least one social media account in settings before generating a campaign.</p>
                                                <a href="{{ route('profile.edit', ['tab' => 'socials']) }}" class="w-fit font-bold underline hover:text-amber-900">Connect Social Accounts →</a>
                                            </div>
                                        @else
                                            <div class="grid grid-cols-2 gap-3 mt-2">
                                                <label class="flex items-center gap-3 p-3.5 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-100/50 transition-colors {{ !$isLinkedinConnected ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                    <input type="checkbox" name="platforms[]" value="linkedin" {{ $isLinkedinConnected ? 'checked' : 'disabled' }} class="checkbox rounded w-5 h-5 text-indigo-600 focus:ring-indigo-500/20" />
                                                    <div class="flex flex-col text-left">
                                                        <span class="text-sm font-semibold text-gray-700">LinkedIn</span>
                                                        @if(!$isLinkedinConnected)
                                                            <span class="text-[10px] text-gray-400">Disconnected</span>
                                                        @endif
                                                    </div>
                                                </label>
                                                
                                                <label class="flex items-center gap-3 p-3.5 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-100/50 transition-colors {{ !$isTwitterConnected ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                    <input type="checkbox" name="platforms[]" value="twitter" {{ $isTwitterConnected ? 'checked' : 'disabled' }} class="checkbox rounded w-5 h-5 text-indigo-600 focus:ring-indigo-500/20" />
                                                    <div class="flex flex-col text-left">
                                                        <span class="text-sm font-semibold text-gray-700">X (Twitter)</span>
                                                        @if(!$isTwitterConnected)
                                                            <span class="text-[10px] text-gray-400">Disconnected</span>
                                                        @endif
                                                    </div>
                                                </label>
                                                
                                                <label class="flex items-center gap-3 p-3.5 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-100/50 transition-colors {{ !$isFacebookConnected ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                    <input type="checkbox" name="platforms[]" value="facebook" {{ $isFacebookConnected ? 'checked' : 'disabled' }} class="checkbox rounded w-5 h-5 text-indigo-600 focus:ring-indigo-500/20" />
                                                    <div class="flex flex-col text-left">
                                                        <span class="text-sm font-semibold text-gray-700">Facebook</span>
                                                        @if(!$isFacebookConnected)
                                                            <span class="text-[10px] text-gray-400">Disconnected</span>
                                                        @endif
                                                    </div>
                                                </label>
                                                
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between z-10 bg-white relative">
                                <button type="button" id="btn-back" class="text-gray-500 hover:text-gray-900 font-medium text-sm px-4 py-2 rounded-xl transition-colors hover:bg-gray-100" onclick="document.getElementById('create-project-modal').close()">Cancel</button>
                                
                                <button type="button" id="btn-next" class="bg-gray-900 hover:bg-black text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all flex items-center gap-2">
                                    Next Step
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>

                                <button type="submit" id="btn-submit" @if(!$hasAnyConnected) disabled @endif class="hidden bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 flex items-center gap-2 @if(!$hasAnyConnected) opacity-50 cursor-not-allowed @endif">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Generate Campaign
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Side: AI Preview -->
                    <div class="md:col-span-2 bg-gray-900 p-8 lg:p-12 text-white relative overflow-hidden flex flex-col justify-center">
                        <!-- Decorative background glow -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500 rounded-full blur-3xl opacity-20 pointer-events-none -mt-20 -mr-20"></div>
                        <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500 rounded-full blur-3xl opacity-20 pointer-events-none -mb-20 -ml-20"></div>

                        <div class="relative z-10">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-bold tracking-wide uppercase mb-8 border border-indigo-500/30">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                                </span>
                                AI Live Preview
                            </div>

                            <h4 class="text-2xl font-bold mb-6 leading-snug">
                                Generating a 30-day strategy for <span id="preview_name" class="text-indigo-400 border-b border-indigo-400/30 pb-0.5 transition-all">Your Brand</span>.
                            </h4>

                            <div class="space-y-4 text-gray-400 text-sm leading-relaxed">
                                <p>
                                    Targeting <span id="preview_audience" class="text-white font-semibold">your audience</span> with a <span id="preview_tone" class="text-white font-semibold">compelling</span> tone of voice.
                                </p>
                                <p id="preview_desc_container" class="opacity-50 italic">
                                    "Awaiting product description..."
                                </p>
                                <p id="preview_value_container" class="hidden">
                                    Highlighting the core value: <span id="preview_value" class="text-white font-semibold"></span>.
                                </p>
                            </div>

                            <!-- Decorative terminal-like skeleton -->
                            <div class="mt-12 bg-black/40 rounded-xl p-4 border border-white/10 font-mono text-xs text-gray-500 space-y-2 opacity-70">
                                <div class="flex items-center gap-2"><span class="text-indigo-400">></span> Analyzing inputs...</div>
                                <div class="flex items-center gap-2"><span class="text-indigo-400">></span> Preparing LLM prompts...</div>
                                <div class="flex items-center gap-2"><span class="text-indigo-400">></span> Waiting for user submission</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        <!-- Vanilla JS for Live Preview & Wizard -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Live preview logic
                const nameIn = document.getElementById('project_name_input');
                const audIn = document.getElementById('project_audience_input');
                const toneIn = document.getElementById('project_tone_input');
                const descIn = document.getElementById('project_desc_input');
                const valIn = document.getElementById('project_value_input');

                const nameOut = document.getElementById('preview_name');
                const audOut = document.getElementById('preview_audience');
                const toneOut = document.getElementById('preview_tone');
                const descOut = document.getElementById('preview_desc_container');
                const valOut = document.getElementById('preview_value');
                const valOutCont = document.getElementById('preview_value_container');

                function updatePreview() {
                    nameOut.textContent = nameIn.value || 'Your Brand';
                    audOut.textContent = audIn.value || 'your audience';
                    toneOut.textContent = toneIn.value || 'compelling';
                    
                    if (descIn.value) {
                        descOut.textContent = `"${descIn.value.substring(0, 100)}${descIn.value.length > 100 ? '...' : ''}"`;
                        descOut.classList.remove('opacity-50', 'italic');
                        descOut.classList.add('text-gray-300');
                    } else {
                        descOut.textContent = '"Awaiting product description..."';
                        descOut.classList.add('opacity-50', 'italic');
                        descOut.classList.remove('text-gray-300');
                    }

                    if (valIn.value) {
                        valOut.textContent = valIn.value;
                        valOutCont.classList.remove('hidden');
                    } else {
                        valOutCont.classList.add('hidden');
                    }
                }

                [nameIn, audIn, toneIn, descIn, valIn].forEach(el => {
                    if(el) el.addEventListener('input', updatePreview);
                });

                // Wizard logic
                let currentStep = 1;
                const totalSteps = 3;
                
                const stepElements = [
                    document.getElementById('step-1'),
                    document.getElementById('step-2'),
                    document.getElementById('step-3')
                ];
                
                const titles = ["The Basics", "The Core", "The Magic"];
                const subtitles = [
                    "Let's start with the name and where we can find your project.",
                    "Tell us what your product does and who it's for.",
                    "Give your campaign a unique voice and highlight your main value."
                ];
                
                const titleEl = document.getElementById('wizard-title');
                const subtitleEl = document.getElementById('wizard-subtitle');
                const progressEl = document.getElementById('wizard-progress');
                const stepTextEl = document.getElementById('wizard-step-text');
                
                const btnBack = document.getElementById('btn-back');
                const btnNext = document.getElementById('btn-next');
                const btnSubmit = document.getElementById('btn-submit');
                const modal = document.getElementById('create-project-modal');

                function updateWizardUI() {
                    // Update Text
                    titleEl.style.opacity = 0;
                    subtitleEl.style.opacity = 0;
                    
                    setTimeout(() => {
                        titleEl.textContent = titles[currentStep - 1];
                        subtitleEl.textContent = subtitles[currentStep - 1];
                        titleEl.style.opacity = 1;
                        subtitleEl.style.opacity = 1;
                    }, 200);

                    // Update Progress
                    progressEl.style.width = `${(currentStep / totalSteps) * 100}%`;
                    stepTextEl.textContent = `Step ${currentStep}/${totalSteps}`;

                    // Update Steps Classes
                    stepElements.forEach((el, index) => {
                        if (index + 1 === currentStep) {
                            el.classList.remove('translate-x-full', '-translate-x-full', 'opacity-0', 'invisible', 'pointer-events-none');
                            el.classList.add('translate-x-0', 'opacity-100');
                        } else if (index + 1 < currentStep) {
                            el.classList.remove('translate-x-0', 'translate-x-full', 'opacity-100');
                            el.classList.add('-translate-x-full', 'opacity-0', 'invisible', 'pointer-events-none');
                        } else {
                            el.classList.remove('translate-x-0', '-translate-x-full', 'opacity-100');
                            el.classList.add('translate-x-full', 'opacity-0', 'invisible', 'pointer-events-none');
                        }
                    });

                    // Update Buttons
                    if (currentStep === 1) {
                        btnBack.textContent = 'Cancel';
                        btnBack.onclick = () => modal.close();
                    } else {
                        btnBack.textContent = 'Back';
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
                    const currentInputs = stepElements[currentStep - 1].querySelectorAll('input[required], textarea[required]');
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

                btnNext.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (validateCurrentStep() && currentStep < totalSteps) {
                        currentStep++;
                        updateWizardUI();
                    }
                });

                // Clear validation on input
                document.querySelectorAll('input[required], textarea[required]').forEach(input => {
                    input.addEventListener('input', () => {
                        input.classList.remove('border-red-500', 'ring-red-500');
                    });
                });
                
                // Initialize
                updateWizardUI();
            });
        </script>
    @endif

    <!-- State B: Campaign Generating (Ambient Pulse Design) -->
    @if ($state === 'B')
        <div class="max-w-2xl mx-auto my-12 px-4 sm:px-6 lg:px-8 font-sans relative z-0 flex flex-col items-center justify-center min-h-[500px]">
            
            <!-- Ambient Background Glows -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-indigo-200/30 rounded-full blur-[100px] pointer-events-none -z-10 animate-pulse"></div>

            <!-- Glassmorphic Card -->
            <div class="w-full bg-white/80 backdrop-blur-xl border border-gray-200/70 rounded-[24px] p-10 sm:p-14 relative overflow-hidden shadow-[0_8px_40px_rgb(0,0,0,0.04)] flex flex-col items-center text-center">
                
                <!-- Elegant Custom Pulsing Indicator -->
                <div class="relative w-20 h-20 mb-8 flex items-center justify-center">
                    <div class="absolute inset-0 border-[3px] border-indigo-100 rounded-full"></div>
                    <div class="absolute inset-0 border-[3px] border-indigo-600 rounded-full border-t-transparent animate-spin"></div>
                    <!-- Inner Core -->
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full animate-pulse shadow-[0_0_20px_rgba(99,102,241,0.5)]"></div>
                </div>

                <!-- Refined Typography -->
                <h2 class="text-[32px] leading-[1.15] font-extrabold text-gray-900 tracking-tight mb-4">
                    Synthesizing Campaign
                </h2>
                <p class="text-[15px] text-gray-500 leading-relaxed max-w-md">
                    Our AI engine is architecting your 30-day strategy. It is currently generating cross-platform content and determining optimal delivery windows.
                </p>
                
                <!-- Refined Polling Status -->
                <div id="polling-alert" class="mt-8 mb-2">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-indigo-50/50 border border-indigo-100 text-[13px] font-medium text-indigo-700">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        Engine operational. Polling server...
                    </div>
                </div>

                <!-- Stealth Cancel Action -->
                <div class="mt-10 pt-6 border-t border-gray-100/80 w-full flex justify-center">
                    <x-confirm-modal 
                        id="cancel-generation-modal" 
                        :action="route('projects.destroy', $project->id)" 
                        title="Halt Generation Sequence?" 
                        message="Are you sure you want to cancel? This will discard the current processing queue and delete the project configuration."
                        confirmText="Yes, Terminate" 
                        triggerClass="inline-flex items-center justify-center px-4 py-2 text-[13px] font-semibold text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-[8px] transition-colors focus:outline-none"
                    >
                        Halt Sequence & Discard
                    </x-confirm-modal>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const campaignId = {{ $campaign->id }};
                let pollInterval = setInterval(() => {
                    fetch('/campaigns/' + campaignId + '/status')
                        .then(response => {
                            // Soft Timeout: check if content-type is HTML (session expired redirect)
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('text/html')) {
                                clearInterval(pollInterval);
                                document.getElementById('polling-alert').innerHTML = `
                                    <div class="alert alert-warning shadow border border-warning/20 text-sm">
                                        <span>Session expired. Please <a href="/login" class="link link-primary font-semibold">log in again</a> to see your campaign.</span>
                                    </div>
                                `;
                                return;
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data) return;
                            if (data.status === 'ready') {
                                clearInterval(pollInterval);
                                window.location.reload();
                            } else if (data.status === 'failed_generation') {
                                clearInterval(pollInterval);
                                window.location.reload();
                            }
                        })
                        .catch(err => {
                            console.error('Polling error:', err);
                        });
                }, 5000);
            });
        </script>
    @endif

    <!-- State FAILED: Campaign Generation Failed -->
    @if ($state === 'FAILED')
        <div class="alert alert-error max-w-2xl mx-auto my-12 shadow-lg rounded-2xl border border-error/20 p-6">
            <div class="flex items-start gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 shrink-0 text-error mt-0.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-15h.008v.008H12V6.75Z" />
                </svg>
                <div class="flex-grow">
                    <h3 class="font-extrabold text-lg">Campaign Generation Failed</h3>
                    <p class="text-sm opacity-90 mt-1 leading-relaxed">
                        An error occurred while generating the campaign. This is usually due to temporary API rate limits or LLM parsing errors.
                    </p>
                    @if ($campaign->error_message)
                        <div class="bg-base-200/50 border border-base-300 rounded-lg p-3 mt-3 font-mono text-xs text-base-content/85">
                            {{ $campaign->error_message }}
                        </div>
                    @endif
                    <div class="mt-4 flex items-center gap-3">
                        <x-confirm-modal 
                            id="failed-delete-project-modal" 
                            :action="route('projects.destroy', $project->id)" 
                            title="Discard Project and Try Again?" 
                            message="This will delete the current project configuration so you can create a fresh one."
                            confirmText="Delete Project" 
                            triggerClass="btn btn-error btn-sm font-semibold"
                        >
                            Delete Project & Restart
                        </x-confirm-modal>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- State C: Ready/Scheduled - The Master Calendar -->
    @if ($state === 'C')
        @php $groupedPosts = $posts->groupBy('day_number'); @endphp
        
        <style>
            .maestro-calendar-wrapper {
                font-family: 'Inter', sans-serif;
                animation: m-fadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                padding-bottom: 4rem;
                       /* The Command Center (Redesigned from the dark pill) */
            .m-command-dock {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(20px);
                border-radius: 32px;
                padding: 2.5rem 3rem;
                display: flex;
                flex-direction: column;
                gap: 2rem;
                box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05), inset 0 0 0 1px rgba(255,255,255,1);
                margin-bottom: 4rem;
                margin-top: 1rem;
                color: #0A0A0A;
                border: 1px solid rgba(0,0,0,0.06);
            }
            .m-command-dock-top { display: flex; justify-content: space-between; align-items: flex-start; }
            .m-command-info { display: flex; align-items: flex-start; gap: 1.5rem; }
            .m-status-icon {
                width: 48px; height: 48px; border-radius: 16px; background: #F8FAFC; border: 1px solid #F1F5F9; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
                flex-shrink: 0;
            }
            .m-status-icon.is-active { background: #ECFDF5; border-color: #D1FAE5; color: #10B981; }
            
            .m-command-title { font-size: 1.8rem; font-weight: 900; letter-spacing: -0.03em; display: flex; align-items: center; gap: 1rem; line-height: 1.1; margin-bottom: 0.5rem; }
            .m-command-subtitle { font-size: 1rem; color: #71717A; font-weight: 500; max-width: 500px; line-height: 1.5; }
            .m-command-badge { padding: 0.3rem 0.8rem; border-radius: 100px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; transform: translateY(-2px); }
            .m-badge-draft { background: #FFFBEB; color: #D97706; border: 1px solid #FEF3C7; }
            .m-badge-active { background: #ECFDF5; color: #059669; border: 1px solid #D1FAE5; }

            .m-command-actions { display: flex; align-items: center; gap: 1rem; }
            .m-btn-approve {
                background: #0A0A0A; color: #fff; padding: 1rem 2.5rem; border-radius: 100px; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; border: none; cursor: pointer; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .m-btn-approve:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
            .m-btn-delete {
                width: 48px; height: 48px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; color: #71717A; transition: all 0.3s; cursor: pointer; background: transparent; flex-shrink: 0;
            }
            .m-btn-delete:hover { background: #DC2626; color: #fff; border-color: #DC2626; transform: rotate(90deg); }

            /* Sleek Progress Bar for Active Mode */
            .m-progress-container { width: 100%; padding-top: 1.5rem; border-top: 1px solid rgba(0,0,0,0.06); }
            .m-progress-stats { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 0.8rem; }
            .m-progress-label { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #A1A1AA; }
            .m-progress-value { font-size: 1.25rem; font-weight: 900; font-family: 'Inter', monospace; color: #0A0A0A; }
            .m-progress-track { width: 100%; height: 6px; background: rgba(0,0,0,0.04); border-radius: 100px; overflow: hidden; }
            .m-progress-fill { height: 100%; background: #10B981; border-radius: 100px; transition: width 1s cubic-bezier(0.16, 1, 0.3, 1); }); }

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
                text-align: right;
                font-size: 0.75rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                color: #A1A1AA;
                padding-right: 1.5rem;
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

        <div class="maestro-calendar-wrapper max-w-7xl mx-auto relative z-0">
            <!-- Decorative Ambient Glow -->
            <div style="position:absolute; top:-100px; left:50%; transform:translateX(-50%); width:600px; height:600px; background:radial-gradient(circle, rgba(79,70,229,0.05) 0%, transparent 70%); pointer-events:none; z-index:-1;"></div>

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
                            <form action="{{ route('campaigns.approve', $campaign->id) }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="m-btn-approve">Approve & Launch</button>
                            </form>
                            <x-confirm-modal 
                                id="delete-project-modal" 
                                :action="route('projects.destroy', $project->id)" 
                                title="Delete Project?" 
                                message="This will permanently delete the project and all campaigns. Irreversible."
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
                            <div class="m-status-icon is-active">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div>
                                <h2 class="m-command-title">
                                    {{ $project->name }}
                                    <span class="m-command-badge m-badge-active">Active</span>
                                </h2>
                                @php
                                    $publishedDaysCount = $groupedPosts->filter(function($dayPosts) {
                                        return $dayPosts->contains('status', 'published');
                                    })->count();
                                @endphp
                                <p class="m-command-subtitle">
                                    Autopilot is running. Your audience is being engaged automatically.
                                </p>
                            </div>
                        </div>
                        <div class="m-command-actions">
                            <x-confirm-modal 
                                id="delete-project-modal-active" 
                                :action="route('projects.destroy', $project->id)" 
                                title="Delete Project?" 
                                message="This will permanently delete the project, all campaigns, and all scheduled social posts. Irreversible."
                                confirmText="Delete Project" 
                                triggerClass="m-btn-delete"
                            >
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </x-confirm-modal>
                        </div>
                    </div>
                    
                    <div class="m-progress-container">
                        <div class="m-progress-stats">
                            <span class="m-progress-label">Campaign Progress</span>
                            <span class="m-progress-value">{{ $publishedDaysCount }} / 30 <span style="font-size: 0.75rem; color: #A1A1AA; font-weight: 700; margin-left: 0.2rem;">DAYS</span></span>
                        </div>
                        <div class="m-progress-track">
                            <div class="m-progress-fill" style="width: {{ ($publishedDaysCount / 30) * 100 }}%"></div>
                        </div>
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
                    @for ($i = 1; $i <= 35; $i++)
                        @if ($i <= 30)
                            @php 
                                $dayPosts = $groupedPosts->get($i, collect()); 
                                $hasPublished = !$dayPosts->isEmpty() && $dayPosts->contains('status', 'published');
                            @endphp
                            <div class="m-cal-cell" onclick="openDayDrawer({{ $i }})">
                                <div class="m-cal-date">
                                    {{ $i }}
                                    @if (!$dayPosts->isEmpty())
                                        <span class="m-cal-posts-badge">{{ $dayPosts->count() }} Posts</span>
                                    @endif
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                                    <div class="m-cal-platforms">
                                        @if (!$dayPosts->isEmpty())
                                            @foreach ($dayPosts->pluck('platform')->map(function($p) { return strtolower($p); })->unique()->take(4) as $platform)
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
                        <span class="text-[24px] font-bold text-gray-300 uppercase tracking-tighter">Day</span>
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

                <div id="drawer-content-container" class="relative z-10 flex flex-col">
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
            $campaignDataArray = $groupedPosts->map(function($posts) {
                return $posts->map(function($post) {
                    return [
                        'id' => $post->id,
                        'platform' => $post->platform,
                        'content' => $post->content,
                        'time' => $post->scheduled_at ? \Carbon\Carbon::parse($post->scheduled_at)->format('h:i A') : 'TBD',
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

                // Build content
                let html = '';
                if (posts.length === 0) {
                    html = `
                        <div class="p-12 flex flex-col items-center justify-center text-center border-b border-gray-200">
                            <div class="w-16 h-16 border-2 border-black flex items-center justify-center mb-6 bg-white/80">
                                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <h4 class="text-[18px] font-extrabold text-black uppercase tracking-widest mb-2">Rest Day</h4>
                            <p class="text-gray-500 text-[14px] font-medium max-w-xs">Zero payloads scheduled. System resting to avoid audience fatigue.</p>
                        </div>
                    `;
                } else {
                    posts.forEach((post, index) => {
                        const platformName = post.platform.toUpperCase();
                        const platformIcon = getPlatformIcon(post.platform);
                        const delay = index * 50; // ms
                        
                        html += `
                            <div 
                                class="group relative border-b border-black/10 bg-white/50 hover:bg-white/75 backdrop-blur-sm p-8 transition-colors duration-200"
                                style="animation: slideUpFadeManifest 0.4s ease-out ${delay}ms forwards; opacity: 0; transform: translateY(10px);"
                                data-content="${escapeHtml(post.content)}"
                            >
                                <!-- Brutalist Post Header -->
                                <div class="flex items-center justify-between mb-6">
                                    <div class="inline-flex items-center gap-3">
                                        <!-- Platform Brutalist Badge with Logo -->
                                        <div class="border-2 border-black px-2.5 py-1 bg-white/90 rounded-md flex items-center gap-2 shadow-sm">
                                            ${platformIcon}
                                            <span class="text-[10px] font-bold text-black uppercase tracking-wider font-mono">${platformName}</span>
                                        </div>
                                        <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded font-mono uppercase tracking-widest flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            ${post.time}
                                        </span>
                                    </div>

                                    <!-- Micro Actions (Brutalist style) -->
                                    <div class="flex items-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button onclick="navigator.clipboard.writeText(this.closest('.group').dataset.content); const s=this; s.textContent='[ COPIED ]'; setTimeout(()=>s.textContent='[ COPY ]', 2000);" class="text-[11px] font-bold text-gray-400 hover:text-black font-mono uppercase tracking-widest transition-colors">
                                            [ COPY ]
                                        </button>
                                        <button onclick="triggerEditModal(${post.id}, this.closest('.group').dataset.content, '${post.platform}')" class="text-[11px] font-bold text-black hover:text-gray-500 font-mono uppercase tracking-widest transition-colors">
                                            [ EDIT ]
                                        </button>
                                    </div>
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

                // Show Drawer
                overlay.classList.remove('hidden');
                // Trigger reflow
                void overlay.offsetWidth;
                overlay.classList.remove('opacity-0');
                
                drawer.classList.remove('translate-x-full');
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

            <dialog id="edit-post-modal" class="modal" @if(old('modal_post_id')) open @endif>
                <div class="modal-box bg-[#0a0a0c]/95 backdrop-blur-3xl border border-white/5 rounded-[32px] max-w-5xl p-0 overflow-hidden text-white shadow-[0_0_80px_rgba(0,0,0,0.8)]">
                    <header class="flex items-center justify-between px-8 py-6 relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-500/10 flex items-center justify-center ring-1 ring-indigo-500/20 shadow-[inset_0_0_20px_rgba(79,70,229,0.1)]">
                                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-100 tracking-tight">Refine Content</h3>
                                <p class="text-[12px] text-gray-500 font-medium">Fine-tune the AI generated narrative</p>
                            </div>
                        </div>
                        <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-all ring-1 ring-white/5" onclick="document.getElementById('edit-post-modal').close()">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </button>
                    </header>
                    
                    <main class="flex flex-col lg:flex-row px-8 pb-8 gap-8 relative z-0">
                        <!-- Left: Live Preview Column -->
                        <section class="lg:w-[480px] shrink-0" data-purpose="post-preview-column">
                            <div class="bg-[#111318] rounded-[24px] ring-1 ring-white/5 p-6 h-full flex flex-col min-h-[400px] shadow-inner relative overflow-hidden">
                                <!-- Abstract glowing orb -->
<div class="absolute top-0 right-0 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                                
                                <div class="text-[10px] font-bold text-indigo-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse shadow-[0_0_8px_rgba(79,70,229,0.6)]"></div>
                                    <span>Live Render</span>
                                </div>
                                <div id="mockup-twitter" class="mockup-template hidden w-full bg-black text-white font-sans text-left border border-[#2f3336] rounded-2xl overflow-hidden relative z-10 shadow-lg">
                                    <div class="p-4">
                                        <!-- Header -->
                                        <div class="flex gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gray-800 flex-shrink-0 overflow-hidden">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="Avatar" class="w-full h-full object-cover" />
                                            </div>
                                            <div class="flex flex-col flex-1">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-1">
                                                        <span class="font-bold text-[15px] hover:underline cursor-pointer">{{ Auth::user()->name }}</span>
                                                        <!-- Verified Badge -->
                                                        <svg viewBox="0 0 24 24" class="w-[18px] h-[18px] fill-[#1d9bf0]"><g><path d="M22.5 12.5c0-1.58-.875-2.95-2.148-3.6.154-.435.238-.905.238-1.4 0-2.21-1.71-3.998-3.918-3.998-.47 0-.92.084-1.336.25C14.818 2.415 13.51 1.5 12 1.5s-2.816.917-3.337 2.25c-.416-.165-.866-.25-1.336-.25-2.21 0-3.918 1.79-3.918 4 0 .495.084.965.238 1.4-1.273.65-2.148 2.02-2.148 3.6 0 1.46.73 2.73 1.83 3.395-.12.42-.18.86-.18 1.305 0 2.21 1.71 4 3.918 4 .55 0 1.07-.125 1.55-.34.56 1.135 1.71 1.9 3.038 1.9s2.478-.765 3.038-1.9c.48.215 1 .34 1.55.34 2.21 0 3.918-1.79 3.918-4 0-.445-.06-.885-.18-1.305 1.1-.665 1.83-1.935 1.83-3.395zm-11.51 3.4l-3.26-3.26 1.41-1.41 1.85 1.85 4.99-4.99 1.41 1.41-6.4 6.4z"></path></g></svg>
                                                    </div>
                                                    <!-- X Logo Top Right -->
                                                    <svg viewBox="0 0 24 24" class="w-5 h-5 fill-[#71767b]"><g><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 22.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></g></svg>
                                                </div>
                                                <div class="text-[#71767b] text-[15px]">@{{ strtolower(str_replace(' ', '', Auth::user()->name)) }}</div>
                                            </div>
                                        </div>
                                        
                                        <!-- Post Content -->
                                        <div class="mt-3">
                                            <p id="preview-text-twitter" class="text-[15px] leading-[20px] whitespace-pre-wrap break-words font-normal"></p>
                                            
                                            @if (!empty($project->website_url))
                                            @php
                                                $host = parse_url($project->website_url, PHP_URL_HOST);
                                                $host = $host ? str_replace('www.', '', $host) : $project->website_url;
                                            @endphp
                                            <div class="mt-3 border border-[#2f3336] rounded-2xl overflow-hidden hover:bg-white/[0.03] transition-colors cursor-pointer">
                                                <div class="h-[120px] bg-[#16181c] border-b border-[#2f3336] flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-[#71767b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                </div>
                                                <div class="p-3">
                                                    <div class="text-[#71767b] text-[13px] mb-0.5">{{ $host }}</div>
                                                    <div class="text-[15px] text-white truncate font-normal">{{ $project->name ?? 'Project Link' }}</div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Meta -->
                                        <div class="text-[#71767b] text-[15px] mt-4 mb-4 hover:underline cursor-pointer">
                                            10:42 AM · {{ date('M j, Y') }} · <span class="text-white font-bold">1.2M</span> Views
                                        </div>

                                        <!-- Actions -->
                                        <div class="border-t border-[#2f3336] border-b py-1 flex justify-between px-1">
                                            <button class="flex items-center group">
                                                <div class="w-9 h-9 rounded-full group-hover:bg-[#1d9bf0]/10 flex items-center justify-center transition-colors">
                                                    <svg viewBox="0 0 24 24" class="w-[18px] h-[18px] fill-[#71767b] group-hover:fill-[#1d9bf0] transition-colors"><g><path d="M1.751 10c0-4.42 3.584-8 8.005-8h4.366c4.49 0 8.129 3.64 8.129 8.13 0 2.96-1.607 5.68-4.196 7.11l-8.054 4.46v-3.69h-.067c-4.49.1-8.183-3.51-8.183-8.01zm8.005-6c-3.317 0-6.005 2.69-6.005 6 0 3.37 2.77 6.08 6.138 6.01l.351-.01h1.761v2.3l5.087-2.81c1.951-1.08 3.163-3.13 3.163-5.36 0-3.39-2.744-6.13-6.129-6.13H9.756z"></path></g></svg>
                                                </div>
                                                <span class="text-[#71767b] group-hover:text-[#1d9bf0] text-[13px] px-1 transition-colors">452</span>
                                            </button>
                                            <button class="flex items-center group">
                                                <div class="w-9 h-9 rounded-full group-hover:bg-[#00ba7c]/10 flex items-center justify-center transition-colors">
                                                    <svg viewBox="0 0 24 24" class="w-[18px] h-[18px] fill-[#71767b] group-hover:fill-[#00ba7c] transition-colors"><g><path d="M4.5 3.88l4.432 4.14-1.364 1.46L5.5 7.55V16c0 1.1.896 2 2 2H13v2H7.5c-2.209 0-4-1.79-4-4V7.55L1.432 9.48.068 8.02 4.5 3.88zM16.5 6H11V4h5.5c2.209 0 4 1.79 4 4v8.45l2.068-1.93 1.364 1.46-4.432 4.14-4.432-4.14 1.364-1.46 2.068 1.93V8c0-1.1-.896-2-2-2z"></path></g></svg>
                                                </div>
                                                <span class="text-[#71767b] group-hover:text-[#00ba7c] text-[13px] px-1 transition-colors">12K</span>
                                            </button>
                                            <button class="flex items-center group">
                                                <div class="w-9 h-9 rounded-full group-hover:bg-[#f91880]/10 flex items-center justify-center transition-colors">
                                                    <svg viewBox="0 0 24 24" class="w-[18px] h-[18px] fill-[#71767b] group-hover:fill-[#f91880] transition-colors"><g><path d="M16.697 5.5c-1.222-.06-2.679.51-3.89 2.16l-.805 1.09-.806-1.09C9.984 6.01 8.526 5.44 7.304 5.5c-1.243.07-2.349.78-2.91 1.91-.552 1.12-.633 2.78.479 4.82 1.074 1.97 3.257 4.27 7.129 6.61 3.87-2.34 6.052-4.64 7.126-6.61 1.111-2.04 1.03-3.7.477-4.82-.561-1.13-1.666-1.84-2.908-1.91zm4.187 7.69c-1.351 2.48-4.001 5.12-8.379 7.67l-.503.3-.504-.3c-4.379-2.55-7.029-5.19-8.382-7.67-1.36-2.5-1.41-4.86-.514-6.67.887-1.79 2.647-2.91 4.601-3.01 1.651-.09 3.368.56 4.798 2.01 1.429-1.45 3.146-2.1 4.796-2.01 1.954.1 3.714 1.22 4.601 3.01.896 1.81.846 4.17-.514 6.67z"></path></g></svg>
                                                </div>
                                                <span class="text-[#71767b] group-hover:text-[#f91880] text-[13px] px-1 transition-colors">45K</span>
                                            </button>
                                            <button class="flex items-center group">
                                                <div class="w-9 h-9 rounded-full group-hover:bg-[#1d9bf0]/10 flex items-center justify-center transition-colors">
                                                    <svg viewBox="0 0 24 24" class="w-[18px] h-[18px] fill-[#71767b] group-hover:fill-[#1d9bf0] transition-colors"><g><path d="M12 2.59l5.7 5.7-1.41 1.42L13 6.41V16h-2V6.41l-3.3 3.3-1.41-1.42L12 2.59zM21 15l-.02 3.51c0 1.38-1.12 2.49-2.5 2.49H5.5C4.11 21 3 19.88 3 18.5V15h2v3.5c0 .28.22.5.5.5h12.98c.28 0 .5-.22.5-.5L19 15h2z"></path></g></svg>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="mockup-linkedin" class="mockup-template hidden w-full bg-[#1d2226] text-white rounded-[10px] border border-[#38434f] overflow-hidden font-sans text-left relative z-10 shadow-lg">
                                    <div class="p-3">
                                        <!-- Header -->
                                        <div class="flex gap-2 mb-2">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-12 h-12 rounded-full border border-white/10" alt="Profile">
                                            <div class="flex flex-col flex-1 mt-0.5">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-semibold text-[14px] text-white/90 hover:text-[#70b5f9] hover:underline cursor-pointer">{{ Auth::user()->name }}</span>
                                                    <button class="text-white/60 hover:text-white/90 px-2 py-0.5 rounded flex items-center gap-1 font-semibold text-[14px]">
                                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16"><path d="M8 7a1.5 1.5 0 11-1.5 1.5A1.5 1.5 0 018 7zm0-4a1.5 1.5 0 11-1.5 1.5A1.5 1.5 0 018 3zm0 8a1.5 1.5 0 11-1.5 1.5A1.5 1.5 0 018 11z"></path></svg>
                                                    </button>
                                                </div>
                                                <span class="text-white/60 text-[12px] -mt-1 block">Founder | Tech Enthusiast</span>
                                                <div class="flex items-center text-white/60 text-[12px] gap-1">
                                                    <span>Just now</span>
                                                    <span>•</span>
                                                    <svg viewBox="0 0 16 16" class="w-3 h-3 fill-current"><path d="M8 1a7 7 0 100 14A7 7 0 008 1zM2.04 8.75h1.86c.07 1.48.33 2.87.75 4.07A5.51 5.51 0 012.04 8.75zM4 8.75h4V13.5c-.88 0-1.68-1.57-2.11-3.66a12.63 12.63 0 01-.11-.59c-.43-1.2-.7-2.6-.78-4.05H1.23a5.53 5.53 0 011.83-4.83c.42 1.2.69 2.59.76 4.05h1.86c.09 1.46.36 2.85.78 4.05zM8 2.5a14.28 14.28 0 012.11 5.5h-4.22A14.28 14.28 0 018 2.5zm3.25 10.32c.42-1.2.68-2.59.75-4.07h1.86a5.51 5.51 0 01-2.61 4.07zM10.11 8.75c-.08 1.45-.35 2.85-.78 4.05-.43 2.09-1.23 3.66-2.11 3.66V8.75h4zm4.56-1.5H12.1c-.07-1.46-.33-2.85-.75-4.05a5.53 5.53 0 012.61 4.05zM9.22 3.2c.43 1.2.7 2.59.78 4.05H6a14.12 14.12 0 01.78-4.05C7.22 1.11 8 1.11 8 1.11s.78 0 1.22 2.09zM3.9 7.25c.07-1.46.33-2.85.75-4.05A5.53 5.53 0 012.04 7.25H3.9z"></path></svg>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Text -->
                                        <p id="preview-text-linkedin" class="text-[14px] leading-[1.42857] text-white/90 whitespace-pre-wrap break-words"></p>
                                    </div>

                                    <!-- Link Preview -->
                                    @if (!empty($project->website_url))
                                    @php
                                        $host = parse_url($project->website_url, PHP_URL_HOST);
                                        $host = $host ? str_replace('www.', '', $host) : $project->website_url;
                                    @endphp
                                    <div class="border-t border-b border-[#38434f] bg-[#1d2226] hover:bg-white/5 transition-colors cursor-pointer block">
                                        <div class="h-[150px] bg-[#38434f] flex items-center justify-center relative overflow-hidden">
                                            <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        </div>
                                        <div class="py-2.5 px-3">
                                            <div class="text-[14px] font-semibold text-white/90 truncate">{{ $project->name ?? 'Project Link' }}</div>
                                            <div class="text-[12px] text-white/60 truncate">{{ $host }}</div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Action Bar -->
                                    <div class="px-3">
                                        <div class="py-1 flex items-center justify-between border-b border-[#38434f] text-[12px] text-white/60">
                                            <div class="flex items-center gap-1">
                                                <div class="w-4 h-4 rounded-full bg-[#70b5f9] flex items-center justify-center border border-[#1d2226]">
                                                    <svg class="w-2.5 h-2.5 fill-white" viewBox="0 0 24 24"><path d="M21 10.5h-5.5V9a2.5 2.5 0 00-2.5-2.5h-.5l-3.5 5v8h10a2.5 2.5 0 002.5-2.5v-4.5A2.5 2.5 0 0021 10.5zM7 11.5v8H4v-8h3z"></path></svg>
                                                </div>
                                                <span>2.4K</span>
                                            </div>
                                            <div>
                                                <span>45 comments</span>
                                                <span> • </span>
                                                <span>12 reposts</span>
                                            </div>
                                        </div>
                                        <div class="py-1 flex justify-between px-1">
                                            <button class="flex-1 flex items-center justify-center gap-1.5 hover:bg-white/10 py-2.5 rounded transition-colors text-white/90">
                                                <svg viewBox="0 0 24 24" class="w-6 h-6 fill-white/90"><path d="M19.46 11l-3.91-3.91a7 7 0 01-1.69-2.74l-.49-1.47A2.76 2.76 0 0010.76 1 2.75 2.75 0 008 3.74v1.12a9.19 9.19 0 00.46 2.89 2.54 2.54 0 00-.46-.35 2.74 2.74 0 00-2.74 0 2.75 2.75 0 00-1.26 2.36v6.24A4.75 4.75 0 008.75 21h6.63a3.52 3.52 0 003.52-3.32l1-6.49A2.5 2.5 0 0019.46 11zM18 11.08l-1 6.49a1.53 1.53 0 01-1.53 1.43H8.75A2.75 2.75 0 016 16.25V7.61a.75.75 0 01.38-.65.74.74 0 01.74 0 .75.75 0 01.38.65V11h2V6.75a.75.75 0 011.5 0v3.75h2V3.74a.75.75 0 01.75-.74.75.75 0 01.71.51l.49 1.47a9.08 9.08 0 002.16 3.54L20 11.8v.17a.5.5 0 01-.5.5z"></path></svg>
                                                <span class="text-[14px] font-semibold">Like</span>
                                            </button>
                                            <button class="flex-1 flex items-center justify-center gap-1.5 hover:bg-white/10 py-2.5 rounded transition-colors text-white/90">
                                                <svg viewBox="0 0 24 24" class="w-6 h-6 fill-white/90"><path d="M7 9h10v1H7zm0 4h7v-1H7zm16-2a6.78 6.78 0 01-2.84 5.61L12 22v-4H8A7 7 0 018 4h8a7 7 0 017 7zm-2 0a5 5 0 00-5-5H8a5 5 0 000 10h6v2.28L19 15a4.79 4.79 0 002-4z"></path></svg>
                                                <span class="text-[14px] font-semibold">Comment</span>
                                            </button>
                                            <button class="flex-1 flex items-center justify-center gap-1.5 hover:bg-white/10 py-2.5 rounded transition-colors text-white/90">
                                                <svg viewBox="0 0 24 24" class="w-6 h-6 fill-white/90"><path d="M23 12l-4.61 5L16 14.38l2.25-2.45c-2.31 0-4.07 1-4.72 2.87-.2.57-.46 1.76-.71 3.25l-.89 5.37-1.89-.35 1-6.19c.17-1.01.44-2.13.78-3.08A4.85 4.85 0 0115.54 10zM1 12l4.61-5L8 9.62 5.75 12.07c2.31 0 4.07-1 4.72-2.87.2-.57.46-1.76.71-3.25l.89-5.37 1.89.35-1 6.19c-.17 1.01-.44 2.13-.78 3.08A4.85 4.85 0 018.46 14z"></path></svg>
                                                <span class="text-[14px] font-semibold">Repost</span>
                                            </button>
                                            <button class="flex-1 flex items-center justify-center gap-1.5 hover:bg-white/10 py-2.5 rounded transition-colors text-white/90">
                                                <svg viewBox="0 0 24 24" class="w-6 h-6 fill-white/90"><path d="M21 3L0 10l7.66 4.26L16 8l-6.26 8.34L14 24l7-21z"></path></svg>
                                                <span class="text-[14px] font-semibold">Send</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="mockup-facebook" class="mockup-template hidden w-full bg-[#242526] text-[#E4E6EB] rounded-lg border border-[#3E4042] overflow-hidden font-sans text-left shadow-lg relative z-10">
                                    <div class="p-3">
                                        <!-- Header -->
                                        <div class="flex gap-2.5 mb-3 items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-10 h-10 rounded-full cursor-pointer" alt="Profile">
                                            <div class="flex flex-col flex-1">
                                                <span class="font-semibold text-[15px] hover:underline cursor-pointer leading-4 mb-0.5">{{ Auth::user()->name }}</span>
                                                <div class="flex items-center text-[#B0B3B8] text-[13px] gap-1 hover:underline cursor-pointer">
                                                    <span>Just now</span>
                                                    <span>·</span>
                                                    <svg viewBox="0 0 16 16" class="w-3 h-3 fill-current"><path d="M8 1.5A6.5 6.5 0 1014.5 8 6.5 6.5 0 008 1.5zm3.56 3h-2.18A9.78 9.78 0 008.3 2.16a5 5 0 013.26 2.34zm-4.26-2.3a8.3 8.3 0 011.4 2.3h-2.8a8.3 8.3 0 011.4-2.3zm-3.64 2.3A5 5 0 016.92 2.16 9.78 9.78 0 005.84 4.5zm-2.07 4a5 5 0 01.19-1.5h2.44a10.61 10.61 0 000 3h-2.44a5 5 0 01-.19-1.5zm.59 2.5h2.18a9.78 9.78 0 001.08 2.34 5 5 0 01-3.26-2.34zm2.18 0h2.8a8.3 8.3 0 01-1.4 2.3 8.3 8.3 0 01-1.4-2.3zm3.64 2.34a9.78 9.78 0 001.08-2.34h2.18a5 5 0 01-3.26 2.34zm2.66-3.84h-2.44a10.61 10.61 0 000-3h2.44a5.2 5.2 0 010 3z"></path></svg>
                                                </div>
                                            </div>
                                            <div class="w-9 h-9 rounded-full hover:bg-[#3A3B3C] flex items-center justify-center cursor-pointer transition-colors">
                                                <svg viewBox="0 0 20 20" class="w-5 h-5 fill-[#B0B3B8]"><path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5zm-7 0a2.5 2.5 0 100-5 2.5 2.5 0 000 5zm14 0a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"></path></svg>
                                            </div>
                                            <div class="w-9 h-9 rounded-full hover:bg-[#3A3B3C] flex items-center justify-center cursor-pointer transition-colors">
                                                <svg viewBox="0 0 20 20" class="w-5 h-5 fill-[#B0B3B8]"><path d="M11.5 10l4.3-4.3a1 1 0 00-1.4-1.4L10 8.6 5.7 4.3a1 1 0 00-1.4 1.4l4.3 4.3-4.3 4.3a1 1 0 101.4 1.4l4.3-4.3 4.3 4.3a1 1 0 001.4-1.4l-4.3-4.3z"></path></svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Text -->
                                        <p id="preview-text-facebook" class="text-[15px] leading-[1.4] whitespace-pre-wrap break-words mb-3"></p>
                                    </div>

                                    <!-- Link Preview -->
                                    @if (!empty($project->website_url))
                                    @php
                                        $host = parse_url($project->website_url, PHP_URL_HOST);
                                        $host = strtoupper($host ? str_replace('www.', '', $host) : $project->website_url);
                                    @endphp
                                    <div class="border-t border-b border-[#3E4042] bg-[#3A3B3C] cursor-pointer block hover:opacity-95 transition-opacity">
                                        <div class="h-[170px] bg-[#242526] flex items-center justify-center border-b border-[#3E4042]">
                                            <svg class="w-10 h-10 text-[#B0B3B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="py-2.5 px-4 bg-[#3A3B3C]">
                                            <div class="text-[12px] text-[#B0B3B8] mb-0.5">{{ $host }}</div>
                                            <div class="text-[16px] font-semibold text-[#E4E6EB] truncate leading-5">{{ $project->name ?? 'Project Link' }}</div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Action Bar -->
                                    <div class="px-4">
                                        <div class="py-2.5 flex items-center justify-between text-[15px] text-[#B0B3B8] border-b border-[#3E4042]">
                                            <div class="flex items-center gap-1.5">
                                                <div class="w-[18px] h-[18px] rounded-full bg-[#1877f2] flex items-center justify-center">
                                                    <svg class="w-3 h-3 fill-white" viewBox="0 0 24 24"><path d="M4 21h1v-8H4v8zm18-7c0-1.1-.9-2-2-2h-5.5l.9-4.3.03-.3c0-.4-.1-.8-.4-1.1L14 5l-6.6 6.6c-.4.4-.6 1-.6 1.6v6c0 1.1.9 2 2 2h8.2c.8 0 1.5-.5 1.8-1.2l2.8-6.5c.1-.2.2-.5.2-.8v-2z"/></svg>
                                                </div>
                                                <span>1.2K</span>
                                            </div>
                                            <div>
                                                <span>142 comments</span>
                                                <span> • </span>
                                                <span>45 shares</span>
                                            </div>
                                        </div>
                                        <div class="py-1 flex justify-between gap-1">
                                            <button class="flex-1 flex items-center justify-center gap-2 hover:bg-[#3A3B3C] py-1.5 rounded transition-colors font-semibold text-[#B0B3B8]">
                                                <svg viewBox="0 0 24 24" class="w-[22px] h-[22px] fill-current"><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.822-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"></path></svg>
                                                <span>Like</span>
                                            </button>
                                            <button class="flex-1 flex items-center justify-center gap-2 hover:bg-[#3A3B3C] py-1.5 rounded transition-colors font-semibold text-[#B0B3B8]">
                                                <svg viewBox="0 0 24 24" class="w-[22px] h-[22px] fill-current"><path d="M12.016 4C6.486 4 2 8.016 2 12.973c0 2.825 1.523 5.353 3.908 6.98a.5.5 0 01.21.464c-.066.69-.265 1.489-.594 2.378-.065.176.084.34.25.267.31-.137.98-.445 1.83-1.026a.5.5 0 01.554.026A10.873 10.873 0 0012.016 22c5.53 0 10.016-4.016 10.016-8.973C22.032 8.016 17.546 4 12.016 4zM3.5 12.973C3.5 8.844 7.314 5.5 12.016 5.5S20.532 8.844 20.532 12.973 16.718 20.5 12.016 20.5a9.38 9.38 0 01-3.52-.676 2.002 2.002 0 00-1.821-.059c-.58.384-1.077.65-1.393.811.233-.569.414-1.127.498-1.56a2.003 2.003 0 00-.832-1.874A8.064 8.064 0 013.5 12.973z"></path></svg>
                                                <span>Comment</span>
                                            </button>
                                            <button class="flex-1 flex items-center justify-center gap-2 hover:bg-[#3A3B3C] py-1.5 rounded transition-colors font-semibold text-[#B0B3B8]">
                                                <svg viewBox="0 0 24 24" class="w-[22px] h-[22px] fill-current"><path d="M20.675 12.023l-7-5.586A1 1 0 0012 7.218v2.868A11.082 11.082 0 004.811 14.8a10.428 10.428 0 00-1.528 5.438c-.027.322.371.492.593.26A12.036 12.036 0 0112 15.029v2.846a1 1 0 001.625.782l7-5.586a1 1 0 00.05-1.548zM13.5 16.32V14.5a.5.5 0 00-.5-.5A10.518 10.518 0 005.158 17.1c.548-2.128 2.39-3.882 5.083-4.502a.5.5 0 00.392-.489V10.22l5.122 4.08-2.255 1.8zm0 0"></path></svg>
                                                <span>Share</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Right: Editor Column -->
                        <section class="flex-1 flex flex-col relative">
                            <form 
                                id="edit-post-form" 
                                method="POST" 
                                action="{{ old('modal_post_id') ? route('posts.update', old('modal_post_id')) : '#' }}" 
                                onsubmit="this.querySelectorAll('button[type=submit]').forEach(b => { b.disabled = true; b.classList.add('opacity-50', 'cursor-not-allowed'); b.innerHTML = 'Saving...'; })"
                                class="flex flex-col h-full"
                            >
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="modal_post_id" id="edit-post-id" value="{{ old('modal_post_id') }}" />
                                
                                <div class="flex-grow flex flex-col relative group h-full">
                                    <div class="absolute inset-0 bg-gradient-to-b from-indigo-500/5 to-transparent opacity-0 group-focus-within:opacity-100 transition-opacity duration-500 pointer-events-none rounded-2xl"></div>
                                    <textarea 
                                        name="content"
                                        id="content"
                                        class="w-full h-full min-h-[300px] bg-[#0f1115] border border-white/5 rounded-[24px] p-6 text-gray-200 text-[15px] leading-relaxed focus:ring-1 focus:ring-indigo-500/50 focus:border-indigo-500/30 custom-scrollbar resize-none outline-none shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)] transition-all relative z-10"
                                        placeholder="Craft your AI-generated narrative..."
                                        required
                                    ></textarea>
                                    <div class="absolute bottom-5 right-6 text-gray-500 text-[11px] font-mono z-20 bg-[#0f1115]/80 backdrop-blur-md px-2.5 py-1 rounded-md ring-1 ring-white/10">
                                        <span id="char-count" class="text-gray-300">0</span> <span class="mx-0.5 opacity-50">/</span> <span id="char-limit-display">280</span>
                                    </div>
                                </div>
                                
                                <div class="flex justify-end items-center gap-5 mt-6">
                                    <button type="button" class="text-[13px] font-semibold text-gray-500 hover:text-white transition-colors" onclick="document.getElementById('edit-post-modal').close()">Cancel</button>
                                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-500 text-white text-[13px] font-bold tracking-wide hover:bg-indigo-400 hover:shadow-[0_0_20px_rgba(79,70,229,0.3)] ring-1 ring-indigo-400/50 transition-all duration-300 flex items-center gap-2 group/btn">
                                        <svg class="w-4 h-4 transform group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </section>
                    </main>
                </div>
            </dialog>

            <script>
                function openEditModal(postId, content, actionUrl, platform) {
                    document.getElementById('edit-post-id').value = postId;
                    const textarea = document.getElementById('content');
                    if (textarea) textarea.value = content;
                    document.getElementById('edit-post-form').action = actionUrl;
                    document.querySelectorAll('.mockup-template').forEach(el => el.classList.add('hidden'));
                    
                    let normalizedPlatform = platform.toLowerCase();
                    let previewElId = '';
                    let charLimit = 3000;
                    
                    if (normalizedPlatform === 'twitter' || normalizedPlatform === 'x') {
                        document.getElementById('mockup-twitter').classList.remove('hidden');
                        previewElId = 'preview-text-twitter';
                        charLimit = 280;
                    } else if (normalizedPlatform === 'linkedin') {
                        document.getElementById('mockup-linkedin').classList.remove('hidden');
                        previewElId = 'preview-text-linkedin';
                    } else if (normalizedPlatform === 'facebook') {
                        document.getElementById('mockup-facebook').classList.remove('hidden');
                        previewElId = 'preview-text-facebook';
                    }
                    
                    const charLimitDisplay = document.getElementById('char-limit-display');
                    if (charLimitDisplay) charLimitDisplay.textContent = charLimit;
                    
                    const updatePreview = () => {
                        if (textarea) {
                            const length = textarea.value.length;
                            const charCountEl = document.getElementById('char-count');
                            if (charCountEl) {
                                charCountEl.textContent = length;
                                charCountEl.className = length > charLimit ? 'text-red-500' : 'text-[#71767b]';
                            }
                            if (previewElId) document.getElementById(previewElId).innerText = textarea.value;
                        }
                    };
                    
                    if (textarea) textarea.oninput = updatePreview;
                    updatePreview();
                    document.getElementById('edit-post-modal').showModal();
                }
            </script>
        </div>
    @endif
</x-app-layout>
