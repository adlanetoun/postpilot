<div x-data="{ 
        show: false, 
        dismissed: localStorage.getItem('postpilot_modal_v3_dismissed') === 'true',
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
            localStorage.setItem('postpilot_modal_v3_dismissed', 'true');
        }
    }" 
    x-cloak
    x-show="show"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 font-sans"
    role="dialog"
    aria-modal="true">

    <!-- Ambient backdrop blur -->
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="dismiss"
         class="fixed inset-0 bg-black/70 backdrop-blur-md"></div>

    <!-- Modal Box (Dark Obsidian Modern Aesthetics) -->
    <div x-show="show"
         x-transition:enter="transition ease-out duration-400"
         x-transition:enter-start="opacity-0 scale-90 translate-y-6"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-90 translate-y-6"
         class="relative w-full max-w-md bg-gray-950/95 border border-emerald-500/30 text-white rounded-3xl p-6 sm:p-8 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9)] backdrop-blur-xl z-10 text-center overflow-hidden">
        
        <!-- Subtle Glow Effect -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-[#006c49]/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Close Button -->
        <button @click="dismiss" 
                class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-gray-400 hover:text-white flex items-center justify-center transition-all focus:outline-none"
                aria-label="Close">
            <span class="material-symbols-outlined text-base">close</span>
        </button>

        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[11px] font-mono font-bold tracking-wider uppercase mb-5">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span>POSTPILOT AUTOPILOT</span>
        </div>

        <!-- Main Headline -->
        <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-snug mb-3">
            Put your social media on autopilot.
        </h3>

        <!-- Subtitle -->
        <p class="text-sm text-gray-300 font-normal leading-relaxed mb-6">
            Stop creating posts one by one. Generate and auto-schedule <span class="text-emerald-400 font-semibold">30 days of high-converting content</span> for LinkedIn, X & Facebook in under 2 minutes.
        </p>

        <!-- Value Highlight Pill -->
        <div class="mb-6 py-2 px-4 bg-white/5 border border-white/10 rounded-xl inline-flex items-center gap-2 text-xs text-gray-300 font-medium">
            <span class="material-symbols-outlined text-emerald-400 text-sm">verified</span>
            <span>14-Day Free Trial • No Credit Card Required</span>
        </div>

        <!-- Primary High-Converting CTA Button -->
        <a href="{{ url('/register') }}?utm_source=free_tools&utm_medium=popup_modal&utm_campaign=plg_conversion" 
           onclick="gtag('event', 'click', { event_category: 'CTA', event_label: 'Dark Modal PLG Popup', value: 1 })"
           class="w-full inline-flex items-center justify-center gap-2.5 bg-gradient-to-r from-[#006c49] to-emerald-600 hover:from-emerald-600 hover:to-[#006c49] text-white font-extrabold text-base py-4 px-6 rounded-2xl shadow-[0_10px_30px_rgba(0,108,73,0.5)] hover:shadow-[0_15px_35px_rgba(0,108,73,0.7)] transition-all duration-300 transform hover:-translate-y-0.5 mb-3">
            <span>Start Free Trial</span>
            <span class="material-symbols-outlined text-lg">arrow_forward</span>
        </a>

        <!-- Secondary Link -->
        <button @click="dismiss" 
                class="text-xs font-semibold text-gray-400 hover:text-white transition-colors py-1">
            Continue to free tool
        </button>
    </div>
</div>
