<x-app-layout full-width="true">
    @php
        $activeTab = request()->query('tab', 'profile');
    @endphp

    <div class="h-full min-h-screen bg-white flex flex-col md:flex-row w-full overflow-hidden relative">
        
        <!-- Mesh Gradient Aura (Moved to background of content) -->
        <div class="absolute top-[-10%] left-[20%] w-[600px] h-[600px] bg-gradient-to-tr from-indigo-400/10 to-purple-400/10 rounded-full blur-[100px] pointer-events-none mix-blend-multiply"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-gradient-to-bl from-rose-400/10 to-orange-300/10 rounded-full blur-[100px] pointer-events-none mix-blend-multiply"></div>

        <!-- Main Content Area -->
        <main class="flex-1 min-w-0 px-6 sm:px-10 md:px-16 py-12 bg-white relative z-0">
            <div class="max-w-4xl mx-auto">
                <!-- Tab 1: Profile (General) -->
                    <!-- Tab 1: Profile (General) -->
                    @if ($activeTab === 'profile')
                        <style>
                            .maestro-profile-wrapper {
                                font-family: 'Inter', sans-serif;
                                animation: m-fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                            }
                            
                            .m-prof-header { margin-bottom: 4rem; }
                            .m-prof-title { font-size: 2.5rem; font-weight: 900; letter-spacing: -0.04em; color: #0A0A0A; margin-bottom: 0.5rem; }
                            .m-prof-desc { font-size: 1.1rem; color: #71717A; max-width: 600px; line-height: 1.6; }

                            .m-prof-section {
                                padding: 4rem 0;
                                border-top: 1px solid rgba(0,0,0,0.08);
                                display: grid;
                                grid-template-columns: 1fr 2.5fr;
                                gap: 4rem;
                            }

                            .m-prof-meta-title { font-size: 1.25rem; font-weight: 800; color: #0A0A0A; margin-bottom: 0.5rem; letter-spacing: -0.02em; }
                            .m-prof-meta-desc { font-size: 0.95rem; color: #71717A; line-height: 1.6; }

                            /* The Avatar Canvas */
                            .m-avatar-container { display: flex; align-items: center; gap: 3rem; }
                            
                            .m-avatar-glass {
                                position: relative;
                                width: 140px;
                                height: 140px;
                                border-radius: 40px;
                                background: linear-gradient(135deg, #111, #333);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: #fff;
                                font-size: 4rem;
                                font-weight: 900;
                                box-shadow: 0 30px 60px -10px rgba(0,0,0,0.3);
                                overflow: hidden;
                                cursor: pointer;
                                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
                            }
                            .m-avatar-glass::before {
                                content: ''; position: absolute; inset: 0;
                                background: radial-gradient(circle at top right, rgba(255,255,255,0.2), transparent);
                            }
                            .m-avatar-glass:hover { transform: scale(1.05) rotate(-2deg); border-radius: 30px; }
                            
                            .m-avatar-overlay {
                                position: absolute; inset: 0;
                                background: rgba(0,0,0,0.5);
                                backdrop-filter: blur(4px);
                                display: flex; align-items: center; justify-content: center;
                                opacity: 0; transition: opacity 0.4s;
                            }
                            .m-avatar-glass:hover .m-avatar-overlay { opacity: 1; }

                            .m-avatar-actions { display: flex; flex-direction: column; gap: 1rem; }
                            .m-btn-upload {
                                padding: 1rem 2rem;
                                background: #fff;
                                border: 1px solid rgba(0,0,0,0.1);
                                border-radius: 100px;
                                font-weight: 800;
                                font-size: 0.85rem;
                                text-transform: uppercase;
                                letter-spacing: 0.05em;
                                color: #0A0A0A;
                                cursor: pointer;
                                transition: all 0.3s;
                                box-shadow: 0 4px 10px rgba(0,0,0,0.02);
                            }
                            .m-btn-upload:hover { border-color: #0A0A0A; background: #0A0A0A; color: #fff; transform: translateY(-2px); }
                            
                            .m-btn-remove {
                                color: #71717A; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; background: transparent; border: none; text-align: left; transition: color 0.3s; padding: 0 1rem;
                            }
                            .m-btn-remove:hover { color: #DC2626; }

                            /* Brutalist Form Inputs */
                            .m-form-group { position: relative; margin-bottom: 3rem; }
                            .m-form-group:last-child { margin-bottom: 0; }
                            
                            .m-input, .m-select {
                                width: 100%;
                                background: transparent;
                                border: none;
                                border-bottom: 2px solid rgba(0,0,0,0.1);
                                padding: 1rem 0;
                                font-size: 1.5rem;
                                font-weight: 700;
                                color: #0A0A0A;
                                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                                outline: none;
                                border-radius: 0;
                                box-shadow: none !important;
                                font-family: 'Inter', sans-serif;
                            }
                            .m-input:focus, .m-select:focus { border-bottom-color: #0A0A0A; box-shadow: none !important; }
                            .m-input::placeholder { color: transparent; }
                            
                            .m-label {
                                position: absolute;
                                left: 0;
                                top: 1.2rem;
                                font-size: 1.1rem;
                                font-weight: 700;
                                color: #A1A1AA;
                                pointer-events: none;
                                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                                transform-origin: left top;
                            }
                            
                            .m-input:focus ~ .m-label,
                            .m-input:not(:placeholder-shown) ~ .m-label,
                            .m-select ~ .m-label.is-active {
                                transform: translateY(-2.2rem) scale(0.75);
                                color: #0A0A0A;
                            }

                            .m-select { cursor: pointer; appearance: none; }
                            .m-select-icon { position: absolute; right: 0; top: 1.5rem; pointer-events: none; transition: transform 0.3s; }
                            .m-select:focus ~ .m-select-icon { transform: rotate(180deg); }

                            .m-grid-cols-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; }

                            .m-btn-save {
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                padding: 1.2rem 3rem;
                                background: #0A0A0A;
                                color: #fff;
                                border-radius: 100px;
                                font-weight: 800;
                                font-size: 0.9rem;
                                letter-spacing: 0.05em;
                                text-transform: uppercase;
                                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                                border: none;
                                cursor: pointer;
                                margin-top: 2rem;
                            }
                            .m-btn-save:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); background: #111; }

                            .m-error-text { color: #DC2626; font-size: 0.85rem; font-weight: 600; margin-top: 0.5rem; position: absolute; bottom: -1.5rem; left: 0; }

                            /* Unverified Banner */
                            .m-banner-warn {
                                background: #FFFBEB;
                                border-left: 4px solid #F59E0B;
                                padding: 2rem;
                                margin-bottom: 3rem;
                                display: flex; align-items: center; justify-content: space-between;
                                border-radius: 0 16px 16px 0;
                            }
                            .m-banner-text { font-size: 1rem; font-weight: 700; color: #92400E; }
                            .m-btn-resend { padding: 0.8rem 1.5rem; background: #fff; color: #92400E; font-weight: 800; border-radius: 100px; font-size: 0.85rem; border: none; cursor: pointer; transition: all 0.3s; }
                            .m-btn-resend:hover { background: #F59E0B; color: #fff; }

                            @keyframes m-fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

                            @media (max-width: 768px) {
                                .m-prof-section { grid-template-columns: 1fr; gap: 2rem; }
                                .m-grid-cols-2 { grid-template-columns: 1fr; gap: 3rem; }
                                .m-avatar-container { flex-direction: column; align-items: flex-start; }
                                .m-banner-warn { flex-direction: column; align-items: flex-start; gap: 1.5rem; }
                            }
                        </style>

                        <div class="maestro-profile-wrapper">
                            <header class="m-prof-header">
                                <h2 class="m-prof-title">Profile & General</h2>
                                <p class="m-prof-desc">Manage your personal details and preferences.</p>
                            </header>

                            <!-- Section: Avatar -->
                            <div class="m-prof-section">
                                <div>
                                    <h3 class="m-prof-meta-title">Profile Picture</h3>
                                    <p class="m-prof-meta-desc">This will be displayed on your profile and across the platform.</p>
                                </div>
                                <div class="m-avatar-container">
                                    <div class="m-avatar-glass">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        <div class="m-avatar-overlay">
                                            <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="m-avatar-actions">
                                        <button class="m-btn-upload">Upload Photo</button>
                                        <button class="m-btn-remove">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Personal Info -->
                            <div class="m-prof-section">
                                <div>
                                    <h3 class="m-prof-meta-title">Personal Information</h3>
                                    <p class="m-prof-meta-desc">Update your name, email address, and scheduling timezone.</p>
                                </div>
                                <div>
                                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                        @csrf
                                    </form>

                                    <form method="post" action="{{ route('profile.update') }}">
                                        @csrf
                                        @method('patch')

                                        <div class="m-grid-cols-2 mb-12">
                                            <div class="m-form-group" style="margin-bottom:0;">
                                                <input type="text" name="name" id="m_name" class="m-input" placeholder=" " value="{{ old('name', Auth::user()->name) }}" required autocomplete="name" />
                                                <label for="m_name" class="m-label">Full Name</label>
                                                @if ($errors->has('name'))
                                                    <div class="m-error-text">{{ $errors->first('name') }}</div>
                                                @endif
                                            </div>

                                            <div class="m-form-group" style="margin-bottom:0;">
                                                <input type="email" name="email" id="m_email" class="m-input" placeholder=" " value="{{ old('email', Auth::user()->email) }}" required autocomplete="username" />
                                                <label for="m_email" class="m-label">Email Address</label>
                                                @if ($errors->has('email'))
                                                    <div class="m-error-text">{{ $errors->first('email') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                                            <div class="m-banner-warn">
                                                <div>
                                                    <div class="m-banner-text">Your email address is unverified.</div>
                                                    @if (session('status') === 'verification-link-sent')
                                                        <div style="font-size: 0.85rem; color: #059669; font-weight: 700; margin-top: 0.5rem;">
                                                            A new verification link has been sent to your email address.
                                                        </div>
                                                    @endif
                                                </div>
                                                <button form="send-verification" class="m-btn-resend">Resend Email</button>
                                            </div>
                                        @endif

                                        <div class="m-form-group" style="max-width: 300px;">
                                            <select name="timezone" id="m_timezone" class="m-select">
                                                @foreach(timezone_identifiers_list() as $tz)
                                                    <option value="{{ $tz }}" {{ old('timezone', Auth::user()->timezone) === $tz ? 'selected' : '' }}>
                                                        {{ $tz }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="m_timezone" class="m-label is-active">Scheduling Timezone</label>
                                            <svg class="m-select-icon" width="20" height="20" fill="none" stroke="#0A0A0A" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                                            @if ($errors->has('timezone'))
                                                <div class="m-error-text">{{ $errors->first('timezone') }}</div>
                                            @endif
                                        </div>

                                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 1.5rem; border-top: 1px solid rgba(0,0,0,0.08); padding-top: 2rem; margin-top: 2rem;">
                                            @if (session('status') === 'profile-updated')
                                                <div style="color: #10B981; font-weight: 800; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.1em; animation: m-fadeUp 0.5s;">
                                                    ✓ Saved successfully
                                                </div>
                                            @endif
                                            <button type="submit" class="m-btn-save">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tab 1.5: Security -->
                    @if ($activeTab === 'security')
                        <style>
                            .maestro-security-wrapper {
                                font-family: 'Inter', sans-serif;
                                animation: m-fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                            }
                            
                            .m-sec-header { margin-bottom: 4rem; }
                            .m-sec-title { font-size: 2.5rem; font-weight: 900; letter-spacing: -0.04em; color: #0A0A0A; margin-bottom: 0.5rem; }
                            .m-sec-desc { font-size: 1.1rem; color: #71717A; max-width: 600px; line-height: 1.6; }

                            .m-sec-section {
                                padding: 4rem 0;
                                border-top: 1px solid rgba(0,0,0,0.08);
                                display: grid;
                                grid-template-columns: 1fr 2.5fr;
                                gap: 4rem;
                            }

                            .m-sec-meta-title { font-size: 1.25rem; font-weight: 800; color: #0A0A0A; margin-bottom: 0.5rem; letter-spacing: -0.02em; }
                            .m-sec-meta-desc { font-size: 0.95rem; color: #71717A; line-height: 1.6; }

                            /* Brutalist Form Inputs */
                            .m-form-group { position: relative; margin-bottom: 3rem; }
                            .m-form-group:last-child { margin-bottom: 0; }
                            
                            .m-input {
                                width: 100%;
                                background: transparent;
                                border: none;
                                border-bottom: 2px solid rgba(0,0,0,0.1);
                                padding: 1rem 0;
                                font-size: 1.5rem;
                                font-weight: 700;
                                color: #0A0A0A;
                                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                                outline: none;
                                border-radius: 0;
                                box-shadow: none !important;
                            }
                            .m-input:focus { border-bottom-color: #0A0A0A; box-shadow: none !important; }
                            .m-input::placeholder { color: transparent; }
                            
                            .m-label {
                                position: absolute;
                                left: 0;
                                top: 1.2rem;
                                font-size: 1.1rem;
                                font-weight: 700;
                                color: #A1A1AA;
                                pointer-events: none;
                                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                                transform-origin: left top;
                            }
                            
                            .m-input:focus ~ .m-label,
                            .m-input:not(:placeholder-shown) ~ .m-label {
                                transform: translateY(-2.2rem) scale(0.75);
                                color: #0A0A0A;
                            }

                            .m-grid-cols-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; }

                            .m-btn-save {
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                padding: 1.2rem 3rem;
                                background: #0A0A0A;
                                color: #fff;
                                border-radius: 100px;
                                font-weight: 800;
                                font-size: 0.9rem;
                                letter-spacing: 0.05em;
                                text-transform: uppercase;
                                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                                border: none;
                                cursor: pointer;
                                margin-top: 2rem;
                            }
                            .m-btn-save:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); background: #111; }

                            /* Danger Zone */
                            .m-danger-section {
                                border-top: 1px solid rgba(220, 38, 38, 0.2);
                                background: linear-gradient(180deg, rgba(220, 38, 38, 0.02) 0%, transparent 100%);
                            }
                            .m-danger-meta-title { color: #DC2626; }
                            
                            .m-danger-box {
                                background: #fff;
                                border: 1px solid rgba(220, 38, 38, 0.2);
                                padding: 3rem;
                                border-radius: 24px;
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                box-shadow: 0 20px 40px -10px rgba(220, 38, 38, 0.05);
                                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
                            }
                            .m-danger-box:hover {
                                border-color: rgba(220, 38, 38, 0.4);
                                box-shadow: 0 20px 50px -10px rgba(220, 38, 38, 0.1);
                            }
                            
                            .m-danger-text { font-size: 1.1rem; font-weight: 600; color: #52525B; max-width: 400px; }
                            
                            .m-btn-danger {
                                background: #DC2626;
                                color: #fff;
                                padding: 1.2rem 2.5rem;
                                border-radius: 100px;
                                font-weight: 800;
                                font-size: 0.9rem;
                                text-transform: uppercase;
                                letter-spacing: 0.05em;
                                border: none;
                                cursor: pointer;
                                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                            }
                            .m-btn-danger:hover {
                                background: #B91C1C;
                                transform: translateY(-2px);
                                box-shadow: 0 10px 20px rgba(220, 38, 38, 0.2);
                            }

                            .m-error-text { color: #DC2626; font-size: 0.85rem; font-weight: 600; margin-top: 0.5rem; position: absolute; bottom: -1.5rem; left: 0; }

                            /* Custom Modal */
                            .m-modal {
                                display: none;
                                position: fixed;
                                inset: 0;
                                z-index: 9999;
                                align-items: center;
                                justify-content: center;
                            }
                            .m-modal.is-open { display: flex; }
                            .m-modal-backdrop {
                                position: absolute;
                                inset: 0;
                                background: rgba(0,0,0,0.4);
                                backdrop-filter: blur(8px);
                                animation: m-fadeIn 0.4s ease;
                            }
                            .m-modal-content {
                                position: relative;
                                background: #fff;
                                padding: 4rem;
                                border-radius: 32px;
                                width: 100%;
                                max-width: 600px;
                                box-shadow: 0 30px 60px rgba(0,0,0,0.15);
                                animation: m-scaleUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
                            }
                            .m-modal-title { font-size: 2.5rem; font-weight: 900; letter-spacing: -0.04em; color: #0A0A0A; margin-bottom: 1rem; }
                            .m-modal-desc { font-size: 1.1rem; color: #71717A; line-height: 1.6; margin-bottom: 3rem; }
                            
                            .m-modal-actions { display: flex; justify-content: flex-end; gap: 1.5rem; margin-top: 4rem; }
                            .m-btn-cancel { padding: 1.2rem 2.5rem; font-weight: 800; color: #71717A; background: transparent; border: none; cursor: pointer; text-transform: uppercase; letter-spacing: 0.05em; transition: all 0.3s; }
                            .m-btn-cancel:hover { color: #0A0A0A; }

                            @keyframes m-fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
                            @keyframes m-fadeIn { from { opacity: 0; } to { opacity: 1; } }
                            @keyframes m-scaleUp { from { opacity: 0; transform: scale(0.95) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }

                            @media (max-width: 768px) {
                                .m-sec-section { grid-template-columns: 1fr; gap: 2rem; }
                                .m-grid-cols-2 { grid-template-columns: 1fr; gap: 3rem; }
                                .m-danger-box { flex-direction: column; align-items: flex-start; gap: 2rem; }
                                .m-modal-content { padding: 2rem; width: 90%; }
                            }
                        </style>

                        <div class="maestro-security-wrapper">
                            <header class="m-sec-header">
                                <h2 class="m-sec-title">Security & Access</h2>
                                <p class="m-sec-desc">Manage your password and account security.</p>
                            </header>

                            <!-- Section: Update Password -->
                            <div class="m-sec-section">
                                <div>
                                    <h3 class="m-sec-meta-title">Update Password</h3>
                                    <p class="m-sec-meta-desc">Ensure your account is using a long, random password to stay secure.</p>
                                </div>
                                <div>
                                    <form method="post" action="{{ route('password.update') }}">
                                        @csrf
                                        @method('put')

                                        <div class="m-form-group">
                                            <input type="password" name="current_password" id="m_current_password" class="m-input" placeholder=" " autocomplete="current-password" />
                                            <label for="m_current_password" class="m-label">Current Password</label>
                                            @if ($errors->updatePassword->has('current_password'))
                                                <div class="m-error-text">{{ $errors->updatePassword->first('current_password') }}</div>
                                            @endif
                                        </div>

                                        <div class="m-grid-cols-2">
                                            <div class="m-form-group">
                                                <input type="password" name="password" id="m_password" class="m-input" placeholder=" " autocomplete="new-password" />
                                                <label for="m_password" class="m-label">New Password</label>
                                                @if ($errors->updatePassword->has('password'))
                                                    <div class="m-error-text">{{ $errors->updatePassword->first('password') }}</div>
                                                @endif
                                            </div>
                                            <div class="m-form-group">
                                                <input type="password" name="password_confirmation" id="m_password_confirmation" class="m-input" placeholder=" " autocomplete="new-password" />
                                                <label for="m_password_confirmation" class="m-label">Confirm Password</label>
                                                @if ($errors->updatePassword->has('password_confirmation'))
                                                    <div class="m-error-text">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 1.5rem;">
                                            @if (session('status') === 'password-updated')
                                                <div style="color: #10B981; font-weight: 800; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.1em; animation: m-fadeUp 0.5s;">
                                                    ✓ Password updated
                                                </div>
                                            @endif
                                            <button type="submit" class="m-btn-save">Save Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Section: Danger Zone -->
                            <div class="m-sec-section m-danger-section">
                                <div>
                                    <h3 class="m-sec-meta-title m-danger-meta-title">Danger Zone</h3>
                                    <p class="m-sec-meta-desc">Permanently delete your account and all associated data.</p>
                                </div>
                                <div>
                                    <div class="m-danger-box">
                                        <div class="m-danger-text">
                                            Once deleted, all data is permanently lost. This action cannot be undone.
                                        </div>
                                        <button type="button" class="m-btn-danger" onclick="document.getElementById('m-delete-modal').classList.add('is-open')">
                                            Delete Account
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Brutalist Delete Modal -->
                        <div id="m-delete-modal" class="m-modal {{ $errors->userDeletion->isNotEmpty() ? 'is-open' : '' }}">
                            <div class="m-modal-backdrop" onclick="document.getElementById('m-delete-modal').classList.remove('is-open')"></div>
                            <div class="m-modal-content">
                                <h3 class="m-modal-title">Are you absolutely sure?</h3>
                                <p class="m-modal-desc">
                                    This action is destructive and irreversible. All your projects, campaigns, and history will be permanently wiped. Please enter your password to confirm.
                                </p>
                                
                                <form method="post" action="{{ route('profile.destroy') }}" onsubmit="this.querySelector('.m-btn-danger').disabled = true; this.querySelector('.m-btn-danger').style.opacity = '0.5';">
                                    @csrf
                                    @method('delete')

                                    <div class="m-form-group">
                                        <input type="password" name="password" id="m_delete_password" class="m-input" placeholder=" " required />
                                        <label for="m_delete_password" class="m-label">Account Password</label>
                                        @if ($errors->userDeletion->has('password'))
                                            <div class="m-error-text">{{ $errors->userDeletion->first('password') }}</div>
                                        @endif
                                    </div>

                                    <div class="m-modal-actions">
                                        <button type="button" class="m-btn-cancel" onclick="document.getElementById('m-delete-modal').classList.remove('is-open')">Cancel</button>
                                        <button type="submit" class="m-btn-danger">Permanently Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                <!-- Tab 2: Social Accounts -->
                @if ($activeTab === 'socials')
                    @php
                        $connectedSocials = Auth::user()->socialAccounts()->pluck('username', 'provider')->toArray();
                    @endphp
                    <style>
                        /* Maestro's Connectivity Monolith */
                        .maestro-social-wrapper {
                            font-family: 'Inter', sans-serif;
                            animation: m-fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                        }
                        .m-social-header {
                            margin-bottom: 4rem;
                        }
                        .m-social-title {
                            font-size: 2.5rem;
                            font-weight: 900;
                            letter-spacing: -0.04em;
                            color: #0A0A0A;
                            margin-bottom: 0.5rem;
                        }
                        .m-social-desc {
                            font-size: 1.1rem;
                            color: #71717A;
                            max-width: 600px;
                            line-height: 1.6;
                        }
                        
                        .m-platform-list {
                            display: flex;
                            flex-direction: column;
                            border-top: 1px solid rgba(0,0,0,0.08);
                        }
                        
                        .m-platform-row {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            padding: 3rem 0;
                            border-bottom: 1px solid rgba(0,0,0,0.08);
                            position: relative;
                            overflow: hidden;
                            transition: padding 0.6s cubic-bezier(0.16, 1, 0.3, 1);
                        }
                        
                        /* Ambient hover backgrounds based on brand */
                        .m-platform-row::before {
                            content: '';
                            position: absolute;
                            inset: 0;
                            opacity: 0;
                            transition: opacity 0.6s ease;
                            z-index: 0;
                            pointer-events: none;
                        }
                        .m-platform-row[data-brand="twitter"]:hover::before { background: linear-gradient(90deg, rgba(0,0,0,0.02) 0%, rgba(255,255,255,0) 100%); opacity: 1; }
                        .m-platform-row[data-brand="linkedin"]:hover::before { background: linear-gradient(90deg, rgba(10,102,194,0.04) 0%, rgba(255,255,255,0) 100%); opacity: 1; }
                        .m-platform-row[data-brand="facebook"]:hover::before { background: linear-gradient(90deg, rgba(24,119,242,0.04) 0%, rgba(255,255,255,0) 100%); opacity: 1; }

                        .m-platform-row:hover {
                            padding-left: 2rem;
                            padding-right: 2rem;
                        }

                        .m-platform-content {
                            position: relative;
                            z-index: 1;
                            display: flex;
                            align-items: center;
                            gap: 2rem;
                            flex-grow: 1;
                        }

                        .m-platform-icon {
                            width: 64px;
                            height: 64px;
                            border-radius: 16px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1);
                            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
                        }
                        .m-platform-row:hover .m-platform-icon {
                            transform: scale(1.05) rotate(-3deg);
                        }

                        .m-icon-twitter { background: #000; color: #fff; }
                        .m-icon-linkedin { background: #0A66C2; color: #fff; }
                        .m-icon-facebook { background: #1877F2; color: #fff; }

                        .m-platform-info {
                            display: flex;
                            flex-direction: column;
                            gap: 0.3rem;
                        }

                        .m-platform-name {
                            font-size: 1.8rem;
                            font-weight: 800;
                            color: #0A0A0A;
                            letter-spacing: -0.03em;
                            display: flex;
                            align-items: center;
                            gap: 1rem;
                        }
                        .m-platform-meta {
                            font-size: 0.95rem;
                            color: #71717A;
                        }

                        .m-badge-connected {
                            padding: 0.3rem 0.8rem;
                            background: rgba(16, 185, 129, 0.1);
                            color: #059669;
                            border-radius: 100px;
                            font-size: 0.7rem;
                            font-weight: 800;
                            text-transform: uppercase;
                            letter-spacing: 0.1em;
                        }
                        .m-badge-disconnected {
                            padding: 0.3rem 0.8rem;
                            background: rgba(113, 113, 122, 0.1);
                            color: #52525B;
                            border-radius: 100px;
                            font-size: 0.7rem;
                            font-weight: 800;
                            text-transform: uppercase;
                            letter-spacing: 0.1em;
                        }
                        
                        .m-username {
                            font-size: 0.9rem;
                            font-family: monospace;
                            color: #4F46E5;
                            font-weight: 600;
                            margin-top: 0.3rem;
                        }

                        .m-platform-action {
                            position: relative;
                            z-index: 1;
                            min-width: 180px;
                            text-align: right;
                        }

                        .m-btn-connect {
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            padding: 1.2rem 2.5rem;
                            background: #0A0A0A;
                            color: #fff;
                            border-radius: 100px;
                            font-weight: 800;
                            font-size: 0.8rem;
                            letter-spacing: 0.05em;
                            text-transform: uppercase;
                            text-decoration: none;
                            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                        }
                        .m-btn-connect:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
                            background: #111;
                        }

                        .m-btn-disconnect {
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            padding: 1.2rem 2.5rem;
                            background: transparent;
                            color: #DC2626;
                            border: 1px solid rgba(220, 38, 38, 0.2);
                            border-radius: 100px;
                            font-weight: 800;
                            font-size: 0.8rem;
                            letter-spacing: 0.05em;
                            text-transform: uppercase;
                            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                            cursor: pointer;
                        }
                        .m-btn-disconnect:hover {
                            background: rgba(220, 38, 38, 0.05);
                            border-color: #DC2626;
                        }

                        .m-notice-box {
                            margin-top: 1.5rem;
                            padding: 1rem;
                            background: #FAFAFA;
                            border: 1px solid rgba(0,0,0,0.05);
                            border-radius: 12px;
                            text-align: left;
                        }

                        @keyframes m-fadeUp {
                            from { opacity: 0; transform: translateY(20px); }
                            to { opacity: 1; transform: translateY(0); }
                        }

                        @media (max-width: 768px) {
                            .m-platform-row { flex-direction: column; align-items: flex-start; gap: 2rem; padding: 2rem 0; }
                            .m-platform-row:hover { padding-left: 0; padding-right: 0; }
                            .m-platform-action { width: 100%; text-align: left; }
                            .m-btn-connect, .m-btn-disconnect { width: 100%; }
                        }
                    </style>

                    <div class="maestro-social-wrapper">
                        <div class="m-social-header">
                            <h2 class="m-social-title">Social Integrations</h2>
                            <p class="m-social-desc">
                                Connect your brand accounts. PostPilot will automatically schedule and publish content directly to these networks.
                            </p>
                        </div>

                        <div class="m-platform-list">
                            
                            <!-- X (Twitter) -->
                            <div class="m-platform-row" data-brand="twitter">
                                <div class="m-platform-content">
                                    <div class="m-platform-icon m-icon-twitter">
                                        <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 4.076H5.078z"/></svg>
                                    </div>
                                    <div class="m-platform-info">
                                        <div class="m-platform-name">
                                            X (Twitter)
                                            @if(isset($connectedSocials['twitter']))
                                                <span class="m-badge-connected">Connected</span>
                                            @else
                                                <span class="m-badge-disconnected">Disconnected</span>
                                            @endif
                                        </div>
                                        <div class="m-platform-meta">Share short micro-updates and threads.</div>
                                        @if(isset($connectedSocials['twitter']))
                                            <div class="m-username">{{ $connectedSocials['twitter'] }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="m-platform-action">
                                    @if(isset($connectedSocials['twitter']))
                                        <form action="{{ route('social-accounts.disconnect', 'twitter') }}" method="POST" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="m-btn-disconnect">Disconnect X</button>
                                        </form>
                                    @else
                                        <a href="{{ route('social-accounts.connect', 'twitter') }}" class="m-btn-connect">Connect X</a>
                                        <div class="m-notice-box">
                                            <p style="font-size: 0.8rem; color: #52525B; line-height: 1.5; margin: 0;">
                                                <strong style="color: #DC2626;">⚠️ Notice:</strong> Please use your email/username to log in. <span style="text-decoration: underline; text-decoration-color: #FCA5A5;">Avoid Google/Apple</span> buttons.
                                            </p>
                                            <img src="{{ asset('images/twitter-login-instruction.png') }}" alt="Login Instruction" style="margin-top: 0.5rem; width: 100%; max-width: 250px; border-radius: 8px; border: 1px solid rgba(0,0,0,0.05);" />
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- LinkedIn -->
                            <div class="m-platform-row" data-brand="linkedin">
                                <div class="m-platform-content">
                                    <div class="m-platform-icon m-icon-linkedin">
                                        <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    </div>
                                    <div class="m-platform-info">
                                        <div class="m-platform-name">
                                            LinkedIn
                                            @if(isset($connectedSocials['linkedin']))
                                                <span class="m-badge-connected">Connected</span>
                                            @else
                                                <span class="m-badge-disconnected">Disconnected</span>
                                            @endif
                                        </div>
                                        <div class="m-platform-meta">Publish professional posts and articles.</div>
                                        @if(isset($connectedSocials['linkedin']))
                                            <div class="m-username">{{ $connectedSocials['linkedin'] }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="m-platform-action">
                                    @if(isset($connectedSocials['linkedin']))
                                        <form action="{{ route('social-accounts.disconnect', 'linkedin') }}" method="POST" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="m-btn-disconnect">Disconnect LinkedIn</button>
                                        </form>
                                    @else
                                        <a href="{{ route('social-accounts.connect', 'linkedin') }}" class="m-btn-connect">Connect LinkedIn</a>
                                    @endif
                                </div>
                            </div>

                            <!-- Facebook -->
                            <div class="m-platform-row" data-brand="facebook">
                                <div class="m-platform-content">
                                    <div class="m-platform-icon m-icon-facebook">
                                        <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </div>
                                    <div class="m-platform-info">
                                        <div class="m-platform-name">
                                            Facebook
                                            @if(isset($connectedSocials['facebook']))
                                                <span class="m-badge-connected">Connected</span>
                                            @else
                                                <span class="m-badge-disconnected">Disconnected</span>
                                            @endif
                                        </div>
                                        <div class="m-platform-meta">Share visual campaign cards and copy.</div>
                                        @if(isset($connectedSocials['facebook']))
                                            <div class="m-username">{{ $connectedSocials['facebook'] }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="m-platform-action">
                                    @if(isset($connectedSocials['facebook']))
                                        <form action="{{ route('social-accounts.disconnect', 'facebook') }}" method="POST" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="m-btn-disconnect">Disconnect Facebook</button>
                                        </form>
                                    @else
                                        <a href="{{ route('social-accounts.connect', 'facebook') }}" class="m-btn-connect">Connect Facebook</a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

                <!-- Tab 3: Billing & Subscription -->
                @if ($activeTab === 'billing')
                    @php
                        $subscription = Auth::user()->subscription;
                        $isPremium = $subscription && $subscription->status === 'active';
                    @endphp
                    <style>
                        .maestro-billing-wrapper {
                            font-family: 'Inter', sans-serif;
                            animation: m-fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                        }
                        
                        .m-bill-header { margin-bottom: 4rem; }
                        .m-bill-title { font-size: 2.5rem; font-weight: 900; letter-spacing: -0.04em; color: #0A0A0A; margin-bottom: 0.5rem; }
                        .m-bill-desc { font-size: 1.1rem; color: #71717A; max-width: 600px; line-height: 1.6; }

                        .m-bill-grid {
                            display: grid;
                            grid-template-columns: 2fr 1fr;
                            gap: 2rem;
                            margin-bottom: 4rem;
                        }

                        /* Luxury Card Container */
                        .m-bill-card {
                            position: relative;
                            padding: 3rem;
                            border-radius: 24px;
                            overflow: hidden;
                            display: flex;
                            flex-direction: column;
                            justify-content: space-between;
                            min-height: 340px;
                            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
                        }
                        .m-bill-card:hover {
                            transform: translateY(-5px);
                        }

                        /* Premium Mode */
                        .m-bill-card.is-premium {
                            background: #050505;
                            color: #fff;
                            box-shadow: 0 30px 60px -10px rgba(0,0,0,0.4);
                        }
                        .m-bill-card.is-premium::before {
                            content: ''; position: absolute; inset: 0;
                            background: radial-gradient(circle at 100% 0%, rgba(79, 70, 229, 0.2) 0%, transparent 50%);
                        }
                        .m-bill-card.is-premium::after {
                            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
                            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.05), transparent);
                            transform: rotate(45deg); transition: 0.8s; pointer-events: none;
                        }
                        .m-bill-card.is-premium:hover::after { left: 100%; top: 100%; }

                        /* Free Mode */
                        .m-bill-card.is-free {
                            background: #F8F9FA;
                            color: #0A0A0A;
                            border: 1px solid rgba(0,0,0,0.05);
                            box-shadow: inset 0 2px 10px rgba(255,255,255,1);
                        }
                        .m-bill-card.is-free::before {
                            content: ''; position: absolute; inset: 0;
                            background: radial-gradient(circle at 100% 0%, rgba(0, 0, 0, 0.03) 0%, transparent 50%);
                        }

                        .m-bill-card-content { position: relative; z-index: 1; display: flex; flex-direction: column; height: 100%; justify-content: space-between; }
                        
                        .m-bill-badge {
                            display: inline-block;
                            padding: 0.4rem 1rem;
                            font-size: 0.75rem;
                            font-weight: 800;
                            text-transform: uppercase;
                            letter-spacing: 0.1em;
                            border-radius: 100px;
                            margin-bottom: 2rem;
                            width: max-content;
                        }
                        .is-premium .m-bill-badge { background: rgba(255,255,255,0.1); color: #fff; backdrop-filter: blur(10px); }
                        .is-free .m-bill-badge { background: #fff; color: #52525B; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05); }

                        .m-bill-plan-name { font-size: 3.5rem; font-weight: 900; letter-spacing: -0.05em; line-height: 1; margin-bottom: 1rem; }
                        .m-bill-plan-desc { font-size: 1rem; line-height: 1.6; max-width: 400px; opacity: 0.8; }

                        .m-bill-card-footer { display: flex; align-items: flex-end; justify-content: space-between; margin-top: 3rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem; }
                        .is-free .m-bill-card-footer { border-top: 1px solid rgba(0,0,0,0.08); }

                        .m-bill-provider { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.6; margin-bottom: 0.5rem; }
                        .m-bill-provider-name { display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 800; }
                        .m-bill-provider-logo { width: 24px; height: 24px; border-radius: 6px; background: #111; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 900; }
                        .is-free .m-bill-provider-logo { background: #E4E4E7; color: #52525B; }

                        .m-bill-cta {
                            padding: 1.2rem 2.5rem;
                            font-weight: 800;
                            font-size: 0.9rem;
                            border-radius: 100px;
                            cursor: pointer;
                            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                            text-transform: uppercase;
                            letter-spacing: 0.05em;
                            border: none;
                        }
                        .is-premium .m-bill-cta { background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px); }
                        .is-premium .m-bill-cta:hover { background: #fff; color: #000; }
                        
                        .is-free .m-bill-cta { background: #0A0A0A; color: #fff; }
                        .is-free .m-bill-cta:hover { background: #111; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }

                        /* Metrics Box */
                        .m-metrics-box {
                            padding: 3rem;
                            border-radius: 24px;
                            border: 1px solid rgba(0,0,0,0.08);
                            background: #fff;
                            display: flex;
                            flex-direction: column;
                            justify-content: space-between;
                        }
                        .m-metrics-title { font-size: 1.2rem; font-weight: 800; color: #0A0A0A; display: flex; align-items: center; gap: 1rem; margin-bottom: 3rem; }
                        
                        .m-metric-item { margin-bottom: 2rem; }
                        .m-metric-item:last-child { margin-bottom: 0; }
                        .m-metric-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1rem; }
                        .m-metric-label { font-size: 0.9rem; font-weight: 700; color: #71717A; }
                        .m-metric-value { font-size: 1.2rem; font-weight: 900; color: #0A0A0A; font-family: monospace; }
                        .m-metric-value span { color: #A1A1AA; font-weight: 600; }

                        /* Precision Progress Bars */
                        .m-metric-track { width: 100%; height: 4px; background: #F4F4F5; border-radius: 4px; overflow: hidden; position: relative; }
                        .m-metric-fill { height: 100%; background: #0A0A0A; border-radius: 4px; position: absolute; left: 0; top: 0; }

                        /* History Ledger */
                        .m-ledger { margin-top: 4rem; }
                        .m-ledger-title { font-size: 1.5rem; font-weight: 900; color: #0A0A0A; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #0A0A0A; }

                        .m-ledger-row {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            padding: 2rem 0;
                            border-bottom: 1px solid rgba(0,0,0,0.08);
                            transition: padding 0.4s ease;
                        }
                        .m-ledger-row:hover { padding-left: 1rem; padding-right: 1rem; background: rgba(0,0,0,0.01); }

                        .m-ledger-info { display: flex; align-items: center; gap: 1.5rem; }
                        .m-ledger-icon { width: 48px; height: 48px; background: #F4F4F5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #52525B; }
                        .m-ledger-row:hover .m-ledger-icon { background: #0A0A0A; color: #fff; }
                        
                        .m-ledger-name { font-size: 1.1rem; font-weight: 800; color: #0A0A0A; }
                        .m-ledger-date { font-size: 0.85rem; font-weight: 600; color: #71717A; font-family: monospace; margin-top: 0.3rem; }

                        .m-ledger-actions { display: flex; align-items: center; gap: 3rem; }
                        .m-ledger-status { display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 800; color: #059669; text-transform: uppercase; letter-spacing: 0.1em; }
                        .m-status-dot { width: 8px; height: 8px; border-radius: 50%; background: #10B981; box-shadow: 0 0 10px rgba(16,185,129,0.5); }
                        
                        .m-ledger-amount { font-size: 1.25rem; font-weight: 900; color: #0A0A0A; font-family: monospace; width: 80px; text-align: right; }
                        
                        .m-ledger-dl { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(0,0,0,0.1); color: #0A0A0A; transition: all 0.3s; cursor: pointer; background: transparent; }
                        .m-ledger-dl:hover { background: #0A0A0A; color: #fff; border-color: #0A0A0A; transform: translateY(-2px); }

                        @keyframes m-fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

                        @media (max-width: 1024px) {
                            .m-bill-grid { grid-template-columns: 1fr; }
                        }
                        @media (max-width: 768px) {
                            .m-bill-card { padding: 2rem; }
                            .m-bill-card-footer { flex-direction: column; align-items: flex-start; gap: 2rem; }
                            .m-bill-cta { width: 100%; }
                            .m-ledger-row { flex-direction: column; align-items: flex-start; gap: 1.5rem; }
                            .m-ledger-actions { width: 100%; justify-content: space-between; }
                        }
                    </style>

                    <div class="maestro-billing-wrapper">
                        <header class="m-bill-header">
                            <h2 class="m-bill-title">Billing & Subscriptions</h2>
                            <p class="m-bill-desc">Manage your premium plans, usage limits, and invoices.</p>
                        </header>

                        <div class="m-bill-grid">
                            
                            <!-- The Card -->
                            <div class="m-bill-card {{ $isPremium ? 'is-premium' : 'is-free' }}">
                                <div class="m-bill-card-content">
                                    <div>
                                        <div class="m-bill-badge">{{ $isPremium ? 'Active Plan' : 'Current Plan' }}</div>
                                        <h3 class="m-bill-plan-name">{{ $isPremium ? $subscription->plan_name : 'Free Tier' }}</h3>
                                        <p class="m-bill-plan-desc">
                                            {{ $isPremium ? 'You are on the premium flight path. All systems nominal. Your subscription is managed securely via Dodo Payments.' : 'Limited to 1 project. Manual generation only. Upgrade to unlock full automation and unlimited potential.' }}
                                        </p>
                                    </div>
                                    
                                    <div class="m-bill-card-footer">
                                        <div>
                                            <div class="m-bill-provider">Managed By</div>
                                            <div class="m-bill-provider-name">
                                                <div class="m-bill-provider-logo">D</div>
                                                Dodo Payments
                                            </div>
                                        </div>
                                        <button class="m-bill-cta">
                                            {{ $isPremium ? 'Manage Subscription' : 'Upgrade to Premium' }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Metrics Box -->
                            <div class="m-metrics-box">
                                <h3 class="m-metrics-title">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    Usage Metrics
                                </h3>
                                <div>
                                    <!-- Metric 1 -->
                                    <div class="m-metric-item">
                                        <div class="m-metric-header">
                                            <div class="m-metric-label">Active Projects</div>
                                            <div class="m-metric-value">1 <span>/ 1</span></div>
                                        </div>
                                        <div class="m-metric-track"><div class="m-metric-fill" style="width: 100%;"></div></div>
                                    </div>
                                    <!-- Metric 2 -->
                                    <div class="m-metric-item">
                                        <div class="m-metric-header">
                                            <div class="m-metric-label">AI Generations</div>
                                            <div class="m-metric-value">5 <span>/ 10</span></div>
                                        </div>
                                        <div class="m-metric-track"><div class="m-metric-fill" style="width: 50%;"></div></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- History Ledger -->
                        <div class="m-ledger">
                            <h3 class="m-ledger-title">Billing History</h3>
                            
                            <!-- Invoice 1 -->
                            <div class="m-ledger-row">
                                <div class="m-ledger-info">
                                    <div class="m-ledger-icon">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div>
                                        <div class="m-ledger-name">Premium Plan Subscription</div>
                                        <div class="m-ledger-date">INV-2026-001 • Oct 1, 2026</div>
                                    </div>
                                </div>
                                <div class="m-ledger-actions">
                                    <div class="m-ledger-status">
                                        <div class="m-status-dot"></div> Paid
                                    </div>
                                    <div class="m-ledger-amount">$29.00</div>
                                    <button class="m-ledger-dl" title="Download Invoice">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Invoice 2 -->
                            <div class="m-ledger-row">
                                <div class="m-ledger-info">
                                    <div class="m-ledger-icon">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div>
                                        <div class="m-ledger-name">Premium Plan Subscription</div>
                                        <div class="m-ledger-date">INV-2026-000 • Sep 1, 2026</div>
                                    </div>
                                </div>
                                <div class="m-ledger-actions">
                                    <div class="m-ledger-status">
                                        <div class="m-status-dot"></div> Paid
                                    </div>
                                    <div class="m-ledger-amount">$29.00</div>
                                    <button class="m-ledger-dl" title="Download Invoice">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-app-layout>


