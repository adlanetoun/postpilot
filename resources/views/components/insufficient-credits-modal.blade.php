{{--
    Insufficient Credits Modal — CRO: replaces redirect-to-billing-page with an
    in-context modal that surfaces 3 compact credit packs and a clear CTA.
    Trigger: included in any layout when @session('insufficient_credits') is set.
--}}
@php
    $autoOpen = session()->has('insufficient_credits');
    $userCredits = (int) (auth()->user()->campaign_credits ?? 0);
@endphp

<dialog id="insufficient-credits-modal" class="modal bg-[#141517]/80 backdrop-blur-xl" {{ $autoOpen ? 'open' : '' }}>
    <div class="modal-box p-0 max-w-3xl w-[95%] rounded-[32px] overflow-hidden bg-white shadow-[0_40px_100px_-20px_rgba(0,0,0,0.5)] border border-white/20 relative">

        <button type="button" class="absolute top-5 right-5 w-10 h-10 flex items-center justify-center rounded-full bg-black/10 text-white hover:bg-rose-500 hover:scale-110 transition-all duration-300 z-50 backdrop-blur-md border border-white/10 cursor-pointer shadow-lg" onclick="document.getElementById('insufficient-credits-modal').close()">✕</button>

        <!-- Hero -->
        <div class="bg-[#141517] text-white p-8 sm:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-72 h-72 bg-[#0040e0]/30 blur-[100px] rounded-full pointer-events-none -mt-24 -mr-24"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-[#8ca8ff]/20 blur-[80px] rounded-full pointer-events-none -mb-20 -ml-20"></div>

            <div class="relative z-10 flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#0040e0] to-[#0030a8] flex items-center justify-center shadow-[0_10px_30px_-10px_rgba(0,64,224,0.6)]">
                    <span class="material-symbols-outlined text-white text-[28px]" style="font-variation-settings: 'FILL' 1;">bolt</span>
                </div>
                <div>
                    <h2 class="text-[24px] sm:text-[28px] font-black tracking-tight leading-tight">You're out of credits</h2>
                    <p class="text-[14px] font-medium text-[#c4c5d9] mt-1">Current balance: <strong class="text-white font-black">{{ $userCredits }}</strong> — pick a pack to keep generating.</p>
                </div>
            </div>
        </div>

        <!-- Packs grid -->
        <div class="p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-3 gap-4 bg-gradient-to-b from-white to-[#f8f9fc]">

            <!-- 1 Credit -->
            <div class="relative bg-white border border-[#edeef1] rounded-2xl p-5 flex flex-col items-center text-center hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-1 transition-all duration-300">
                <div class="text-[11px] font-extrabold text-[#434656] uppercase tracking-widest mb-2">Starter</div>
                <div class="text-[36px] font-black text-[#191c1e] leading-none mb-1">$9.99</div>
                <div class="text-[13px] font-bold text-[#434656] mb-4">1 Credit</div>
                <ul class="text-[12px] font-medium text-[#434656] space-y-1.5 mb-5 text-left w-full">
                    <li class="flex items-start gap-1.5"><span class="text-emerald-500 mt-0.5">✓</span> 1 full 30-day campaign</li>
                    <li class="flex items-start gap-1.5"><span class="text-emerald-500 mt-0.5">✓</span> 3 platforms max</li>
                </ul>
                <a href="https://{{ config('services.dodo.mode') === 'test' ? 'test.checkout.dodopayments.com' : 'checkout.dodopayments.com' }}/buy/{{ config('services.dodo.link_1_campaign') }}?email={{ urlencode(Auth::user()->email) }}&redirect_url={{ urlencode(route('profile.edit', ['tab' => 'billing'])) }}"
                   class="inline-flex items-center justify-center gap-2 w-full px-5 py-3 text-[15px] font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all shadow-sm">
                    Buy 1 Credit
                </a>
            </div>

            <!-- 3 Credits (Popular) -->
            <div class="relative bg-[#191c1e] text-white rounded-2xl p-5 flex flex-col items-center text-center shadow-[0_20px_50px_-15px_rgba(0,64,224,0.4)] hover:-translate-y-1 transition-all duration-300 ring-2 ring-[#0040e0]">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 bg-gradient-to-r from-[#0040e0] to-[#0030a8] text-white text-[10px] font-extrabold uppercase tracking-widest rounded-full shadow-lg whitespace-nowrap">Most Popular</div>
                <div class="text-[11px] font-extrabold text-[#8ca8ff] uppercase tracking-widest mb-2 mt-2">Growth</div>
                <div class="text-[36px] font-black leading-none mb-1">$25.99</div>
                <div class="text-[13px] font-bold text-[#c4c5d9] mb-4">3 Credits <span class="text-emerald-400 ml-1 text-[11px]">(save 13%)</span></div>
                <ul class="text-[12px] font-medium text-[#c4c5d9] space-y-1.5 mb-5 text-left w-full">
                    <li class="flex items-start gap-1.5"><span class="text-[#8ca8ff] mt-0.5">✓</span> 3 full campaigns</li>
                    <li class="flex items-start gap-1.5"><span class="text-[#8ca8ff] mt-0.5">✓</span> Perfect for multi-project</li>
                </ul>
                <a href="https://{{ config('services.dodo.mode') === 'test' ? 'test.checkout.dodopayments.com' : 'checkout.dodopayments.com' }}/buy/{{ config('services.dodo.link_3_campaigns') }}?email={{ urlencode(Auth::user()->email) }}&redirect_url={{ urlencode(route('profile.edit', ['tab' => 'billing'])) }}"
                   class="w-full py-3 bg-gradient-to-r from-[#0040e0] to-[#0030a8] hover:shadow-[0_10px_25px_-5px_rgba(0,64,224,0.6)] text-white text-[11px] font-extrabold uppercase tracking-widest rounded-xl transition-all duration-300 text-center">
                    Get 3 Credits
                </a>
            </div>

            <!-- 10 Credits -->
            <div class="relative bg-white border border-[#edeef1] rounded-2xl p-5 flex flex-col items-center text-center hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-1 transition-all duration-300">
                <div class="text-[11px] font-extrabold text-[#434656] uppercase tracking-widest mb-2">Agency <span class="text-emerald-600 ml-1 text-[10px]">Best Value</span></div>
                <div class="text-[36px] font-black text-[#191c1e] leading-none mb-1">$69.99</div>
                <div class="text-[13px] font-bold text-[#434656] mb-4">10 Credits <span class="text-emerald-600 ml-1 text-[11px]">(save 30%)</span></div>
                <ul class="text-[12px] font-medium text-[#434656] space-y-1.5 mb-5 text-left w-full">
                    <li class="flex items-start gap-1.5"><span class="text-emerald-500 mt-0.5">✓</span> 10 full campaigns</li>
                    <li class="flex items-start gap-1.5"><span class="text-emerald-500 mt-0.5">✓</span> For agencies & heavy users</li>
                </ul>
                <a href="https://{{ config('services.dodo.mode') === 'test' ? 'test.checkout.dodopayments.com' : 'checkout.dodopayments.com' }}/buy/{{ config('services.dodo.link_10_campaigns') }}?email={{ urlencode(Auth::user()->email) }}&redirect_url={{ urlencode(route('profile.edit', ['tab' => 'billing'])) }}"
                   class="inline-flex items-center justify-center gap-2 w-full px-5 py-3 text-[15px] font-semibold text-white bg-slate-900 rounded-xl hover:bg-black transition-all shadow-sm">
                    Buy 10 Credits
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 sm:px-8 py-5 border-t border-[#edeef1] flex flex-col sm:flex-row items-center justify-between gap-3 bg-[#f8f9fc]/60">
            <div class="flex items-center gap-2 text-[12px] font-medium text-[#434656]">
                <span class="material-symbols-outlined text-[#0040e0] text-[18px]">verified_user</span>
                <span>Secure checkout by Dodo Payments · Credits never expire</span>
            </div>
            <button type="button" class="text-[12px] font-extrabold text-[#434656] hover:text-[#191c1e] uppercase tracking-widest px-4 py-2 rounded-xl hover:bg-white transition-all cursor-pointer" onclick="document.getElementById('insufficient-credits-modal').close()">
                Maybe Later
            </button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop bg-[#141517]/50">
        <button>close</button>
    </form>
</dialog>

@once
    @if ($autoOpen)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('insufficient-credits-modal');
                if (modal && typeof modal.showModal === 'function' && !modal.open) {
                    setTimeout(() => modal.showModal(), 200);
                }
            });
        </script>
    @endif
@endonce