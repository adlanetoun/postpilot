@extends('layouts.tool')

@section('title', 'Free LinkedIn Post Preview & See More Fold Checker - PostPilot')
@section('meta_description', 'Preview how your LinkedIn posts look live on Desktop and Mobile before publishing. Instantly check where the "See More" cutoff hides your hooks.')
@section('tool_name', 'Free LinkedIn Post Preview & See More Fold Checker')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs text-indigo-400 font-semibold uppercase tracking-wider mb-2">
        <span>LinkedIn Tools</span>
        <span>•</span>
        <span>100% Free & Client-Side</span>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
        LinkedIn Post Preview & "See More" Fold Checker
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-3xl leading-relaxed">
        Test your LinkedIn post formatting live. Make sure your opening hook captures attention before LinkedIn cuts off text behind the "see more" button (~140-210 characters).
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8" x-data="linkedinPreview()">
    <!-- Left Column: Input Form -->
    <div class="lg:col-span-6 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="postText" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                    Write or Paste Your Post
                </label>
                <div class="text-xs text-slate-400 font-mono">
                    <span :class="charCount > 3000 ? 'text-red-400 font-bold' : 'text-slate-300'" x-text="charCount"></span> / 3,000 chars
                </div>
            </div>

            <textarea 
                id="postText"
                x-model="text"
                rows="10"
                placeholder="Type your LinkedIn post hook here..."
                class="w-full bg-slate-950 border border-slate-800 focus:border-indigo-500 rounded-xl p-4 text-sm text-slate-100 placeholder-slate-600 focus:outline-none focus:ring-1 focus:ring-indigo-500 font-sans leading-relaxed resize-y"
            ></textarea>

            <div class="mt-4 grid grid-cols-3 gap-2 text-center text-xs">
                <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800/80">
                    <span class="block text-slate-500 mb-0.5">Lines</span>
                    <span class="font-bold text-slate-200" x-text="lineCount"></span>
                </div>
                <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800/80">
                    <span class="block text-slate-500 mb-0.5">Words</span>
                    <span class="font-bold text-slate-200" x-text="wordCount"></span>
                </div>
                <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800/80">
                    <span class="block text-slate-500 mb-0.5">Fold Cutoff</span>
                    <span class="font-bold" :class="isCutoff ? 'text-amber-400' : 'text-emerald-400'" x-text="isCutoff ? 'Cut Hidden' : 'Full Hook Visible'"></span>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-800/80 flex items-center justify-between gap-3">
            <button 
                x-on:click="copyText()"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span x-text="copied ? 'Copied!' : 'Copy Post'"></span>
            </button>

            <button 
                x-on:click="text = samplePost"
                class="text-xs text-indigo-400 hover:underline font-medium"
            >
                Load Sample Hook
            </button>
        </div>
    </div>

    <!-- Right Column: Live Mockup -->
    <div class="lg:col-span-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">
                    Live LinkedIn Feed Preview
                </span>
                <div class="flex items-center gap-2">
                    <button 
                        x-on:click="mode = 'desktop'"
                        :class="mode === 'desktop' ? 'bg-indigo-600 text-white' : 'bg-slate-900 text-slate-400 hover:text-slate-200'"
                        class="px-2.5 py-1 rounded-lg text-xs font-medium transition-colors"
                    >
                        Desktop
                    </button>
                    <button 
                        x-on:click="mode = 'mobile'"
                        :class="mode === 'mobile' ? 'bg-indigo-600 text-white' : 'bg-slate-900 text-slate-400 hover:text-slate-200'"
                        class="px-2.5 py-1 rounded-lg text-xs font-medium transition-colors"
                    >
                        Mobile
                    </button>
                </div>
            </div>

            <!-- Mockup Card -->
            <div class="bg-white text-slate-900 rounded-xl p-4 shadow-2xl border border-slate-200" :class="mode === 'mobile' ? 'max-w-xs mx-auto' : 'w-full'">
                <!-- Header: User Profile -->
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-sm shrink-0">
                        PP
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 leading-none">Your Name</h4>
                        <p class="text-xs text-slate-500 mt-1">Founder / Creator • 1w • 🌐</p>
                    </div>
                </div>

                <!-- Post Text Body -->
                <div class="text-sm text-slate-900 leading-relaxed font-sans whitespace-pre-line relative">
                    <template x-if="text.length === 0">
                        <span class="text-slate-400 italic">Your post preview will appear here as you type...</span>
                    </template>

                    <template x-if="text.length > 0">
                        <div>
                            <span x-text="visibleText"></span>
                            <span x-show="isCutoff" class="text-slate-500 font-semibold cursor-pointer">...see more</span>
                        </div>
                    </template>
                </div>

                <!-- Engagement Bar -->
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>👍 💡 42</span>
                    <span>12 comments • 5 reposts</span>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-indigo-950/40 border border-indigo-800/40 rounded-xl p-4 text-xs text-slate-300 flex items-center gap-3">
            <span class="text-xl">💡</span>
            <div>
                <strong class="text-white block mb-0.5">LinkedIn Hook Pro-Tip:</strong>
                LinkedIn shows only the first 2-3 lines (~140-210 characters) before inserting "...see more". Make sure your main statement or cliffhanger is in the first 20 words.
            </div>
        </div>
    </div>
</div>

<script>
function linkedinPreview() {
    return {
        text: '',
        mode: 'desktop',
        copied: false,
        samplePost: "90% of SaaS founders fail at marketing because they focus on features instead of audience pain.\n\nHere is the exact 3-step strategy we used to reach our first $10k MRR without spending a dollar on ads:\n\n1. Built 10 free micro-tools for SEO\n2. Answered Reddit questions daily\n3. Scheduled 30 days of consistent content\n\nWhich strategy are you using today?",
        
        get charCount() { return this.text.length; },
        get wordCount() { return this.text.trim() ? this.text.trim().split(/\s+/).length : 0; },
        get lineCount() { return this.text ? this.text.split('\n').length : 0; },
        get limit() { return this.mode === 'mobile' ? 140 : 210; },
        get isCutoff() { return this.text.length > this.limit; },
        get visibleText() {
            if (this.text.length <= this.limit) return this.text;
            return this.text.substring(0, this.limit);
        },

        copyText() {
            if (!this.text) return;
            navigator.clipboard.writeText(this.text);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
    }
}
</script>
@endsection
