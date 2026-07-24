                <x-app-layout full-width="true">
    @php
        $activeTab = request()->query('tab', 'profile');
        $validTabs = ['profile', 'security', 'billing'];
        if (!in_array($activeTab, $validTabs)) {
            $activeTab = 'profile';
        }
    @endphp

    <div class="h-full min-h-screen flex flex-col md:flex-row w-full overflow-x-hidden overflow-y-auto relative">
        
        <!-- Main Content Area -->
        <main class="flex-1 min-w-0 px-6 sm:px-10 md:px-16 py-12 relative z-0">
            <div class="max-w-4xl mx-auto">
                <!-- Tab 1: Profile (General) -->
                    <!-- Tab CSS: Applies to multiple tabs -->
                        <style>
                            /* ============================================================
                               ✨ IDENTITY TAB — Premium Personal Workspace
                               ============================================================ */
                            @keyframes id-fade-up   { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
                            @keyframes id-orb-spin  { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
                            @keyframes id-pulse     { 0% { transform: scale(1); opacity: 0.55; } 100% { transform: scale(1.55); opacity: 0; } }
                            @keyframes id-pop       { 0% { transform: scale(0); } 60% { transform: scale(1.18); } 100% { transform: scale(1); } }
                            @keyframes id-shimmer   { 0% { transform: translateX(-120%) skewX(-12deg); } 100% { transform: translateX(220%) skewX(-12deg); } }

                            /* ---------- Stagger entrance ---------- */
                            .id-stagger > * { animation: id-fade-up 0.75s cubic-bezier(0.16, 1, 0.3, 1) backwards; }
                            .id-stagger > *:nth-child(1) { animation-delay: 0.05s; }
                            .id-stagger > *:nth-child(2) { animation-delay: 0.18s; }
                            .id-stagger > *:nth-child(3) { animation-delay: 0.30s; }

                            /* ---------- Floating labels ---------- */
                            .id-float-input  { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
                            .id-float-label  { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); transform-origin: left top; pointer-events: none; }
                            .id-float-input:focus ~ .id-float-label,
                            .id-float-input:not(:placeholder-shown) ~ .id-float-label,
                            .id-float-select.has-value ~ .id-float-label {
                                transform: translateY(-1.55rem) scale(0.78);
                                color: #6366F1;
                                font-weight: 700;
                                letter-spacing: -0.01em;
                            }

                            /* ---------- Avatar ---------- */
                            .id-avatar-frame { position: relative; transition: transform 0.55s cubic-bezier(0.16, 1, 0.3, 1); }
                            .id-avatar-frame:hover { transform: translateY(-4px) scale(1.02); }
                            .id-avatar-ring {
                                position: absolute; inset: -3px; border-radius: inherit; padding: 3px;
                                background: conic-gradient(from 0deg, #6366F1, #A855F7, #EC4899, #F59E0B, #10B981, #6366F1);
                                -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
                                -webkit-mask-composite: xor; mask-composite: exclude;
                                animation: id-orb-spin 14s linear infinite;
                            }
                            .id-avatar-frame:hover .id-avatar-ring { animation-duration: 6s; }
                            .id-avatar-glow {
                                position: absolute; inset: -36px; border-radius: 50%;
                                background: radial-gradient(circle, rgba(99,102,241,0.35), transparent 70%);
                                filter: blur(22px); opacity: 0; transition: opacity 0.6s ease; pointer-events: none;
                            }
                            .id-avatar-frame:hover .id-avatar-glow { opacity: 1; }

                            /* ---------- Frosted glass input shell ---------- */
                            .id-glass-wrap {
                                position: relative;
                                background: linear-gradient(180deg, rgba(248,250,252,0.85) 0%, rgba(255,255,255,0.65) 100%);
                                border: 1.5px solid rgba(15, 23, 42, 0.06);
                                border-radius: 18px;
                                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                                box-shadow: inset 0 1px 0 rgba(255,255,255,0.85), 0 1px 2px rgba(15, 23, 42, 0.02);
                                backdrop-filter: blur(8px);
                            }
                            .id-glass-wrap:hover {
                                border-color: rgba(99, 102, 241, 0.22);
                                box-shadow: inset 0 1px 0 rgba(255,255,255,0.85), 0 6px 14px -4px rgba(15, 23, 42, 0.05);
                            }
                            .id-glass-wrap:focus-within {
                                border-color: rgba(99, 102, 241, 0.5);
                                background: #ffffff;
                                box-shadow:
                                    0 0 0 4px rgba(99, 102, 241, 0.12),
                                    inset 0 1px 0 rgba(255,255,255,0.85),
                                    0 14px 28px -10px rgba(99, 102, 241, 0.22);
                                transform: translateY(-1px);
                            }

                            /* ---------- Select chevron ---------- */
                            .id-select-chevron { transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), background 0.3s, color 0.3s; }
                            .id-glass-wrap:focus-within .id-select-chevron {
                                transform: translateY(-50%) rotate(180deg);
                                background: rgba(99, 102, 241, 0.18);
                                color: #4F46E5;
                            }

                            /* ---------- Avatar action buttons ---------- */
                            .id-action-upload {
                                position: relative; overflow: hidden;
                                background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
                                box-shadow: 0 6px 14px -4px rgba(15, 23, 42, 0.3), inset 0 1px 0 rgba(255,255,255,0.08);
                            }
                            .id-action-upload::after {
                                content: ''; position: absolute; top: 0; left: -120%; width: 60%; height: 100%;
                                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
                                transition: left 0.7s ease;
                            }
                            .id-action-upload:hover::after { left: 130%; }
                            .id-action-upload:hover {
                                transform: translateY(-2px);
                                box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.45), inset 0 1px 0 rgba(255,255,255,0.1);
                                background: linear-gradient(135deg, #1E293B 0%, #334155 100%);
                            }
                            .id-action-upload:active { transform: translateY(0) scale(0.97); transition-duration: 0.08s; }

                            .id-action-remove { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
                            .id-action-remove:hover {
                                border-color: rgba(244, 63, 94, 0.45);
                                color: #E11D48;
                                background: linear-gradient(180deg, rgba(254,226,226,0.5) 0%, rgba(255,255,255,0.7) 100%);
                                transform: translateY(-2px);
                                box-shadow: 0 10px 22px -8px rgba(244, 63, 94, 0.25);
                            }
                            .id-action-remove:active { transform: translateY(0) scale(0.97); transition-duration: 0.08s; }

                            /* ---------- Verify banner (amber gold) ---------- */
                            .id-verify-banner {
                                background:
                                    radial-gradient(circle at 0% 0%, rgba(245, 158, 11, 0.18) 0%, transparent 55%),
                                    radial-gradient(circle at 100% 100%, rgba(251, 191, 36, 0.18) 0%, transparent 55%),
                                    linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
                                border: 1px solid rgba(245, 158, 11, 0.32);
                                box-shadow: 0 14px 32px -12px rgba(245, 158, 11, 0.22), inset 0 1px 0 rgba(255,255,255,0.65);
                            }
                            .id-verify-btn {
                                position: relative; overflow: hidden;
                                background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
                                box-shadow: 0 10px 22px -6px rgba(245, 158, 11, 0.5), inset 0 1px 0 rgba(255,255,255,0.35);
                                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                            }
                            .id-verify-btn::after {
                                content: ''; position: absolute; top: 0; left: -120%; width: 60%; height: 100%;
                                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent);
                                transition: left 0.7s ease;
                            }
                            .id-verify-btn:hover::after { left: 130%; }
                            .id-verify-btn:hover {
                                transform: translateY(-2px);
                                box-shadow: 0 16px 32px -6px rgba(245, 158, 11, 0.65), inset 0 1px 0 rgba(255,255,255,0.4);
                                background: linear-gradient(135deg, #FBBF24 0%, #F59E0B 100%);
                            }
                            .id-verify-btn:active { transform: translateY(0) scale(0.97); transition-duration: 0.08s; }

                            /* ---------- Save button (premium haptic) ---------- */
                            .id-save-btn {
                                position: relative; overflow: hidden;
                                background: linear-gradient(135deg, #0F172A 0%, #1E293B 45%, #334155 100%);
                                box-shadow: 0 12px 28px -10px rgba(15, 23, 42, 0.35), inset 0 1px 0 rgba(255,255,255,0.08);
                                transition: all 0.45s cubic-bezier(0.16, 1, 0.3, 1);
                            }
                            .id-save-btn::before {
                                content: ''; position: absolute; top: 0; left: -120%; width: 60%; height: 100%;
                                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
                                transition: left 0.8s ease;
                            }
                            .id-save-btn:hover::before { left: 130%; }
                            .id-save-btn:hover {
                                transform: translateY(-2px) scale(1.015);
                                box-shadow: 0 22px 44px -12px rgba(15, 23, 42, 0.5), inset 0 1px 0 rgba(255,255,255,0.1);
                                background: linear-gradient(135deg, #1E293B 0%, #334155 50%, #4F46E5 100%);
                            }
                            .id-save-btn:active { transform: translateY(0) scale(0.96); transition-duration: 0.08s; }
                            .id-save-arrow { display: inline-flex; transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1); }
                            .id-save-btn:hover .id-save-arrow { transform: translateX(6px); }

                            /* ---------- Misc ---------- */
                            .id-pulse-ring     { animation: id-pulse 2.6s ease-out infinite; }
                            .id-verified-badge { animation: id-pop 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.55s backwards; }
                            .id-shimmer-line   { animation: id-shimmer 6s ease-in-out infinite; }

                            @media (max-width: 768px) {
                                .id-grid-2 { grid-template-columns: 1fr !important; }
                                .id-identity-card { grid-template-columns: 1fr !important; text-align: center; gap: 2rem !important; }
                                .id-identity-card .id-avatar-frame { margin: 0 auto; }
                                .id-avatar-actions { align-items: center !important; }
                                .id-form-actions { flex-direction: column; align-items: stretch !important; }
                                .id-form-actions button { width: 100%; justify-content: center; }
                            }
                        </style>

                    <!-- Tab 1: Profile (General) -->
                    @if ($activeTab === 'profile')
                        <div class="id-stagger font-sans antialiased text-slate-900">

                            {{-- ============================================================
                                 ✨ HEADER — "Personal Workspace"
                                 ============================================================ --}}
                            <header class="mb-10 md:mb-12">
                                <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50 border border-indigo-100/70 mb-5">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                                    </span>
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-indigo-700">Digital Identity</span>
                                </div>
                                <h1 class="text-[40px] md:text-[52px] font-black tracking-[-0.04em] text-slate-900 leading-[1.02]">
                                    Your
                                    <span class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent">Personal Workspace</span>
                                </h1>
                                <p class="mt-4 text-[15px] text-slate-500 max-w-2xl leading-relaxed">
                                    Curate how you appear across the platform. Every detail here shapes your digital presence — refined, intentional, and unmistakably yours.
                                </p>
                            </header>

                            {{-- ============================================================
                                 ✨ IDENTITY CARD — Avatar + Actions
                                 ============================================================ --}}
                            <div class="id-identity-card relative grid grid-cols-[auto_1fr] gap-8 md:gap-12 items-center p-8 md:p-10 mb-6 rounded-[28px] bg-white border border-slate-200/70 shadow-[0_4px_28px_-10px_rgba(15,23,42,0.08)] overflow-hidden">

                                {{-- soft decorative mesh --}}
                                <div class="absolute -top-24 -right-24 w-72 h-72 bg-gradient-to-br from-indigo-100/40 to-purple-100/40 rounded-full blur-3xl pointer-events-none"></div>
                                <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-gradient-to-tr from-pink-100/30 to-amber-100/30 rounded-full blur-3xl pointer-events-none"></div>

                                {{-- Avatar --}}
                                <div class="relative flex justify-center z-10">
                                    <div class="id-avatar-frame relative rounded-[36px] overflow-visible">
                                        <div class="id-avatar-ring rounded-[36px]"></div>
                                        <div class="id-avatar-glow"></div>
                                        <div class="relative w-[140px] h-[140px] rounded-[32px] bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-[0_30px_60px_-15px_rgba(99,102,241,0.5)] overflow-hidden">
                                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,0.4),transparent_60%)]"></div>
                                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_80%,rgba(0,0,0,0.18),transparent_60%)]"></div>
                                            <span class="relative text-[56px] font-black text-white tracking-tight drop-shadow-md leading-none">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </span>
                                            <div class="id-shimmer-line absolute inset-0 bg-gradient-to-r from-transparent via-white/25 to-transparent pointer-events-none"></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Identity info + actions --}}
                                <div class="id-avatar-actions flex flex-col gap-5 z-10">
                                    <div>
                                        <div class="flex items-center gap-2.5 mb-1.5 flex-wrap">
                                            <h2 class="text-[26px] md:text-[30px] font-black text-slate-900 tracking-[-0.03em] leading-tight">
                                                {{ Auth::user()->name }}
                                            </h2>
                                            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && Auth::user()->hasVerifiedEmail())
                                                <span class="id-verified-badge inline-flex items-center justify-center w-6 h-6 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 text-white shadow-md shadow-emerald-500/40" title="Verified email">
                                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[13px] text-slate-500 font-medium">
                                            Member since {{ Auth::user()->created_at->format('F Y') }}
                                            <span class="mx-1.5 text-slate-300">·</span>
                                            <span class="text-slate-600">{{ Auth::user()->email }}</span>
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap gap-3">
                                        <button type="button" class="id-action-upload inline-flex items-center gap-2.5 px-5 py-3 rounded-2xl text-white text-[13px] font-bold tracking-wide">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12"/>
                                            </svg>
                                            Upload Photo
                                        </button>
                                        <button type="button" class="id-action-remove inline-flex items-center gap-2.5 px-5 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 text-[13px] font-bold tracking-wide">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a2 2 0 012-2h2a2 2 0 012 2v3"/>
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- ============================================================
                                 ✨ FORM CARD — Personal Information
                                 ============================================================ --}}
                            <div class="bg-white rounded-[28px] border border-slate-200/70 shadow-[0_4px_28px_-10px_rgba(15,23,42,0.08)] overflow-hidden">

                                {{-- Card header --}}
                                <div class="px-8 md:px-10 pt-8 pb-6 border-b border-slate-100">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center text-indigo-600 border border-indigo-100/70 shadow-sm shadow-indigo-500/10">
                                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-black text-slate-900 tracking-[-0.02em]">Personal Information</h3>
                                            <p class="text-[13px] text-slate-500 mt-0.5">Update your display details. Changes apply instantly.</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Verification form (separate) --}}
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                </form>

                                {{-- Main profile form --}}
                                <form method="post" action="{{ route('profile.update') }}" class="p-8 md:p-10">
                                    @csrf
                                    @method('patch')

                                    {{-- Unverified banner (Action Required card) --}}
                                    @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                                        <div class="id-verify-banner rounded-2xl p-6 mb-8 flex flex-col sm:flex-row sm:items-center gap-5">
                                            <div class="flex items-start gap-4 flex-1">
                                                <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/40 flex-shrink-0">
                                                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                    <div class="id-pulse-ring absolute inset-[-4px] rounded-2xl border-2 border-amber-400"></div>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="text-[15px] font-black text-amber-900 mb-1 tracking-[-0.01em]">Action Required: Verify Your Email</h4>
                                                    <p class="text-[13px] text-amber-800/85 leading-relaxed">
                                                        Your email <strong class="font-bold text-amber-900">{{ Auth::user()->email }}</strong> is unverified. Verify it to unlock all features and secure your account.
                                                    </p>
                                                    @if (session('status') === 'verification-link-sent')
                                                        <p class="mt-2.5 text-[12px] font-bold text-emerald-700 inline-flex items-center gap-1.5">
                                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                            New verification link sent successfully
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <button form="send-verification" class="id-verify-btn inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-white text-[13px] font-black tracking-wide whitespace-nowrap">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                Resend Email
                                            </button>
                                        </div>
                                    @endif

                                    {{-- Name + Email (frosted-glass floating-label inputs) --}}
                                    <div class="id-grid-2 grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                        <div>
                                            <div class="id-glass-wrap relative">
                                                <input
                                                    type="text"
                                                    name="name"
                                                    id="id_name"
                                                    placeholder=" "
                                                    value="{{ old('name', Auth::user()->name) }}"
                                                    required
                                                    autocomplete="name"
                                                    class="id-float-input w-full bg-transparent border-0 outline-none px-5 pt-7 pb-3 text-[15px] font-semibold text-slate-900 placeholder-transparent"
                                                />
                                                <label for="id_name" class="id-float-label absolute left-5 top-5 text-[14px] font-medium text-slate-400">Full Name</label>
                                                <svg class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            @if ($errors->has('name'))
                                                <p class="mt-2 text-[12px] font-semibold text-rose-500 flex items-center gap-1.5">
                                                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    {{ $errors->first('name') }}
                                                </p>
                                            @endif
                                        </div>

                                        <div>
                                            <div class="id-glass-wrap relative">
                                                <input
                                                    type="email"
                                                    name="email"
                                                    id="id_email"
                                                    placeholder=" "
                                                    value="{{ old('email', Auth::user()->email) }}"
                                                    required
                                                    autocomplete="username"
                                                    class="id-float-input w-full bg-transparent border-0 outline-none px-5 pt-7 pb-3 text-[15px] font-semibold text-slate-900 placeholder-transparent"
                                                />
                                                <label for="id_email" class="id-float-label absolute left-5 top-5 text-[14px] font-medium text-slate-400">Email Address</label>
                                                <svg class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            @if ($errors->has('email'))
                                                <p class="mt-2 text-[12px] font-semibold text-rose-500 flex items-center gap-1.5">
                                                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    {{ $errors->first('email') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Timezone (bespoke select with floating label) --}}
                                    <div>
                                        <div class="id-glass-wrap relative">
                                            <select
                                                name="timezone"
                                                id="id_timezone"
                                                class="id-float-input id-float-select w-full bg-transparent border-0 outline-none px-5 pt-7 pb-3 text-[15px] font-semibold text-slate-900 appearance-none cursor-pointer pr-16"
                                            >
                                                @foreach(timezone_identifiers_list() as $tz)
                                                    <option value="{{ $tz }}" {{ old('timezone', Auth::user()->timezone) === $tz ? 'selected' : '' }}>{{ $tz }}</option>
                                                @endforeach
                                            </select>
                                            <label for="id_timezone" class="id-float-label absolute left-5 top-5 text-[14px] font-medium text-slate-400">Scheduling Timezone</label>
                                            <div class="id-select-chevron absolute right-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 pointer-events-none">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </div>
                                        </div>
                                        @if ($errors->has('timezone'))
                                            <p class="mt-2 text-[12px] font-semibold text-rose-500 flex items-center gap-1.5">
                                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                {{ $errors->first('timezone') }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Save row --}}
                                    <div class="id-form-actions flex flex-wrap items-center justify-end gap-5 pt-8 mt-8 border-t border-slate-100">
                                        @if (session('status') === 'profile-updated')
                                            <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-50 border border-emerald-200/60 text-emerald-700 text-[12px] font-black tracking-wide" style="animation: id-fade-up 0.5s ease">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                Saved Successfully
                                            </div>
                                        @endif

                                        <button type="submit" class="id-save-btn inline-flex items-center gap-3 px-7 py-4 rounded-2xl text-white text-[13px] font-black tracking-[0.06em] uppercase">
                                            <span>Save Changes</span>
                                            <span class="id-save-arrow inline-flex">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Sync floating-label state for selects --}}
                        <script>
                            (function(){
                                document.querySelectorAll('.id-float-select').forEach(function(el){
                                    var sync = function(){ el.classList.toggle('has-value', !!el.value); };
                                    el.addEventListener('change', sync);
                                    sync();
                                });
                            })();
                        </script>
                    @endif

                    <!-- Tab 2: Security -->
                    @if ($activeTab === 'security')
                        <div class="id-stagger font-sans antialiased text-slate-900">

                            {{-- ============================================================
                                 ✨ HEADER — "Security Fortress"
                                 ============================================================ --}}
                            <header class="mb-8 md:mb-10">
                                <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-emerald-50 via-teal-50 to-cyan-50 border border-emerald-100/70 mb-4">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-emerald-700">Security Frontend</span>
                                </div>
                                <h1 class="text-[40px] md:text-[52px] font-black tracking-[-0.04em] text-slate-900 leading-[1.02]">
                                    Security
                                    <span class="bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-500 bg-clip-text text-transparent">Fortress</span>
                                </h1>
                                <p class="mt-4 text-[15px] text-slate-500 max-w-2xl leading-relaxed">
                                    Your account is protected by enterprise-grade encryption. Update your password and access credentials below.
                                </p>
                            </header>

                            {{-- ============================================================
                                 ✨ UNIFIED MINIMALIST PREMIUM CARD — With Spinning Ring Animation
                                 ============================================================ --}}
                            <div class="relative bg-white rounded-[28px] border border-slate-200/70 shadow-[0_4px_28px_-10px_rgba(15,23,42,0.08)] overflow-hidden">
                                {{-- Soft background ambient mesh --}}
                                <div class="absolute -top-24 -right-24 w-72 h-72 bg-gradient-to-br from-emerald-100/30 to-teal-100/30 rounded-full blur-3xl pointer-events-none"></div>
                                <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-gradient-to-tr from-cyan-100/20 to-indigo-100/20 rounded-full blur-3xl pointer-events-none"></div>

                                {{-- Card Header with Spinning Conic Gradient Ring & Shimmer Line --}}
                                <div class="px-8 md:px-10 pt-8 pb-6 border-b border-slate-100 relative z-10">
                                    <div class="flex items-center gap-5">
                                        <div class="id-avatar-frame relative rounded-2xl overflow-visible shrink-0">
                                            <div class="id-avatar-ring rounded-2xl"></div>
                                            <div class="id-avatar-glow"></div>
                                            <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 overflow-hidden">
                                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,0.4),transparent_60%)]"></div>
                                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_80%,rgba(0,0,0,0.18),transparent_60%)]"></div>
                                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="relative drop-shadow">
                                                    <rect x="3" y="11" width="18" height="11" rx="2" stroke-linecap="round"/>
                                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke-linecap="round"/>
                                                </svg>
                                                <div class="id-shimmer-line absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent pointer-events-none"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-black text-slate-900 tracking-[-0.02em]">Credential & Password Settings</h3>
                                            <p class="text-[13px] text-slate-500 mt-0.5">Choose a strong, unique password to keep your account safe.</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Body --}}
                                <form method="post" action="{{ route('password.update') }}" id="sec-password-form" class="p-8 md:p-10 relative z-10">
                                    @csrf
                                    @method('put')

                                    {{-- Current Password --}}
                                    <div class="mb-5">
                                        <div class="id-glass-wrap relative">
                                            <input type="password" name="current_password" id="current_password" placeholder=" " autocomplete="current-password" class="id-float-input w-full bg-transparent border-0 outline-none px-5 pt-7 pb-3 text-[15px] font-semibold text-slate-900 placeholder-transparent" />
                                            <label for="current_password" class="id-float-label absolute left-5 top-5 text-[14px] font-medium text-slate-400">Current Password</label>
                                            <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition-colors" onclick="secTogglePassword('current_password', this)" aria-label="Toggle password visibility">
                                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-linecap="round"/><circle cx="12" cy="12" r="3"/></svg>
                                            </button>
                                        </div>
                                        @if ($errors->updatePassword->has('current_password'))
                                            <p class="mt-2 text-[12px] font-semibold text-rose-500 flex items-center gap-1.5">
                                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                {{ $errors->updatePassword->first('current_password') }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- New Password + Confirmation --}}
                                    <div class="id-grid-2 grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                        <div>
                                            <div class="id-glass-wrap relative">
                                                <input type="password" name="password" id="password" placeholder=" " autocomplete="new-password" class="id-float-input w-full bg-transparent border-0 outline-none px-5 pt-7 pb-3 text-[15px] font-semibold text-slate-900 placeholder-transparent" />
                                                <label for="password" class="id-float-label absolute left-5 top-5 text-[14px] font-medium text-slate-400">New Password</label>
                                                <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition-colors" onclick="secTogglePassword('password', this)" aria-label="Toggle password visibility">
                                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-linecap="round"/><circle cx="12" cy="12" r="3"/></svg>
                                                </button>
                                            </div>
                                            @if ($errors->updatePassword->has('password'))
                                                <p class="mt-2 text-[12px] font-semibold text-rose-500 flex items-center gap-1.5">
                                                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    {{ $errors->updatePassword->first('password') }}
                                                </p>
                                            @endif
                                        </div>

                                        <div>
                                            <div class="id-glass-wrap relative">
                                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder=" " autocomplete="new-password" class="id-float-input w-full bg-transparent border-0 outline-none px-5 pt-7 pb-3 text-[15px] font-semibold text-slate-900 placeholder-transparent" />
                                                <label for="password_confirmation" class="id-float-label absolute left-5 top-5 text-[14px] font-medium text-slate-400">Confirm Password</label>
                                                <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition-colors" onclick="secTogglePassword('password_confirmation', this)" aria-label="Toggle password visibility">
                                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-linecap="round"/><circle cx="12" cy="12" r="3"/></svg>
                                                </button>
                                            </div>
                                            @if ($errors->updatePassword->has('password_confirmation'))
                                                <p class="mt-2 text-[12px] font-semibold text-rose-500 flex items-center gap-1.5">
                                                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    {{ $errors->updatePassword->first('password_confirmation') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Save Action Row --}}
                                    <div class="id-form-actions flex flex-wrap items-center justify-end gap-5 pt-8 mt-6 border-t border-slate-100">
                                        @if (session('status') === 'password-updated')
                                            <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-50 border border-emerald-200/60 text-emerald-700 text-[12px] font-black tracking-wide" style="animation: id-fade-up 0.5s ease">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                Saved Successfully
                                            </div>
                                        @endif

                                        <button type="submit" class="id-save-btn inline-flex items-center gap-3 px-7 py-4 rounded-2xl text-white text-[13px] font-black tracking-[0.06em] uppercase">
                                            <span>Save Changes</span>
                                            <span class="id-save-arrow inline-flex">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </span>
                                        </button>
                                    </div>
                                </form>

                                {{-- Subtle & Refined Minimal Danger Zone Trigger --}}
                                <div class="px-8 md:px-10 py-5 bg-slate-50/60 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4 relative z-10">
                                    <div class="flex items-center gap-2.5 text-[13px] text-slate-500 font-medium">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="text-slate-400"><path d="M12 9v2m0 4h.01M5 19h14a2 2 0 001.84-2.75L13.74 4a2 2 0 00-3.48 0L3.16 16.25A2 2 0 005 19z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Need to permanently delete your account & data?
                                    </div>
                                    <button type="button" onclick="document.getElementById('m-delete-modal').classList.add('is-open')" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-rose-600 hover:text-rose-700 hover:bg-rose-50 border border-rose-200/60 text-[12px] font-bold transition-all">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Delete Account
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Modal for delete --}}
                        <div id="m-delete-modal" class="sec-modal {{ $errors->userDeletion->isNotEmpty() ? 'is-open' : '' }} fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 opacity-0 pointer-events-none transition-opacity duration-300 [&.is-open]:opacity-100 [&.is-open]:pointer-events-auto">
                            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="document.getElementById('m-delete-modal').classList.remove('is-open')"></div>
                            
                            <div class="relative w-full max-w-lg bg-white rounded-[28px] shadow-2xl shadow-rose-900/10 border border-rose-100 p-8 sm:p-10 transform scale-95 transition-transform duration-300 [&.is-open]:scale-100">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rose-50 to-rose-100 flex items-center justify-center text-rose-600 border border-rose-200/70 shadow-sm shadow-rose-500/10 shrink-0">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M5 19h14a2 2 0 001.84-2.75L13.74 4a2 2 0 00-3.48 0L3.16 16.25A2 2 0 005 19z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-rose-900 tracking-[-0.02em] leading-tight">Are you absolutely sure?</h3>
                                        <p class="text-[13px] text-rose-700/80 mt-1">This action is destructive and irreversible.</p>
                                    </div>
                                </div>

                                <div class="bg-rose-50/50 border border-rose-100 rounded-2xl p-5 mb-8">
                                    <p class="text-[13px] font-bold text-rose-900 mb-2">What will be permanently deleted:</p>
                                    <ul class="text-[13px] text-rose-700 space-y-1.5 ml-4 list-disc marker:text-rose-400">
                                        <li>All your projects & campaigns</li>
                                        <li>Unused campaign credits</li>
                                        <li>Social media connections</li>
                                        <li>Account history & analytics</li>
                                    </ul>
                                </div>

                                <form method="post" action="{{ route('profile.destroy') }}" onsubmit="this.querySelector('button[type=submit]').disabled = true; this.querySelector('button[type=submit] span').innerText = 'Deleting...';">
                                    @csrf
                                    @method('delete')

                                    <div class="mb-8">
                                        <div class="id-glass-wrap relative border-rose-200 focus-within:border-rose-500">
                                            <input type="password" name="password" id="delete_password" placeholder=" " required class="id-float-input w-full bg-transparent border-0 outline-none px-5 pt-7 pb-3 text-[15px] font-semibold text-slate-900 placeholder-transparent" />
                                            <label for="delete_password" class="id-float-label absolute left-5 top-5 text-[14px] font-medium text-rose-500">Confirm with your password</label>
                                            <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition-colors" onclick="secTogglePassword('delete_password', this)" aria-label="Toggle password visibility">
                                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-linecap="round"/><circle cx="12" cy="12" r="3"/></svg>
                                            </button>
                                        </div>
                                        @if ($errors->userDeletion->has('password'))
                                            <p class="mt-2 text-[12px] font-semibold text-rose-500 flex items-center gap-1.5">
                                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                {{ $errors->userDeletion->first('password') }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex items-center justify-end gap-3 pt-2">
                                        <button type="button" class="px-5 py-3 rounded-xl text-[13px] font-bold text-slate-600 hover:bg-slate-100 transition-colors" onclick="document.getElementById('m-delete-modal').classList.remove('is-open')">Cancel</button>
                                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-[13px] font-bold transition-colors shadow-sm shadow-rose-500/20">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <span>Permanently Delete</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            function secTogglePassword(inputId, btn) {
                                const input = document.getElementById(inputId);
                                if (input.type === 'password') {
                                    input.type = 'text';
                                    btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24M1 1l22 22" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                } else {
                                    input.type = 'password';
                                    btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-linecap="round"/><circle cx="12" cy="12" r="3"/></svg>';
                                }
                            }

                            document.addEventListener('keydown', (e) => {
                                if (e.key === 'Escape') {
                                    document.getElementById('m-delete-modal').classList.remove('is-open');
                                }
                            });
                        </script>
                    @endif


