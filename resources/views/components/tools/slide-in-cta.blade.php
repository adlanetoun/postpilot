<div x-data="{ 
        show: false, 
        dismissed: localStorage.getItem('postpilot_modal_v4_dismissed') === 'true',
        init() {
            if (!this.dismissed) {
                setTimeout(() => {
                    this.show = true;
                }, 5000);
            }
        },
        dismiss() {
            this.show = false;
            this.dismissed = true;
            localStorage.setItem('postpilot_modal_v4_dismissed', 'true');
        }
    }" 
    x-cloak
    x-show="show"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 font-sans"
    role="dialog"
    aria-modal="true">

    <!-- Backdrop -->
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="dismiss"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Modal Card -->
    <div x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 scale-95 translate-y-8"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-8"
         class="relative w-full max-w-lg bg-white text-gray-900 overflow-hidden z-10 shadow-2xl">
        
        <!-- Top Accent Bar -->
        <div class="h-1 w-full bg-black"></div>

        <!-- Close Button -->
        <button @click="dismiss" 
                class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center text-gray-400 hover:text-black transition-colors focus:outline-none group"
                aria-label="Close">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Content -->
        <div class="px-8 pt-8 pb-6 sm:px-10 sm:pt-10">

            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-extrabold text-emerald-900 tracking-widest uppercase font-mono">Autopilot Engine</span>
            </div>

            <!-- Headline -->
            <h3 class="text-[28px] sm:text-[34px] font-extrabold text-black tracking-tight leading-[1.1] mb-4">
                Stop posting manually.<br/>
                <span class="text-gray-400">Automate 30 days.</span>
            </h3>

            <!-- Subtitle -->
            <p class="text-[15px] text-gray-500 font-medium leading-relaxed mb-8 max-w-sm">
                Generate and auto-schedule <span class="text-black font-bold">a full month of content</span> for LinkedIn, X & Facebook in under 2 minutes.
            </p>

            <!-- Social Proof Stats -->
            <div class="grid grid-cols-3 gap-4 mb-8 border-t border-b border-gray-100 py-5">
                <div class="text-center">
                    <div class="text-[22px] font-extrabold text-black tracking-tight">30</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider font-mono">Days of Posts</div>
                </div>
                <div class="text-center border-l border-r border-gray-100">
                    <div class="text-[22px] font-extrabold text-black tracking-tight">3</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider font-mono">Platforms</div>
                </div>
                <div class="text-center">
                    <div class="text-[22px] font-extrabold text-black tracking-tight">&lt;2</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider font-mono">Minutes</div>
                </div>
            </div>

            <!-- CTA Button -->
            <a href="{{ url('/register') }}?utm_source=free_tools&utm_medium=popup_modal&utm_campaign=plg_conversion" 
               onclick="gtag('event', 'click', { event_category: 'CTA', event_label: 'PLG Modal v4', value: 1 })"
               class="group w-full inline-flex items-center justify-center gap-3 bg-black hover:bg-gray-800 text-white font-extrabold text-[15px] py-4 px-6 tracking-wide transition-all duration-200">
                <span>Start Free Trial</span>
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>

        <!-- Footer -->
        <div class="px-8 pb-6 sm:px-10 flex items-center justify-between">
            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider font-mono">14-day free trial • No card required</span>
            <button @click="dismiss" 
                    class="text-[11px] font-bold text-gray-400 hover:text-black uppercase tracking-wider font-mono transition-colors">
                Skip →
            </button>
        </div>
    </div>
</div>
