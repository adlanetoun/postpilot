@extends('layouts.tool')

@section('title', 'Free GA4 UTM Link Builder & Parameter Generator - PostPilot')
@section('meta_description', 'Generate clean, error-free Google Analytics 4 tracking links with utm_source, utm_medium, and utm_campaign parameters in seconds.')
@section('tool_name', 'Free GA4 UTM Link Builder')

@section('content')
<div class="mb-8" x-data="utmBuilder()">
    <div class="flex items-center gap-2 text-xs text-teal-400 font-semibold uppercase tracking-wider mb-2">
        <span>Analytics Tools</span>
        <span>•</span>
        <span>100% Free & Client-Side</span>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
        GA4 UTM Link Builder & Parameter Generator
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-3xl leading-relaxed">
        Track where your website traffic comes from in Google Analytics 4. Fill in the parameters below to generate a clean, campaign-ready URL.
    </p>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Form -->
        <div class="lg:col-span-7 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
            <div>
                <label for="targetUrl" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                    Website URL *
                </label>
                <input 
                    id="targetUrl"
                    type="url" x-model="url" 
                    placeholder="https://yourwebsite.com/landing-page" 
                    class="w-full bg-slate-950 border border-slate-800 focus:border-teal-500 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none"
                >
            </div>

            <!-- Quick Presets -->
            <div class="flex items-center gap-2 pt-1">
                <span class="text-xs text-slate-500 font-medium">Quick Source Presets:</span>
                <button x-on:click="setPreset('linkedin', 'social')" class="px-2.5 py-1 bg-blue-950 text-blue-400 border border-blue-800/40 rounded-lg text-xs font-medium hover:bg-blue-900">LinkedIn</button>
                <button x-on:click="setPreset('twitter', 'social')" class="px-2.5 py-1 bg-sky-950 text-sky-400 border border-sky-800/40 rounded-lg text-xs font-medium hover:bg-sky-900">Twitter/X</button>
                <button x-on:click="setPreset('facebook', 'social')" class="px-2.5 py-1 bg-indigo-950 text-indigo-400 border border-indigo-800/40 rounded-lg text-xs font-medium hover:bg-indigo-900">Facebook</button>
                <button x-on:click="setPreset('newsletter', 'email')" class="px-2.5 py-1 bg-amber-950 text-amber-400 border border-amber-800/40 rounded-lg text-xs font-medium hover:bg-amber-900">Email</button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label for="utmSource" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Campaign Source (utm_source) *
                    </label>
                    <input 
                        id="utmSource"
                        type="text" x-model="source" 
                        placeholder="linkedin, twitter, newsletter" 
                        class="w-full bg-slate-950 border border-slate-800 focus:border-teal-500 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none"
                    >
                </div>

                <div>
                    <label for="utmMedium" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Campaign Medium (utm_medium) *
                    </label>
                    <input 
                        id="utmMedium"
                        type="text" x-model="medium" 
                        placeholder="social, cpc, email, bio" 
                        class="w-full bg-slate-950 border border-slate-800 focus:border-teal-500 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="utmCampaign" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Campaign Name (utm_campaign) *
                    </label>
                    <input 
                        id="utmCampaign"
                        type="text" x-model="campaign" 
                        placeholder="launch_2026, Black_friday" 
                        class="w-full bg-slate-950 border border-slate-800 focus:border-teal-500 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none"
                    >
                </div>

                <div>
                    <label for="utmContent" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Campaign Content (utm_content)
                    </label>
                    <input 
                        id="utmContent"
                        type="text" x-model="content" 
                        placeholder="banner_v1, post_link" 
                        class="w-full bg-slate-950 border border-slate-800 focus:border-teal-500 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none"
                    >
                </div>
            </div>
        </div>

        <!-- Generated Result -->
        <div class="lg:col-span-5 bg-slate-900 border border-teal-500/30 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-teal-400 block mb-2">
                    Generated Tracking URL
                </span>

                <div class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-xs font-mono text-teal-300 break-all min-h-[140px] flex items-center leading-relaxed">
                    <span x-text="generatedUrl || 'Fill in Website URL & Source above...' "></span>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-500">Valid GA4 Link</span>
                <button 
                    x-on:click="copyUrl()"
                    class="px-5 py-2.5 bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold rounded-xl shadow-lg transition-colors"
                >
                    <span x-text="copied ? 'Copied URL!' : 'Copy UTM Link'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function utmBuilder() {
    return {
        url: 'https://postpilot.com',
        source: 'linkedin',
        medium: 'social',
        campaign: 'autopilot_launch',
        content: '',
        copied: false,

        setPreset(src, med) {
            this.source = src;
            this.medium = med;
        },

        get generatedUrl() {
            if (!this.url) return '';
            try {
                let baseUrl = this.url.trim();
                if (!baseUrl.startsWith('http://') && !baseUrl.startsWith('https://')) {
                    baseUrl = 'https://' + baseUrl;
                }
                const parsed = new URL(baseUrl);
                if (this.source) parsed.searchParams.set('utm_source', this.source.trim());
                if (this.medium) parsed.searchParams.set('utm_medium', this.medium.trim());
                if (this.campaign) parsed.searchParams.set('utm_campaign', this.campaign.trim());
                if (this.content) parsed.searchParams.set('utm_content', this.content.trim());
                return parsed.toString();
            } catch (e) {
                return '';
            }
        },

        copyUrl() {
            if (!this.generatedUrl) return;
            navigator.clipboard.writeText(this.generatedUrl);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
    }
}
</script>
@endsection
