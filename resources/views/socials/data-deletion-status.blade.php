<x-guest-layout>
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-primary/20">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <h1 class="text-2xl font-bold text-base-content mb-2">Data Deletion Status</h1>
        <p class="text-sm text-base-content/70">Track your request status from {{ config('app.name', 'PostPilot') }}.</p>
    </div>

    <div class="space-y-4 text-left">
        <div class="bg-base-200 border border-base-300 rounded-xl p-4">
            <div class="text-xs text-base-content/50 font-medium uppercase tracking-wider mb-1">Confirmation Code</div>
            <div class="font-mono text-sm font-bold text-base-content">{{ $request->confirmation_code }}</div>
        </div>

        <div class="bg-base-200 border border-base-300 rounded-xl p-4">
            <div class="text-xs text-base-content/50 font-medium uppercase tracking-wider mb-1">Status</div>
            <div class="flex items-center gap-2">
                @if($request->status === 'pending')
                    <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                    <span class="font-semibold text-yellow-600 capitalize">Pending</span>
                @elseif($request->status === 'processing')
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <span class="font-semibold text-blue-600 capitalize">Processing</span>
                @elseif($request->status === 'completed')
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    <span class="font-semibold text-green-600 capitalize">Completed</span>
                @elseif($request->status === 'failed')
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    <span class="font-semibold text-red-600 capitalize">Failed</span>
                @endif
            </div>
        </div>

        <div class="bg-base-200 border border-base-300 rounded-xl p-4">
            <div class="text-xs text-base-content/50 font-medium uppercase tracking-wider mb-1">Requested At</div>
            <div class="text-sm font-medium text-base-content">{{ $request->created_at->format('M d, Y h:i A') }}</div>
        </div>
        
        @if($request->notes)
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mt-4">
            <div class="text-xs text-red-500 font-medium uppercase tracking-wider mb-1">Notes</div>
            <div class="text-sm font-medium text-red-700">{{ $request->notes }}</div>
        </div>
        @endif
    </div>
    
    <div class="mt-8 text-center">
        <a href="{{ url('/') }}" class="text-sm font-bold text-primary hover:text-primary-focus transition-colors">Return to Homepage</a>
    </div>
</x-guest-layout>
