@extends('layouts.tool')

@section('title', 'Free Social Media Engagement Rate Calculator - PostPilot')
@section('meta_description', 'Calculate post & account engagement rate percentage, letter grade (A+ to F), and industry benchmarks across LinkedIn, Instagram, TikTok, X, and Facebook.')
@section('tool_name', 'Free Social Media Engagement Rate Calculator')
@section('tool_route', 'tools.engagement-calculator')

@section('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #ffffff; }
    .font-mono { font-family: 'JetBrains Mono', monospace; }
    .font-mono-numbers { font-family: 'JetBrains Mono', monospace; font-variant-numeric: tabular-nums; }

    input[type=range] {
        -webkit-appearance: none;
        appearance: none;
        width: 100%;
        background: transparent;
    }

    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        height: 22px;
        width: 22px;
        border-radius: 50%;
        background: #000000;
        cursor: pointer;
        margin-top: -8px;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        transition: transform 0.15s ease, background-color 0.15s ease;
    }

    input[type=range]::-webkit-slider-thumb:hover {
        transform: scale(1.15);
        background: #006c49;
    }

    input[type=range]::-moz-range-thumb {
        height: 22px;
        width: 22px;
        border-radius: 50%;
        background: #000000;
        cursor: pointer;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        transition: transform 0.15s ease, background-color 0.15s ease;
    }

    input[type=range]::-moz-range-thumb:hover {
        transform: scale(1.15);
        background: #006c49;
    }

    input[type=range]::-webkit-slider-runnable-track {
        width: 100%;
        height: 6px;
        cursor: pointer;
        background: #e2e8f0;
        border-radius: 3px;
    }

    input[type=range]::-moz-range-track {
        width: 100%;
        height: 6px;
        cursor: pointer;
        background: #e2e8f0;
        border-radius: 3px;
    }

    .metric-card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    
    .metric-card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection

@section('schema_json')
    <x-seo.faq-schema :faqs="[
        [
            'question' => 'How do you calculate social media engagement rate?',
            'answer' => 'Social media engagement rate is calculated by dividing total interactions (likes, comments, shares, retweets, and saves) by your total audience size or reach, then multiplying by 100 to get a percentage. For example, if a post receives 200 interactions from 5,000 followers, your engagement rate is 4.0%.'
        ],
        [
            'question' => 'What is a good engagement rate on LinkedIn?',
            'answer' => 'A good engagement rate on LinkedIn typically ranges between 2.0% and 3.5% for company pages and personal profiles. Top-performing thought leaders and viral B2B posts often achieve engagement rates above 5.0% by driving active comment discussions and post reposts.'
        ],
        [
            'question' => 'What is a good engagement rate on Instagram?',
            'answer' => 'An average Instagram engagement rate sits between 1.2% and 2.5% across feed posts, Reels, and carousels. Accounts with high-intent audience interaction, strong carousel saves, and active DM shares frequently achieve top-tier engagement rates exceeding 4.5%.'
        ],
        [
            'question' => 'Should I use follower-based or impression-based engagement rate?',
            'answer' => 'Follower-based engagement rate (ER) is best for evaluating overall account loyalty and audience interest over time. Impression-based engagement rate (ERR or Reach ER) measures actual content virality and post quality by comparing interactions directly against the number of unique people who viewed the post.'
        ],
        [
            'question' => 'Why is my engagement rate low and how can I improve it?',
            'answer' => 'Low engagement rates are usually caused by weak opening hooks, passive call-to-actions, irregular posting schedules, or ghost followers. You can improve your rate by crafting compelling 2-line hooks, asking direct open-ended questions, publishing high-value saveable carousels, and engaging actively with comments within the first hour of posting.'
        ],
        [
            'question' => 'Does this calculator support multiple social media platforms?',
            'answer' => 'Yes, our free engagement rate calculator includes tailored benchmark algorithms and custom metrics for LinkedIn, Instagram, TikTok, X (Twitter), and Facebook. Simply toggle your target platform to get real-time performance letter grades (A+ to F) and actionable optimization recommendations.'
        ]
    ]" />
@endsection

