@props([
    'id',
    'action',
    'method' => 'DELETE',
    'title' => 'Are you sure?',
    'message' => 'This action cannot be undone.',
    'confirmText' => 'Delete',
    'triggerClass' => 'btn btn-error btn-sm'
])

<button type="button" class="{{ $triggerClass }}" onclick="document.getElementById('dialog-confirm-{{ $id }}').showModal()">
    {{ $slot->isEmpty() ? $confirmText : $slot }}
</button>

<dialog id="dialog-confirm-{{ $id }}" class="modal backdrop-blur-sm transition-all duration-300">
    <div class="modal-box relative bg-white rounded-[24px] shadow-[0_20px_60px_-15px_rgba(220,38,38,0.15)] border border-gray-100/80 p-8 max-w-md w-full overflow-hidden transform scale-95 transition-transform duration-300">
        
        <!-- Subtle Danger Accent Background -->
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-500 via-rose-400 to-red-500 opacity-90"></div>
        <div class="absolute -top-32 -right-32 w-64 h-64 bg-red-50 rounded-full blur-[80px] opacity-70 pointer-events-none"></div>

        <div class="relative z-10">
            <!-- Icon -->
            <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 ring-1 ring-inset ring-red-100 shadow-sm">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <!-- Typography -->
            <h3 class="text-xl font-extrabold text-gray-900 tracking-tight mb-2.5">{{ $title }}</h3>
            <p class="text-sm font-medium text-gray-500 leading-relaxed mb-8">
                {{ $message }}
            </p>
            
            <!-- Actions -->
            <form action="{{ $action }}" method="POST" class="flex flex-col-reverse sm:flex-row gap-3 mt-2">
                @csrf
                @method($method)
                
                <button type="button" class="w-full sm:w-1/2 flex justify-center items-center px-4 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-100 transition-all duration-200 shadow-sm" onclick="this.closest('dialog').close()">
                    Cancel
                </button>
                <button type="submit" class="w-full sm:w-1/2 flex justify-center items-center px-4 py-3 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 shadow-md shadow-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition-all duration-200 group">
                    <span>{{ $confirmText }}</span>
                </button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop bg-gray-900/30">
        <button>close</button>
    </form>
</dialog>

