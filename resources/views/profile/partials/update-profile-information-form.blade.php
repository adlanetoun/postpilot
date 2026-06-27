<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="w-full">
                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-2" for="name">
                    Full Name
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $user->name) }}" 
                    required 
                    autofocus 
                    autocomplete="name"
                    class="w-full bg-[#F4F5F7] border border-transparent text-slate-900 text-[14px] rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 block py-3 px-4 transition-all shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)] {{ $errors->has('name') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-500' : '' }}" 
                />
            </div>

            <div class="w-full">
                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-2" for="email">
                    Email Address
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email', $user->email) }}" 
                    required 
                    autocomplete="username"
                    class="w-full bg-[#F4F5F7] border border-transparent text-slate-900 text-[14px] rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 block py-3 px-4 transition-all shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)] {{ $errors->has('email') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-500' : '' }}" 
                />
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="p-5 bg-amber-50 border border-amber-200/60 rounded-[16px] flex flex-col sm:flex-row sm:items-center justify-between gap-4 w-full">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[14px] font-bold text-amber-900">{{ __('Your email address is unverified.') }}</p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="text-[13px] text-emerald-600 font-medium mt-1">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                </div>
                <button form="send-verification" class="shrink-0 px-4 py-2 bg-white border border-amber-200 text-amber-800 text-[13px] font-bold rounded-xl hover:bg-amber-100 transition-colors shadow-sm">
                    {{ __('Resend Email') }}
                </button>
            </div>
        @endif

        <div class="w-full max-w-md mt-6">
            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-2" for="timezone">
                Scheduling Timezone
            </label>
            <div class="relative">
                <select name="timezone" id="timezone" class="w-full bg-[#F4F5F7] border border-transparent text-slate-900 text-[14px] rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 block py-3 px-4 appearance-none transition-all cursor-pointer shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)] {{ $errors->has('timezone') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-500' : '' }}">
                    @foreach(timezone_identifiers_list() as $tz)
                        <option value="{{ $tz }}" {{ old('timezone', $user->timezone) === $tz ? 'selected' : '' }}>
                            {{ $tz }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            @error('timezone')
                <p class="text-rose-500 text-[12px] mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end gap-5 pt-8">
            @if (session('status') === 'profile-updated')
                <div class="flex items-center gap-2 text-emerald-500 animate-in fade-in slide-in-from-right-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    <span class="text-[13px] font-bold tracking-wide">Saved successfully</span>
                </div>
            @endif
            
            <button type="submit" class="px-6 py-3 bg-[#3B28CC] text-white text-[14px] font-bold rounded-xl hover:bg-indigo-700 shadow-[0_4px_12px_rgba(59,40,204,0.3)] hover:shadow-[0_6px_16px_rgba(59,40,204,0.4)] hover:-translate-y-0.5 transition-all">
                Save Changes
            </button>
        </div>
    </form>
</section>