@section('content')
<div class="mb-16 font-sans" x-data="engagementCalc()">
    <!-- Hero Section -->
    <section class="flex flex-col items-center text-center gap-4 max-w-3xl mx-auto mb-10 font-sans">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#006c49]/10 border border-[#006c49]/30 rounded-full shadow-md">
            <span class="material-symbols-outlined text-[16px] text-[#006c49]">verified</span>
            <span class="font-mono text-xs text-[#006c49] uppercase tracking-wider font-extrabold">ANALYTICS TOOLS • 100% FREE &amp; CLIENT-SIDE</span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-black tracking-tight leading-tight font-sans text-center">
            Social Media Engagement Rate Calculator
        </h1>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl font-medium leading-relaxed text-center font-sans">
            Audit your social media engagement rate percentage, calculate letter grades (A+ to F), and benchmark performance across LinkedIn, Instagram, TikTok, X, and Facebook.
        </p>
    </section>

    {{-- GEO / Answer-First Content --}}
    <div class="max-w-3xl mx-auto mb-8 px-4 sm:px-0">
        <p class="text-[15px] leading-relaxed text-gray-700 font-medium bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <strong>What is this tool?</strong> The Social Media Engagement Rate Calculator is a free utility that measures your content performance across LinkedIn, Instagram, TikTok, X, and Facebook. Marketers and creators use it to calculate exact engagement percentages, grade post interactions, compare performance against industry benchmarks, and optimize audience growth strategies based on high-intent data.
        </p>
    </div>

    <!-- Platform Switcher Tabs -->
    <div class="flex justify-center mb-8">
        <div class="bg-[#f3f4f6] p-1.5 rounded-2xl border-2 border-gray-300 shrink-0 shadow-md">
            <div class="text-[10px] font-mono font-extrabold uppercase text-gray-500 px-2 py-1 tracking-wider text-center sm:text-left">Target Social Platform</div>
            <div class="flex items-center gap-1.5 flex-wrap sm:flex-nowrap justify-center">
                <button
                    type="button"
                    x-on:click="selectedPlatform = 'linkedin'"
                    :class="selectedPlatform === 'linkedin' ? 'bg-black text-white border-2 border-black font-extrabold shadow-md' : 'bg-white text-gray-700 border-2 border-gray-300 hover:border-black font-semibold'"
                    class="px-3.5 py-2 text-xs rounded-xl transition-all flex items-center gap-1.5 font-sans cursor-pointer active:scale-95"
                >
                    <span class="material-symbols-outlined text-[16px] text-sky-600">work</span>
                    <span>LinkedIn</span>
                </button>
                <button
                    type="button"
                    x-on:click="selectedPlatform = 'instagram'"
                    :class="selectedPlatform === 'instagram' ? 'bg-black text-white border-2 border-black font-extrabold shadow-md' : 'bg-white text-gray-700 border-2 border-gray-300 hover:border-black font-semibold'"
                    class="px-3.5 py-2 text-xs rounded-xl transition-all flex items-center gap-1.5 font-sans cursor-pointer active:scale-95"
                >
                    <span class="material-symbols-outlined text-[16px] text-pink-600">photo_camera</span>
                    <span>Instagram</span>
                </button>
                <button
                    type="button"
                    x-on:click="selectedPlatform = 'tiktok'"
                    :class="selectedPlatform === 'tiktok' ? 'bg-black text-white border-2 border-black font-extrabold shadow-md' : 'bg-white text-gray-700 border-2 border-gray-300 hover:border-black font-semibold'"
                    class="px-3.5 py-2 text-xs rounded-xl transition-all flex items-center gap-1.5 font-sans cursor-pointer active:scale-95"
                >
                    <span class="material-symbols-outlined text-[16px] text-teal-600">music_note</span>
                    <span>TikTok</span>
                </button>
                <button
                    type="button"
                    x-on:click="selectedPlatform = 'twitter'"
                    :class="selectedPlatform === 'twitter' ? 'bg-black text-white border-2 border-black font-extrabold shadow-md' : 'bg-white text-gray-700 border-2 border-gray-300 hover:border-black font-semibold'"
                    class="px-3.5 py-2 text-xs rounded-xl transition-all flex items-center gap-1.5 font-sans cursor-pointer active:scale-95"
                >
                    <span class="material-symbols-outlined text-[16px] text-blue-500">tag</span>
                    <span>X (Twitter)</span>
                </button>
                <button
                    type="button"
                    x-on:click="selectedPlatform = 'facebook'"
                    :class="selectedPlatform === 'facebook' ? 'bg-black text-white border-2 border-black font-extrabold shadow-md' : 'bg-white text-gray-700 border-2 border-gray-300 hover:border-black font-semibold'"
                    class="px-3.5 py-2 text-xs rounded-xl transition-all flex items-center gap-1.5 font-sans cursor-pointer active:scale-95"
                >
                    <span class="material-symbols-outlined text-[16px] text-indigo-600">thumb_up</span>
                    <span>Facebook</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Top Overview Stats Bar Grid -->
    <section class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 sm:gap-4 mb-8">
        <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 sm:p-4 flex flex-col shadow-md hover:border-gray-400 transition-all metric-card-hover">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-gray-700">groups</span>
                <span x-text="calculationMode === 'reach' ? 'Reach / Impr' : 'Followers'">Followers</span>
            </span>
            <span class="font-mono-numbers text-xl sm:text-2xl font-black text-black mt-1" x-text="formatNumber(audienceCount)">2,500</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 sm:p-4 flex flex-col shadow-md hover:border-gray-400 transition-all metric-card-hover">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-rose-500">favorite</span>
                Likes
            </span>
            <span class="font-mono-numbers text-xl sm:text-2xl font-black text-black mt-1" x-text="formatNumber(likes)">85</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 sm:p-4 flex flex-col shadow-md hover:border-gray-400 transition-all metric-card-hover">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-sky-500">chat_bubble</span>
                Comments
            </span>
            <span class="font-mono-numbers text-xl sm:text-2xl font-black text-black mt-1" x-text="formatNumber(comments)">18</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 sm:p-4 flex flex-col shadow-md hover:border-gray-400 transition-all metric-card-hover">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-[#006c49]">repeat</span>
                Shares
            </span>
            <span class="font-mono-numbers text-xl sm:text-2xl font-black text-black mt-1" x-text="formatNumber(shares)">7</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 sm:p-4 flex flex-col shadow-md hover:border-gray-400 transition-all metric-card-hover">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-purple-600">bookmark</span>
                Saves
            </span>
            <span class="font-mono-numbers text-xl sm:text-2xl font-black text-black mt-1" x-text="formatNumber(saves)">12</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 sm:p-4 flex flex-col shadow-md hover:border-gray-400 transition-all metric-card-hover">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-indigo-600">analytics</span>
                Total Volume
            </span>
            <span class="font-mono-numbers text-xl sm:text-2xl font-black text-black mt-1" x-text="formatNumber(totalInteractions)">122</span>
        </div>
        <div class="col-span-2 md:col-span-1 bg-white border-2 border-gray-300 rounded-xl p-3.5 sm:p-4 flex flex-col shadow-md hover:border-gray-400 transition-all metric-card-hover">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-[#006c49]">percent</span>
                Eng. Rate
            </span>
            <span class="font-mono-numbers text-xl sm:text-2xl font-black text-[#006c49] mt-1" x-text="`${rate.toFixed(2)}%`">4.88%</span>
        </div>
    </section>

    <!-- Main Calculator Workspace Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-12">

        <!-- Left Column: Inputs & Controls (7 cols) -->
        <div class="lg:col-span-7 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md space-y-6 flex flex-col justify-between">
            <div class="space-y-6">
                <!-- Section Header -->
                <div class="flex items-center justify-between border-b-2 border-gray-200/80 pb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-full bg-black text-white text-xs font-mono flex items-center justify-center font-bold">1</span>
                        <h2 class="text-xs font-extrabold text-black uppercase tracking-wider font-mono flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-[#006c49]">tune</span>
                            Input Profile &amp; Post Metrics
                        </h2>
                    </div>
                    <button
                        type="button"
                        x-on:click="resetForm()"
                        class="px-3 py-1.5 rounded-lg border border-gray-300 hover:border-black bg-white text-gray-700 hover:text-black font-mono text-xs font-bold transition-all flex items-center gap-1 cursor-pointer shadow-md active:scale-95"
                    >
                        <span class="material-symbols-outlined text-sm">restart_alt</span>
                        <span>Reset</span>
                    </button>
                </div>

                <!-- Calculation Mode Selector (Follower ER vs Reach ERR) -->
                <div class="bg-white border-2 border-gray-300 rounded-xl p-4 space-y-3 shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-black font-mono flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-[#006c49]">calculate</span>
                            Engagement Formula Basis:
                        </span>
                        <span class="text-[10px] font-mono font-bold text-gray-500" x-text="calculationMode === 'reach' ? 'ERR (By Reach)' : 'ER (By Followers)'"></span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <button
                            type="button"
                            x-on:click="calculationMode = 'followers'"
                            :class="calculationMode === 'followers' ? 'bg-black text-white border-2 border-black font-extrabold shadow-md' : 'bg-gray-50 text-gray-700 border-2 border-gray-200 hover:border-black font-semibold'"
                            class="py-2 px-3 text-xs rounded-lg transition-all flex items-center justify-center gap-1.5 font-sans cursor-pointer active:scale-98"
                        >
                            <span class="material-symbols-outlined text-sm">groups</span>
                            <span>Follower Basis (ER)</span>
                        </button>
                        <button
                            type="button"
                            x-on:click="calculationMode = 'reach'"
                            :class="calculationMode === 'reach' ? 'bg-black text-white border-2 border-black font-extrabold shadow-md' : 'bg-gray-50 text-gray-700 border-2 border-gray-200 hover:border-black font-semibold'"
                            class="py-2 px-3 text-xs rounded-lg transition-all flex items-center justify-center gap-1.5 font-sans cursor-pointer active:scale-98"
                        >
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            <span>Reach / Impression (ERR)</span>
                        </button>
                    </div>
                </div>

                <!-- Quick Scenario Presets -->
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-700 font-mono flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm text-[#006c49]">bolt</span>
                            Quick Benchmark Presets:
                        </span>
                        <span class="text-[11px] text-gray-500 font-mono">Click to test profiles</span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                        <button
                            type="button"
                            x-on:click="setPreset(2500, 85, 18, 7, 12, 'instagram', 'followers')"
                            class="p-2 text-[11px] font-bold rounded-xl border-2 border-gray-300 bg-white hover:bg-black hover:text-white hover:border-black transition-all text-center cursor-pointer font-sans shadow-md"
                        >
                            Micro Creator
                        </button>
                        <button
                            type="button"
                            x-on:click="setPreset(8400, 180, 42, 24, 18, 'linkedin', 'followers')"
                            class="p-2 text-[11px] font-bold rounded-xl border-2 border-gray-300 bg-white hover:bg-black hover:text-white hover:border-black transition-all text-center cursor-pointer font-sans shadow-md"
                        >
                            B2B Exec
                        </button>
                        <button
                            type="button"
                            x-on:click="setPreset(45000, 2800, 340, 410, 620, 'tiktok', 'reach')"
                            class="p-2 text-[11px] font-bold rounded-xl border-2 border-gray-300 bg-white hover:bg-black hover:text-white hover:border-black transition-all text-center cursor-pointer font-sans shadow-md"
                        >
                            Viral Reel
                        </button>
                        <button
                            type="button"
                            x-on:click="setPreset(12000, 65, 12, 15, 8, 'twitter', 'followers')"
                            class="p-2 text-[11px] font-bold rounded-xl border-2 border-gray-300 bg-white hover:bg-black hover:text-white hover:border-black transition-all text-center cursor-pointer font-sans shadow-md"
                        >
                            SaaS Account
                        </button>
                        <button
                            type="button"
                            x-on:click="setPreset(18500, 210, 48, 32, 14, 'facebook', 'followers')"
                            class="p-2 text-[11px] font-bold rounded-xl border-2 border-gray-300 bg-white hover:bg-black hover:text-white hover:border-black transition-all text-center cursor-pointer font-sans shadow-md col-span-2 sm:col-span-1"
                        >
                            Brand Page
                        </button>
                    </div>
                </div>

                <!-- Audience Base Count Input Card -->
                <div class="bg-white border-2 border-gray-300 rounded-xl p-4 sm:p-5 space-y-2 hover:border-gray-400 transition-all shadow-md">
                    <div class="flex items-center justify-between">
                        <label for="followersCount" class="block text-xs font-extrabold uppercase tracking-wider text-black font-mono flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-gray-700" x-text="calculationMode === 'reach' ? 'visibility' : 'groups'"></span>
                            <span x-text="calculationMode === 'reach' ? 'Post Reach / Total Impressions' : 'Total Followers / Connections'"></span>
                            <span class="text-[#006c49] font-extrabold">*</span>
                        </label>
                        <span class="text-xs font-mono-numbers font-black text-[#006c49]" x-text="formatNumber(audienceCount)"></span>
                    </div>
                    <div class="relative">
                        <input
                            id="followersCount"
                            type="number"
                            min="1"
                            x-model.number="calculationMode === 'reach' ? reach : followers"
                            placeholder="e.g. 5000"
                            class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl pl-4 pr-32 py-3 text-base text-black font-mono-numbers font-bold focus:outline-none transition-all"
                        >
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1">
                            <button
                                type="button"
                                x-on:click="if(calculationMode==='reach'){ reach = Math.max(1, (Number(reach)||0) - 500); } else { followers = Math.max(1, (Number(followers)||0) - 500); }"
                                class="bg-gray-100 hover:bg-black hover:text-white border border-gray-300 rounded-lg px-2 py-1 text-xs font-mono font-bold transition-colors cursor-pointer"
                                title="Subtract 500"
                            >-500</button>
                            <button
                                type="button"
                                x-on:click="if(calculationMode==='reach'){ reach = (Number(reach)||0) + 500; } else { followers = (Number(followers)||0) + 500; }"
                                class="bg-gray-100 hover:bg-black hover:text-white border border-gray-300 rounded-lg px-2 py-1 text-xs font-mono font-bold transition-colors cursor-pointer"
                                title="Add 500"
                            >+500</button>
                        </div>
                    </div>
                    <p class="text-[11px] text-gray-500 font-medium font-sans flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-gray-400">info</span>
                        <span x-text="calculationMode === 'reach' ? 'Total unique viewers or impressions achieved by your post.' : 'Total follower base or connected audience size.'"></span>
                    </p>
                </div>

                <!-- Engagement Breakdown 4 Input Cards Grid -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="block text-xs font-extrabold uppercase tracking-wider text-black font-mono flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-gray-700">bar_chart</span>
                            Post Interaction Breakdown (Per Post or Avg)
                        </span>
                        <span class="text-xs font-mono-numbers font-bold text-gray-600" x-text="`${formatNumber(totalInteractions)} total`"></span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <!-- Likes Input Card -->
                        <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 space-y-2 hover:border-gray-400 transition-all shadow-md">
                            <div class="flex items-center justify-between">
                                <label for="likesCount" class="block text-[11px] font-extrabold uppercase tracking-wider text-gray-900 font-mono flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-rose-500">favorite</span>
                                    Likes
                                </label>
                                <span class="text-[10px] font-mono-numbers font-bold text-gray-500" x-text="`${likesShare}%`"></span>
                            </div>
                            <input
                                id="likesCount"
                                type="number"
                                min="0"
                                x-model.number="likes"
                                placeholder="0"
                                class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl px-3 py-2 text-sm text-black font-mono-numbers font-bold focus:outline-none transition-all"
                            >
                        </div>

                        <!-- Comments Input Card -->
                        <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 space-y-2 hover:border-gray-400 transition-all shadow-md">
                            <div class="flex items-center justify-between">
                                <label for="commentsCount" class="block text-[11px] font-extrabold uppercase tracking-wider text-gray-900 font-mono flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-sky-500">chat_bubble</span>
                                    Comments
                                </label>
                                <span class="text-[10px] font-mono-numbers font-bold text-gray-500" x-text="`${commentsShare}%`"></span>
                            </div>
                            <input
                                id="commentsCount"
                                type="number"
                                min="0"
                                x-model.number="comments"
                                placeholder="0"
                                class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl px-3 py-2 text-sm text-black font-mono-numbers font-bold focus:outline-none transition-all"
                            >
                        </div>

                        <!-- Shares Input Card -->
                        <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 space-y-2 hover:border-gray-400 transition-all shadow-md">
                            <div class="flex items-center justify-between">
                                <label for="sharesCount" class="block text-[11px] font-extrabold uppercase tracking-wider text-gray-900 font-mono flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-[#006c49]">repeat</span>
                                    Shares
                                </label>
                                <span class="text-[10px] font-mono-numbers font-bold text-gray-500" x-text="`${sharesShare}%`"></span>
                            </div>
                            <input
                                id="sharesCount"
                                type="number"
                                min="0"
                                x-model.number="shares"
                                placeholder="0"
                                class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl px-3 py-2 text-sm text-black font-mono-numbers font-bold focus:outline-none transition-all"
                            >
                        </div>

                        <!-- Saves Input Card -->
                        <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 space-y-2 hover:border-gray-400 transition-all shadow-md">
                            <div class="flex items-center justify-between">
                                <label for="savesCount" class="block text-[11px] font-extrabold uppercase tracking-wider text-gray-900 font-mono flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-purple-600">bookmark</span>
                                    Saves
                                </label>
                                <span class="text-[10px] font-mono-numbers font-bold text-gray-500" x-text="`${savesShare}%`"></span>
                            </div>
                            <input
                                id="savesCount"
                                type="number"
                                min="0"
                                x-model.number="saves"
                                placeholder="0"
                                class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl px-3 py-2 text-sm text-black font-mono-numbers font-bold focus:outline-none transition-all"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Volume & Color-Coded Share Distribution Bar Footer -->
            <div class="pt-4 border-t-2 border-gray-200 space-y-3 mt-4">
                <div class="flex items-center justify-between text-xs text-gray-700 font-medium">
                    <span class="font-mono font-bold uppercase tracking-wider text-gray-700 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base text-[#006c49]">calculate</span>
                        Total Engagement Volume:
                    </span>
                    <span class="font-mono-numbers font-black text-black text-sm" x-text="`${formatNumber(totalInteractions)} interactions`"></span>
                </div>

                <!-- Multi-Segment Progress Bar -->
                <div x-show="totalInteractions > 0" class="bg-white border-2 border-gray-300 rounded-xl p-3 space-y-2">
                    <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden flex">
                        <div class="bg-rose-500 h-full transition-all duration-300" :style="`width: ${likesShare}%`" title="Likes"></div>
                        <div class="bg-sky-500 h-full transition-all duration-300" :style="`width: ${commentsShare}%`" title="Comments"></div>
                        <div class="bg-[#006c49] h-full transition-all duration-300" :style="`width: ${sharesShare}%`" title="Shares"></div>
                        <div class="bg-purple-600 h-full transition-all duration-300" :style="`width: ${savesShare}%`" title="Saves"></div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-1 text-[11px] text-gray-600 font-mono font-medium">
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Likes (<span x-text="`${likesShare}%`"></span>)</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-sky-500"></span> Comments (<span x-text="`${commentsShare}%`"></span>)</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#006c49]"></span> Shares (<span x-text="`${sharesShare}%`"></span>)</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-purple-600"></span> Saves (<span x-text="`${savesShare}%`"></span>)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Grade Audit & Results (5 cols) -->
        <div class="lg:col-span-5 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md flex flex-col justify-between space-y-6">

            <div class="space-y-6">
                <!-- Header -->
                <div class="flex items-center justify-between border-b-2 border-gray-200 pb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-full bg-black text-white text-xs font-mono flex items-center justify-center font-bold">2</span>
                        <span class="text-xs font-extrabold uppercase tracking-wider text-black block font-mono">
                            Engagement Audit &amp; Grade
                        </span>
                    </div>
                    <span class="text-[10px] bg-emerald-50 border border-emerald-300 text-[#006c49] px-2.5 py-1 rounded-full font-mono font-extrabold uppercase tracking-widest flex items-center gap-1 shadow-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006c49] animate-ping"></span>
                        Real-time Audit
                    </span>
                </div>

                <!-- Dynamic Grade Badge Display (A+ to F) -->
                <div class="flex flex-col items-center justify-center py-1">
                    <div
                        class="inline-flex items-center gap-3 px-6 py-2.5 rounded-full border-2 text-xl font-extrabold shadow-md transition-all duration-300"
                        :class="gradeBadgeClass"
                    >
                        <span class="w-2.5 h-2.5 rounded-full animate-pulse" :class="gradeDotClass"></span>
                        <span class="text-xs uppercase tracking-widest font-mono font-extrabold">Engagement Grade</span>
                        <span class="font-mono text-3xl font-black" x-text="grade"></span>
                    </div>
                </div>

                <!-- Engagement Rate % Big Readout Card -->
                <div class="text-center bg-white border-2 border-gray-300 py-6 px-4 rounded-xl shadow-md space-y-1">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-gray-500 block font-mono">
                        Calculated Engagement Rate
                    </span>
                    <div class="font-mono-numbers font-black text-5xl sm:text-6xl text-black tracking-tight flex items-center justify-center gap-1" x-text="`${rate.toFixed(2)}%`">4.88%</div>
                    <span class="block text-xs text-gray-600 mt-2 font-sans font-medium">
                        Based on <strong class="text-black font-mono-numbers" x-text="formatNumber(totalInteractions)"></strong> total interactions / <strong class="text-black font-mono-numbers" x-text="formatNumber(audienceCount)"></strong> <span x-text="calculationMode === 'reach' ? 'reach' : 'followers'"></span>
                    </span>
                </div>

                <!-- Benchmark Scale Position Bar Card -->
                <div class="bg-white border-2 border-gray-300 rounded-xl p-4 sm:p-5 space-y-4 shadow-md">
                    <div class="flex items-center justify-between text-xs text-gray-800 font-bold font-mono">
                        <span class="uppercase tracking-wider flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-[#006c49]">straighten</span>
                            Benchmark Scale Position
                        </span>
                        <span class="text-black font-extrabold bg-[#f8f9fa] px-2.5 py-1 rounded-lg border-2 border-gray-300 font-mono-numbers" x-text="`${rate.toFixed(2)}%`"></span>
                    </div>

                    <!-- Visual Scale Progress Bar -->
                    <div class="relative w-full bg-gray-200 h-4 rounded-full overflow-hidden border border-gray-300">
                        <div class="absolute inset-0 grid grid-cols-4 h-full">
                            <div class="bg-rose-100 border-r border-gray-300" title="Low (< 1.0%)"></div>
                            <div class="bg-amber-100 border-r border-gray-300" title="Average (1.0% - 2.5%)"></div>
                            <div class="bg-sky-100 border-r border-gray-300" title="Good (2.5% - 4.0%)"></div>
                            <div class="bg-emerald-100" title="Top 5% (>= 4.0%)"></div>
                        </div>

                        <!-- Floating Pin Handle Marker -->
                        <div
                            class="absolute top-0 bottom-0 w-4 bg-black shadow-md rounded-full border-2 border-white transition-all duration-300 transform -translate-x-1/2 cursor-pointer"
                            :style="{ left: indicatorPosition }"
                        ></div>
                    </div>

                    <!-- 4-Tier Scale Labels -->
                    <div class="grid grid-cols-4 text-[10px] sm:text-xs text-gray-500 text-center font-mono pt-0.5 font-medium">
                        <div :class="rate < 1.0 ? 'text-rose-700 font-black' : ''">&lt;1.0% Low</div>
                        <div :class="rate >= 1.0 && rate < 2.5 ? 'text-amber-700 font-black' : ''">1.0% Average</div>
                        <div :class="rate >= 2.5 && rate < 4.0 ? 'text-sky-700 font-black' : ''">2.5% Good</div>
                        <div :class="rate >= 4.0 ? 'text-[#006c49] font-black' : ''">&gt;4.0% Top 5%</div>
                    </div>

                    <!-- Dynamic Benchmark Analysis Text -->
                    <div class="border-t border-gray-200 pt-3">
                        <p class="text-xs text-gray-700 leading-relaxed font-medium font-sans" x-text="benchmarkText"></p>
                    </div>
                </div>

                <!-- Tailored Optimization Tips Card Per Grade Level -->
                <div class="bg-white border-2 border-gray-300 rounded-xl p-4 sm:p-5 space-y-3 shadow-md">
                    <div class="flex items-center justify-between border-b border-gray-200 pb-2.5">
                        <span class="text-xs font-mono font-extrabold uppercase tracking-wider text-black flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-[#006c49]">lightbulb</span>
                            Grade Optimization Action Plan
                        </span>
                        <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded-md border" :class="gradeTips.badgeColor" x-text="gradeTips.badge"></span>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-xs font-extrabold text-black font-sans" x-text="gradeTips.title"></h4>
                        <p class="text-[11px] text-gray-600 font-medium" x-text="gradeTips.summary"></p>
                        
                        <ul class="space-y-1.5 pt-1">
                            <template x-for="(tip, index) in gradeTips.tips" :key="index">
                                <li class="flex items-start gap-2 text-xs text-gray-700 font-medium">
                                    <span class="material-symbols-outlined text-sm text-[#006c49] shrink-0 mt-0.5">check_circle</span>
                                    <span x-text="tip"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <!-- Deep-Dive Secondary Metrics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-white border-2 border-gray-300 p-3 rounded-xl space-y-1 shadow-md">
                        <div class="text-[10px] font-mono font-bold uppercase text-gray-500 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs text-gray-700">forum</span>
                            Comment Ratio
                        </div>
                        <div class="font-mono-numbers font-extrabold text-xs text-black" x-text="commentToLikeRatio"></div>
                        <div class="text-[9px] text-gray-500 font-sans">Target: ~1:10 ratio</div>
                    </div>
                    <div class="bg-white border-2 border-gray-300 p-3 rounded-xl space-y-1 shadow-md">
                        <div class="text-[10px] font-mono font-bold uppercase text-gray-500 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs text-purple-600">stars</span>
                            High-Intent
                        </div>
                        <div class="font-mono-numbers font-extrabold text-xs text-purple-700" x-text="highIntentRatio"></div>
                        <div class="text-[9px] text-gray-500 font-sans">Shares &amp; Saves %</div>
                    </div>
                    <div class="bg-white border-2 border-gray-300 p-3 rounded-xl space-y-1 shadow-md">
                        <div class="text-[10px] font-mono font-bold uppercase text-gray-500 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs text-[#006c49]">verified</span>
                            Quality Score
                        </div>
                        <div class="font-mono-numbers font-extrabold text-xs text-[#006c49]" x-text="weightedQualityScore"></div>
                        <div class="text-[9px] text-gray-500 font-sans">Weighted algorithm index</div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons: Copy Summary & PostPilot CTA -->
            <div class="pt-4 border-t-2 border-gray-200 space-y-3 mt-4">
                <button
                    type="button"
                    x-on:click="copySummary()"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3.5 bg-white hover:bg-gray-100 text-black text-xs font-bold font-mono uppercase tracking-wider rounded-xl transition-all border-2 border-gray-300 hover:border-black cursor-pointer shadow-md active:scale-98"
                >
                    <span class="material-symbols-outlined text-base text-[#006c49]" x-text="copiedSummary ? 'check_circle' : 'content_copy'"></span>
                    <span x-text="copiedSummary ? 'Audit Report Copied!' : 'Copy Audit Report Summary'"></span>
                </button>

                <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-black hover:bg-gray-800 text-white text-xs sm:text-sm font-bold rounded-xl border-2 border-black transition-all shadow-md group">
                    <span>Boost Your Engagement Rate with PostPilot</span>
                    <span class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Editorial Best Practices Banner & Benchmarks Breakdown -->
    <div class="mt-12 bg-white border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md space-y-8">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 border-2 border-emerald-200 flex items-center justify-center shrink-0 shadow-md">
                <span class="material-symbols-outlined text-[#006c49] text-xl">rocket_launch</span>
            </div>
            <div class="space-y-2 flex-1">
                <h3 class="text-lg sm:text-xl font-extrabold text-black font-sans tracking-tight">
                    How to Increase Your Social Media Engagement Rate
                </h3>
                <p class="text-xs sm:text-sm text-gray-600 font-medium leading-relaxed">Proven tactics used by top 1% creators and brand marketing managers to boost organic reach.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3">
                    <div class="bg-[#f8f9fa] border-2 border-gray-300 p-4 rounded-xl space-y-1.5 shadow-md">
                        <span class="text-xs font-extrabold font-mono text-[#006c49] block flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">bolt</span>
                            1. Strong Opening Hooks
                        </span>
                        <p class="text-xs text-gray-600 leading-relaxed font-medium">The first 2 lines of your post dictate whether readers click 'see more' or scroll past. Test pattern interrupts and bold claims.</p>
                    </div>
                    <div class="bg-[#f8f9fa] border-2 border-gray-300 p-4 rounded-xl space-y-1.5 shadow-md">
                        <span class="text-xs font-extrabold font-mono text-[#006c49] block flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">chat</span>
                            2. Explicit Call-to-Actions
                        </span>
                        <p class="text-xs text-gray-600 leading-relaxed font-medium font-sans">End your posts with open-ended questions or clear prompts to drive comments and discussion instead of passive reading.</p>
                    </div>
                    <div class="bg-[#f8f9fa] border-2 border-gray-300 p-4 rounded-xl space-y-1.5 shadow-md">
                        <span class="text-xs font-extrabold font-mono text-[#006c49] block flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            3. Consistent Schedule
                        </span>
                        <p class="text-xs text-gray-600 leading-relaxed font-medium">Social algorithms prioritize accounts that post consistently 3-5 times per week. Automate your scheduling with PostPilot.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Industry Benchmark Reference Table -->
        <div class="border-t-2 border-gray-200 pt-6">
            <h4 class="text-sm font-extrabold text-black uppercase tracking-wider font-mono mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg text-[#006c49]">table_chart</span>
                2026 Social Platform Benchmark Averages
            </h4>
            <div class="overflow-x-auto border-2 border-gray-300 rounded-xl">
                <table class="w-full text-left text-xs font-sans">
                    <thead>
                        <tr class="bg-[#f3f4f6] text-black font-mono uppercase tracking-wider text-[11px] border-b-2 border-gray-300">
                            <th class="p-3.5">Platform</th>
                            <th class="p-3.5">Average ER%</th>
                            <th class="p-3.5">Top 10% ER%</th>
                            <th class="p-3.5">Primary Algorithm Driver</th>
                            <th class="p-3.5">Ideal Post Frequency</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-gray-200 text-gray-700 bg-white">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3.5 font-extrabold text-black font-mono">LinkedIn</td>
                            <td class="p-3.5 font-mono-numbers font-bold">1.8% - 3.2%</td>
                            <td class="p-3.5 font-mono-numbers font-black text-[#006c49]">&gt; 5.0%</td>
                            <td class="p-3.5 font-medium">Comment depth &amp; dwell time</td>
                            <td class="p-3.5 font-medium">3 - 5 posts / week</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3.5 font-extrabold text-black font-mono">Instagram</td>
                            <td class="p-3.5 font-mono-numbers font-bold">1.2% - 2.5%</td>
                            <td class="p-3.5 font-mono-numbers font-black text-[#006c49]">&gt; 4.2%</td>
                            <td class="p-3.5 font-medium">Shares / DMs &amp; saves</td>
                            <td class="p-3.5 font-medium">4 - 7 posts / week</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3.5 font-extrabold text-black font-mono">TikTok</td>
                            <td class="p-3.5 font-mono-numbers font-bold">3.5% - 6.0%</td>
                            <td class="p-3.5 font-mono-numbers font-black text-[#006c49]">&gt; 9.0%</td>
                            <td class="p-3.5 font-medium">Video watch-through &amp; shares</td>
                            <td class="p-3.5 font-medium">1 - 3 posts / day</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3.5 font-extrabold text-black font-mono">X (Twitter)</td>
                            <td class="p-3.5 font-mono-numbers font-bold">0.8% - 1.8%</td>
                            <td class="p-3.5 font-mono-numbers font-black text-[#006c49]">&gt; 3.5%</td>
                            <td class="p-3.5 font-medium">Retweets / Reposts &amp; replies</td>
                            <td class="p-3.5 font-medium">2 - 5 posts / day</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3.5 font-extrabold text-black font-mono">Facebook</td>
                            <td class="p-3.5 font-mono-numbers font-bold">0.9% - 2.0%</td>
                            <td class="p-3.5 font-mono-numbers font-black text-[#006c49]">&gt; 3.8%</td>
                            <td class="p-3.5 font-medium">Reactions, comments &amp; shares</td>
                            <td class="p-3.5 font-medium">3 - 7 posts / week</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    {{-- FAQ Section (SSR Content for SEO) --}}
    <section class="mt-16 max-w-4xl mx-auto" x-data="{ openFaq: null }">
        <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-[#006c49] text-xl">help</span>
            <h2 class="text-xl font-extrabold text-black tracking-tight font-sans">Frequently Asked Questions</h2>
        </div>

        @php
            $faqs = [
                [
                    'question' => 'How do you calculate social media engagement rate?',
                    'answer' => 'Social media engagement rate is calculated by dividing total interactions (likes, comments, shares, retweets, and saves) by your total audience size or reach, then multiplying by 100 to get a percentage. For example, if a post receives 200 interactions from 5,000 followers, your engagement rate is 4.0%.'
                ],
                [
                    'question' => 'What is a good engagement rate on LinkedIn?',
                    'answer' => 'A good engagement rate on LinkedIn typically ranges between 2.0% and 3.5% for company pages and personal profiles. Top-performing thought leaders and viral B2B posts often achieve engagement rates above 5.0% by driving active comment discussions and post reposts.'
                ],
                [
                    'question' => 'What is a good engagement rate on Instagram?',
                    'answer' => 'An average Instagram engagement rate sits between 1.2% and 2.5% across feed posts, Reels, and carousels. Accounts with high-intent audience interaction, strong carousel saves, and active DM shares frequently achieve top-tier engagement rates exceeding 4.5%.'
                ],
                [
                    'question' => 'Should I use follower-based or impression-based engagement rate?',
                    'answer' => 'Follower-based engagement rate (ER) is best for evaluating overall account loyalty and audience interest over time. Impression-based engagement rate (ERR or Reach ER) measures actual content virality and post quality by comparing interactions directly against the number of unique people who viewed the post.'
                ],
                [
                    'question' => 'Why is my engagement rate low and how can I improve it?',
                    'answer' => 'Low engagement rates are usually caused by weak opening hooks, passive call-to-actions, irregular posting schedules, or ghost followers. You can improve your rate by crafting compelling 2-line hooks, asking direct open-ended questions, publishing high-value saveable carousels, and engaging actively with comments within the first hour of posting.'
                ],
                [
                    'question' => 'Does this calculator support multiple social media platforms?',
                    'answer' => 'Yes, our free engagement rate calculator includes tailored benchmark algorithms and custom metrics for LinkedIn, Instagram, TikTok, X (Twitter), and Facebook. Simply toggle your target platform to get real-time performance letter grades (A+ to F) and actionable optimization recommendations.'
                ]
            ];
        @endphp

        <div class="space-y-3">
            @foreach($faqs as $index => $faq)
            <div class="border border-gray-200 rounded-xl overflow-hidden bg-white">
                <button
                    @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                    class="w-full flex items-center justify-between p-5 text-left hover:bg-gray-50 transition-colors"
                    :aria-expanded="openFaq === {{ $index }}">
                    <span class="text-sm font-bold text-black pr-4">{{ $faq['question'] }}</span>
                    <span class="material-symbols-outlined text-gray-400 transition-transform duration-200 flex-shrink-0"
                          :class="openFaq === {{ $index }} && 'rotate-180'">expand_more</span>
                </button>
                <div x-show="openFaq === {{ $index }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-cloak
                     class="px-5 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-100">
                    <p class="pt-4">{{ $faq['answer'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    </div>
</div>

<script>
function engagementCalc() {
    return {
        followers: 2500,
        reach: 5000,
        calculationMode: 'followers',
        likes: 85,
        comments: 18,
        shares: 7,
        saves: 12,
        selectedPlatform: 'instagram',
        copiedSummary: false,

        formatNumber(num) {
            const n = Math.max(0, Number(num) || 0);
            return n.toLocaleString();
        },

        setPreset(f, l, c, s, sv, platform = 'instagram', mode = 'followers') {
            this.calculationMode = mode;
            if (mode === 'reach') {
                this.reach = f;
            } else {
                this.followers = f;
            }
            this.likes = l;
            this.comments = c;
            this.shares = s;
            this.saves = sv;
            this.selectedPlatform = platform;
        },

        resetForm() {
            this.followers = 0;
            this.reach = 0;
            this.likes = 0;
            this.comments = 0;
            this.shares = 0;
            this.saves = 0;
        },

        get audienceCount() {
            if (this.calculationMode === 'reach') {
                return Math.max(0, Number(this.reach) || 0);
            }
            return Math.max(0, Number(this.followers) || 0);
        },

        get totalInteractions() {
            const l = Math.max(0, Number(this.likes) || 0);
            const c = Math.max(0, Number(this.comments) || 0);
            const s = Math.max(0, Number(this.shares) || 0);
            const sv = Math.max(0, Number(this.saves) || 0);
            return Math.floor(l + c + s + sv);
        },

        get rate() {
            const f = Math.max(0, Number(this.followers) || 0);
            if (f <= 0) return 0;
            const r = (this.totalInteractions / f) * 100;
            return isNaN(r) || !isFinite(r) ? 0 : r;
        },

        get grade() {
            const r = this.rate;
            if (r >= 4.0) return 'A+';
            if (r >= 2.5) return 'A';
            if (r >= 1.5) return 'B';
            if (r >= 0.8) return 'C';
            if (r >= 0.3) return 'D';
            return 'F';
        },

        get gradeBadgeClass() {
            const r = this.rate;
            if (r >= 4.0) return 'bg-emerald-100 text-emerald-950 border-emerald-400';
            if (r >= 2.5) return 'bg-emerald-50 text-emerald-900 border-emerald-300';
            if (r >= 1.5) return 'bg-sky-50 text-sky-900 border-sky-300';
            if (r >= 0.8) return 'bg-amber-50 text-amber-900 border-amber-300';
            if (r >= 0.3) return 'bg-orange-50 text-orange-900 border-orange-300';
            return 'bg-rose-50 text-rose-900 border-rose-300';
        },

        get gradeDotClass() {
            const r = this.rate;
            if (r >= 4.0 || r >= 2.5) return 'bg-[#006c49]';
            if (r >= 1.5) return 'bg-sky-500';
            if (r >= 0.8) return 'bg-amber-500';
            if (r >= 0.3) return 'bg-orange-500';
            return 'bg-rose-500';
        },

        get gradeTips() {
            const r = this.rate;
            if (r >= 4.0) {
                return {
                    title: 'Viral & Elite Authority Status',
                    summary: 'Your engagement rate is in the top 5% of creators on this platform.',
                    badge: 'Top 5% Creator',
                    badgeColor: 'bg-emerald-100 text-[#006c49] border-emerald-300',
                    tips: [
                        'Monetize High Intent: Convert high post engagement into email subscribers and leads.',
                        'Establish Content Pillars: Document the exact hook and image style that triggered viral saves.',
                        'Cross-Pollinate Audiences: Partner with other tier-1 creators for joint live streams & posts.'
                    ]
                };
            } else if (r >= 2.5) {
                return {
                    title: 'Strong Community Resonance',
                    summary: 'Outperforming ~75% of industry competitors with high audience trust.',
                    badge: 'Top 25% Creator',
                    badgeColor: 'bg-emerald-50 text-[#006c49] border-emerald-200',
                    tips: [
                        'Accelerate Dwell Time: Reply to all comments within 60 minutes of posting.',
                        'Test Hook Variations: Experiment with pattern-interrupt opening lines and bold questions.',
                        'Increase Output: Scale your publishing cadence from 3x to 5x per week with PostPilot.'
                    ]
                };
            } else if (r >= 1.5) {
                return {
                    title: 'Solid Baseline Performance',
                    summary: 'Consistent interaction, with significant potential to unlock viral distribution.',
                    badge: 'Above Average',
                    badgeColor: 'bg-sky-50 text-sky-800 border-sky-200',
                    tips: [
                        'Drive High-Value Actions: Create swipeable carousels and checklists that invite Saves & Shares.',
                        'Add Explicit CTAs: End every post with a direct, single-choice question to drive comments.',
                        'Refine Post Timing: Schedule content when your target demographic is most active.'
                    ]
                };
            } else if (r >= 0.8) {
                return {
                    title: 'Average Engagement Baseline',
                    summary: 'Followers are reading passively without taking active engagement actions.',
                    badge: 'Average Range',
                    badgeColor: 'bg-amber-50 text-amber-800 border-amber-200',
                    tips: [
                        'Optimize Hook Lines: Cut intro fluff; make the first 2 lines urgent and curiosity-driven.',
                        'Enhance Readability: Use short sentences, line breaks, and clear bullet points.',
                        'Reduce Direct Sales Pitches: Keep promotional posts under 20% of your total feed volume.'
                    ]
                };
            } else if (r >= 0.3) {
                return {
                    title: 'Underperforming Benchmark',
                    summary: 'Low engagement rate relative to audience size; algorithm reach is throttled.',
                    badge: 'Needs Improvement',
                    badgeColor: 'bg-orange-50 text-orange-800 border-orange-200',
                    tips: [
                        'Pivot Content Strategy: Test completely new content pillars and visual graphics.',
                        'Outbound Community Engagement: Comment meaningfully on 15 niche target accounts daily.',
                        'Simplify Call to Actions: Use simple binary questions (e.g. Agree or Disagree?).'
                    ]
                };
            } else {
                return {
                    title: 'Critical Engagement Deficit',
                    summary: 'Engagement is under 0.3%. Content is suppressed or audience is disengaged.',
                    badge: 'Action Required',
                    badgeColor: 'bg-rose-50 text-rose-800 border-rose-200',
                    tips: [
                        'Audience Audit: Clean up inactive or bot connections that dilute your reach ratio.',
                        'Hook & Format Overhaul: Replace long text walls with visual infographics and short hooks.',
                        'Use PostPilot Templates: Re-build post structure using tested viral templates and hooks.'
                    ]
                };
            }
        },

        get benchmarkText() {
            const r = this.rate;
            const f = Math.max(0, Number(this.followers) || 0);
            if (f <= 0) return 'Enter your follower or connection count to calculate your engagement rate benchmark.';
            const platformName = {
                linkedin: 'LinkedIn',
                instagram: 'Instagram',
                tiktok: 'TikTok',
                twitter: 'X (Twitter)',
                facebook: 'Facebook'
            }[this.selectedPlatform] || 'Social Media';

            if (r >= 4.0) return `Top 5% performer across ${platformName}. Your content triggers immense community action and organic reach.`;
            if (r >= 2.5) return `Above average engagement rate on ${platformName}. Outperforming ~75% of industry competitors with healthy audience engagement.`;
            if (r >= 1.5) return `Average baseline engagement on ${platformName}. Steady interaction levels across your posts, but has room to scale with stronger hooks.`;
            if (r >= 0.8) return `Slightly low engagement on ${platformName}. Consider optimizing call-to-actions, post timing, and lead hooks to drive more comments.`;
            return `Needs optimization. Engagement is under 0.3% on ${platformName}. Test high-converting post templates, visual media, and open questions.`;
        },

        get indicatorPosition() {
            const r = this.rate;
            let pct = 0;
            if (r <= 0) {
                pct = 2;
            } else if (r < 1.0) {
                pct = (r / 1.0) * 25;
            } else if (r < 2.5) {
                pct = 25 + ((r - 1.0) / 1.5) * 25;
            } else if (r < 4.0) {
                pct = 50 + ((r - 2.5) / 1.5) * 25;
            } else {
                pct = 75 + Math.min(23, ((r - 4.0) / 4.0) * 23);
            }
            pct = Math.min(Math.max(pct, 2), 98);
            return `${pct.toFixed(1)}%`;
        },

        get likesShare() {
            if (this.totalInteractions === 0) return 0;
            return Math.round((this.likes / this.totalInteractions) * 100);
        },

        get commentsShare() {
            if (this.totalInteractions === 0) return 0;
            return Math.round((this.comments / this.totalInteractions) * 100);
        },

        get sharesShare() {
            if (this.totalInteractions === 0) return 0;
            return Math.round((this.shares / this.totalInteractions) * 100);
        },

        get savesShare() {
            if (this.totalInteractions === 0) return 0;
            return Math.round((this.saves / this.totalInteractions) * 100);
        },

        get commentToLikeRatio() {
            const l = Math.max(0, Number(this.likes) || 0);
            const c = Math.max(0, Number(this.comments) || 0);
            if (l === 0) return c > 0 ? 'High Depth' : 'N/A';
            const ratio = (c / l).toFixed(2);
            return `1:${(l / Math.max(1, c)).toFixed(1)} (${ratio})`;
        },

        get highIntentRatio() {
            if (this.totalInteractions === 0) return '0%';
            const highIntent = (Number(this.shares) || 0) + (Number(this.saves) || 0);
            const pct = Math.round((highIntent / this.totalInteractions) * 100);
            return `${pct}% (Shares & Saves)`;
        },

        get weightedQualityScore() {
            const l = Math.max(0, Number(this.likes) || 0);
            const c = Math.max(0, Number(this.comments) || 0);
            const s = Math.max(0, Number(this.shares) || 0);
            const sv = Math.max(0, Number(this.saves) || 0);
            if (this.totalInteractions === 0) return '0 / 100';
            // Formula: Likes 1x, Saves 3x, Comments 4x, Shares 5x
            const weighted = (l * 1) + (sv * 3) + (c * 4) + (s * 5);
            const maxScorePerInteraction = 5;
            const score = Math.min(100, Math.round((weighted / Math.max(1, (l + c + s + sv) * maxScorePerInteraction)) * 100));
            return `${score} / 100 Quality`;
        },

        copySummary() {
            const modeLabel = this.calculationMode === 'reach' ? 'Reach / Impressions' : 'Total Followers';
            const audVal = this.calculationMode === 'reach' ? this.reach : this.followers;
            const report = `Social Media Engagement Rate Audit:
- Target Platform: ${this.selectedPlatform.toUpperCase()}
- Calculation Basis: ${modeLabel} (${Number(audVal).toLocaleString()})
- Total Interactions: ${this.totalInteractions.toLocaleString()} (${this.likes} likes, ${this.comments} comments, ${this.shares} shares, ${this.saves} saves)
- Calculated ER%: ${this.rate.toFixed(2)}%
- Performance Grade: ${this.grade} (${this.gradeTips.badge})
- Strategy Evaluation: ${this.gradeTips.title} - ${this.gradeTips.summary}
- Benchmark Assessment: ${this.benchmarkText}

Generated with PostPilot Free Social Media Engagement Calculator`;
            navigator.clipboard.writeText(report);
            this.copiedSummary = true;
            setTimeout(() => { this.copiedSummary = false; }, 2500);
        }
    }
}
</script>
@endsection
