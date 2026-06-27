<section>
    <div class="flex items-center justify-between">
        <p class="text-[13px] text-slate-600 font-medium max-w-sm leading-relaxed">
            Once deleted, all data is permanently lost. This action cannot be undone.
        </p>
        <button 
            type="button" 
            class="px-5 py-2.5 bg-rose-500 text-white text-[13px] font-bold rounded-xl hover:bg-rose-600 shadow-[0_2px_8px_rgba(244,63,94,0.25)] transition-all"
            onclick="document.getElementById('confirm-user-deletion-modal').showModal()"
        >
            {{ __('Delete Account') }}
        </button>
    </div>

    <dialog id="confirm-user-deletion-modal" class="modal backdrop:bg-slate-900/40 backdrop:backdrop-blur-sm" @if ($errors->userDeletion->isNotEmpty()) open @endif>
        <div class="modal-box bg-white border border-gray-100 shadow-[0_20px_60px_rgba(0,0,0,0.08)] rounded-[24px] max-w-lg p-10">
            <h3 class="font-black text-[22px] text-slate-800 mb-2">Are you absolutely sure?</h3>
            <p class="text-[14px] text-slate-500 mb-8 leading-relaxed">
                This action is destructive and irreversible. All your projects, campaigns, and history will be permanently wiped. Please enter your password to confirm.
            </p>
            
            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6" onsubmit="this.querySelectorAll('button[type=submit]').forEach(b => { b.disabled = true; b.classList.add('opacity-50'); })">
                @csrf
                @method('delete')

                <div class="w-full">
                    <label class="block text-[12px] font-bold text-slate-700 uppercase tracking-wide mb-2" for="delete_password">
                        Account Password
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="delete_password" 
                        placeholder="Enter password to confirm"
                        class="w-full bg-[#F4F5F7] border border-transparent text-slate-900 text-[14px] rounded-xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 block py-3 px-4 transition-all shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)] {{ $errors->userDeletion->has('password') ? 'border-red-400' : '' }}" 
                        required
                        autofocus
                    />
                    @if ($errors->userDeletion->has('password'))
                        <p class="text-rose-500 text-[12px] mt-1.5 font-medium">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 mt-8">
                    <button type="button" class="px-5 py-2.5 text-[14px] font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-50 rounded-xl transition-all" onclick="document.getElementById('confirm-user-deletion-modal').close()">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-rose-500 text-white text-[14px] font-bold rounded-xl hover:bg-rose-600 shadow-[0_4px_12px_rgba(244,63,94,0.3)] hover:shadow-[0_6px_16px_rgba(244,63,94,0.4)] hover:-translate-y-0.5 transition-all">
                        Permanently Delete
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</section>
