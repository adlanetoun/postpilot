@extends('layouts.tool')

@section('title', 'Free UTM Link Builder [No Sign-Up] – Track Any Campaign Instantly | PostPilot')
@section('meta_description', 'Build UTM tracking URLs for Google Analytics in seconds. Track campaigns from TikTok, Instagram, email & more. 100% free UTM generator, no sign-up ➔')
@section('tool_name', 'Free GA4 UTM Link Builder')
@section('tool_route', 'tools.utm-builder')

@section('schema_json')
    <x-seo.faq-schema :faqs="[
        [
            'question' => 'What are UTM parameters and why are they important?',
            'answer' => 'UTM (Urchin Tracking Module) parameters are standardized tags appended to the end of a URL to track digital marketing campaign performance. They enable analytics tools like Google Analytics 4 to identify where traffic comes from, which channels drive visitors, and which specific links lead to conversions. Using UTM parameters ensures precise marketing attribution so you can measure ROI and optimize campaign strategy.',
        ],
        [
            'question' => 'What is the difference between utm_source, utm_medium, and utm_campaign?',
            'answer' => 'The utm_source parameter identifies the specific platform or site referring traffic, such as linkedin, google, or newsletter. The utm_medium parameter indicates the top-level marketing channel or format, such as social, cpc, email, or referral. The utm_campaign parameter identifies the specific promotion or product push, such as q3_launch or black_friday.',
        ],
        [
            'question' => 'Does this UTM builder work with Google Analytics 4 (GA4)?',
            'answer' => 'Yes, our UTM link builder is 100% compatible with Google Analytics 4 (GA4), Universal Analytics, and custom analytics solutions. It features automatic GA4 sanitization that converts parameter values to lowercase and replaces spaces with dashes or underscores for accurate GA4 default channel grouping.',
        ],
        [
            'question' => 'How do UTM parameters affect SEO?',
            'answer' => 'UTM parameters do not negatively impact SEO search rankings when canonical tags are configured properly on your target landing pages. Google and other search engines ignore query strings if self-referencing canonical URLs point to the clean base URL. Avoid using UTM parameters on internal website links, as this can overwrite visitor session data in analytics.',
        ],
        [
            'question' => 'What are best practices for naming UTM campaigns?',
            'answer' => 'Best practices for UTM naming include using strictly lowercase letters, avoiding spaces by using hyphens or underscores, keeping names short yet descriptive, and standardizing parameter values across your marketing team. Using consistent conventions prevents fragmented reporting in Google Analytics 4.',
        ],
        [
            'question' => 'Can I track social media campaigns with UTM links?',
            'answer' => 'Yes, adding UTM tracking links to posts across LinkedIn, X (Twitter), Facebook, Instagram, and YouTube allows you to track organic social posts and paid ad campaigns separately in Google Analytics. Using utm_content or utm_term lets you compare individual post variations, CTA placements, or ad creative variations.',
        ],
    ]" />
@endsection

