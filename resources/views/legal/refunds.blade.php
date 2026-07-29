<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Refund Policy - PostPilot</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 font-['Plus_Jakarta_Sans',sans-serif] antialiased min-h-screen flex flex-col">
    <header class="border-b border-slate-800 bg-slate-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 font-bold text-lg text-white">
                <div class="w-7 h-7 rounded bg-white flex items-center justify-center text-slate-950 font-black text-xs">PP</div>
                <span>PostPilot</span>
            </a>
            <a href="/" class="text-sm font-semibold text-slate-400 hover:text-white transition-colors">Back to Home</a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-12 flex-1">
        <div class="mb-10 border-b border-slate-800 pb-6">
            <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">Refund Policy</h1>
            <p class="text-slate-400 text-sm">Last updated: {{ date('F j, Y') }}</p>
        </div>

        <div class="space-y-8 text-slate-300 leading-relaxed text-sm">
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">1. Money-Back Guarantee</h2>
                <p>We want you to be completely satisfied with PostPilot. We offer a 14-day money-back guarantee for unused campaign credit purchases.</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">2. Refund Eligibility</h2>
                <p>If you have purchased campaign credits and have not yet approved or launched a live 30-day AI campaign with those credits, you are eligible for a full refund within 14 days of purchase.</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">3. How to Request a Refund</h2>
                <p>To request a refund, please email support@postpilot.app or contact Paddle Customer Support directly with your order reference number. Refunds are processed back to the original payment method within 5-10 business days.</p>
            </section>
        </div>
    </main>

    <footer class="border-t border-slate-900 bg-slate-950 py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} PostPilot. All rights reserved.
    </footer>
</body>
</html>
