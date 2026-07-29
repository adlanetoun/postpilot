<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - PostPilot</title>
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
            <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">Privacy Policy</h1>
            <p class="text-slate-400 text-sm">Last updated: {{ date('F j, Y') }}</p>
        </div>

        <div class="space-y-8 text-slate-300 leading-relaxed text-sm">
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">1. Data We Collect</h2>
                <p>We collect information you provide directly to us when registering an account, connecting social media channels (such as Twitter, LinkedIn, and Facebook OAuth tokens), and generating social media campaigns.</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">2. How We Use Data</h2>
                <p>We use collected data solely to deliver the PostPilot service: generating AI content, scheduling posts, publishing content to your connected social channels, and processing billing transactions.</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">3. Data Security & Storage</h2>
                <p>Your authentication credentials and OAuth tokens are encrypted at rest using industry-standard protocols. We do not sell your personal data or content to third parties.</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">4. Payment Processing</h2>
                <p>All payment data is handled securely by our Merchant of Record partners (Paddle / Dodo Payments). PostPilot does not store credit card numbers on our servers.</p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white">5. Privacy Inquiries</h2>
                <p>If you have any questions or data deletion requests, please contact privacy@postpilot.app.</p>
            </section>
        </div>
    </main>

    <footer class="border-t border-slate-900 bg-slate-950 py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} PostPilot. All rights reserved.
    </footer>
</body>
</html>