@section('content')
<div class="mb-16" x-data="utmBuilder()">
    <!-- Centered Hero Section -->
    <section class="flex flex-col items-center text-center gap-4 max-w-3xl mx-auto mb-10 font-sans">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#006c49]/10 border border-[#006c49]/30 rounded-full shadow-md">
            <span class="material-symbols-outlined text-[16px] text-[#006c49]">verified</span>
            <span class="font-mono text-xs text-[#006c49] uppercase tracking-wider font-extrabold">ANALYTICS TOOLS • 100% FREE &amp; CLIENT-SIDE</span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-black tracking-tight leading-tight font-sans text-center">
            GA4 UTM Link Builder &amp; Parameter Generator
        </h1>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl font-medium leading-relaxed text-center font-sans">
            Track marketing campaign performance in Google Analytics 4 with clean, error-free UTM links, automatic GA4 sanitization, instant platform presets, and instant QR codes.
        </p>
    </section>

    {{-- GEO / Answer-First Content --}}
    <div class="max-w-3xl mx-auto mb-8 px-4 sm:px-0">
        <p class="text-[15px] leading-relaxed text-gray-700 font-medium bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <strong>What is this tool?</strong> The UTM Link Builder is a free utility that generates custom tracking URLs formatted for Google Analytics 4 and other marketing analytics platforms. Digital marketers use it to add standardized utm_source, utm_medium, and utm_campaign parameters to landing page links, solving the problem of inconsistent campaign data, missing attribution, and broken reporting across promotional campaigns.
        </p>
    </div>

    <!-- Top Summary Stats Bar -->
    <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
        <!-- Stat 1: Target Domain -->
        <div class="bg-[#f3f4f6] border-2 border-gray-300 rounded-xl p-5 flex flex-col shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-[#4c4546] uppercase tracking-wider font-extrabold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-[#006c49]">public</span>
                Target Domain
            </span>
            <span class="font-mono text-lg sm:text-xl font-extrabold text-black mt-2 truncate" x-text="domainName || 'No Domain'" :title="domainName">No Domain</span>
        </div>

        <!-- Stat 2: Active Parameters -->
        <div class="bg-[#f3f4f6] border-2 border-gray-300 rounded-xl p-5 flex flex-col shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-[#4c4546] uppercase tracking-wider font-extrabold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-[#006c49]">tune</span>
                Active Params
            </span>
            <span class="font-mono text-xl sm:text-2xl font-extrabold text-black mt-2" x-text="`${activeParamCount} / 5`">0 / 5</span>
        </div>

        <!-- Stat 3: Total URL Length -->
        <div class="bg-[#f3f4f6] border-2 border-gray-300 rounded-xl p-5 flex flex-col shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-[#4c4546] uppercase tracking-wider font-extrabold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-[#006c49]">straighten</span>
                URL Length
            </span>
            <span class="font-mono text-xl sm:text-2xl font-extrabold text-black mt-2" x-text="generatedUrl ? `${generatedUrl.length} chars` : '0 chars'">0 chars</span>
        </div>

        <!-- Stat 4: GA4 Formatting -->
        <div class="bg-[#f3f4f6] border-2 border-gray-300 rounded-xl p-5 flex flex-col shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-[#4c4546] uppercase tracking-wider font-extrabold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-[#006c49]">auto_fix_high</span>
                GA4 Format
            </span>
            <span class="font-mono text-base sm:text-lg font-extrabold mt-2" :class="sanitize ? 'text-[#006c49]' : 'text-amber-700'" x-text="sanitize ? (spaceReplacement === 'dash' ? 'Clean (Lower & Dashed)' : 'Clean (Lower & Underscore)') : 'Raw Input'">Clean (Lower & Dashed)</span>
        </div>

        <!-- Stat 5: Validation Status -->
        <div class="bg-[#f3f4f6] border-2 border-gray-300 rounded-xl p-5 flex flex-col shadow-md hover:border-gray-400 transition-all col-span-2 sm:col-span-1">
            <span class="font-mono text-xs text-[#4c4546] uppercase tracking-wider font-extrabold flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-[#006c49]">verified</span>
                Status
            </span>
            <span class="font-mono text-base sm:text-lg font-extrabold mt-2 flex items-center gap-1" :class="isValidUrl ? 'text-[#006c49]' : (generatedUrl ? 'text-amber-600' : 'text-gray-400')">
                <template x-if="isValidUrl">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">check_circle</span>
                        <span>Valid HTTPS</span>
                    </span>
                </template>
                <template x-if="!isValidUrl && generatedUrl">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">warning</span>
                        <span>Check Protocol</span>
                    </span>
                </template>
                <template x-if="!generatedUrl">
                    <span>Waiting Input</span>
                </template>
            </span>
        </div>
    </section>

    <!-- Main Tool Interface Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Form Container Card -->
        <div class="lg:col-span-7 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md flex flex-col justify-between space-y-6">
            <div class="space-y-6">
                <!-- Target Website URL -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="targetUrl" class="text-xs font-extrabold uppercase tracking-wider text-black flex items-center gap-1.5 font-mono">
                            <span class="material-symbols-outlined text-[#006c49] text-base">language</span>
                            <span>Website URL</span>
                            <span class="text-[#006c49] font-extrabold">*</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <button 
                                type="button" 
                                x-on:click="loadSample()" 
                                class="text-xs font-bold text-[#006c49] hover:text-emerald-800 transition-colors font-mono uppercase tracking-wider cursor-pointer flex items-center gap-1"
                            >
                                <span class="material-symbols-outlined text-xs">auto_fix_high</span>
                                <span>Load Sample</span>
                            </button>
                            <span class="text-gray-300">|</span>
                            <button 
                                type="button" 
                                x-on:click="resetForm()" 
                                class="text-xs font-bold text-gray-400 hover:text-rose-600 transition-colors font-mono uppercase tracking-wider cursor-pointer flex items-center gap-1"
                            >
                                <span class="material-symbols-outlined text-xs">restart_alt</span>
                                <span>Reset</span>
                            </button>
                        </div>
                    </div>
                    <div class="relative">
                        <input 
                            id="targetUrl"
                            type="url" 
                            x-model.trim="url" 
                            placeholder="https://yourwebsite.com/landing-page" 
                            class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl px-4 py-3.5 text-sm text-gray-900 placeholder-gray-400 font-sans focus:outline-none transition-all font-medium shadow-md"
                        >
                    </div>
                    <p class="text-[11px] text-gray-500 font-sans mt-1.5 flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs text-gray-400">info</span>
                        <span>Protocol <code class="font-mono text-gray-700">https://</code> will automatically be added if omitted.</span>
                    </p>
                </div>

                <!-- Quick Source & Medium Presets -->
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="text-xs text-black font-extrabold font-mono uppercase tracking-wider flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[#006c49] text-sm">bolt</span>
                            Quick Platform Presets:
                        </span>
                        <span class="text-[11px] font-mono text-gray-500">Auto-sets Source &amp; Medium</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <!-- LinkedIn Preset Pill -->
                        <button 
                            type="button"
                            x-on:click="setPreset('linkedin', 'social')" 
                            :class="isPresetActive('linkedin', 'social') ? 'bg-black text-white border-2 border-black shadow-md scale-[1.02]' : 'bg-white hover:bg-emerald-50/80 text-gray-800 hover:text-[#006c49] border-2 border-gray-300 hover:border-emerald-400'"
                            class="font-mono font-bold px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200 flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 fill-current text-[#0a66c2]" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
                            <span>LinkedIn</span>
                        </button>

                        <!-- Twitter/X Preset Pill -->
                        <button 
                            type="button"
                            x-on:click="setPreset('twitter', 'social')" 
                            :class="isPresetActive('twitter', 'social') ? 'bg-black text-white border-2 border-black shadow-md scale-[1.02]' : 'bg-white hover:bg-emerald-50/80 text-gray-800 hover:text-[#006c49] border-2 border-gray-300 hover:border-emerald-400'"
                            class="font-mono font-bold px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200 flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 fill-current text-gray-900" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            <span>Twitter / X</span>
                        </button>

                        <!-- Facebook Preset Pill -->
                        <button 
                            type="button"
                            x-on:click="setPreset('facebook', 'social')" 
                            :class="isPresetActive('facebook', 'social') ? 'bg-black text-white border-2 border-black shadow-md scale-[1.02]' : 'bg-white hover:bg-emerald-50/80 text-gray-800 hover:text-[#006c49] border-2 border-gray-300 hover:border-emerald-400'"
                            class="font-mono font-bold px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200 flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 fill-current text-blue-600" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H7.5v-3H10V9.5C10 7.01 11.49 5.65 13.75 5.65c1.08 0 2.2.19 2.2.19v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.45 3h-2.33v6.8c4.56-.93 8-4.96 8-9.8z"/></svg>
                            <span>Facebook</span>
                        </button>

                        <!-- Instagram Preset Pill -->
                        <button 
                            type="button"
                            x-on:click="setPreset('instagram', 'social')" 
                            :class="isPresetActive('instagram', 'social') ? 'bg-black text-white border-2 border-black shadow-md scale-[1.02]' : 'bg-white hover:bg-emerald-50/80 text-gray-800 hover:text-[#006c49] border-2 border-gray-300 hover:border-emerald-400'"
                            class="font-mono font-bold px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200 flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 fill-current text-pink-600" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            <span>Instagram</span>
                        </button>

                        <!-- Google Ads Preset Pill -->
                        <button 
                            type="button"
                            x-on:click="setPreset('google', 'cpc')" 
                            :class="isPresetActive('google', 'cpc') ? 'bg-black text-white border-2 border-black shadow-md scale-[1.02]' : 'bg-white hover:bg-emerald-50/80 text-gray-800 hover:text-[#006c49] border-2 border-gray-300 hover:border-emerald-400'"
                            class="font-mono font-bold px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200 flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 fill-current text-amber-500" viewBox="0 0 24 24"><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 15.973 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/></svg>
                            <span>Google Ads</span>
                        </button>

                        <!-- Newsletter Preset Pill -->
                        <button 
                            type="button"
                            x-on:click="setPreset('newsletter', 'email')" 
                            :class="isPresetActive('newsletter', 'email') ? 'bg-black text-white border-2 border-black shadow-md scale-[1.02]' : 'bg-white hover:bg-emerald-50/80 text-gray-800 hover:text-[#006c49] border-2 border-gray-300 hover:border-emerald-400'"
                            class="font-mono font-bold px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200 flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95"
                        >
                            <span class="material-symbols-outlined text-[#006c49] text-sm">mail</span>
                            <span>Newsletter / Email</span>
                        </button>

                        <!-- YouTube Preset Pill -->
                        <button 
                            type="button"
                            x-on:click="setPreset('youtube', 'video')" 
                            :class="isPresetActive('youtube', 'video') ? 'bg-black text-white border-2 border-black shadow-md scale-[1.02]' : 'bg-white hover:bg-emerald-50/80 text-gray-800 hover:text-[#006c49] border-2 border-gray-300 hover:border-emerald-400'"
                            class="font-mono font-bold px-3.5 py-1.5 rounded-xl text-xs transition-all duration-200 flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 fill-current text-red-600" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            <span>YouTube</span>
                        </button>
                    </div>
                </div>

                <!-- Parameters Input Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="utmSource" class="block text-xs font-extrabold uppercase tracking-wider text-black mb-1.5 font-mono">
                            Campaign Source (utm_source) <span class="text-[#006c49] font-extrabold">*</span>
                        </label>
                        <input 
                            id="utmSource"
                            type="text" 
                            x-model.trim="source" 
                            placeholder="linkedin, twitter, newsletter" 
                            class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 font-sans focus:outline-none transition-all font-medium shadow-md"
                        >
                    </div>

                    <div>
                        <label for="utmMedium" class="block text-xs font-extrabold uppercase tracking-wider text-black mb-1.5 font-mono">
                            Campaign Medium (utm_medium) <span class="text-[#006c49] font-extrabold">*</span>
                        </label>
                        <input 
                            id="utmMedium"
                            type="text" 
                            x-model.trim="medium" 
                            placeholder="social, cpc, email, bio" 
                            class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 font-sans focus:outline-none transition-all font-medium shadow-md"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="utmCampaign" class="block text-xs font-extrabold uppercase tracking-wider text-black mb-1.5 font-mono">
                            Campaign Name (utm_campaign) <span class="text-[#006c49] font-extrabold">*</span>
                        </label>
                        <input 
                            id="utmCampaign"
                            type="text" 
                            x-model.trim="campaign" 
                            placeholder="q3_launch, black_friday" 
                            class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 font-sans focus:outline-none transition-all font-medium shadow-md"
                        >
                    </div>

                    <div>
                        <label for="utmContent" class="block text-xs font-extrabold uppercase tracking-wider text-black mb-1.5 font-mono">
                            Campaign Content (utm_content) <span class="text-gray-400 font-sans font-normal lowercase">(optional)</span>
                        </label>
                        <input 
                            id="utmContent"
                            type="text" 
                            x-model.trim="content" 
                            placeholder="banner_v1, hero_cta" 
                            class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 font-sans focus:outline-none transition-all font-medium shadow-md"
                        >
                    </div>
                </div>

                <div>
                    <label for="utmTerm" class="block text-xs font-extrabold uppercase tracking-wider text-black mb-1.5 font-mono">
                        Campaign Term (utm_term) <span class="text-gray-400 font-sans font-normal lowercase">(optional)</span>
                    </label>
                    <input 
                        id="utmTerm"
                        type="text" 
                        x-model.trim="term" 
                        placeholder="running_shoes, saas_automation" 
                        class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 font-sans focus:outline-none transition-all font-medium shadow-md"
                    >
                </div>
            </div>

            <!-- Sanitize / Clean Formatting & Delimiter Options -->
            <div class="pt-5 border-t-2 border-gray-200 flex flex-col space-y-3">
                <div class="flex items-center gap-3">
                    <input 
                        id="sanitizeToggle" 
                        type="checkbox" 
                        x-model="sanitize"
                        class="w-4 h-4 text-[#006c49] bg-white border-2 border-gray-300 rounded focus:ring-black cursor-pointer accent-[#006c49]"
                    >
                    <label for="sanitizeToggle" class="text-xs text-gray-900 font-bold cursor-pointer select-none font-sans">
                        Clean GA4 Formatting <span class="text-gray-500 font-normal">(lowercase, replace spaces &amp; strip special chars)</span>
                    </label>
                </div>

                <div class="flex items-center gap-4 pl-7 text-xs font-sans text-gray-700" x-show="sanitize">
                    <span class="font-bold font-mono text-[11px] text-gray-500 uppercase tracking-wider">Space Separator:</span>
                    <label class="inline-flex items-center gap-1.5 cursor-pointer">
                        <input type="radio" name="spaceReplacement" value="dash" x-model="spaceReplacement" class="accent-[#006c49]">
                        <span>Dash (<code class="font-mono text-black font-bold">-</code>)</span>
                    </label>
                    <label class="inline-flex items-center gap-1.5 cursor-pointer">
                        <input type="radio" name="spaceReplacement" value="underscore" x-model="spaceReplacement" class="accent-[#006c49]">
                        <span>Underscore (<code class="font-mono text-black font-bold">_</code>)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Generated Result Output Card -->
        <div class="lg:col-span-5 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md flex flex-col justify-between relative min-h-[500px]">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b-2 border-gray-200">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-black font-mono flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[#006c49] text-base">terminal</span>
                        <span>Generated Tracking URL</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-[10px] uppercase font-bold text-[#006c49] bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 font-mono shadow-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006c49] animate-pulse"></span>
                        GA4 Ready
                    </span>
                </div>

                <!-- URL Preview Display Box -->
                <div class="bg-[#0d1117] border-2 border-gray-800 rounded-xl p-5 font-mono text-xs text-emerald-400 break-all flex flex-col justify-between min-h-[200px] leading-relaxed relative selection:bg-emerald-900 selection:text-white shadow-inner">
                    <span x-text="generatedUrl || 'Fill in Website URL &amp; Source above to construct link...'" class="w-full select-all font-mono tracking-tight" :class="generatedUrl ? 'text-emerald-300 font-semibold' : 'text-gray-500 font-sans italic'"></span>
                    
                    <div class="mt-4 pt-3 border-t border-gray-800/80 flex items-center justify-between text-[11px] text-gray-400 font-sans">
                        <span class="font-mono">Length: <strong class="text-emerald-400 font-bold" x-text="generatedUrl ? generatedUrl.length : 0"></strong> chars</span>
                        <span x-show="generatedUrl && isValidUrl" class="text-emerald-400 font-semibold flex items-center gap-1 font-mono text-[11px]" x-cloak>
                            <span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span>
                            Valid HTTPS
                        </span>
                        <span x-show="generatedUrl && !isValidUrl" class="text-amber-400 font-semibold flex items-center gap-1 font-mono text-[11px]" x-cloak>
                            <span class="material-symbols-outlined text-amber-400 text-sm">warning</span>
                            Check Protocol
                        </span>
                    </div>
                </div>

                <!-- Parameter Badges Breakdown -->
                <div class="mt-6 space-y-2.5" x-show="generatedUrl" x-cloak>
                    <div class="flex items-center justify-between text-[11px] font-extrabold text-gray-700 uppercase tracking-wider font-mono">
                        <span>Active Parameters Breakdown:</span>
                        <span class="text-[#006c49] font-extrabold" x-text="`${activeParamCount} Active`"></span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        <template x-if="cleanParam(source)">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-mono bg-emerald-50 text-[#006c49] border border-emerald-200 shadow-md font-bold">
                                <span class="text-emerald-800 mr-1">source:</span><span x-text="cleanParam(source)"></span>
                            </span>
                        </template>
                        <template x-if="cleanParam(medium)">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-mono bg-emerald-50 text-[#006c49] border border-emerald-200 shadow-md font-bold">
                                <span class="text-emerald-800 mr-1">medium:</span><span x-text="cleanParam(medium)"></span>
                            </span>
                        </template>
                        <template x-if="cleanParam(campaign)">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-mono bg-emerald-50 text-[#006c49] border border-emerald-200 shadow-md font-bold">
                                <span class="text-emerald-800 mr-1">campaign:</span><span x-text="cleanParam(campaign)"></span>
                            </span>
                        </template>
                        <template x-if="cleanParam(content)">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-mono bg-white text-gray-800 border border-gray-300 shadow-md">
                                <span class="text-gray-500 mr-1 font-bold">content:</span><span x-text="cleanParam(content)"></span>
                            </span>
                        </template>
                        <template x-if="cleanParam(term)">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-mono bg-white text-gray-800 border border-gray-300 shadow-md">
                                <span class="text-gray-500 mr-1 font-bold">term:</span><span x-text="cleanParam(term)"></span>
                            </span>
                        </template>
                    </div>
                </div>

                <!-- QR Code Preview Button & Modal Container -->
                <div class="mt-6 pt-4 border-t border-gray-200" x-show="generatedUrl" x-cloak>
                    <div class="flex items-center justify-between bg-white border-2 border-gray-300 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-50 border border-emerald-200 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[#006c49]">qr_code_2</span>
                            </div>
                            <div>
                                <h4 class="text-xs font-extrabold text-black font-mono uppercase tracking-wider">Campaign QR Code</h4>
                                <p class="text-[11px] text-gray-500 font-sans">Scannable link for print, flyers &amp; events</p>
                            </div>
                        </div>
                        <button 
                            type="button" 
                            x-on:click="showQrModal = true"
                            class="bg-[#006c49] hover:bg-emerald-800 text-white font-mono font-bold text-xs uppercase tracking-wider px-3.5 py-2 rounded-lg transition-all shadow-sm flex items-center gap-1.5 cursor-pointer"
                        >
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            <span>View QR</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer Action Buttons -->
            <div class="mt-6 pt-5 border-t-2 border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a 
                        :href="generatedUrl || '#'" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        x-show="generatedUrl"
                        x-cloak
                        class="bg-white hover:bg-gray-50 text-black border-2 border-black rounded-xl font-mono font-bold text-xs uppercase tracking-wider px-4 py-3 flex items-center justify-center gap-1.5 cursor-pointer transition-all shadow-md w-1/2 sm:w-auto"
                    >
                        <span>Test Link</span>
                        <span class="material-symbols-outlined text-sm">open_in_new</span>
                    </a>
                    
                    <button 
                        type="button"
                        x-on:click="copyParamsOnly()"
                        x-show="generatedUrl && activeParamCount > 0"
                        x-cloak
                        class="text-xs font-bold text-[#006c49] hover:text-emerald-900 transition-colors font-mono uppercase tracking-wider cursor-pointer underline flex items-center gap-1"
                    >
                        <span x-text="copiedParams ? 'Params Copied!' : 'Copy Query Only'"></span>
                    </button>
                </div>

                <button 
                    type="button"
                    x-on:click="copyUrl()"
                    :disabled="!generatedUrl"
                    class="bg-black hover:bg-gray-800 disabled:opacity-40 disabled:cursor-not-allowed text-white font-bold rounded-xl border-2 border-black px-6 py-3.5 text-xs uppercase tracking-wider font-mono transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer shadow-md active:scale-95 w-full sm:w-auto"
                >
                    <template x-if="!copied">
                        <span class="material-symbols-outlined text-base">content_copy</span>
                    </template>
                    <template x-if="copied">
                        <span class="material-symbols-outlined text-base text-emerald-300">check_circle</span>
                    </template>
                    <span x-text="copied ? 'Copied Full URL!' : 'Copy UTM Link'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- QR Code Preview Modal -->
    <div 
        x-show="showQrModal" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div 
            class="bg-white border-2 border-black rounded-2xl p-6 sm:p-8 max-w-sm w-full shadow-2xl space-y-5 relative"
            @click.away="showQrModal = false"
        >
            <div class="flex items-center justify-between pb-3 border-b-2 border-gray-200">
                <h3 class="text-base font-extrabold text-black font-mono uppercase tracking-wider flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#006c49]">qr_code_2</span>
                    <span>UTM QR Code</span>
                </h3>
                <button 
                    type="button" 
                    x-on:click="showQrModal = false"
                    class="text-gray-400 hover:text-black transition-colors"
                >
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="p-3 bg-white border-2 border-gray-300 rounded-xl shadow-md">
                    <img 
                        :src="qrCodeUrl" 
                        alt="Campaign QR Code"
                        class="w-56 h-56 object-contain rounded-lg"
                        loading="lazy"
                    >
                </div>
                <p class="text-xs text-gray-500 text-center font-sans max-w-xs truncate font-mono" x-text="generatedUrl"></p>
            </div>

            <div class="flex flex-col gap-2 pt-2">
                <a 
                    :href="qrCodeUrl" 
                    target="_blank"
                    download="utm-qr-code.png"
                    class="bg-black hover:bg-gray-800 text-white font-mono font-bold text-xs uppercase tracking-wider py-3 px-4 rounded-xl text-center border-2 border-black shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer"
                >
                    <span class="material-symbols-outlined text-base">download</span>
                    <span>Download QR Code Image</span>
                </a>
                <button 
                    type="button" 
                    x-on:click="copyQrCodeLink()"
                    class="bg-white hover:bg-gray-50 text-black border-2 border-gray-300 font-mono font-bold text-xs uppercase tracking-wider py-2.5 px-4 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2 cursor-pointer"
                >
                    <span class="material-symbols-outlined text-base text-[#006c49]">link</span>
                    <span x-text="copiedQrUrl ? 'Link Copied!' : 'Copy QR Image URL'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Editorial Reference & GA4 Best Practices Guide Card -->
    <div class="mt-12 bg-white border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md">
        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-gray-200">
            <h2 class="text-xl font-extrabold text-black tracking-tight font-sans flex items-center gap-2">
                <span class="material-symbols-outlined text-[#006c49]">menu_book</span>
                GA4 UTM Parameters Quick Reference
            </h2>
            <span class="text-xs font-mono text-gray-500 font-bold uppercase tracking-wider">GA4 Standard Conventions</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm mb-6">
            <div class="bg-[#f8f9fa] border-2 border-gray-300 p-5 rounded-xl space-y-2 hover:border-gray-400 transition-all">
                <div class="font-mono text-xs font-extrabold text-black uppercase mb-1 flex items-center justify-between">
                    <span class="text-[#006c49]">utm_source</span>
                    <span class="text-[#006c49] bg-emerald-50 px-2 py-0.5 rounded text-[10px] border border-emerald-200 font-bold">Required</span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-sans font-medium">
                    Identifies the platform or site referring traffic (e.g., <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-emerald-950 font-mono text-[11px] font-bold">linkedin</code>, <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-emerald-950 font-mono text-[11px] font-bold">google</code>, <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-emerald-950 font-mono text-[11px] font-bold">newsletter</code>).
                </p>
            </div>

            <div class="bg-[#f8f9fa] border-2 border-gray-300 p-5 rounded-xl space-y-2 hover:border-gray-400 transition-all">
                <div class="font-mono text-xs font-extrabold text-black uppercase mb-1 flex items-center justify-between">
                    <span class="text-[#006c49]">utm_medium</span>
                    <span class="text-[#006c49] bg-emerald-50 px-2 py-0.5 rounded text-[10px] border border-emerald-200 font-bold">Required</span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-sans font-medium">
                    Identifies the channel or medium type (e.g., <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-emerald-950 font-mono text-[11px] font-bold">social</code>, <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-emerald-950 font-mono text-[11px] font-bold">cpc</code>, <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-emerald-950 font-mono text-[11px] font-bold">email</code>, <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-emerald-950 font-mono text-[11px] font-bold">bio</code>).
                </p>
            </div>

            <div class="bg-[#f8f9fa] border-2 border-gray-300 p-5 rounded-xl space-y-2 hover:border-gray-400 transition-all">
                <div class="font-mono text-xs font-extrabold text-black uppercase mb-1 flex items-center justify-between">
                    <span class="text-[#006c49]">utm_campaign</span>
                    <span class="text-[#006c49] bg-emerald-50 px-2 py-0.5 rounded text-[10px] border border-emerald-200 font-bold">Required</span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-sans font-medium">
                    Identifies the specific promotion or product campaign (e.g., <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-emerald-950 font-mono text-[11px] font-bold">q3_launch</code>, <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-emerald-950 font-mono text-[11px] font-bold">black_friday</code>).
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mb-6">
            <div class="bg-[#f8f9fa] border-2 border-gray-300 p-5 rounded-xl space-y-2 hover:border-gray-400 transition-all">
                <div class="font-mono text-xs font-extrabold text-black uppercase mb-1 flex items-center justify-between">
                    <span class="text-gray-800">utm_content</span>
                    <span class="text-gray-500 bg-gray-100 px-2 py-0.5 rounded text-[10px] border border-gray-300 font-bold">Optional</span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-sans font-medium">
                    Differentiates specific links or ads within the same campaign (e.g., <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-gray-900 font-mono text-[11px]">header_cta</code>, <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-gray-900 font-mono text-[11px]">sidebar_banner</code>, <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-gray-900 font-mono text-[11px]">blue_button</code>).
                </p>
            </div>

            <div class="bg-[#f8f9fa] border-2 border-gray-300 p-5 rounded-xl space-y-2 hover:border-gray-400 transition-all">
                <div class="font-mono text-xs font-extrabold text-black uppercase mb-1 flex items-center justify-between">
                    <span class="text-gray-800">utm_term</span>
                    <span class="text-gray-500 bg-gray-100 px-2 py-0.5 rounded text-[10px] border border-gray-300 font-bold">Optional</span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-sans font-medium">
                    Identifies paid search keywords or targeting terms (e.g., <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-gray-900 font-mono text-[11px]">social_media_automation</code>, <code class="bg-white border border-gray-300 px-1.5 py-0.5 rounded text-gray-900 font-mono text-[11px]">content_calendar</code>).
                </p>
            </div>
        </div>

        <div class="pt-6 border-t-2 border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6 text-xs font-sans text-gray-600">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[#006c49] text-lg shrink-0 mt-0.5">verified</span>
                <div>
                    <h4 class="font-extrabold text-black text-xs uppercase tracking-wider font-mono mb-1">GA4 Case Sensitivity Rule</h4>
                    <p class="leading-relaxed font-medium">Google Analytics 4 is strictly case-sensitive. Links tagged with <code class="font-mono text-[#006c49] font-bold">Email</code> vs <code class="font-mono text-[#006c49] font-bold">email</code> split reporting across separate channels. Enable Clean GA4 formatting to ensure lowercase parameters.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[#006c49] text-lg shrink-0 mt-0.5">analytics</span>
                <div>
                    <h4 class="font-extrabold text-black text-xs uppercase tracking-wider font-mono mb-1">Standard GA4 Channel Grouping</h4>
                    <p class="leading-relaxed font-medium">For accurate auto-channel grouping in GA4 reports, use <code class="font-mono text-[#006c49] font-bold">cpc</code> or <code class="font-mono text-[#006c49] font-bold">paid</code> for paid ad traffic, <code class="font-mono text-[#006c49] font-bold">social</code> for organic social posts, and <code class="font-mono text-[#006c49] font-bold">email</code> for newsletter campaigns.</p>
                </div>
            </div>
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
                    'question' => 'What are UTM parameters and why are they important?',
                    'answer' => 'UTM (Urchin Tracking Module) parameters are standardized tags appended to the end of a URL to track digital marketing campaign performance. They enable analytics tools like Google Analytics 4 to identify where traffic comes from, which channels drive visitors, and which specific links lead to conversions. Using UTM parameters ensures precise marketing attribution so you can measure ROI and optimize campaign strategy.',
                ],
                [
                    'question' => 'What is the difference between utm_source, utm_medium, and utm_campaign?',
                    'answer' => 'The utm_source parameter identifies the specific platform or site referring traffic, such as linkedin, google, or newsletter. The utm_medium parameter indicates the top-level marketing channel or format, such as social, cpc, email, or referral. The utm_campaign parameter identifies the specific promotion or product push, such as q3_launch or black_friday.',
                ],
                [
                    'question' => 'Does this UTM builder work with Google Analytics 4 (GA4)?',
                    'answer' => 'Yes, our UTM link builder is 100% compatible with Google Analytics 4 (GA4), Universal Analytics, and custom analytics solutions. It features automatic GA4 sanitization that converts parameter values to lowercase and replaces spaces with dashes or underscores for accurate GA4 default channel grouping.',
                ],
                [
                    'question' => 'How do UTM parameters affect SEO?',
                    'answer' => 'UTM parameters do not negatively impact SEO search rankings when canonical tags are configured properly on your target landing pages. Google and other search engines ignore query strings if self-referencing canonical URLs point to the clean base URL. Avoid using UTM parameters on internal website links, as this can overwrite visitor session data in analytics.',
                ],
                [
                    'question' => 'What are best practices for naming UTM campaigns?',
                    'answer' => 'Best practices for UTM naming include using strictly lowercase letters, avoiding spaces by using hyphens or underscores, keeping names short yet descriptive, and standardizing parameter values across your marketing team. Using consistent conventions prevents fragmented reporting in Google Analytics 4.',
                ],
                [
                    'question' => 'Can I track social media campaigns with UTM links?',
                    'answer' => 'Yes, adding UTM tracking links to posts across LinkedIn, X (Twitter), Facebook, Instagram, and YouTube allows you to track organic social posts and paid ad campaigns separately in Google Analytics. Using utm_content or utm_term lets you compare individual post variations, CTA placements, or ad creative variations.',
                ],
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

    <!-- PostPilot Promotional CTA Section -->
    <div class="mt-12 bg-white border-2 border-black rounded-[1rem] p-8 sm:p-10 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-3 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-[#006c49] text-[11px] font-extrabold tracking-widest uppercase font-mono">
                    <span class="w-2 h-2 rounded-full bg-[#006c49] animate-pulse"></span>
                    <span>PostPilot Autopilot Engine</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-black tracking-tight font-sans">
                    Track Your Links &amp; Automate Your Entire Social Strategy
                </h3>
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed font-medium font-sans">
                    PostPilot automatically creates, schedules, and tracks 30 days of high-converting social content across LinkedIn, X, and Facebook with built-in UTM link generation.
                </p>
            </div>
            <div class="shrink-0 flex flex-col sm:flex-row md:flex-col gap-3 w-full sm:w-auto">
                <a 
                    href="{{ route('register') }}" 
                    class="bg-black hover:bg-gray-800 text-white font-mono font-bold text-xs uppercase tracking-wider px-6 py-4 rounded-xl border-2 border-black text-center shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-95"
                >
                    <span>Start Free Trial</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
                <a 
                    href="{{ route('home') }}" 
                    class="bg-white hover:bg-gray-50 text-black border-2 border-black font-mono font-bold text-xs uppercase tracking-wider px-6 py-3.5 rounded-xl text-center transition-all flex items-center justify-center gap-2 cursor-pointer shadow-md"
                >
                    <span>Explore Features</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function utmBuilder() {
    return {
        url: 'https://postpilot.com/landing',
        source: 'linkedin',
        medium: 'social',
        campaign: 'q3_launch',
        content: 'hero_cta_button',
        term: 'saas_automation',
        sanitize: true,
        spaceReplacement: 'dash',
        copied: false,
        copiedParams: false,
        showQrModal: false,
        copiedQrUrl: false,
        openFaq: null,

        isPresetActive(src, med) {
            if (src === 'newsletter' || src === 'email') {
                return (this.source === 'newsletter' || this.source === 'email') && this.medium === med;
            }
            return this.source === src && this.medium === med;
        },

        setPreset(src, med) {
            if (this.isPresetActive(src, med)) {
                this.source = '';
                this.medium = '';
            } else {
                this.source = src;
                this.medium = med;
            }
        },

        loadSample() {
            this.url = 'https://postpilot.com/landing';
            this.source = 'linkedin';
            this.medium = 'social';
            this.campaign = 'q3_launch';
            this.content = 'hero_cta_button';
            this.term = 'saas_automation';
            this.sanitize = true;
            this.spaceReplacement = 'dash';
            this.copied = false;
            this.copiedParams = false;
        },

        resetForm() {
            this.url = '';
            this.source = '';
            this.medium = '';
            this.campaign = '';
            this.content = '';
            this.term = '';
            this.copied = false;
            this.copiedParams = false;
        },

        cleanParam(val) {
            if (!val) return '';
            let s = String(val).trim();
            if (this.sanitize) {
                s = s.toLowerCase();
                const rep = this.spaceReplacement === 'underscore' ? '_' : '-';
                s = s.replace(/[\s\t\n]+/g, rep);
                s = s.replace(/[?#&=%!+'"<>\/\\]/g, '');
                if (rep === '-') {
                    s = s.replace(/-+/g, '-').replace(/^-+|-+$/g, '');
                } else {
                    s = s.replace(/_+/g, '_').replace(/^_+|_+$/g, '');
                }
            }
            return s;
        },

        get domainName() {
            if (!this.url || !this.url.trim()) return '';
            try {
                let u = this.url.trim();
                if (!u.startsWith('http://') && !u.startsWith('https://')) {
                    u = 'https://' + u;
                }
                const parsed = new URL(u);
                return parsed.hostname || '';
            } catch (e) {
                return '';
            }
        },

        get activeParamCount() {
            let count = 0;
            if (this.cleanParam(this.source)) count++;
            if (this.cleanParam(this.medium)) count++;
            if (this.cleanParam(this.campaign)) count++;
            if (this.cleanParam(this.content)) count++;
            if (this.cleanParam(this.term)) count++;
            return count;
        },

        get isValidUrl() {
            if (!this.url || !this.url.trim()) return false;
            try {
                let u = this.url.trim();
                if (!u.startsWith('http://') && !u.startsWith('https://')) {
                    u = 'https://' + u;
                }
                const parsed = new URL(u);
                return Boolean(
                    parsed.hostname && 
                    (parsed.hostname.includes('.') || parsed.hostname === 'localhost') &&
                    (parsed.protocol === 'http:' || parsed.protocol === 'https:')
                );
            } catch (e) {
                return false;
            }
        },

        get generatedUrl() {
            if (!this.url || !this.url.trim()) return '';
            try {
                let baseUrl = this.url.trim();
                if (!baseUrl.startsWith('http://') && !baseUrl.startsWith('https://')) {
                    baseUrl = 'https://' + baseUrl;
                }
                const parsed = new URL(baseUrl);
                if (!parsed.hostname || (!parsed.hostname.includes('.') && parsed.hostname !== 'localhost') || (parsed.protocol !== 'http:' && parsed.protocol !== 'https:')) {
                    return '';
                }

                const paramsMap = [
                    { key: 'utm_source', val: this.source },
                    { key: 'utm_medium', val: this.medium },
                    { key: 'utm_campaign', val: this.campaign },
                    { key: 'utm_content', val: this.content },
                    { key: 'utm_term', val: this.term },
                ];

                paramsMap.forEach(item => {
                    const cleaned = this.cleanParam(item.val);
                    if (cleaned) {
                        parsed.searchParams.set(item.key, cleaned);
                    } else {
                        parsed.searchParams.delete(item.key);
                    }
                });

                return parsed.toString();
            } catch (e) {
                return '';
            }
        },

        get generatedParamsOnly() {
            if (!this.generatedUrl) return '';
            try {
                const parsed = new URL(this.generatedUrl);
                return parsed.search || '';
            } catch (e) {
                return '';
            }
        },

        get qrCodeUrl() {
            if (!this.generatedUrl) return '';
            return `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(this.generatedUrl)}`;
        },

        async copyUrl() {
            if (!this.generatedUrl) return;
            const success = await this.copyToClipboard(this.generatedUrl);
            if (success) {
                this.copied = true;
                setTimeout(() => { this.copied = false; }, 2000);
            }
        },

        async copyParamsOnly() {
            if (!this.generatedParamsOnly) return;
            const success = await this.copyToClipboard(this.generatedParamsOnly);
            if (success) {
                this.copiedParams = true;
                setTimeout(() => { this.copiedParams = false; }, 2000);
            }
        },

        async copyQrCodeLink() {
            if (!this.qrCodeUrl) return;
            const success = await this.copyToClipboard(this.qrCodeUrl);
            if (success) {
                this.copiedQrUrl = true;
                setTimeout(() => { this.copiedQrUrl = false; }, 2000);
            }
        },

        async copyToClipboard(text) {
            if (!text) return false;
            let success = false;
            if (navigator.clipboard && window.isSecureContext) {
                try {
                    await navigator.clipboard.writeText(text);
                    success = true;
                } catch (e) {
                    success = false;
                }
            }

            if (!success) {
                try {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.left = '-9999px';
                    textarea.style.top = '-9999px';
                    textarea.style.opacity = '0';
                    textarea.setAttribute('readonly', '');
                    document.body.appendChild(textarea);
                    textarea.focus();
                    textarea.select();
                    textarea.setSelectionRange(0, 99999);
                    success = document.execCommand('copy');
                    document.body.removeChild(textarea);
                } catch (e) {
                    console.error('Fallback copy failed', e);
                }
            }
            return success;
        }
    };
}
</script>
@endsection
