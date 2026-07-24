<x-guest-layout>
    <div class="text-center py-6 px-4 max-w-md mx-auto">
        <!-- Platform Icon Header -->
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-3xl bg-blue-50 text-blue-600 mb-6 shadow-sm border border-blue-100/50">
            @if($platform === 'facebook')
                <svg class="h-10 w-10 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            @elseif($platform === 'linkedin')
                <svg class="h-10 w-10 text-[#0A66C2]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.25V10.9H6.46M7.86 6.64a1.62 1.62 0 1 0 0 3.24 1.62 1.62 0 0 0 0-3.24z"/>
                </svg>
            @else
                <svg class="h-10 w-10 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
            @endif
        </div>

        <h2 class="text-2xl font-black text-gray-900 mb-2">Connecting {{ ucfirst($platform) }}</h2>
        @if(in_array(strtolower($platform), ['twitter', 'x']))
            <div class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900 font-semibold flex items-center gap-2 text-left shadow-sm">
                <span class="text-lg">⭐</span>
                <div>
                    <span class="font-extrabold block text-amber-900">X (Twitter) Premium Required</span>
                    <span class="text-[11px] text-amber-800 font-medium">Automated 30-day AI campaign publishing requires an X Premium / Blue account.</span>
                </div>
            </div>

            <label class="flex items-start gap-2.5 text-left mb-5 cursor-pointer bg-slate-50 p-3 rounded-2xl border border-slate-200/80 hover:bg-slate-100/80 transition-colors">
                <input type="checkbox" id="x-premium-checkbox" onchange="handleCheckboxChange()" class="mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 shrink-0">
                <span class="text-[11px] text-slate-700 font-semibold leading-snug">
                    I confirm that the X (Twitter) account I am connecting has an active <strong>X Premium / Blue</strong> subscription.
                </span>
            </label>
        @else
            <p class="text-gray-500 text-sm font-medium mb-6">
                Please authorize your account in the popup window. This bridge window will close automatically once connected.
            </p>
        @endif

        <!-- Dynamic Status Indicator -->
        <div id="status-box" class="flex items-center justify-center gap-3 text-blue-600 font-bold bg-blue-50/80 py-3.5 px-6 rounded-2xl border border-blue-100 text-xs uppercase tracking-wider mb-6">
            <svg class="animate-spin h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Waiting for authorization...</span>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col gap-2">
            <button type="button" id="reopen-btn" onclick="reopenAuthWindow()" class="w-full py-3 bg-gray-900 hover:bg-black text-white font-bold text-xs rounded-xl transition-all uppercase tracking-wider shadow-sm">
                Re-open Login Window
            </button>
            <button type="button" onclick="closeSelf()" class="w-full py-2.5 bg-transparent hover:bg-gray-100 text-gray-500 font-bold text-xs rounded-xl transition-colors">
                Cancel
            </button>
        </div>
    </div>

    <script>
        const connectUrl = @json($connectUrl);
        const platform = @json($platform);
        const checkStatusUrl = @json(route('social-accounts.check-status', ['project' => $project->id]));
        
        let authWindow = null;
        let pollTimer = null;

        function isTwitterPlatform() {
            return ['twitter', 'x'].includes(platform.toLowerCase());
        }

        function handleCheckboxChange() {
            const cb = document.getElementById('x-premium-checkbox');
            const btn = document.getElementById('reopen-btn');
            if (cb && btn) {
                if (cb.checked) {
                    btn.classList.remove('opacity-50', 'pointer-events-none');
                } else {
                    btn.classList.add('opacity-50', 'pointer-events-none');
                }
            }
        }

        function openAuthChild() {
            if (isTwitterPlatform()) {
                const cb = document.getElementById('x-premium-checkbox');
                if (!cb || !cb.checked) {
                    document.getElementById('status-box').innerHTML = '<span class="text-amber-700 font-bold">Please confirm X Premium subscription above before connecting.</span>';
                    return;
                }
            }

            const popupWidth = 600;
            const popupHeight = 750;
            const left = (window.screen.availWidth / 2) - (popupWidth / 2);
            const top = (window.screen.availHeight / 2) - (popupHeight / 2);
            const features = `width=${popupWidth},height=${popupHeight},left=${left},top=${top},menubar=no,toolbar=no,location=yes,status=no,resizable=yes`;
            
            authWindow = window.open(connectUrl, 'PostPeerOAuthWindow', features);
        }

        function reopenAuthWindow() {
            if (authWindow && !authWindow.closed) {
                authWindow.focus();
            } else {
                openAuthChild();
            }
        }

        function cleanupAndComplete(destinationUrl, reloadParent = false) {
            if (pollTimer) {
                clearInterval(pollTimer);
                pollTimer = null;
            }

            // Close child auth window via handle and fixed window name
            try {
                if (authWindow && !authWindow.closed) {
                    authWindow.close();
                }
            } catch (e) {}

            try {
                const win = window.open('', 'PostPeerOAuthWindow');
                if (win) {
                    win.close();
                }
            } catch (e) {}

            // Communicate with opener main window
            try {
                if (window.opener && !window.opener.closed) {
                    if (reloadParent) {
                        window.opener.location.reload();
                    } else if (destinationUrl) {
                        window.opener.location.href = destinationUrl;
                    }
                }
            } catch (e) {
                console.error('Failed to communicate with opener:', e);
            }

            // Close this bridge popup window
            setTimeout(() => {
                window.close();
            }, 200);
        }

        function closeSelf() {
            if (pollTimer) clearInterval(pollTimer);
            try {
                if (authWindow && !authWindow.closed) {
                    authWindow.close();
                }
            } catch (e) {}
            try {
                const win = window.open('', 'PostPeerOAuthWindow');
                if (win) {
                    win.close();
                }
            } catch (e) {}
            window.close();
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Immediately open auth window
            openAuthChild();

            let attempts = 0;
            const maxAttempts = 180; // Poll for 3 minutes (1.5s interval)

            pollTimer = setInterval(() => {
                attempts++;
                if (attempts > maxAttempts) {
                    clearInterval(pollTimer);
                    document.getElementById('status-box').innerHTML = '<span class="text-rose-600 font-bold">Connection timed out. Please try again.</span>';
                    return;
                }

                fetch(checkStatusUrl)
                    .then(response => response.json())
                    .then(data => {
                        // CASE 1: Needs page selection (Facebook / LinkedIn pages)
                        if (data.needs_selection && data.needs_selection.includes(platform)) {
                            document.getElementById('status-box').innerHTML = '<span class="text-emerald-600 font-bold">Connected! Redirecting...</span>';
                            cleanupAndComplete('/projects/{{ $project->id }}/socials/' + platform + '/select-page');
                            return;
                        }

                        // CASE 2: Already connected
                        if (data.connected && data.connected.includes(platform)) {
                            document.getElementById('status-box').innerHTML = '<span class="text-emerald-600 font-bold">Connected! Refreshing dashboard...</span>';
                            cleanupAndComplete(null, true);
                            return;
                        }

                        // CASE 3: Rejected
                        if (data.rejected && data.rejected.includes(platform)) {
                            cleanupAndComplete(window.location.pathname + '?error=duplicate_account_' + platform);
                            return;
                        }
                    })
                    .catch(err => console.error('Bridge polling error:', err));
            }, 1500);
        });
    </script>
</x-guest-layout>
