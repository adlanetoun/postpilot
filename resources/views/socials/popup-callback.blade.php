<x-guest-layout>
    <div class="text-center">
        @if($status === 'success')
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 text-green-600 mb-6 shadow-[0_0_30px_rgba(34,197,94,0.3)] animate-bounce" style="animation-duration: 2s;">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold mb-3 text-neutral">Connection Successful!</h2>
            <p class="text-neutral/70 text-base mb-8 font-medium">{{ $message }}</p>
            
            <div class="flex items-center justify-center gap-3 text-primary text-sm font-bold bg-primary/5 py-3 px-6 rounded-xl w-max mx-auto">
                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Closing and refreshing dashboard...
            </div>

            <script>
                setTimeout(function() {
                    try {
                        if (window.opener && !window.opener.closed) {
                            window.opener.postMessage({
                                type: 'oauth-complete',
                                success: true,
                                provider: '{{ $platform ?? "Social Account" }}'
                            }, window.location.origin);
                        }
                    } catch (e) {
                        console.error('Failed to communicate success with opener:', e);
                    }
                    window.close();
                }, 1500);
            </script>
        @else
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 text-red-600 mb-6 shadow-[0_0_30px_rgba(239,68,68,0.3)]">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold mb-3 text-neutral">Connection Failed</h2>
            <p class="text-neutral/70 text-base mb-8 font-medium">{{ $message }}</p>
            <button onclick="window.close()" class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-bold text-base rounded-2xl transition-all shadow-lg active:scale-95 duration-300">
                Close Window
            </button>
            <script>
                try {
                    if (window.opener && !window.opener.closed) {
                        window.opener.postMessage({
                            type: 'oauth-complete',
                            success: false,
                            provider: '{{ $platform ?? "Social Account" }}',
                            message: @json($message)
                        }, window.location.origin);
                    }
                } catch (e) {
                    console.error('Failed to communicate error with opener:', e);
                }
            </script>
        @endif
    </div>
</x-guest-layout>
