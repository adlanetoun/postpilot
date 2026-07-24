<x-guest-layout>
    <div class="w-full max-w-lg mx-auto">
        <div class="text-center mb-8">
            @if($platform === 'facebook')
                <div class="mx-auto w-16 h-16 bg-[#1877F2]/10 text-[#1877F2] rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-[#1877F2]/20">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Connect Facebook Page</h2>
                <p class="text-sm text-gray-500">Select the Facebook Business Page you want to automate.</p>
            @elseif($platform === 'linkedin')
                <div class="mx-auto w-16 h-16 bg-[#0077b5]/10 text-[#0077b5] rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-[#0077b5]/20">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Connect LinkedIn Page</h2>
                <p class="text-sm text-gray-500">Select the LinkedIn Company Page you want to automate.</p>
            @else
                <div class="mx-auto w-16 h-16 bg-gray-100 text-gray-700 rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-gray-200">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Select Account</h2>
                <p class="text-sm text-gray-500">Choose the account to connect to this project.</p>
            @endif
        </div>

        <div class="bg-white border border-gray-200 shadow-xl shadow-gray-200/50 rounded-2xl p-6 md:p-8">
            @if(empty($pages))
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">No Pages Found</h3>
                    
                    @if($platform === 'facebook')
                        <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto">
                            We couldn't find any associated pages. <strong>Important:</strong> You must click "Edit Settings" during the Facebook login and select the pages you want to use.
                        </p>
                    @else
                        <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto">
                            We couldn't find any associated pages. Please ensure you granted all necessary permissions when logging in.
                        </p>
                    @endif
                    
                    @if($isPopup)
                        <button onclick="window.close()" class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-colors">
                            Close Window
                        </button>
                    @else
                        <a href="{{ route('projects.show', $project->id) }}" class="block w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-colors text-center">
                            Return to Project
                        </a>
                    @endif
                </div>
            @else
                <form action="{{ route('social-accounts.save-page', ['project' => $project->id, 'platform' => $platform]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="state" value="{{ $state }}">
                    <input type="hidden" name="popup" value="{{ $isPopup ? 1 : 0 }}">
                    
                    <div class="space-y-3 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                        <style>
                            .custom-scrollbar::-webkit-scrollbar { width: 6px; }
                            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
                            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 10px; }
                        </style>
                        
                        @foreach($pages as $index => $page)
                            <label class="relative flex cursor-pointer">
                                <input type="radio" name="selected_page_index" value="{{ $index }}" class="peer sr-only" required {{ $index === 0 ? 'checked' : '' }}>
                                <div class="w-full flex items-center p-4 bg-gray-50 border-2 border-gray-200 rounded-xl transition-all peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:bg-gray-100">
                                    <div class="relative flex-shrink-0 mr-4">
                                        @if(!empty($page['logo_url']))
                                            <img src="{{ $page['logo_url'] }}" alt="{{ $page['name'] }}" class="h-12 w-12 rounded-full object-cover border border-gray-200 bg-white">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg border border-blue-200">
                                                {{ substr($page['name'], 0, 1) }}
                                            </div>
                                        @endif
                                        
                                        <!-- Checked Icon -->
                                        <div class="absolute -bottom-1 -right-1 bg-blue-600 text-white rounded-full p-0.5 opacity-0 peer-checked:opacity-100 transition-opacity transform scale-0 peer-checked:scale-100">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <p class="text-base font-bold text-gray-900 truncate peer-checked:text-blue-800">{{ $page['name'] }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            @if(isset($page['is_personal']) && $page['is_personal'])
                                                Personal Profile
                                            @else
                                                Business Page
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="ml-4 flex-shrink-0">
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 flex items-center justify-center transition-colors">
                                            <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    
                    @if($platform === 'facebook')
                        <div class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-xl">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-700">Missing a page?</h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        If your page isn't listed here, you probably didn't select it during the Facebook authentication. 
                                        @if($isPopup)
                                            <button type="button" onclick="window.close()" class="text-blue-600 font-bold hover:underline">Close this window</button> and reconnect, making sure to select ALL your pages.
                                        @else
                                            <a href="{{ route('projects.show', $project->id) }}" class="text-blue-600 font-bold hover:underline">Return to Dashboard</a> and reconnect, making sure to select ALL your pages.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-8 flex items-center justify-between gap-4">
                        @if($isPopup)
                            <button type="button" onclick="window.close()" class="flex-1 py-3 px-4 text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl transition-colors text-center">
                                Cancel
                            </button>
                        @else
                            <a href="{{ route('projects.show', $project->id) }}" class="flex-1 py-3 px-4 text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl transition-colors text-center">
                                Cancel
                            </a>
                        @endif
                        
                        <button type="submit" class="flex-1 py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors text-center shadow-lg shadow-blue-600/30">
                            Connect
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Automatically target and close any lingering OAuth popup windows
            const popupNames = ['PostPeerOAuthWindow', 'PostPeerAuthWin'];
            popupNames.forEach(name => {
                try {
                    const win = window.open('', name);
                    if (win) {
                        win.close();
                    }
                } catch (e) {}
            });
        });
    </script>
</x-guest-layout>
