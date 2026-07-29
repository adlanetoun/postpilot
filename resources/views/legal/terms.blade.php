<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms of Service - PostPilot</title>
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
            <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">Terms of Service</h1>
            <p class="text-slate-400 text-sm">Last updated: {{ date('F j, Y') }}</p>
        </div>

        <div class="space-y-8 text-slate-300 leading-relaxed text-sm">
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">1. Agreement to Terms</h2>
                <p>By accessing or using PostPilot ("the Service"), operated at https://postpilot-production-65ef.up.railway.app, you agree to be bound by these Terms of Service. If you do not agree, please do not use the Service.</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">2. Description of Service</h2>
                <p>PostPilot provides AI-powered social media content generation, scheduling, and automated publishing tools across supported social media platforms (LinkedIn, Twitter/X, and Facebook).</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">3. Accounts & Subscriptions</h2>
                <p>To use PostPilot, you must register for an account. You are responsible for maintaining the confidentiality of your account credentials. Subscriptions and campaign credit purchases are processed securely via our Merchant of Record partners (Paddle / Dodo Payments).</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">4. Acceptable Use Policy</h2>
                <p>You agree not to use PostPilot to generate or publish illegal, fraudulent, harmful, or spam content. We reserve the right to suspend or terminate accounts that violate platform guidelines or third-party social network API policies.</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">5. Contact Information</h2>
                <p>If you have any questions regarding these Terms, please contact support at support@postpilot.app.</p>
            </section>
        </div>
    </main>

    <footer class="border-t border-slate-900 bg-slate-950 py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} PostPilot. All rights reserved.
    </footer>
</body>
</html>
