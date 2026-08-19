@extends(request()->routeIs('embed.*') ? 'layouts.embed' : 'layouts.tool')

@section('title', isset($seo) ? $seo['title'] : 'Free Social Media Character Counter [No Sign-Up] – All Platforms 2026 | PostPilot')
@section('meta_description', isset($seo) ? $seo['meta_description'] : 'Check character limits for LinkedIn, X/Twitter, Instagram, Threads & Facebook in real-time. Free multi-platform counter, no login required. Start now ➔')
@section('tool_name', 'Free Multi-Platform Social Character Counter')
@section('tool_route', 'tools.social-character-counter')

@section('schema_json')
    @php
        $schemaFaqs = [
            [
                'question' => 'What are the character limits for each social media platform?',
                'answer' => 'Character limits vary significantly across networks: X (Twitter) allows 280 characters for standard posts, Threads allows 500 characters, and Instagram captions allow up to 2,200 characters. LinkedIn permits up to 3,000 characters per post, while Facebook provides the largest post limit at 63,206 characters.'
            ],
            [
                'question' => 'Does LinkedIn count emojis as multiple characters?',
                'answer' => 'Yes, LinkedIn and most other social platforms count emojis as 2 to 4 characters because emojis use multi-byte UTF-16 Unicode encoding. Adding emojis to your LinkedIn posts will reduce your remaining character count faster than standard letters or numbers.'
            ],
            [
                'question' => 'What is the difference between character count and word count?',
                'answer' => 'Character count measures every individual letter, number, symbol, punctuation mark, emoji, and space in your text string. In contrast, word count measures the total number of distinct words separated by spaces or line breaks.'
            ],
            [
                'question' => 'How does Twitter count URLs in character limits?',
                'answer' => 'X (Twitter) automatically wraps all web links using its native t.co link shortening service. Regardless of how long or short the original URL is, every web link counts as exactly 23 characters toward your 280-character limit.'
            ],
            [
                'question' => 'What is the optimal post length for LinkedIn engagement?',
                'answer' => 'The optimal LinkedIn post length is between 150 and 250 words (approximately 1,000 to 1,500 characters) for maximum reach and engagement. Keep your main hook within the first 140 to 210 characters so it appears before the "...see more" feed fold line.'
            ],
            [
                'question' => 'Does this tool track reading time?',
                'answer' => 'Yes, our social media counter calculates estimated reading time based on an average reading speed of 200 words per minute. It also calculates speaking time at 130 words per minute, which is ideal for video captions, podcasts, and speech preparation.'
            ],
        ];
    @endphp
    <x-seo.faq-schema :faqs="$schemaFaqs" />
@endsection

