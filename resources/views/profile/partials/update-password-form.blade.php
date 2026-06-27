<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="w-full">
            <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-2" for="current_password">
                Current Password
            </label>
            <input 
                type="password" 
                name="current_password" 
                id="current_password" 
                autocomplete="current-password" 
                class="w-full bg-[#F4F5F7] border border-transparent text-slate-900 text-[14px] rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 block py-3 px-4 transition-all shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)] {{ $errors->updatePassword->has('current_password') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-500' : '' }}" 
            />
            @if ($errors->updatePassword->has('current_password'))
                <p class="text-rose-500 text-[12px] mt-1.5 font-medium">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- New Password -->
            <div class="w-full">
                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-2" for="password">
                    New Password
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    autocomplete="new-password" 
                    class="w-full bg-[#F4F5F7] border border-transparent text-slate-900 text-[14px] rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 block py-3 px-4 transition-all shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)] {{ $errors->updatePassword->has('password') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-500' : '' }}" 
                />
                @if ($errors->updatePassword->has('password'))
                    <p class="text-rose-500 text-[12px] mt-1.5 font-medium">{{ $errors->updatePassword->first('password') }}</p>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="w-full">
                <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-2" for="password_confirmation">
                    Confirm Password
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    autocomplete="new-password" 
                    class="w-full bg-[#F4F5F7] border border-transparent text-slate-900 text-[14px] rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 block py-3 px-4 transition-all shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)] {{ $errors->updatePassword->has('password_confirmation') ? 'border-red-400 focus:ring-red-500/10 focus:border-red-500' : '' }}" 
                />
                @if ($errors->updatePassword->has('password_confirmation'))
                    <p class="text-rose-500 text-[12px] mt-1.5 font-medium">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-end gap-5 pt-8">
            @if (session('status') === 'password-updated')
                <div class="flex items-center gap-2 text-emerald-500 animate-in fade-in slide-in-from-right-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    <span class="text-[13px] font-bold tracking-wide">Password updated</span>
                </div>
            @endif
            
            <button type="submit" class="px-6 py-3 bg-[#3B28CC] text-white text-[14px] font-bold rounded-xl hover:bg-indigo-700 shadow-[0_4px_12px_rgba(59,40,204,0.3)] hover:shadow-[0_6px_16px_rgba(59,40,204,0.4)] hover:-translate-y-0.5 transition-all">
                Save Password
            </button>
        </div>
    </form>
</section>
