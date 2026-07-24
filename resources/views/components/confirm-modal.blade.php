@props([
    'id',
    'action',
    'method' => 'DELETE',
    'title' => 'Are you sure?',
    'message' => 'This action cannot be undone.',
    'confirmText' => 'Delete',
    'triggerClass' => 'btn btn-error btn-sm',
    'type' => 'delete', // 'delete', 'approve', or 'refund'
])

@php
    $isApprove = $type === 'approve' || (strtoupper($method) === 'POST' && $type !== 'refund');
    $isRefund = $type === 'refund';

    if ($isRefund) {
        $glowColor = 'bg-emerald-500/10';
        $barGradient = 'from-emerald-500 via-teal-400 to-emerald-600';
        $iconBg = 'bg-emerald-50 text-emerald-600 ring-emerald-100';
        $confirmBtnBg = 'bg-emerald-600 hover:bg-emerald-700 shadow-[0_10px_20px_-10px_rgba(16,185,129,0.5)]';
    } elseif ($isApprove) {
        $glowColor = 'bg-blue-500/10';
        $barGradient = 'from-blue-600 via-indigo-500 to-blue-500';
        $iconBg = 'bg-blue-50 text-blue-600 ring-blue-100';
        $confirmBtnBg = 'bg-[#0040e0] hover:bg-blue-700 shadow-[0_10px_20px_-10px_rgba(0,64,224,0.5)]';
    } else { // delete
        $glowColor = 'bg-rose-500/10';
        $barGradient = 'from-rose-500 via-red-400 to-rose-600';
        $iconBg = 'bg-rose-50 text-rose-600 ring-rose-100';
        $confirmBtnBg = 'bg-rose-600 hover:bg-rose-700 shadow-[0_10px_20px_-10px_rgba(225,29,72,0.5)]';
    }
@endphp

<button type="button" class="{{ $triggerClass }}" onclick="document.getElementById('dialog-confirm-{{ $id }}').showModal()">
    {{ $slot->isEmpty() ? $confirmText : $slot }}
</button>

<dialog id="dialog-confirm-{{ $id }}" class="modal backdrop-blur-md transition-all duration-300">
    <div class="modal-box p-0 relative bg-white rounded-[32px] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.15)] border border-slate-200/80 max-w-md w-[95%] overflow-hidden transform scale-95 transition-transform duration-300">
        
        <!-- Premium Ambient Glow -->
        <div class="absolute top-0 right-0 w-64 h-64 {{ $glowColor }} blur-[80px] rounded-full pointer-events-none -mt-32 -mr-32"></div>
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r {{ $barGradient }} opacity-90"></div>

        <div class="relative z-10 p-7 sm:p-9 flex flex-col items-center text-center">
            
            <!-- Elite Header SVG Icon -->
            <div class="relative mb-5 flex h-16 w-16 items-center justify-center rounded-[22px] {{ $iconBg }} ring-1 ring-inset shadow-sm">
                <div class="absolute inset-0 rounded-[22px] {{ $isRefund ? 'bg-emerald-400' : ($isApprove ? 'bg-blue-400' : 'bg-rose-400') }} opacity-15 animate-ping" style="animation-duration: 3s;"></div>
                
                @if($isRefund)
                    <!-- Wallet / Refund SVG -->
                    <svg class="w-8 h-8 text-emerald-600 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                @elseif($isApprove)
                    <!-- Rocket Launch SVG -->
                    <svg class="w-8 h-8 text-blue-600 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.24a6 6 0 00-2.12 2.12m0 0l-3.5 3.5m3.5-3.5h-4.5m4.5 0v-4.5" />
                    </svg>
                @else
                    <!-- Warning SVG -->
                    <svg class="w-8 h-8 text-rose-600 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                @endif
            </div>

            <!-- Typography -->
            <h3 class="text-[21px] font-black text-slate-900 tracking-tight mb-2">{{ $title }}</h3>
            <p class="text-[13.5px] font-medium text-slate-500 leading-relaxed mb-7 max-w-sm mx-auto">
                {{ $message }}
            </p>
            
            <!-- Actions Grid -->
            <form action="{{ $action }}" method="POST" class="w-full flex items-center justify-center gap-3" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Processing...';">
                @csrf
                @if(strtoupper($method) !== 'POST')
                    @method($method)
                @endif
                
                <button type="button" class="flex-1 h-12 inline-flex justify-center items-center px-4 text-[11px] font-extrabold text-slate-600 uppercase tracking-wider bg-slate-100 border border-slate-200/80 rounded-2xl hover:bg-slate-200 hover:text-slate-900 focus:outline-none transition-all active:scale-95 cursor-pointer" onclick="this.closest('dialog').close()">
                    Cancel
                </button>

                <button type="submit" class="flex-1 h-12 inline-flex justify-center items-center gap-2 px-4 text-[11px] font-black text-white uppercase tracking-wider {{ $confirmBtnBg }} rounded-2xl focus:outline-none transition-all active:scale-95 cursor-pointer relative overflow-hidden">
                    @if($isRefund)
                        <svg class="w-4 h-4 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    @elseif($isApprove)
                        <svg class="w-4 h-4 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    @endif
                    <span class="truncate">{{ $confirmText }}</span>
                </button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop bg-slate-900/60 backdrop-blur-sm">
        <button>close</button>
    </form>
</dialog>

