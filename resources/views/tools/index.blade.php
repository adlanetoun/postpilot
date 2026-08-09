@extends('layouts.tool')

@section('title', '100% Free Social Media Tools Directory - PostPilot')
@section('meta_description', 'Free, zero-signup micro-tools for creators, marketers, and SaaS founders. Preview posts, split Twitter threads, format LinkedIn text, and calculate ROI instantly.')

@section('content')
<div class="text-center max-w-3xl mx-auto mb-12">
    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-950 text-indigo-400 border border-indigo-800/60 text-xs font-semibold mb-4">
        ⚡ 100% Free • No Signup Required • Client-Side Speed
    </span>
    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-4 leading-tight">
        Free Social Media Marketing & Optimization Tools
    </h1>
    <p class="text-slate-400 text-base sm:text-lg leading-relaxed">
        Purpose-built utilities for founders and creators to format, preview, analyze, and structure high-converting social media content.
    </p>
</div>

<!-- Tools Directory Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Tool 1 -->
    <a href="{{ route('tools.linkedin-preview') }}" class="group bg-slate-900/80 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/50 rounded-2xl p-6 transition-all shadow-lg hover:shadow-indigo-950/40 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="p-2.5 rounded-xl bg-blue-950/80 text-blue-400 border border-blue-800/40 text-xs font-bold uppercase tracking-wider">
                    LinkedIn
                </span>
                <span class="text-xs text-indigo-400 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Use Tool &rarr;
                </span>
            </div>
            <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors mb-2">
                LinkedIn Post Preview & See More Checker
            </h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Preview your LinkedIn posts live on Desktop & Mobile. Instantly identify where the "See More" fold cut happens (~140-210 characters) so your hooks never get hidden.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-500">
            <span>⚡ Zero Signup</span>
            <span>📱 Desktop & Mobile Preview</span>
        </div>
    </a>

    <!-- Tool 2 -->
    <a href="{{ route('tools.twitter-thread-splitter') }}" class="group bg-slate-900/80 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/50 rounded-2xl p-6 transition-all shadow-lg hover:shadow-indigo-950/40 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="p-2.5 rounded-xl bg-sky-950/80 text-sky-400 border border-sky-800/40 text-xs font-bold uppercase tracking-wider">
                    X / Twitter
                </span>
                <span class="text-xs text-indigo-400 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Use Tool &rarr;
                </span>
            </div>
            <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors mb-2">
                Twitter / X Thread Splitter & Auto-Numberer
            </h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Paste long blog posts or articles to instantly split them into perfectly formatted ≤280 character tweets with auto-numbering (1/N) and accurate t.co link math.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-500">
            <span>⚡ Auto 280-char Splitting</span>
            <span>🔗 URL t.co Counting</span>
        </div>
    </a>

    <!-- Tool 3 -->
    <a href="{{ route('tools.linkedin-bold-italic') }}" class="group bg-slate-900/80 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/50 rounded-2xl p-6 transition-all shadow-lg hover:shadow-indigo-950/40 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="p-2.5 rounded-xl bg-indigo-950/80 text-indigo-400 border border-indigo-800/40 text-xs font-bold uppercase tracking-wider">
                    Formatting
                </span>
                <span class="text-xs text-indigo-400 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Use Tool &rarr;
                </span>
            </div>
            <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors mb-2">
                LinkedIn Bold & Italic Unicode Text Formatter
            </h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Convert standard plain text into mathematical Unicode 𝗕𝗼𝗹𝗱, 𝘐𝘵𝘢𝘭𝘪𝘤, 𝖲𝖺𝗇𝗌-𝖲𝖾𝗋𝗂𝖿, and 𝙼𝚘𝚗𝚘𝚜𝚙𝚊𝚌𝖾 styles ready to paste directly into LinkedIn and Twitter.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-500">
            <span>✍️ Unicode Math Formatting</span>
            <span>📋 One-Click Copy</span>
        </div>
    </a>

    <!-- Tool 4 -->
    <a href="{{ route('tools.social-character-counter') }}" class="group bg-slate-900/80 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/50 rounded-2xl p-6 transition-all shadow-lg hover:shadow-indigo-950/40 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="p-2.5 rounded-xl bg-purple-950/80 text-purple-400 border border-purple-800/40 text-xs font-bold uppercase tracking-wider">
                    Multi-Platform
                </span>
                <span class="text-xs text-indigo-400 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Use Tool &rarr;
                </span>
            </div>
            <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors mb-2">
                Multi-Platform Character Limit Counter Grid
            </h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Track character limits, word counts, and line counts across LinkedIn, X/Twitter, and Facebook simultaneously in a real-time progress bar dashboard.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-500">
            <span>📊 Realtime Multi-Platform Limits</span>
            <span>⏱️ Reading Time Stats</span>
        </div>
    </a>

    <!-- Tool 5 -->
    <a href="{{ route('tools.social-roi-calculator') }}" class="group bg-slate-900/80 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/50 rounded-2xl p-6 transition-all shadow-lg hover:shadow-indigo-950/40 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="p-2.5 rounded-xl bg-emerald-950/80 text-emerald-400 border border-emerald-800/40 text-xs font-bold uppercase tracking-wider">
                    ROI Calculator
                </span>
                <span class="text-xs text-indigo-400 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Use Tool &rarr;
                </span>
            </div>
            <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors mb-2">
                Social Media Time Saved & ROI Calculator
            </h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Calculate how many hours and dollars your agency or business wastes every month doing manual content creation and scheduling versus automated autopilot.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-500">
            <span>💰 Dollar Savings Estimates</span>
            <span>📈 Workload Efficiency</span>
        </div>
    </a>

    <!-- Tool 6 -->
    <a href="{{ route('tools.linkedin-line-break') }}" class="group bg-slate-900/80 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/50 rounded-2xl p-6 transition-all shadow-lg hover:shadow-indigo-950/40 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="p-2.5 rounded-xl bg-amber-950/80 text-amber-400 border border-amber-800/40 text-xs font-bold uppercase tracking-wider">
                    Formatting
                </span>
                <span class="text-xs text-indigo-400 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Use Tool &rarr;
                </span>
            </div>
            <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors mb-2">
                LinkedIn Paragraph Spacing & Line Break Formatter
            </h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Fix cramped LinkedIn posts. Injects zero-width invisible spaces between paragraphs so LinkedIn never strips your clean line breaks upon pasting.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-500">
            <span>✨ Zero-Width Spaces</span>
            <span>📖 Clean Mobile Layout</span>
        </div>
    </a>

    <!-- Tool 7 -->
    <a href="{{ route('tools.utm-builder') }}" class="group bg-slate-900/80 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/50 rounded-2xl p-6 transition-all shadow-lg hover:shadow-indigo-950/40 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="p-2.5 rounded-xl bg-teal-950/80 text-teal-400 border border-teal-800/40 text-xs font-bold uppercase tracking-wider">
                    Analytics
                </span>
                <span class="text-xs text-indigo-400 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Use Tool &rarr;
                </span>
            </div>
            <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors mb-2">
                GA4 UTM Link Builder & Parameter Generator
            </h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Generate clean, error-free Google Analytics 4 tracking links with utm_source, utm_medium, and utm_campaign parameters in seconds.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-500">
            <span>🔗 GA4 Validated URLs</span>
            <span>📋 One-Click Copy</span>
        </div>
    </a>

    <!-- Tool 8 -->
    <a href="{{ route('tools.engagement-calculator') }}" class="group bg-slate-900/80 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/50 rounded-2xl p-6 transition-all shadow-lg hover:shadow-indigo-950/40 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="p-2.5 rounded-xl bg-rose-950/80 text-rose-400 border border-rose-800/40 text-xs font-bold uppercase tracking-wider">
                    Audit & Grade
                </span>
                <span class="text-xs text-indigo-400 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Use Tool &rarr;
                </span>
            </div>
            <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors mb-2">
                Social Media Engagement Rate Calculator
            </h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Compute post or account engagement percentage with industry benchmarks and receive an instant A+ through F readability & engagement score.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-500">
            <span>🎯 A-F Grade Scoring</span>
            <span>📊 Industry Benchmarks</span>
        </div>
    </a>

    <!-- Tool 9 -->
    <a href="{{ route('tools.linkedin-hooks') }}" class="group bg-slate-900/80 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/50 rounded-2xl p-6 transition-all shadow-lg hover:shadow-indigo-950/40 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="p-2.5 rounded-xl bg-indigo-950/80 text-indigo-400 border border-indigo-800/40 text-xs font-bold uppercase tracking-wider">
                    Content Generation
                </span>
                <span class="text-xs text-indigo-400 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Use Tool &rarr;
                </span>
            </div>
            <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors mb-2">
                LinkedIn Hook Generator Template Matrix
            </h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Overcome writer's block. Select from 50+ viral LinkedIn opening hook formulas filtered by topic, story, curiosity, and opinion styles.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-500">
            <span>🔥 50+ Viral Hook Templates</span>
            <span>🎯 Topic Dynamic Filling</span>
        </div>
    </a>

    <!-- Tool 10 -->
    <a href="{{ route('tools.content-calendar-template') }}" class="group bg-slate-900/80 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/50 rounded-2xl p-6 transition-all shadow-lg hover:shadow-indigo-950/40 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="p-2.5 rounded-xl bg-emerald-950/80 text-emerald-400 border border-emerald-800/40 text-xs font-bold uppercase tracking-wider">
                    Planning & Export
                </span>
                <span class="text-xs text-indigo-400 font-semibold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                    Use Tool &rarr;
                </span>
            </div>
            <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors mb-2">
                30-Day Content Calendar Matrix & CSV Exporter
            </h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Generate a structured 30-day social media matrix balancing 40% Educational, 30% Proof, 20% Personal, and 10% Promotional content. Export to CSV instantly.
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-500">
            <span>📅 30-Day Content Balance</span>
            <span>📥 One-Click CSV Export</span>
        </div>
    </a>
</div>
@endsection
