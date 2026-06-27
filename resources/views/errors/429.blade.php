<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Too Many Requests - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    
    <!-- Decorative background glow -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-500 rounded-full filter blur-3xl opacity-20 pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-500 rounded-full filter blur-3xl opacity-20 pointer-events-none"></div>

    <div class="max-w-2xl w-full text-center relative z-10 p-8 bg-gray-900/50 backdrop-blur-sm rounded-3xl border border-white/5 shadow-2xl">
        
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-500/10 text-red-400 mb-8 ring-1 ring-red-500/20 shadow-[0_0_40px_rgba(239,68,68,0.2)]">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>

        <h1 class="text-5xl font-black mb-4 tracking-tight text-white">Rate Limit Exceeded</h1>
        
        <div class="text-lg text-indigo-400 mb-6 font-medium uppercase tracking-widest">Error 429: Too Many Requests</div>
        
        <p class="text-gray-300 max-w-lg mx-auto mb-10 text-lg leading-relaxed">
            You have reached the maximum number of campaign generation requests. To maintain optimal performance for all users, please wait a few minutes before trying again.
        </p>

        <a href="{{ url('/') }}" class="inline-flex items-center gap-3 bg-white hover:bg-gray-100 text-gray-900 font-bold py-3 px-8 rounded-xl shadow-lg transition-all transform hover:-translate-y-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Return to Dashboard
        </a>
        
    </div>

</body>
</html>