@section('head')
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0.75; }
    [x-cloak] { display: none !important; }
    textarea::placeholder { font-family: 'Plus Jakarta Sans', sans-serif; }
    textarea::-webkit-scrollbar { width: 8px; }
    textarea::-webkit-scrollbar-track { background: #e5e7eb; border-radius: 4px; }
    textarea::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    textarea::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection

@section('content')
<div class="mb-16 font-sans" x-data="socialCounter('{{ isset($seo) ? $seo['preset_platform'] : 'twitter' }}')">
    <!-- Hero Section -->
    <section class="flex flex-col items-center text-center gap-4 max-w-3xl mx-auto mb-10">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#006c49]/10 border border-[#006c49]/30 rounded-full shadow-md">
            <span class="material-symbols-outlined text-[16px] text-[#006c49]">verified</span>
            <span class="font-mono text-xs text-[#006c49] uppercase tracking-wider font-extrabold">SOCIAL MEDIA TOOLS • 100% FREE &amp; CLIENT-SIDE</span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-black tracking-tight leading-tight font-sans text-center">
            {{ isset($seo) ? $seo['h1'] : 'Multi-Platform Social Character Limit Counter' }}
        </h1>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl font-medium leading-relaxed text-center font-sans">
            Track character limits, word counts, sentence counts, and reading time in real-time across LinkedIn, X (Twitter), Facebook, Threads, and Instagram.
        </p>
    </section>

    @if(!request()->routeIs('embed.*'))
    {{-- GEO / Answer-First Content --}}
    <div class="max-w-3xl mx-auto mb-8 px-4 sm:px-0">
        <p class="text-[15px] leading-relaxed text-gray-700 font-medium bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <strong>What is this tool?</strong> The Social Character Counter is a free utility that tracks character limits, word counts, sentence counts, and estimated reading times in real time. Content creators and marketers use it to format posts perfectly for LinkedIn, X (Twitter), Facebook, Threads, and Instagram, solving the problem of accidental truncation and truncated feed fold lines before publishing.
        </p>
    </div>
    @endif

    <!-- Top Stats Bar Grid -->
    <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <!-- Stat 1: Total Characters -->
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 shadow-md hover:border-gray-400 transition-all flex flex-col justify-between">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold">Chars (Total)</span>
            <span class="font-mono text-2xl sm:text-3xl font-extrabold text-black mt-2" x-text="formatNumber(text.length)">0</span>
        </div>
        <!-- Stat 2: No Spaces -->
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 shadow-md hover:border-gray-400 transition-all flex flex-col justify-between">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold">No Spaces</span>
            <span class="font-mono text-2xl sm:text-3xl font-extrabold text-black mt-2" x-text="formatNumber(charsNoSpaces)">0</span>
        </div>
        <!-- Stat 3: Words -->
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 shadow-md hover:border-gray-400 transition-all flex flex-col justify-between">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold">Words</span>
            <span class="font-mono text-2xl sm:text-3xl font-extrabold text-black mt-2" x-text="formatNumber(wordCount)">0</span>
        </div>
        <!-- Stat 4: Sentences -->
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 shadow-md hover:border-gray-400 transition-all flex flex-col justify-between">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold">Sentences</span>
            <span class="font-mono text-2xl sm:text-3xl font-extrabold text-black mt-2" x-text="formatNumber(sentenceCount)">0</span>
        </div>
        <!-- Stat 5: Paragraphs -->
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 shadow-md hover:border-gray-400 transition-all flex flex-col justify-between">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold">Paragraphs</span>
            <span class="font-mono text-2xl sm:text-3xl font-extrabold text-black mt-2" x-text="formatNumber(paragraphCount)">0</span>
        </div>
        <!-- Stat 6: Read Time -->
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 shadow-md hover:border-gray-400 transition-all flex flex-col justify-between">
            <span class="font-mono text-[11px] text-gray-500 uppercase tracking-wider font-extrabold">Read Time</span>
            <span class="font-mono text-2xl sm:text-3xl font-extrabold text-[#006c49] mt-2" x-text="readTime">0 min</span>
        </div>
    </section>

    <!-- Main Tool Workspace Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Input & Text Utilities (7 cols) -->
        <div class="lg:col-span-7 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-300 pb-3">
                    <label for="counterInput" class="text-xs font-extrabold uppercase tracking-wider text-black flex items-center gap-2 font-mono">
                        <span class="material-symbols-outlined text-base text-[#006c49]">edit_note</span>
                        <span>Post Content Workspace</span>
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
                        <span class="text-gray-300" x-show="text.length > 0" x-cloak>|</span>
                        <button 
                            type="button"
                            x-on:click="clearText()" 
                            x-show="text.length > 0" 
                            class="text-xs font-bold text-gray-400 hover:text-rose-600 transition-colors font-mono uppercase tracking-wider cursor-pointer flex items-center gap-1"
                            x-cloak
                        >
                            <span class="material-symbols-outlined text-xs">delete</span>
                            <span>Clear</span>
                        </button>
                    </div>
                </div>

                <!-- Textarea -->
                <textarea 
                    id="counterInput"
                    x-model="text"
                    rows="11"
                    placeholder="Start typing or paste your post text here..."
                    class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl p-4 text-sm text-gray-900 placeholder-gray-400 font-sans leading-relaxed resize-y focus:outline-none transition-all shadow-md min-h-[240px]"
                ></textarea>

                <!-- Quick Text Transformers Toolbar -->
                <div class="pt-3 border-t border-gray-200">
                    <span class="text-[11px] font-mono font-extrabold text-gray-500 uppercase tracking-wider block mb-2.5">
                        Quick Text Transformers:
                    </span>
                    <div class="flex flex-wrap items-center gap-2">
                        <button 
                            type="button"
                            x-on:click="transformText('clean')"
                            title="Remove extra spaces and duplicate empty lines" 
                            class="px-3 py-1.5 rounded-xl bg-white hover:bg-black hover:text-white text-black text-xs font-mono font-extrabold border-2 border-black transition-all cursor-pointer active:scale-95 flex items-center gap-1 shadow-md"
                        >
                            <span class="material-symbols-outlined text-xs">cleaning_services</span>
                            Clean Spaces
                        </button>
                        <button 
                            type="button"
                            x-on:click="transformText('uppercase')" 
                            class="px-3 py-1.5 rounded-xl bg-white hover:bg-black hover:text-white text-black text-xs font-mono font-extrabold border-2 border-black transition-all cursor-pointer active:scale-95 shadow-md"
                        >
                            UPPERCASE
                        </button>
                        <button 
                            type="button"
                            x-on:click="transformText('lowercase')" 
                            class="px-3 py-1.5 rounded-xl bg-white hover:bg-black hover:text-white text-black text-xs font-mono font-extrabold border-2 border-black transition-all cursor-pointer active:scale-95 shadow-md"
                        >
                            lowercase
                        </button>
                        <button 
                            type="button"
                            x-on:click="transformText('titlecase')" 
                            class="px-3 py-1.5 rounded-xl bg-white hover:bg-black hover:text-white text-black text-xs font-mono font-extrabold border-2 border-black transition-all cursor-pointer active:scale-95 shadow-md"
                        >
                            Title Case
                        </button>
                        <button 
                            type="button"
                            x-on:click="transformText('sentencecase')" 
                            class="px-3 py-1.5 rounded-xl bg-white hover:bg-black hover:text-white text-black text-xs font-mono font-extrabold border-2 border-black transition-all cursor-pointer active:scale-95 shadow-md"
                        >
                            Sentence case
                        </button>
                        <button 
                            type="button"
                            x-on:click="transformText('striphtml')" 
                            class="px-3 py-1.5 rounded-xl bg-white hover:bg-black hover:text-white text-black text-xs font-mono font-extrabold border-2 border-black transition-all cursor-pointer active:scale-95 shadow-md"
                        >
                            Strip HTML
                        </button>
                    </div>
                </div>

                <!-- Live Keyword Density Breakdown -->
                <div class="pt-4 border-t border-gray-200" x-show="topKeywords.length > 0" x-cloak>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-mono font-extrabold text-gray-500 uppercase tracking-wider">
                            Keyword Density (Top 5 Words):
                        </span>
                        <span class="text-xs font-mono text-gray-500 font-semibold" x-text="`Speaking Time: ${speakTime}`"></span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 font-mono">
                        <template x-for="(item, idx) in topKeywords" :key="idx">
                            <div class="bg-white border-2 border-gray-300 rounded-lg p-2 text-center text-xs shadow-md">
                                <span class="block font-bold text-gray-900 truncate" x-text="item.word"></span>
                                <span class="text-[10px] text-gray-500 font-medium" x-text="`${item.count} (${item.pct}%)`"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Bottom Action Row: Copy Button -->
            <div class="pt-5 border-t border-gray-300 flex items-center justify-between gap-3">
                <span class="text-xs text-gray-500 font-mono font-bold" x-text="`${formatNumber(text.length)} chars typed`"></span>
                <button 
                    type="button"
                    x-on:click="copyAll()"
                    :disabled="!text"
                    :class="copied ? 'bg-[#006c49] border-[#006c49] text-white' : (!text ? 'bg-gray-100 text-gray-400 border-2 border-gray-300 cursor-not-allowed' : 'bg-black hover:bg-gray-800 text-white border-2 border-black active:scale-95')"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-extrabold rounded-xl shadow-md transition-all font-mono uppercase tracking-wider cursor-pointer"
                >
                    <template x-if="copied">
                        <span class="material-symbols-outlined text-base">check</span>
                    </template>
                    <template x-if="!copied">
                        <span class="material-symbols-outlined text-base">content_copy</span>
                    </template>
                    <span x-text="copied ? 'Copied to Clipboard!' : 'Copy Post Text'"></span>
                </button>
            </div>
        </div>

        <!-- Right Column: Platform Limits Progress Cards Grid (5 cols) -->
        <div class="lg:col-span-5 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md flex flex-col justify-between space-y-6">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-300">
                    <h2 class="text-xs font-extrabold uppercase tracking-wider text-black flex items-center gap-2 font-mono">
                        <span class="material-symbols-outlined text-base text-[#006c49]">bar_chart</span>
                        <span>Platform Progress Limits</span>
                    </h2>
                    <span class="text-xs text-gray-500 font-mono font-bold" x-text="`${formatNumber(text.length)} Total Chars`"></span>
                </div>

                <div class="space-y-3.5">
                    <!-- X / Twitter (280) -->
                    <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 shadow-md hover:border-gray-400 transition-colors space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-sky-50 border border-sky-200 text-sky-600 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-gray-900 block leading-tight font-sans">X / Twitter</span>
                                    <span class="text-[10px] text-gray-500 font-medium font-sans">Standard Post (280)</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-mono block font-bold transition-colors duration-300" :class="getPlatform(280, 240).textClass" x-text="`${formatNumber(text.length)} / 280`"></span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider inline-block transition-colors duration-300 font-mono mt-0.5" :class="getPlatform(280, 240).badgeClass" x-text="getPlatform(280, 240).badgeLabel"></span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden border border-gray-200">
                            <div 
                                class="h-full transition-all duration-300 rounded-full" 
                                :class="getPlatform(280, 240).barClass" 
                                :style="`width: ${getPlatform(280, 240).percentage}%`"
                            ></div>
                        </div>
                        <span class="block text-[11px] transition-colors duration-300 font-medium font-mono" :class="getPlatform(280, 240).textClass" x-text="getPlatform(280, 240).statusText"></span>
                    </div>

                    <!-- LinkedIn Post (3,000) -->
                    <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 shadow-md hover:border-gray-400 transition-colors space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 border border-blue-200 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.25V10.9H6.46M7.86 6.78a1.6 1.6 0 1 0 0 3.2 1.6 1.6 0 0 0 0-3.2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-gray-900 block leading-tight font-sans">LinkedIn Post</span>
                                    <span class="text-[10px] text-gray-500 font-medium font-sans">Standard Post (3k)</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-mono block font-bold transition-colors duration-300" :class="getPlatform(3000, 2700).textClass" x-text="`${formatNumber(text.length)} / 3,000`"></span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider inline-block transition-colors duration-300 font-mono mt-0.5" :class="getPlatform(3000, 2700).badgeClass" x-text="getPlatform(3000, 2700).badgeLabel"></span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden border border-gray-200">
                            <div 
                                class="h-full transition-all duration-300 rounded-full" 
                                :class="getPlatform(3000, 2700).barClass" 
                                :style="`width: ${getPlatform(3000, 2700).percentage}%`"
                            ></div>
                        </div>
                        <div class="flex items-center justify-between font-mono">
                            <span class="text-[11px] transition-colors duration-300 font-medium" :class="getPlatform(3000, 2700).textClass" x-text="getPlatform(3000, 2700).statusText"></span>
                            <span class="text-[10px] text-gray-400 font-sans">Fold cutoff: ~140–210 chars</span>
                        </div>
                    </div>

                    <!-- Facebook Post (63,206) -->
                    <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 shadow-md hover:border-gray-400 transition-colors space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-600 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-gray-900 block leading-tight font-sans">Facebook Post</span>
                                    <span class="text-[10px] text-gray-500 font-medium font-sans">Post Limit (63k)</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-mono block font-bold transition-colors duration-300" :class="getPlatform(63206, 60000).textClass" x-text="`${formatNumber(text.length)} / 63,206`"></span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider inline-block transition-colors duration-300 font-mono mt-0.5" :class="getPlatform(63206, 60000).badgeClass" x-text="getPlatform(63206, 60000).badgeLabel"></span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden border border-gray-200">
                            <div 
                                class="h-full transition-all duration-300 rounded-full" 
                                :class="getPlatform(63206, 60000).barClass" 
                                :style="`width: ${getPlatform(63206, 60000).percentage}%`"
                            ></div>
                        </div>
                        <div class="flex items-center justify-between font-mono">
                            <span class="text-[11px] transition-colors duration-300 font-medium" :class="getPlatform(63206, 60000).textClass" x-text="getPlatform(63206, 60000).statusText"></span>
                            <span class="text-[10px] text-gray-400 font-sans">Optimal: 250–400 chars</span>
                        </div>
                    </div>

                    <!-- Threads Post (500) -->
                    <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 shadow-md hover:border-gray-400 transition-colors space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-emerald-50 border border-emerald-200 text-[#006c49] flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-gray-900 block leading-tight font-sans">Threads Post</span>
                                    <span class="text-[10px] text-gray-500 font-medium font-sans">Standard Post (500)</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-mono block font-bold transition-colors duration-300" :class="getPlatform(500, 450).textClass" x-text="`${formatNumber(text.length)} / 500`"></span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider inline-block transition-colors duration-300 font-mono mt-0.5" :class="getPlatform(500, 450).badgeClass" x-text="getPlatform(500, 450).badgeLabel"></span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden border border-gray-200">
                            <div 
                                class="h-full transition-all duration-300 rounded-full" 
                                :class="getPlatform(500, 450).barClass" 
                                :style="`width: ${getPlatform(500, 450).percentage}%`"
                            ></div>
                        </div>
                        <span class="block text-[11px] transition-colors duration-300 font-medium font-mono" :class="getPlatform(500, 450).textClass" x-text="getPlatform(500, 450).statusText"></span>
                    </div>

                    <!-- Instagram Post (2,200) -->
                    <div class="bg-white border-2 border-gray-300 rounded-xl p-3.5 shadow-md hover:border-gray-400 transition-colors space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-pink-50 border border-pink-200 text-pink-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-base">photo_camera</span>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-gray-900 block leading-tight font-sans">Instagram Caption</span>
                                    <span class="text-[10px] text-gray-500 font-medium font-sans">Post Caption (2,200)</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-mono block font-bold transition-colors duration-300" :class="getPlatform(2200, 2000).textClass" x-text="`${formatNumber(text.length)} / 2,200`"></span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider inline-block transition-colors duration-300 font-mono mt-0.5" :class="getPlatform(2200, 2000).badgeClass" x-text="getPlatform(2200, 2000).badgeLabel"></span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden border border-gray-200">
                            <div 
                                class="h-full transition-all duration-300 rounded-full" 
                                :class="getPlatform(2200, 2000).barClass" 
                                :style="`width: ${getPlatform(2200, 2000).percentage}%`"
                            ></div>
                        </div>
                        <div class="flex items-center justify-between font-mono">
                            <span class="text-[11px] transition-colors duration-300 font-medium" :class="getPlatform(2200, 2000).textClass" x-text="getPlatform(2200, 2000).statusText"></span>
                            <span class="text-[10px] text-gray-400 font-sans">Fold cutoff: ~125 chars</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pro Tip Note Banner -->
            <div class="bg-emerald-50 border-2 border-emerald-300 rounded-xl p-4 text-xs text-emerald-950 flex items-start gap-3 shadow-md">
                <span class="material-symbols-outlined text-base text-[#006c49] shrink-0 mt-0.5">lightbulb</span>
                <div class="leading-relaxed font-medium font-sans">
                    <strong class="text-emerald-950 block font-bold mb-0.5 font-mono uppercase tracking-wider text-[11px]">Character Optimization Pro Tip:</strong>
                    X/Twitter posts under 240 chars get 18% higher engagement. On LinkedIn, your first 140–210 characters dictate whether users click "...see more" before the feed fold line.
                </div>
            </div>
        </div>
    </div>

    <!-- PostPilot Promotional CTA Section (Full-Width Card) -->
    <div class="mt-12 bg-black rounded-[1rem] p-8 sm:p-12 text-white relative overflow-hidden border-2 border-black shadow-xl">
        <!-- Subtle Emerald Glow Accent -->
        <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-[#006c49]/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -top-16 w-60 h-60 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-950/80 border border-emerald-700/60 text-emerald-300 font-mono text-[11px] font-bold uppercase tracking-wider">
                    <span class="material-symbols-outlined text-xs text-emerald-400">rocket_launch</span>
                    <span>PostPilot Engine</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight font-sans text-white">
                    Automate &amp; Cross-Post Your Content Across All Social Platforms
                </h3>
                <p class="text-gray-300 text-sm sm:text-base leading-relaxed max-w-2xl font-sans font-normal">
                    Stop manually checking character limits and copy-pasting across tabs. PostPilot automatically reformats, previews fold cutoffs, and schedules your content for X, LinkedIn, Facebook, Instagram, and Threads on autopilot.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 font-mono text-xs text-gray-300">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
                        <span>Auto Limit Protection</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
                        <span>Multi-Channel Cross Post</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
                        <span>AI Hook Generator</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3 justify-center">
                <a 
                    href="{{ route('register') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-[#006c49] hover:bg-emerald-600 text-white font-extrabold px-6 py-3.5 rounded-xl border-2 border-[#006c49] shadow-lg transition-all font-mono text-xs uppercase tracking-wider text-center cursor-pointer active:scale-95"
                >
                    <span>Start 14-Day Free Trial</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
                <a 
                    href="{{ route('tools.index') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white border-2 border-white/20 font-bold px-6 py-3.5 rounded-xl transition-all font-mono text-xs uppercase tracking-wider text-center cursor-pointer"
                >
                    <span>Explore All Free Tools</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Feature Highlights Cards Grid -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border-2 border-gray-300 rounded-xl p-6 shadow-md hover:border-gray-400 transition-all space-y-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#006c49] border border-emerald-200 flex items-center justify-center font-mono font-extrabold text-xs shadow-md">
                <span class="material-symbols-outlined text-xl">speed</span>
            </div>
            <h3 class="text-sm font-extrabold text-black uppercase font-mono tracking-wide">Real-Time Multi-Platform Limits</h3>
            <p class="text-xs text-gray-600 leading-relaxed font-medium">
                Instantly track strict limit progress for X (280), LinkedIn (3,000), Facebook (63k), Threads (500), and Instagram (2,200) without page reloads.
            </p>
        </div>

        <div class="bg-white border-2 border-gray-300 rounded-xl p-6 shadow-md hover:border-gray-400 transition-all space-y-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#006c49] border border-emerald-200 flex items-center justify-center shadow-md">
                <span class="material-symbols-outlined text-xl">cleaning_services</span>
            </div>
            <h3 class="text-sm font-extrabold text-black uppercase font-mono tracking-wide">Smart Text Transformers</h3>
            <p class="text-xs text-gray-600 leading-relaxed font-medium">
                One-click formatting utilities to clean unwanted line breaks, strip HTML tags, and convert casing (UPPERCASE, lowercase, Title Case).
            </p>
        </div>

        <div class="bg-white border-2 border-gray-300 rounded-xl p-6 shadow-md hover:border-gray-400 transition-all space-y-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#006c49] border border-emerald-200 flex items-center justify-center shadow-md">
                <span class="material-symbols-outlined text-xl">lock</span>
            </div>
            <h3 class="text-sm font-extrabold text-black uppercase font-mono tracking-wide">100% Client-Side &amp; Private</h3>
            <p class="text-xs text-gray-600 leading-relaxed font-medium">
                Runs completely inside your web browser. Your draft copy is processed strictly in local client memory and is never transmitted or stored.
            </p>
        </div>
    </div>

    @if(!request()->routeIs('embed.*'))
    <!-- Educational Guide & Best Practices Section -->
    <div class="mt-12 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md space-y-6">
        <div class="border-b border-gray-300 pb-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-[#006c49] border border-emerald-200 font-mono text-[11px] font-extrabold uppercase tracking-wider mb-2">
                <span class="material-symbols-outlined text-xs">auto_awesome</span>
                <span>Social Media Best Practices</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-black font-sans tracking-tight">
                Optimal Social Media Character Limits Guide
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 font-medium leading-relaxed mt-1">
                While platform limits define the absolute maximum, sticking to optimal length guidelines significantly improves click-through rates and engagement.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- Platform 1 -->
            <div class="bg-white border-2 border-gray-300 rounded-xl p-5 shadow-md space-y-2">
                <div class="flex items-center gap-2 text-[#006c49]">
                    <span class="material-symbols-outlined text-base">tag</span>
                    <h3 class="text-sm font-extrabold text-black font-sans">X / Twitter</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-medium">
                    Max: 280 chars. Optimal: 70–100 chars. Concise tweets receive up to 18% higher retweets and replies. URLs count as 23 chars.
                </p>
            </div>

            <!-- Platform 2 -->
            <div class="bg-white border-2 border-gray-300 rounded-xl p-5 shadow-md space-y-2">
                <div class="flex items-center gap-2 text-[#006c49]">
                    <span class="material-symbols-outlined text-base">work</span>
                    <h3 class="text-sm font-extrabold text-black font-sans">LinkedIn</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-medium">
                    Max: 3,000 chars. Optimal: 150–250 words (approx. 1,000–1,500 chars). The first 140–210 characters are crucial before the "...see more" fold cutoff.
                </p>
            </div>

            <!-- Platform 3 -->
            <div class="bg-white border-2 border-gray-300 rounded-xl p-5 shadow-md space-y-2">
                <div class="flex items-center gap-2 text-[#006c49]">
                    <span class="material-symbols-outlined text-base">thumb_up</span>
                    <h3 class="text-sm font-extrabold text-black font-sans">Facebook</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-medium">
                    Max: 63,206 chars. Optimal: 40–80 chars. Posts with fewer than 80 characters receive 66% more engagement on mobile feeds.
                </p>
            </div>

            <!-- Platform 4 -->
            <div class="bg-white border-2 border-gray-300 rounded-xl p-5 shadow-md space-y-2">
                <div class="flex items-center gap-2 text-[#006c49]">
                    <span class="material-symbols-outlined text-base">forum</span>
                    <h3 class="text-sm font-extrabold text-black font-sans">Threads</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-medium">
                    Max: 500 chars. Optimal: 200–350 chars. Short bulleted lists and high-impact hooks drive the best conversation and re-threads.
                </p>
            </div>

            <!-- Platform 5 -->
            <div class="bg-white border-2 border-gray-300 rounded-xl p-5 shadow-md space-y-2">
                <div class="flex items-center gap-2 text-[#006c49]">
                    <span class="material-symbols-outlined text-base">photo_camera</span>
                    <h3 class="text-sm font-extrabold text-black font-sans">Instagram</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-medium">
                    Max: 2,200 chars. Optimal: 125–150 chars for short captions, or 1,000+ for long-form stories. The first 125 chars show before the fold line.
                </p>
            </div>

            <!-- Platform 6 -->
            <div class="bg-white border-2 border-gray-300 rounded-xl p-5 shadow-md space-y-2">
                <div class="flex items-center gap-2 text-[#006c49]">
                    <span class="material-symbols-outlined text-base">timer</span>
                    <h3 class="text-sm font-extrabold text-black font-sans">Reading &amp; Speaking Time</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-medium">
                    Average reading speed is ~200 words per minute (WPM). Average speaking speed for audio/video scripts is ~130 WPM.
                </p>
            </div>
        </div>
    </div>

    <x-tools.embed-widget toolSlug="social-character-counter" />

    {{-- FAQ Section (SSR Content for SEO) --}}
    <section class="mt-16 max-w-4xl mx-auto" x-data="{ openFaq: null }">
        <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-[#006c49] text-xl">help</span>
            <h2 class="text-xl font-extrabold text-black tracking-tight font-sans">Frequently Asked Questions</h2>
        </div>

        @php
            $faqs = [
                [
                    'question' => 'What are the character limits for each social media platform?',
                    'answer' => 'Character limits vary significantly across networks: X (Twitter) allows 280 characters for standard posts, Threads allows 500 characters, and Instagram captions allow up to 2,200 characters. LinkedIn permits up to 3,000 characters per post, while Facebook provides the largest post limit at 63,206 characters.'
                ],
                [
                    'question' => 'Does LinkedIn count emojis as multiple characters?',
                    'answer' => 'Yes, LinkedIn and most other social platforms count emojis as 2 to 4 characters because emojis use multi-byte UTF-16 Unicode encoding. Adding emojis to your LinkedIn posts will reduce your remaining character count faster than standard letters or numbers.'
                ],
                [
                    'question' => 'What is the difference between character count and word count?',
                    'answer' => 'Character count measures every individual letter, number, symbol, punctuation mark, emoji, and space in your text string. In contrast, word count measures the total number of distinct words separated by spaces or line breaks.'
                ],
                [
                    'question' => 'How does Twitter count URLs in character limits?',
                    'answer' => 'X (Twitter) automatically wraps all web links using its native t.co link shortening service. Regardless of how long or short the original URL is, every web link counts as exactly 23 characters toward your 280-character limit.'
                ],
                [
                    'question' => 'What is the optimal post length for LinkedIn engagement?',
                    'answer' => 'The optimal LinkedIn post length is between 150 and 250 words (approximately 1,000 to 1,500 characters) for maximum reach and engagement. Keep your main hook within the first 140 to 210 characters so it appears before the "...see more" feed fold line.'
                ],
                [
                    'question' => 'Does this tool track reading time?',
                    'answer' => 'Yes, our social media counter calculates estimated reading time based on an average reading speed of 200 words per minute. It also calculates speaking time at 130 words per minute, which is ideal for video captions, podcasts, and speech preparation.'
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
    @endif
</div>

<!-- Schema.org JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebApplication",
  "name": "Multi-Platform Social Character Limit Counter",
  "url": "{{ url()->current() }}",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "All",
  "description": "Track character limits, word counts, sentence counts, and reading time in real-time across LinkedIn, X (Twitter), Facebook, Threads, and Instagram.",
  "offers": {
    "@@type": "Offer",
    "price": "0",
    "priceCurrency": "USD"
  }
}
</script>

<script>
function socialCounter(initialPlatform = 'twitter') {
    return {
        text: '',
        activePlatform: initialPlatform,
        copied: false,

        formatNumber(num) {
            return new Intl.NumberFormat().format(num || 0);
        },

        get charsNoSpaces() {
            return (this.text || '').replace(/\s/g, '').length;
        },

        get wordCount() {
            const trimmed = (this.text || '').trim();
            if (!trimmed) return 0;
            return trimmed.split(/\s+/).filter(Boolean).length;
        },

        get sentenceCount() {
            const trimmed = (this.text || '').trim();
            if (!trimmed) return 0;
            let cleaned = trimmed.replace(/(?:^|\n)\s*\d+[\.\)]\s*/g, '\n');
            cleaned = cleaned.replace(/\b(mr|mrs|ms|dr|prof|sr|jr|vs|e\.g|i\.e|etc|inc|ltd)\./gi, '$1');
            const sentences = cleaned.split(/(?:[.!?]+(?:\s+|\n+|$))|\n+/).map(s => s.trim()).filter(Boolean);
            return sentences.length || 1;
        },

        get paragraphCount() {
            const trimmed = (this.text || '').trim();
            if (!trimmed) return 0;
            return trimmed.split(/\n+/).filter(p => p.trim().length > 0).length;
        },

        get readTime() {
            const words = this.wordCount;
            if (words === 0) return '0 min';
            if (words < 200) return '< 1 min';
            const minutes = Math.round(words / 200);
            return minutes <= 1 ? '1 min' : `${minutes} mins`;
        },

        get speakTime() {
            const words = this.wordCount;
            if (words === 0) return '0 sec';
            const totalSeconds = Math.round((words / 130) * 60);
            if (totalSeconds < 60) return `${totalSeconds} sec`;
            const mins = Math.floor(totalSeconds / 60);
            const secs = totalSeconds % 60;
            return secs > 0 ? `${mins}m ${secs}s` : `${mins} min`;
        },

        get topKeywords() {
            const trimmed = (this.text || '').trim().toLowerCase();
            if (!trimmed) return [];
            const words = trimmed.match(/\b[a-z0-9]{3,}\b/g) || [];
            if (words.length === 0) return [];
            
            const stopWords = new Set(['the','and','for','that','this','with','have','you','your','are','from','not','can','all','has','was','but','they','more','out','about','into','over','after','these','their','will','some','what','when','where','who','which','why','how']);
            const counts = {};
            let validTotal = 0;

            words.forEach(w => {
                if (!stopWords.has(w)) {
                    counts[w] = (counts[w] || 0) + 1;
                    validTotal++;
                }
            });

            if (validTotal === 0) return [];

            return Object.entries(counts)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 5)
                .map(([word, count]) => ({
                    word,
                    count,
                    pct: Math.round((count / validTotal) * 100)
                }));
        },

        getPlatform(limit, warningThreshold) {
            const len = (this.text || '').length;
            const pct = limit > 0 ? Math.min(Math.round((len / limit) * 100), 100) : 0;
            const isOver = len > limit;
            const isNear = !isOver && len >= warningThreshold;

            let colorState = 'emerald';
            let barClass = 'bg-[#006c49]';
            let textClass = 'text-[#006c49]';
            let badgeClass = 'bg-emerald-50 text-[#006c49] border border-emerald-200';
            let badgeLabel = 'Within Limit';
            
            let statusText = '';
            if (isOver) {
                colorState = 'rose';
                const diff = len - limit;
                barClass = 'bg-rose-500';
                textClass = 'text-rose-700';
                badgeClass = 'bg-rose-50 text-rose-800 border border-rose-200';
                badgeLabel = 'Over Limit';
                statusText = `Exceeds limit by ${this.formatNumber(diff)} ${diff === 1 ? 'char' : 'chars'}`;
            } else if (isNear) {
                colorState = 'amber';
                const rem = limit - len;
                barClass = 'bg-amber-500';
                textClass = 'text-amber-700';
                badgeClass = 'bg-amber-50 text-amber-800 border border-amber-200';
                badgeLabel = 'Nearing Limit';
                statusText = `Only ${this.formatNumber(rem)} ${rem === 1 ? 'char' : 'chars'} remaining`;
            } else {
                const rem = limit - len;
                statusText = `${this.formatNumber(rem)} ${rem === 1 ? 'char' : 'chars'} remaining`;
            }

            return {
                percentage: pct,
                colorState,
                barClass,
                textClass,
                badgeClass,
                badgeLabel,
                statusText,
                isOver,
                isNear
            };
        },

        copyAll() {
            if (!this.text) return;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(this.text).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                }).catch(() => {
                    this.fallbackCopy();
                });
            } else {
                this.fallbackCopy();
            }
        },

        fallbackCopy() {
            const textarea = document.createElement('textarea');
            textarea.value = this.text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            } catch (err) {
                console.error('Copy failed', err);
            }
            document.body.removeChild(textarea);
        },

        clearText() {
            this.text = '';
            this.copied = false;
        },

        loadSample() {
            this.text = "🚀 Launching our new feature today! Here is how we scaled PostPilot to 10k+ active users without spending a single dollar on paid ads:\n\n1. Built free satellite micro-tools\n2. Consistently created high-value content\n3. Focused on developer-first SEO & UX\n\nWhat content strategy is driving the most growth for your business this quarter? Let us know in the comments below! 👇";
            this.copied = false;
        },

        transformText(type) {
            if (!this.text) return;
            if (type === 'uppercase') {
                this.text = this.text.toUpperCase();
            } else if (type === 'lowercase') {
                this.text = this.text.toLowerCase();
            } else if (type === 'titlecase') {
                this.text = this.text.replace(/\w\S*/g, (txt) => {
                    return txt.charAt(0).toUpperCase() + txt.slice(1).toLowerCase();
                });
            } else if (type === 'sentencecase') {
                this.text = this.text.replace(/(^\s*|[.!?]\s+)([a-z])/g, (m, p1, p2) => p1 + p2.toUpperCase());
            } else if (type === 'striphtml') {
                this.text = this.text.replace(/<[^>]*>/g, '');
            } else if (type === 'clean') {
                this.text = this.text
                    .split('\n')
                    .map(line => line.trim().replace(/[ \t]+/g, ' '))
                    .join('\n')
                    .replace(/\n{3,}/g, '\n\n')
                    .trim();
            }
        }
    }
}
</script>
@endsection