<!-- Tab 3: Credits & Top-Up -->
                @if ($activeTab === 'billing')
                    {{-- ============================================================ --}}
                    {{-- 🎨 PREMIUM BILLING TAB — REDESIGNED 2026                       --}}
                    {{-- ============================================================ --}}

                    {{-- 1️⃣ VIP ANNUAL WAITLIST (Premium Amber-Gold) --}}
                    @php
                        $alreadyOnWaitlist = \App\Models\WaitlistSignup::where('email', Auth::user()->email)
                            ->where('plan_interest', 'annual')
                            ->exists();
                    @endphp

                    <div class="vip-waitlist">
                        <div class="vip-shimmer"></div>
                        <div class="vip-orb vip-orb-1"></div>
                        <div class="vip-orb vip-orb-2"></div>

                        <div class="vip-content">
                            <div class="vip-icon-wrap">
                                <div class="vip-icon-bg">
                                    <span class="vip-icon">💎</span>
                                </div>
                                <div class="vip-icon-ring"></div>
                            </div>

                            <div class="vip-text">
                                <div class="vip-eyebrow">
                                    <span class="vip-dot"></span>
                                    EXCLUSIVE INVITATION
                                </div>
                                <h3 class="vip-title">Annual Plans Launching Soon</h3>
                                <p class="vip-desc">
                                    Reserve your spot for <strong>25% savings</strong> + 3 months free.
                                    Early-bird pricing for our first 100 members only.
                                </p>
                            </div>

                            @if ($alreadyOnWaitlist)
                                <div class="vip-confirmed">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    You're on the VIP list
                                </div>
                            @else
                                <form action="{{ route('waitlist.annual') }}" method="POST" class="vip-form">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                    <input type="hidden" name="source" value="profile_billing">
                                    <button type="submit" class="vip-btn">
                                        <span>Reserve My Spot</span>
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M13 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- 2️⃣ STYLES --}}
                    <style>
                        /* ============ ANIMATIONS ============ */
                        @keyframes vip-shimmer {
                            0% { transform: translateX(-150%) skewX(-20deg); }
                            100% { transform: translateX(250%) skewX(-20deg); }
                        }
                        @keyframes vip-orb-float {
                            0%, 100% { transform: translate(0, 0) scale(1); }
                            50% { transform: translate(20px, -20px) scale(1.1); }
                        }
                        @keyframes wallet-glow {
                            0%, 100% { opacity: 0.4; transform: rotate(0deg); }
                            50% { opacity: 0.7; transform: rotate(180deg); }
                        }
                        @keyframes count-pulse {
                            0%, 100% { transform: scale(1); }
                            50% { transform: scale(1.03); }
                        }
                        @keyframes pro-border-spin {
                            0% { background-position: 0% 50%; }
                            50% { background-position: 100% 50%; }
                            100% { background-position: 0% 50%; }
                        }
                        @keyframes pro-glow {
                            0%, 100% { box-shadow: 0 0 40px rgba(99, 102, 241, 0.3), 0 20px 50px -10px rgba(0,0,0,0.4); }
                            50% { box-shadow: 0 0 60px rgba(99, 102, 241, 0.5), 0 25px 60px -10px rgba(0,0,0,0.5); }
                        }
                        @keyframes badge-float {
                            0%, 100% { transform: translateY(0); }
                            50% { transform: translateY(-3px); }
                        }
                        @keyframes fade-up {
                            from { opacity: 0; transform: translateY(20px); }
                            to { opacity: 1; transform: translateY(0); }
                        }

                        /* ============ VIP WAITLIST ============ */
                        .vip-waitlist {
                            position: relative;
                            overflow: hidden;
                            border-radius: 28px;
                            padding: 2rem;
                            margin-bottom: 2rem;
                            background:
                                linear-gradient(135deg, #FEF3C7 0%, #FED7AA 40%, #FBBF24 100%);
                            border: 1px solid rgba(245, 158, 11, 0.3);
                            box-shadow:
                                0 30px 60px -20px rgba(245, 158, 11, 0.4),
                                inset 0 1px 0 rgba(255,255,255,0.6);
                            animation: fade-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                        }
                        .vip-shimmer {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 60%;
                            height: 100%;
                            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
                            animation: vip-shimmer 4s ease-in-out infinite;
                            pointer-events: none;
                        }
                        .vip-orb {
                            position: absolute;
                            border-radius: 50%;
                            filter: blur(40px);
                            pointer-events: none;
                        }
                        .vip-orb-1 {
                            top: -50%;
                            right: -10%;
                            width: 300px;
                            height: 300px;
                            background: radial-gradient(circle, rgba(245, 158, 11, 0.4), transparent 70%);
                            animation: vip-orb-float 8s ease-in-out infinite;
                        }
                        .vip-orb-2 {
                            bottom: -50%;
                            left: -10%;
                            width: 300px;
                            height: 300px;
                            background: radial-gradient(circle, rgba(239, 68, 68, 0.3), transparent 70%);
                            animation: vip-orb-float 10s ease-in-out infinite reverse;
                        }
                        .vip-content {
                            position: relative;
                            z-index: 2;
                            display: grid;
                            grid-template-columns: auto 1fr auto;
                            gap: 1.5rem;
                            align-items: center;
                        }
                        @media (max-width: 768px) {
                            .vip-content { grid-template-columns: 1fr; text-align: center; }
                        }
                        .vip-icon-wrap {
                            position: relative;
                            width: 72px;
                            height: 72px;
                        }
                        .vip-icon-bg {
                            position: absolute;
                            inset: 0;
                            background: linear-gradient(135deg, #F59E0B 0%, #DC2626 100%);
                            border-radius: 20px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            box-shadow: 0 15px 30px -8px rgba(245, 158, 11, 0.6);
                            transform: rotate(-6deg);
                        }
                        .vip-icon {
                            font-size: 32px;
                            transform: rotate(6deg);
                            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
                        }
                        .vip-icon-ring {
                            position: absolute;
                            inset: -6px;
                            border: 2px dashed rgba(245, 158, 11, 0.5);
                            border-radius: 24px;
                            animation: badge-float 3s ease-in-out infinite;
                        }
                        .vip-text { min-width: 0; }
                        .vip-eyebrow {
                            display: inline-flex;
                            align-items: center;
                            gap: 0.5rem;
                            font-size: 11px;
                            font-weight: 800;
                            color: #92400E;
                            letter-spacing: 0.15em;
                            margin-bottom: 0.5rem;
                        }
                        .vip-dot {
                            width: 6px;
                            height: 6px;
                            border-radius: 50%;
                            background: #DC2626;
                            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.2);
                            animation: count-pulse 2s ease-in-out infinite;
                        }
                        .vip-title {
                            font-size: 1.5rem;
                            font-weight: 900;
                            color: #7C2D12;
                            letter-spacing: -0.02em;
                            margin: 0 0 0.5rem 0;
                            line-height: 1.2;
                        }
                        .vip-desc {
                            font-size: 0.9rem;
                            color: #78350F;
                            line-height: 1.5;
                            margin: 0;
                            max-width: 480px;
                        }
                        .vip-desc strong { color: #7C2D12; font-weight: 800; }
                        .vip-btn {
                            display: inline-flex;
                            align-items: center;
                            gap: 0.5rem;
                            padding: 1rem 1.75rem;
                            background: linear-gradient(135deg, #7C2D12 0%, #451A03 100%);
                            color: #FEF3C7;
                            border: none;
                            border-radius: 14px;
                            font-weight: 800;
                            font-size: 0.85rem;
                            letter-spacing: 0.05em;
                            text-transform: uppercase;
                            cursor: pointer;
                            box-shadow:
                                0 15px 30px -8px rgba(124, 45, 18, 0.5),
                                inset 0 1px 0 rgba(255,255,255,0.15);
                            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                            white-space: nowrap;
                        }
                        .vip-btn:hover {
                            transform: translateY(-3px) scale(1.02);
                            box-shadow:
                                0 20px 40px -8px rgba(124, 45, 18, 0.7),
                                inset 0 1px 0 rgba(255,255,255,0.2);
                        }
                        .vip-btn svg { transition: transform 0.3s; }
                        .vip-btn:hover svg { transform: translateX(4px); }
                        .vip-confirmed {
                            display: inline-flex;
                            align-items: center;
                            gap: 0.5rem;
                            padding: 1rem 1.75rem;
                            background: linear-gradient(135deg, #10B981 0%, #047857 100%);
                            color: white;
                            border-radius: 14px;
                            font-weight: 800;
                            font-size: 0.85rem;
                            letter-spacing: 0.05em;
                            text-transform: uppercase;
                            box-shadow: 0 15px 30px -8px rgba(16, 185, 129, 0.5);
                        }

                        /* ============ HEADER ============ */
                        .billing-header {
                            margin-bottom: 1.5rem;
                            animation: fade-up 0.8s 0.1s cubic-bezier(0.16, 1, 0.3, 1) backwards;
                        }
                        .billing-title {
                            font-size: 2.25rem;
                            font-weight: 900;
                            letter-spacing: -0.04em;
                            color: #0A0A0A;
                            margin: 0 0 0.5rem 0;
                            line-height: 1.1;
                        }
                        .billing-title span {
                            background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 50%, #EC4899 100%);
                            -webkit-background-clip: text;
                            background-clip: text;
                            -webkit-text-fill-color: transparent;
                        }
                        .billing-subtitle {
                            font-size: 1.05rem;
                            color: #71717A;
                            margin: 0;
                            line-height: 1.5;
                            max-width: 600px;
                        }

                        /* ============ DIGITAL WALLET ============ */
                        .digital-wallet {
                            position: relative;
                            overflow: hidden;
                            border-radius: 28px;
                            padding: 2rem 2.5rem;
                            margin-bottom: 2rem;
                            background:
                                radial-gradient(ellipse at top left, #1E1B4B 0%, transparent 50%),
                                radial-gradient(ellipse at bottom right, #4C1D95 0%, transparent 50%),
                                linear-gradient(135deg, #0A0A0A 0%, #171717 100%);
                            color: white;
                            box-shadow:
                                0 30px 60px -20px rgba(0,0,0,0.5),
                                inset 0 1px 0 rgba(255,255,255,0.08);
                            animation: fade-up 0.8s 0.2s cubic-bezier(0.16, 1, 0.3, 1) backwards;
                        }
                        .digital-wallet::before {
                            content: '';
                            position: absolute;
                            top: -50%;
                            right: -10%;
                            width: 400px;
                            height: 400px;
                            background: conic-gradient(from 0deg, transparent, rgba(99, 102, 241, 0.3), transparent);
                            filter: blur(60px);
                            animation: wallet-glow 8s linear infinite;
                            pointer-events: none;
                        }
                        .digital-wallet::after {
                            content: '';
                            position: absolute;
                            inset: 0;
                            background:
                                linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.03) 50%, transparent 100%);
                            pointer-events: none;
                        }
                        .wallet-grid {
                            position: relative;
                            z-index: 2;
                            display: grid;
                            grid-template-columns: 1fr auto;
                            gap: 2rem;
                            align-items: center;
                        }
                        .wallet-label {
                            display: inline-flex;
                            align-items: center;
                            gap: 0.5rem;
                            font-size: 0.8rem;
                            font-weight: 700;
                            color: #A5B4FC;
                            text-transform: uppercase;
                            letter-spacing: 0.15em;
                            margin-bottom: 0.75rem;
                        }
                        .wallet-label::before {
                            content: '';
                            width: 8px;
                            height: 8px;
                            border-radius: 50%;
                            background: #10B981;
                            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
                            animation: count-pulse 2s ease-in-out infinite;
                        }
                        .wallet-value {
                            font-size: 4rem;
                            font-weight: 900;
                            font-family: 'Inter', monospace;
                            line-height: 1;
                            letter-spacing: -0.04em;
                            background: linear-gradient(135deg, #FFFFFF 0%, #A5B4FC 100%);
                            -webkit-background-clip: text;
                            background-clip: text;
                            -webkit-text-fill-color: transparent;
                            animation: count-pulse 4s ease-in-out infinite;
                        }
                        .wallet-meta {
                            font-size: 0.85rem;
                            color: #71717A;
                            margin-top: 0.75rem;
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                        }
                        .wallet-meta-dot {
                            width: 4px;
                            height: 4px;
                            border-radius: 50%;
                            background: #6366F1;
                        }
                        .wallet-icon {
                            width: 80px;
                            height: 80px;
                            border-radius: 24px;
                            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
                            border: 1px solid rgba(99, 102, 241, 0.3);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            backdrop-filter: blur(20px);
                            position: relative;
                        }
                        .wallet-icon svg { color: #A5B4FC; }
                        .wallet-icon::before {
                            content: '';
                            position: absolute;
                            inset: -1px;
                            border-radius: inherit;
                            background: linear-gradient(135deg, rgba(99, 102, 241, 0.5), transparent, rgba(139, 92, 246, 0.5));
                            z-index: -1;
                            filter: blur(10px);
                            opacity: 0.6;
                        }

                        /* ============ VALUE STRIP ============ */
                        .value-strip {
                            display: grid;
                            grid-template-columns: repeat(3, 1fr);
                            gap: 1rem;
                            margin-bottom: 2rem;
                            animation: fade-up 0.8s 0.3s cubic-bezier(0.16, 1, 0.3, 1) backwards;
                        }
                        @media (max-width: 640px) {
                            .value-strip { grid-template-columns: 1fr; }
                        }
                        .value-item {
                            display: flex;
                            align-items: center;
                            gap: 0.75rem;
                            padding: 1rem 1.25rem;
                            background: linear-gradient(135deg, #FAFAFA 0%, #FFFFFF 100%);
                            border: 1px solid rgba(0,0,0,0.06);
                            border-radius: 16px;
                            transition: all 0.3s;
                        }
                        .value-item:hover {
                            border-color: #6366F1;
                            transform: translateY(-2px);
                            box-shadow: 0 10px 25px -10px rgba(99, 102, 241, 0.3);
                        }
                        .value-icon {
                            width: 40px;
                            height: 40px;
                            border-radius: 12px;
                            background: linear-gradient(135deg, #EEF2FF 0%, #F5F3FF 100%);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 20px;
                            flex-shrink: 0;
                        }
                        .value-text {
                            font-size: 0.85rem;
                            font-weight: 700;
                            color: #18181B;
                            line-height: 1.3;
                        }
                        .value-text small {
                            display: block;
                            font-size: 0.7rem;
                            font-weight: 500;
                            color: #71717A;
                            margin-top: 2px;
                        }

                        /* ============ SOCIAL PROOF ============ */
                        .social-proof {
                            text-align: center;
                            margin-bottom: 1.5rem;
                            animation: fade-up 0.8s 0.35s cubic-bezier(0.16, 1, 0.3, 1) backwards;
                        }
                        .social-proof-text {
                            display: inline-flex;
                            align-items: center;
                            gap: 0.5rem;
                            font-size: 0.85rem;
                            color: #52525B;
                            font-weight: 500;
                        }
                        .social-proof-avatars {
                            display: inline-flex;
                            margin-right: 0.5rem;
                        }
                        .social-avatar {
                            width: 24px;
                            height: 24px;
                            border-radius: 50%;
                            border: 2px solid white;
                            margin-left: -8px;
                            background: linear-gradient(135deg, #F59E0B, #EC4899);
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 11px;
                            color: white;
                            font-weight: 800;
                        }
                        .social-avatar:first-child { margin-left: 0; }
                        .social-avatar:nth-child(2) { background: linear-gradient(135deg, #6366F1, #8B5CF6); }
                        .social-avatar:nth-child(3) { background: linear-gradient(135deg, #10B981, #059669); }
                        .social-avatar:nth-child(4) { background: linear-gradient(135deg, #EF4444, #DC2626); }
                        .social-proof strong { color: #0A0A0A; font-weight: 800; }

                        /* ============ PRICING GRID ============ */
                        .pricing-grid {
                            display: grid;
                            grid-template-columns: repeat(3, 1fr);
                            gap: 1.5rem;
                            margin-bottom: 2rem;
                            align-items: center;
                        }
                        @media (max-width: 1024px) {
                            .pricing-grid { grid-template-columns: 1fr; }
                        }

                        /* Base pack card */
                        .pack-card {
                            position: relative;
                            border-radius: 24px;
                            padding: 2rem 1.75rem;
                            display: flex;
                            flex-direction: column;
                            min-height: 480px;
                            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
                            overflow: hidden;
                            animation: fade-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) backwards;
                        }
                        .pack-card:nth-child(1) { animation-delay: 0.4s; }
                        .pack-card:nth-child(2) { animation-delay: 0.5s; }
                        .pack-card:nth-child(3) { animation-delay: 0.6s; }

                        /* ===== STARTER (Clean White) ===== */
                        .pack-card.starter {
                            background: linear-gradient(180deg, #FFFFFF 0%, #FAFAFA 100%);
                            border: 1px solid rgba(0,0,0,0.08);
                            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);
                        }
                        .pack-card.starter:hover {
                            transform: translateY(-8px);
                            box-shadow: 0 30px 60px -15px rgba(0,0,0,0.15);
                            border-color: rgba(0,0,0,0.15);
                        }

                        /* ===== PRO (Dark + Glow Border) ===== */
                        .pack-card.pro {
                            background: linear-gradient(180deg, #0A0A0A 0%, #171717 100%);
                            color: white;
                            transform: scale(1.05);
                            z-index: 2;
                            animation: pro-glow 4s ease-in-out infinite;
                        }
                        .pack-card.pro::before {
                            content: '';
                            position: absolute;
                            inset: -2px;
                            border-radius: inherit;
                            background: linear-gradient(135deg, #6366F1, #8B5CF6, #EC4899, #6366F1);
                            background-size: 300% 300%;
                            z-index: -1;
                            animation: pro-border-spin 6s linear infinite;
                        }
                        .pack-card.pro::after {
                            content: '';
                            position: absolute;
                            inset: 0;
                            border-radius: inherit;
                            background:
                                radial-gradient(circle at top right, rgba(99, 102, 241, 0.2), transparent 50%),
                                radial-gradient(circle at bottom left, rgba(236, 72, 153, 0.15), transparent 50%);
                            pointer-events: none;
                        }
                        .pack-card.pro:hover {
                            transform: scale(1.08) translateY(-8px);
                        }

                        /* ===== AGENCY (Purple-Gold Premium) ===== */
                        .pack-card.agency {
                            background: linear-gradient(135deg, #1E1B4B 0%, #312E81 60%, #1E1B4B 100%);
                            color: white;
                            border: 1px solid rgba(245, 158, 11, 0.3);
                            box-shadow: 0 20px 40px -15px rgba(30, 27, 75, 0.5);
                            position: relative;
                        }
                        .pack-card.agency::before {
                            content: '';
                            position: absolute;
                            top: -50%;
                            right: -50%;
                            width: 200%;
                            height: 200%;
                            background: radial-gradient(circle, rgba(245, 158, 11, 0.15), transparent 50%);
                            pointer-events: none;
                        }
                        .pack-card.agency:hover {
                            transform: translateY(-8px);
                            box-shadow: 0 30px 60px -15px rgba(245, 158, 11, 0.4);
                            border-color: rgba(245, 158, 11, 0.6);
                        }

                        /* ===== BADGES ===== */
                        .pack-badge-top {
                            position: absolute;
                            top: 1.25rem;
                            right: 1.25rem;
                            padding: 0.4rem 0.9rem;
                            background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
                            color: white;
                            font-size: 0.65rem;
                            font-weight: 900;
                            letter-spacing: 0.1em;
                            text-transform: uppercase;
                            border-radius: 100px;
                            box-shadow: 0 8px 20px -4px rgba(99, 102, 241, 0.5);
                            z-index: 3;
                            animation: badge-float 3s ease-in-out infinite;
                        }
                        .pack-badge-gold {
                            position: absolute;
                            top: 1.25rem;
                            right: 1.25rem;
                            padding: 0.4rem 0.9rem;
                            background: linear-gradient(135deg, #F59E0B 0%, #EF4444 100%);
                            color: white;
                            font-size: 0.65rem;
                            font-weight: 900;
                            letter-spacing: 0.1em;
                            text-transform: uppercase;
                            border-radius: 100px;
                            box-shadow: 0 8px 20px -4px rgba(245, 158, 11, 0.5);
                            z-index: 3;
                            animation: badge-float 3s ease-in-out infinite 0.5s;
                        }

                        /* ===== PACK CONTENT ===== */
                        .pack-header {
                            display: flex;
                            align-items: center;
                            gap: 0.75rem;
                            margin-bottom: 1.25rem;
                        }
                        .pack-icon {
                            width: 44px;
                            height: 44px;
                            border-radius: 12px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 22px;
                            flex-shrink: 0;
                        }
                        .pack-card.starter .pack-icon { background: linear-gradient(135deg, #FEF3C7, #FED7AA); }
                        .pack-card.pro .pack-icon { background: linear-gradient(135deg, rgba(99, 102, 241, 0.3), rgba(139, 92, 246, 0.3)); border: 1px solid rgba(99, 102, 241, 0.4); }
                        .pack-card.agency .pack-icon { background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(239, 68, 68, 0.3)); border: 1px solid rgba(245, 158, 11, 0.4); }

                        .pack-name {
                            font-size: 1.1rem;
                            font-weight: 800;
                            letter-spacing: -0.01em;
                            margin: 0;
                        }
                        .pack-card.starter .pack-name { color: #18181B; }
                        .pack-card.pro .pack-name { color: white; }
                        .pack-card.agency .pack-name { color: #FED7AA; }
                        .pack-tagline {
                            font-size: 0.75rem;
                            font-weight: 500;
                            opacity: 0.7;
                            margin: 0;
                        }

                        .pack-price-row {
                            display: flex;
                            align-items: baseline;
                            gap: 0.25rem;
                            margin-bottom: 0.5rem;
                        }
                        .pack-currency {
                            font-size: 1.5rem;
                            font-weight: 700;
                            opacity: 0.7;
                        }
                        .pack-price {
                            font-size: 3rem;
                            font-weight: 900;
                            letter-spacing: -0.04em;
                            line-height: 1;
                        }
                        .pack-card.starter .pack-price { color: #0A0A0A; }
                        .pack-card.pro .pack-price { background: linear-gradient(135deg, #FFFFFF, #A5B4FC); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
                        .pack-card.agency .pack-price { background: linear-gradient(135deg, #FFFFFF, #FED7AA); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }

                        .pack-unit {
                            font-size: 0.8rem;
                            font-weight: 600;
                            opacity: 0.7;
                            margin-bottom: 1.25rem;
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                        }
                        .pack-save-pill {
                            display: inline-block;
                            padding: 0.2rem 0.6rem;
                            background: linear-gradient(135deg, #10B981, #059669);
                            color: white;
                            font-size: 0.65rem;
                            font-weight: 800;
                            letter-spacing: 0.05em;
                            border-radius: 100px;
                            box-shadow: 0 4px 10px -2px rgba(16, 185, 129, 0.4);
                        }

                        .pack-features {
                            list-style: none;
                            padding: 0;
                            margin: 0 0 1.5rem 0;
                            flex-grow: 1;
                        }
                        .pack-features li {
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                            font-size: 0.85rem;
                            font-weight: 500;
                            padding: 0.4rem 0;
                            opacity: 0.9;
                        }
                        .pack-features li::before {
                            content: '✓';
                            width: 18px;
                            height: 18px;
                            border-radius: 50%;
                            background: rgba(16, 185, 129, 0.2);
                            color: #10B981;
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 11px;
                            font-weight: 900;
                            flex-shrink: 0;
                        }
                        .pack-card.pro .pack-features li::before { background: rgba(99, 102, 241, 0.3); color: #A5B4FC; }
                        .pack-card.agency .pack-features li::before { background: rgba(245, 158, 11, 0.3); color: #FED7AA; }

                        .pack-btn {
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            width: 100%;
                            padding: 1rem 1.25rem;
                            border: none;
                            border-radius: 14px;
                            font-weight: 800;
                            font-size: 0.85rem;
                            letter-spacing: 0.05em;
                            text-transform: uppercase;
                            text-decoration: none;
                            cursor: pointer;
                            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                            margin-top: auto;
                            position: relative;
                            overflow: hidden;
                        }
                        .pack-btn::before {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: -100%;
                            width: 100%;
                            height: 100%;
                            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
                            transition: left 0.6s;
                        }
                        .pack-btn:hover::before { left: 100%; }

                        .pack-card.starter .pack-btn {
                            background: #0A0A0A;
                            color: white;
                            box-shadow: 0 10px 20px -8px rgba(0,0,0,0.3);
                        }
                        .pack-card.starter .pack-btn:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 15px 30px -8px rgba(0,0,0,0.4);
                        }

                        .pack-card.pro .pack-btn {
                            background: linear-gradient(135deg, #FFFFFF 0%, #E0E7FF 100%);
                            color: #0A0A0A;
                            box-shadow: 0 15px 30px -8px rgba(255,255,255,0.3);
                        }
                        .pack-card.pro .pack-btn:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 20px 40px -8px rgba(255,255,255,0.5);
                        }

                        .pack-card.agency .pack-btn {
                            background: linear-gradient(135deg, #F59E0B 0%, #EF4444 100%);
                            color: white;
                            box-shadow: 0 15px 30px -8px rgba(245, 158, 11, 0.5);
                        }
                        .pack-card.agency .pack-btn:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 20px 40px -8px rgba(245, 158, 11, 0.7);
                        }

                        .pack-btn-sub {
                            display: block;
                            font-size: 0.65rem;
                            font-weight: 500;
                            opacity: 0.7;
                            margin-top: 0.25rem;
                            text-transform: none;
                            letter-spacing: 0;
                        }

                        /* ============ TRUST SECTION ============ */
                        .trust-section {
                            display: grid;
                            grid-template-columns: repeat(4, 1fr);
                            gap: 1rem;
                            padding: 1.5rem;
                            margin-bottom: 1.5rem;
                            background: linear-gradient(135deg, #FAFAFA 0%, #FFFFFF 100%);
                            border: 1px solid rgba(0,0,0,0.06);
                            border-radius: 20px;
                            animation: fade-up 0.8s 0.7s cubic-bezier(0.16, 1, 0.3, 1) backwards;
                        }
                        @media (max-width: 768px) {
                            .trust-section { grid-template-columns: repeat(2, 1fr); }
                        }
                        .trust-badge {
                            display: flex;
                            align-items: center;
                            gap: 0.75rem;
                        }
                        .trust-icon {
                            width: 36px;
                            height: 36px;
                            border-radius: 10px;
                            background: white;
                            border: 1px solid rgba(0,0,0,0.08);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 16px;
                            flex-shrink: 0;
                            box-shadow: 0 4px 10px -2px rgba(0,0,0,0.05);
                        }
                        .trust-text {
                            font-size: 0.75rem;
                            font-weight: 700;
                            color: #18181B;
                            line-height: 1.3;
                        }
                        .trust-text small {
                            display: block;
                            font-size: 0.65rem;
                            font-weight: 500;
                            color: #71717A;
                            margin-top: 2px;
                        }

                        /* ============ ANNUAL NOTE ============ */
                        .annual-note {
                            text-align: center;
                            padding: 1rem 1.5rem;
                            background: linear-gradient(135deg, rgba(245, 158, 11, 0.05), rgba(239, 68, 68, 0.05));
                            border: 1px solid rgba(245, 158, 11, 0.2);
                            border-radius: 14px;
                            font-size: 0.85rem;
                            color: #78350F;
                            font-weight: 500;
                            line-height: 1.5;
                        }
                        .annual-note a {
                            color: #7C2D12;
                            font-weight: 800;
                            text-decoration: none;
                            border-bottom: 2px solid rgba(124, 45, 18, 0.3);
                            transition: border-color 0.3s;
                        }
                        .annual-note a:hover { border-color: #7C2D12; }
                    </style>

                    {{-- 3️⃣ MAIN CONTENT --}}
                    <div class="billing-wrapper">

                        {{-- ERROR MESSAGE --}}
                        @if(request()->query('error') === 'credits_required')
                            <div class="vip-waitlist" style="background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%); border-color: rgba(239, 68, 68, 0.3); margin-bottom: 1.5rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #EF4444, #DC2626); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: 900;">!</div>
                                    <div>
                                        <h4 style="font-weight: 900; font-size: 1.1rem; color: #7F1D1D; margin: 0 0 0.25rem 0;">Insufficient Credits</h4>
                                        <p style="font-size: 0.9rem; color: #991B1B; margin: 0; opacity: 0.9;">You need at least 1 campaign credit to generate an AI campaign. Top up your balance below.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- HEADER --}}
                        <header class="billing-header">
                            <h2 class="billing-title">Credits & <span>Top-Up</span></h2>
                            <p class="billing-subtitle">Power your AI engine. Pay only for campaigns you generate. No subscriptions, no expiry.</p>
                        </header>

                        {{-- DIGITAL WALLET --}}
                        <div class="digital-wallet">
                            <div class="wallet-grid">
                                <div>
                                    <div class="wallet-label">Available Credits</div>
                                    <div class="wallet-value">{{ Auth::user()->campaign_credits }}</div>
                                    <div class="wallet-meta">
                                        <span class="wallet-meta-dot"></span>
                                        ≈ {{ number_format(Auth::user()->campaign_credits * 90) }} AI-generated posts ready
                                    </div>
                                </div>
                                <div class="wallet-icon">
                                    <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                            </div>
                        </div>

                        {{-- VALUE STRIP --}}
                        <div class="value-strip">
                            <div class="value-item">
                                <div class="value-icon">📅</div>
                                <div class="value-text">30 Days of Content<small>per credit</small></div>
                            </div>
                            <div class="value-item">
                                <div class="value-icon">🎯</div>
                                <div class="value-text">3 Platforms<small>LinkedIn, X, Facebook</small></div>
                            </div>
                            <div class="value-item">
                                <div class="value-icon">⚡</div>
                                <div class="value-text">90 Posts<small>AI-crafted & scheduled</small></div>
                            </div>
                        </div>

                        {{-- SOCIAL PROOF --}}
                        <div class="social-proof">
                            <div class="social-proof-text">
                                <span class="social-proof-avatars">
                                    <span class="social-avatar">A</span>
                                    <span class="social-avatar">M</span>
                                    <span class="social-avatar">S</span>
                                    <span class="social-avatar">+</span>
                                </span>
                                Join <strong>500+ creators</strong> automating their social media with <strong>PostPilot</strong>
                            </div>
                        </div>

                        {{-- PRICING GRID --}}
                        <div class="pricing-grid">

                            {{-- STARTER --}}
                            <div class="pack-card starter">
                                <div class="pack-header">
                                    <div class="pack-icon">🌱</div>
                                    <div>
                                        <h3 class="pack-name">Starter</h3>
                                        <p class="pack-tagline">Perfect for trying out</p>
                                    </div>
                                </div>
                                <div class="pack-price-row">
                                    <span class="pack-currency">$</span>
                                    <span class="pack-price">9.99</span>
                                </div>
                                <div class="pack-unit">$9.99 per credit</div>
                                <ul class="pack-features">
                                    <li>1 full 30-day campaign</li>
                                    <li>90 AI-crafted posts</li>
                                    <li>All 3 platforms</li>
                                    <li>Auto-publishing</li>
                                </ul>
                                <a href="https://{{ config('services.dodo.mode') === 'test' ? 'test.checkout.dodopayments.com' : 'checkout.dodopayments.com' }}/buy/{{ config('services.dodo.link_1_campaign') }}?email={{ urlencode(Auth::user()->email) }}&redirect_url={{ urlencode(route('profile.edit', ['tab' => 'billing'])) }}" class="pack-btn">
                                    Get Started
                                    <span class="pack-btn-sub">Instant access</span>
                                </a>
                            </div>

                            {{-- PRO (Most Popular) --}}
                            <div class="pack-card pro">
                                <div class="pack-badge-top">⭐ Most Popular</div>
                                <div class="pack-header">
                                    <div class="pack-icon">🚀</div>
                                    <div>
                                        <h3 class="pack-name">Pro</h3>
                                        <p class="pack-tagline">Best for growing creators</p>
                                    </div>
                                </div>
                                <div class="pack-price-row">
                                    <span class="pack-currency">$</span>
                                    <span class="pack-price">25.99</span>
                                </div>
                                <div class="pack-unit">
                                    $8.66 per credit
                                    <span class="pack-save-pill">Save 13%</span>
                                </div>
                                <ul class="pack-features">
                                    <li>3 full 30-day campaigns</li>
                                    <li>270 AI-crafted posts</li>
                                    <li>Multiple projects support</li>
                                    <li>Priority AI processing</li>
                                    <li>Advanced analytics</li>
                                </ul>
                                <a href="https://{{ config('services.dodo.mode') === 'test' ? 'test.checkout.dodopayments.com' : 'checkout.dodopayments.com' }}/buy/{{ config('services.dodo.link_3_campaigns') }}?email={{ urlencode(Auth::user()->email) }}&redirect_url={{ urlencode(route('profile.edit', ['tab' => 'billing'])) }}" class="pack-btn">
                                    Go Pro Now
                                    <span class="pack-btn-sub">Unlock 3 campaigns</span>
                                </a>
                            </div>

                            {{-- AGENCY --}}
                            <div class="pack-card agency">
                                <div class="pack-badge-gold">👑 Best Value</div>
                                <div class="pack-header">
                                    <div class="pack-icon">💎</div>
                                    <div>
                                        <h3 class="pack-name">Agency</h3>
                                        <p class="pack-tagline">For agencies & power users</p>
                                    </div>
                                </div>
                                <div class="pack-price-row">
                                    <span class="pack-currency">$</span>
                                    <span class="pack-price">69.99</span>
                                </div>
                                <div class="pack-unit">
                                    $7.00 per credit
                                    <span class="pack-save-pill">Save 30%</span>
                                </div>
                                <ul class="pack-features">
                                    <li>10 full 30-day campaigns</li>
                                    <li>900 AI-crafted posts</li>
                                    <li>Unlimited projects</li>
                                    <li>White-label exports</li>
                                    <li>Dedicated support</li>
                                    <li>Early access to features</li>
                                </ul>
                                <a href="https://{{ config('services.dodo.mode') === 'test' ? 'test.checkout.dodopayments.com' : 'checkout.dodopayments.com' }}/buy/{{ config('services.dodo.link_10_campaigns') }}?email={{ urlencode(Auth::user()->email) }}&redirect_url={{ urlencode(route('profile.edit', ['tab' => 'billing'])) }}" class="pack-btn">
                                    Get Agency Access
                                    <span class="pack-btn-sub">Maximum value</span>
                                </a>
                            </div>
                        </div>

                        {{-- TRUST BADGES --}}
                        <div class="trust-section">
                            <div class="trust-badge">
                                <div class="trust-icon">🔒</div>
                                <div class="trust-text">256-bit SSL<small>Bank-level encryption</small></div>
                            </div>
                            <div class="trust-badge">
                                <div class="trust-icon">💳</div>
                                <div class="trust-text">Dodo Payments<small>PCI-DSS compliant</small></div>
                            </div>
                            <div class="trust-badge">
                                <div class="trust-icon">⚡</div>
                                <div class="trust-text">Instant Delivery<small>Credits in seconds</small></div>
                            </div>
                            <div class="trust-badge">
                                <div class="trust-icon">↩️</div>
                                <div class="trust-text">7-Day Refund<small>No questions asked</small></div>
                            </div>
                        </div>

                        {{-- ANNUAL NOTE --}}
                        <div class="annual-note">
                            💎 <strong>Coming soon:</strong> Annual plans with 25% savings — <a href="mailto:hello@postpilot.app?subject=Annual%20Plan%20Waitlist&body=Please%20add%20me%20to%20the%20annual%20plan%20waitlist.">Join the waitlist</a>
                        </div>

                    </div>
                @endif
            </div>
        </main>
    </div>
</x-app-layout>


