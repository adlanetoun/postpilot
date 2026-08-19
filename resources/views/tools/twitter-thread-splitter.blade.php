@extends('layouts.tool')

@section('title', isset($seo) ? $seo['title'] : 'Free Twitter Thread Splitter [No Sign-Up] – Auto-Number & Split in Seconds | PostPilot')
@section('meta_description', isset($seo) ? $seo['meta_description'] : 'Split any blog post or article into a perfectly numbered Twitter/X thread instantly. Auto-chunks at 280 chars, preserves sentence breaks. 100% free ➔')
@section('tool_name', 'Free X / Twitter Thread Splitter')
@section('tool_route', 'tools.twitter-thread-splitter')

@section('head')
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0.75; }
    [x-cloak] { display: none !important; }
    textarea::placeholder { font-family: 'Plus Jakarta Sans', sans-serif; }
    textarea::-webkit-scrollbar { width: 8px; }
    textarea::-webkit-scrollbar-track { background: #e5e7eb; border-radius: 4px; }
    textarea::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    textarea::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Toast fade & slide animation */
    .toast-enter {
        opacity: 0; transform: translateY(1rem); transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .toast-enter-active {
        opacity: 1; transform: translateY(0);
    }
    .toast-leave {
        opacity: 1; transform: translateY(0); transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .toast-leave-end {
        opacity: 0; transform: translateY(1rem);
    }

    /* Staggered tweet card entrance */
    @keyframes fadeInUp {
        0% {
            opacity: 0; transform: translateY(0.5rem);
        }
        100% {
            opacity: 1; transform: translateY(0);
        }
    }
    .tweet-card-enter { animation: fadeInUp 0.35s ease forwards; }

    /* Progress bar background */
    .progress-bg { background-color: #e5e7eb; }

    /* Thread connector pulse */
    @keyframes pulse-line {
        0%, 100% { opacity: 0.4; }
        50% { opacity: 1; }
    }
    .thread-line-pulse {
        animation: pulse-line 2s ease-in-out infinite;
    }
</style>
@endsection

@section('schema_json')
    <x-seo.faq-schema :faqs="[
        [
            'question' => 'What is a Twitter thread splitter?',
            'answer' => 'A Twitter (X) thread splitter is a free online tool that automatically divides long-form text, blog posts, or articles into individual, character-compliant tweets. It intelligently splits your content on natural word and sentence boundaries to preserve readability and logical flow across the thread. By automatically formatting and numbering each post, it saves creators hours of manual editing.',
        ],
        [
            'question' => 'What is the character limit for X (Twitter) tweets?',
            'answer' => 'Standard X (Twitter) accounts have a limit of 280 characters per tweet, while X Premium subscribers can post longer content up to 25,000 characters. For maximum reach and engagement, 280-character thread posts remain the optimal format because they are easily digestible for all users. Our thread splitter tracks weighted character counts in real time to ensure every card fits perfectly within standard limits.',
        ],
        [
            'question' => 'How does auto-numbering work in threads?',
            'answer' => 'Auto-numbering automatically attaches sequential sequence indicators—such as 1/N, (1/N), [1/N], or 1.—to each tweet in your generated thread. You can customize whether the numbers appear at the beginning or end of each tweet, or add custom emoji prefixes like 🧵. This gives your readers a clear navigational guide so they can follow your entire thread from start to finish without getting lost.',
        ],
        [
            'question' => 'Does this tool count URLs toward the character limit?',
            'answer' => 'Yes, our tool accurately accounts for the official Twitter link wrapping system, where all URLs are calculated as 23 characters regardless of their actual length. Whether you paste a short link or a lengthy URL, the thread splitter adjusts character limits dynamically to prevent your tweets from exceeding the threshold on X. This ensures your links do not cause accidental truncation when posted.',
        ],
        [
            'question' => 'Can I export my thread to a text file?',
            'answer' => 'Absolutely. Once your thread is generated, you can export the full sequence into Markdown (.md), plain text (.txt), or a clean text format without numbering. You can also copy all tweets to your clipboard with a single click or send individual posts directly to X via intent links. This flexibility makes it easy to save drafts, back up your content, or schedule posts in your favorite social media management tool.',
        ],
        [
            'question' => 'What is the best thread length for engagement on X?',
            'answer' => 'High-performing X threads typically contain between 5 and 10 tweets. This length provides enough space to deliver valuable insights, tell a compelling story, or explain a complex topic without losing reader attention. Keeping individual tweets concise and using clear visual hooks in your opening post helps maximize retweets, bookmarks, and overall thread reach.',
        ],
    ]" />
@endsection

@section('content')
<div class="mb-16 font-sans" x-data="twitterSplitter(`{{ str_replace('`', '\`', $seo['preset_text'] ?? '') }}`)">

    <!-- Hero Section -->
    <section class="flex flex-col items-center text-center gap-4 max-w-3xl mx-auto mb-10">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#006c49]/10 border border-[#006c49]/30 rounded-full shadow-md">
            <span class="material-symbols-outlined text-[16px] text-[#006c49]">verified</span>
            <span class="font-mono text-xs text-[#006c49] uppercase tracking-wider font-extrabold">SOCIAL MEDIA TOOLS • 100% FREE &amp; CLIENT-SIDE</span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-black tracking-tight leading-tight font-sans text-center">
            {{ $seo['h1'] ?? 'Twitter Thread Splitter & Auto-Numberer' }}
        </h1>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl font-medium leading-relaxed text-center font-sans">
            Convert long articles, blogs, or notes into a perfectly split X/Twitter thread with auto-numbering (1/N) and accurate 280-character t.co URL limits.
        </p>
    </section>

    {{-- GEO / Answer-First Content --}}
    <div class="max-w-3xl mx-auto mb-8 px-4 sm:px-0">
        <p class="text-[15px] leading-relaxed text-gray-700 font-medium bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <strong>What is this tool?</strong> {{ $seo['answer_first'] ?? 'The Twitter Thread Splitter is a free utility that automatically converts long-form text, blog posts, and articles into formatted X (Twitter) threads. Content creators use it to split drafts into 280-character tweets with auto-numbering and link weighting, solving the hassle of manual trimming, character counting, and awkward sentence cuts.' }}
        </p>
    </div>

    <!-- Stats Bar (High Contrast Cards) -->
    <section class="grid grid-cols-2 md:grid-cols-5 gap-4 w-full mb-8 font-mono">
        <div class="bg-white border-2 border-gray-300 rounded-xl p-5 flex flex-col gap-1 shadow-md hover:border-[#006c49] hover:shadow-lg transition-all">
            <span class="text-xs text-gray-500 uppercase font-extrabold tracking-wider">Raw Characters</span>
            <span class="text-2xl font-extrabold text-black" x-text="formatNumber(rawText.length)">0</span>
            <span
                class="text-[10px] font-bold uppercase tracking-wider mt-auto"
                :class="charWarning ? 'text-rose-600' : 'text-gray-400'"
                x-show="rawText.length >= 1800" x-cloak
            >
                <span x-show="rawText.length > 2500">OVER 2500 CHARS</span>
                <span x-show="rawText.length >= 1800 && rawText.length <= 2500">Approaching limit</span>
            </span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-5 flex flex-col gap-1 shadow-md hover:border-[#006c49] hover:shadow-lg transition-all">
            <span class="text-xs text-gray-500 uppercase font-extrabold tracking-wider">Words</span>
            <span class="text-2xl font-extrabold text-black" x-text="formatNumber(wordCount)">0</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-5 flex flex-col gap-1 shadow-md hover:border-[#006c49] hover:shadow-lg transition-all">
            <span class="text-xs text-gray-500 uppercase font-extrabold tracking-wider">Generated Tweets</span>
            <span class="text-2xl font-extrabold text-[#006c49]" x-text="formatNumber(tweets.length)">0</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-5 flex flex-col gap-1 shadow-md hover:border-[#006c49] hover:shadow-lg transition-all">
            <span class="text-xs text-gray-500 uppercase font-extrabold tracking-wider">Largest Tweet</span>
            <span
                class="text-2xl font-extrabold transition-colors"
                :class="largestTweetLen > 280 ? 'text-rose-600' : (largestTweetLen > 260 ? 'text-amber-600' : 'text-[#006c49]')"
                x-text="formatNumber(largestTweetLen)">0</span>
            <span class="text-[10px] text-gray-400 font-bold">/ 280 weighted</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-5 flex flex-col gap-1 shadow-md hover:border-[#006c49] hover:shadow-lg transition-all">
            <span class="text-xs text-gray-500 uppercase font-extrabold tracking-wider">Est. Read Time</span>
            <span class="text-2xl font-extrabold text-black" x-text="readingTime > 0 ? `${readingTime}m` : '0m'">0m</span>
        </div>
    </section>

    <!-- Main Workspace Grid (12 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start w-full">

        <!-- Left Column: Input & Configuration (7 cols) -->
        <div class="lg:col-span-7 flex flex-col gap-6 self-start">

            <!-- Draft Input Card -->
            <div class="bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 shadow-md flex flex-col gap-4">
                <div class="flex flex-wrap justify-between items-center border-b-2 border-gray-300 pb-3 gap-2">
                    <label for="draft-input" class="font-mono text-xs font-extrabold text-black uppercase tracking-wider flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-mono font-extrabold bg-black text-white uppercase tracking-wider">STEP 1</span>
                        <span class="material-symbols-outlined text-[18px] text-[#006c49]">edit_note</span>
                        Draft Content
                    </label>
                    <div class="flex flex-wrap gap-2">
                        <button
                            type="button"
                            x-on:click="cleanSpaces()"
                            x-show="rawText.length > 0"
                            title="Trim extra spaces and standardize line breaks"
                            class="font-mono text-xs text-gray-600 hover:text-black hover:border-black transition-all flex items-center gap-1 bg-white border-2 border-gray-300 px-2.5 py-1 rounded-xl cursor-pointer active:scale-95 shadow-md font-semibold"
                            x-cloak
                        >
                            <span class="material-symbols-outlined text-[14px]">cleaning_services</span>
                            Clean Spaces
                        </button>
                        <button
                            type="button"
                            x-on:click="stripHtml()"
                            x-show="rawText.length > 0"
                            title="Remove HTML tags"
                            class="font-mono text-xs text-gray-600 hover:text-black hover:border-black transition-all flex items-center gap-1 bg-white border-2 border-gray-300 px-2.5 py-1 rounded-xl cursor-pointer active:scale-95 shadow-md font-semibold"
                            x-cloak
                        >
                            <span class="material-symbols-outlined text-[14px]">code_off</span>
                            Strip HTML
                        </button>
                    </div>
                </div>

                <!-- Textarea with floating char counter overlay -->
                <div class="relative">
                    <textarea
                        id="draft-input"
                        x-model="rawText"
                        x-on:input.debounce.150ms="debouncedSplit()"
                        rows="12"
                        maxlength="5000"
                        placeholder="Type or paste your post, article, or thread draft here. We'll automatically break it down into 280-character tweets on word boundaries as you type..."
                        class="w-full p-4 bg-white border-2 border-gray-300 rounded-xl font-sans text-sm text-gray-800 placeholder-gray-400 focus:border-black focus:ring-2 focus:ring-[#006c49]/20 resize-y transition-all shadow-md leading-relaxed focus:outline-none"
                    ></textarea>

                    <!-- Floating char counter -->
                    <div
                        class="absolute bottom-3 right-3 text-[11px] font-mono font-extrabold px-2.5 py-1 rounded shadow-md transition-all"
                        :class="charWarning ? 'bg-rose-100 text-rose-800 border border-rose-300' : 'bg-gray-100 text-gray-500 border border-gray-300'"
                    >
                        <span x-text="formatNumber(rawText.length)">0</span> / 5,000
                    </div>
                </div>

                <div class="flex justify-between items-center pt-1">
                    <button
                        type="button"
                        x-on:click="loadSample()"
                        class="text-xs text-[#006c49] font-mono font-extrabold hover:underline cursor-pointer flex items-center gap-1 uppercase tracking-wider"
                    >
                        <span class="material-symbols-outlined text-xs">auto_fix_high</span>
                        Load Sample Article
                    </button>
                    <div class="flex items-center gap-3">
                        <span
                            x-show="charWarning"
                            class="text-[10px] text-rose-600 font-mono font-extrabold uppercase tracking-wider flex items-center gap-1" x-cloak
                        >
                            <span class="material-symbols-outlined text-[12px]">warning</span>
                            Long draft! Generates multiple tweets
                        </span>
                        <button
                            type="button"
                            x-on:click="clearText()"
                            x-show="rawText.length > 0"
                            class="text-xs text-gray-400 hover:text-rose-600 font-mono font-extrabold transition-colors cursor-pointer uppercase tracking-wider flex items-center gap-1"
                            x-cloak
                        >
                            <span class="material-symbols-outlined text-xs">delete</span>
                            Clear Text
                        </button>
                    </div>
                </div>
            </div>

            <!-- Thread Configuration Card -->
            <div class="bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 flex flex-col gap-4 shadow-md">
                <h3 class="font-sans text-base font-bold text-black flex items-center gap-2 border-b-2 border-gray-300 pb-3">
                    <span class="material-symbols-outlined text-[#006c49]">settings</span>
                    Thread Configuration
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 font-mono">
                    <!-- Format -->
                    <div class="flex flex-col gap-1.5">
                        <label for="numberFormat" class="text-xs font-extrabold text-gray-500 uppercase tracking-wider">Numbering Format</label>
                        <select
                            id="numberFormat"
                            x-model="numberFormat"
                            x-on:change="applySettings()"
                            class="w-full p-3 bg-white border-2 border-gray-300 rounded-xl font-mono text-xs text-black focus:border-black focus:ring-2 focus:ring-[#006c49]/20 transition-all cursor-pointer font-bold"
                        >
                            <option value="1/N">1/N (e.g., 1/5, 2/5)</option>
                            <option value="(1/N)">(1/N) (e.g., (1/5))</option>
                            <option value="[1/N]">[1/N] (e.g., [1/5])</option>
                            <option value="1.">1. (e.g., 1., 2.)</option>
                            <option value="none">None</option>
                        </select>
                    </div>

                    <!-- Position -->
                    <div class="flex flex-col gap-1.5">
                        <label for="numberPosition" class="text-xs font-extrabold text-gray-500 uppercase tracking-wider">Numbering Position</label>
                        <select
                            id="numberPosition"
                            x-model="numberPosition"
                            x-on:change="applySettings()"
                            :disabled="numberFormat === 'none'"
                            class="w-full p-3 bg-white border-2 border-gray-300 rounded-xl font-mono text-xs text-black focus:border-black focus:ring-2 focus:ring-[#006c49]/20 transition-all cursor-pointer font-bold disabled:opacity-40 disabled:cursor-not-allowed"
                        >
                            <option value="end">End of Tweet (Bottom)</option>
                            <option value="start">Start of Tweet (Top)</option>
                        </select>
                    </div>

                    <!-- Prefix -->
                    <div class="flex flex-col gap-1.5">
                        <label for="prefixText" class="text-xs font-extrabold text-gray-500 uppercase tracking-wider">Tweet Prefix</label>
                        <input
                            type="text"
                            id="prefixText"
                            x-model="prefixText"
                            x-on:input.debounce.200ms="applySettings()"
                            maxlength="10"
                            placeholder="🧵 or 🔵 (optional)"
                            class="w-full p-3 bg-white border-2 border-gray-300 rounded-xl font-mono text-xs text-black focus:border-black focus:ring-2 focus:ring-[#006c49]/20 transition-all"
                        >
                    </div>

                    <!-- Separator -->
                    <div class="flex flex-col gap-1.5">
                        <label for="separator" class="text-xs font-extrabold text-gray-500 uppercase tracking-wider">Copy / Export Separator</label>
                        <select
                            id="separator"
                            x-model="separator"
                            x-on:change="applySettings()"
                            class="w-full p-3 bg-white border-2 border-gray-300 rounded-xl font-mono text-xs text-black focus:border-black focus:ring-2 focus:ring-[#006c49]/20 transition-all cursor-pointer font-bold"
                        >
                            <option value="\n\n">Double Newline (\n\n)</option>
                            <option value="\n">Single Newline (\n)</option>
                            <option value=" | ">Pipe ( | )</option>
                            <option value=" · ">Middle Dot ( · )</option>
                        </select>
                    </div>
                </div>

                <div class="pt-2 border-t border-gray-300">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            x-model="autoNumbering"
                            x-on:change="applySettings()"
                            class="w-4 h-4 rounded border-2 border-gray-300 text-[#006c49] focus:ring-2 focus:ring-[#006c49]/20 cursor-pointer"
                        >
                        <span class="text-xs font-mono font-extrabold text-gray-700 uppercase tracking-wider">Auto-number tweets (recommended)</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons Card -->
            <div class="bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 flex flex-col gap-3 shadow-md">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 font-mono">
                    <!-- Copy All -->
                    <button
                        type="button"
                        x-on:click="copyAllTweets()"
                        :disabled="tweets.length === 0"
                        class="py-3.5 bg-black hover:bg-[#006c49] text-white rounded-xl border-2 border-black font-mono text-xs uppercase tracking-wider font-extrabold transition-all flex items-center justify-center gap-2 shadow-md cursor-pointer active:scale-98 disabled:opacity-40 disabled:cursor-not-allowed"
                    >
                        <span class="material-symbols-outlined text-[18px]" x-text="copiedAll ? 'check' : 'content_copy'">content_copy</span>
                        <span x-text="copiedAll ? 'Copied!' : 'Copy All Tweets'">Copy All Tweets</span>
                    </button>

                    <!-- Export Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button
                            type="button"
                            x-on:click="open = !open"
                            :disabled="tweets.length === 0"
                            class="w-full py-3.5 bg-white text-black border-2 border-gray-300 hover:border-black rounded-xl font-mono text-xs uppercase tracking-wider font-extrabold transition-all flex items-center justify-center gap-2 shadow-md cursor-pointer active:scale-98 disabled:opacity-40 disabled:cursor-not-allowed"
                        >
                            <span class="material-symbols-outlined text-[18px]">download</span>
                            <span>Export Thread</span>
                            <span class="material-symbols-outlined text-[16px] transition-transform" :class="{'rotate-180': open}">expand_more</span>
                        </button>

                        <div
                            x-show="open"
                            x-cloak
                            x-on:click.outside="open = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute right-0 left-0 mt-2 bg-white border-2 border-gray-300 rounded-xl shadow-lg overflow-hidden z-20"
                        >
                            <button
                                type="button"
                                x-on:click="exportThread('markdown'); open = false;"
                                class="w-full px-4 py-2.5 text-left font-mono text-xs text-gray-700 hover:bg-[#f8f9fa] hover:text-black transition-all flex items-center gap-2 cursor-pointer"
                            >
                                <span class="material-symbols-outlined text-sm">description</span>
                                Markdown (.md)
                            </button>
                            <button
                                type="button"
                                x-on:click="exportThread('txt'); open = false;"
                                class="w-full px-4 py-2.5 text-left font-mono text-xs text-gray-700 hover:bg-[#f8f9fa] hover:text-black transition-all flex items-center gap-2 border-t border-gray-300 cursor-pointer"
                            >
                                <span class="material-symbols-outlined text-sm">article</span>
                                Plain Text (.txt)
                            </button>
                            <button
                                type="button"
                                x-on:click="exportThread('plain'); open = false;"
                                class="w-full px-4 py-2.5 text-left font-mono text-xs text-gray-700 hover:bg-[#f8f9fa] hover:text-black transition-all flex items-center gap-2 border-t border-gray-300 cursor-pointer"
                            >
                                <span class="material-symbols-outlined text-sm">format_align_left</span>
                                Clean Text (no numbers)
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Post All to X -->
                <button
                    type="button"
                    x-on:click="postAllToX()"
                    :disabled="tweets.length === 0"
                    class="w-full py-3 bg-[#006c49] hover:bg-emerald-600 text-white rounded-xl border-2 border-[#006c49] font-mono text-xs uppercase tracking-wider font-extrabold transition-all flex items-center justify-center gap-2 shadow-md cursor-pointer active:scale-98 disabled:opacity-40 disabled:cursor-not-allowed"
                >
                    <span class="material-symbols-outlined text-[16px]">send</span>
                    Post All Tweets to X
                </button>
            </div>
        </div>

        <!-- Right Column: Thread Preview (5 cols) -->
        <div class="lg:col-span-5 flex flex-col gap-4 self-start">
            <!-- Preview Header -->
            <div class="flex justify-between items-center pb-2 border-b-2 border-gray-300">
                <h2 class="font-sans text-xl font-extrabold text-black flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-mono font-extrabold bg-[#006c49] text-white uppercase tracking-wider">STEP 2</span>
                    Thread Preview
                </h2>
                <span class="font-mono text-xs font-extrabold text-[#006c49] uppercase bg-emerald-50 border-2 border-emerald-300 px-3 py-1 rounded-xl">
                    <span x-text="tweets.length">0</span> Tweet<span x-show="tweets.length !== 1" x-cloak>s</span>
                </span>
            </div>

            <!-- Tweet Cards Timeline -->
            <div class="flex flex-col relative pt-2 min-h-[400px]">

                <!-- Empty State -->
                <div
                    x-show="tweets.length === 0"
                    class="bg-[#f8f9fa] border-2 border-dashed border-gray-300 rounded-[1rem] p-8 text-center flex flex-col items-center justify-center min-h-[350px]"
                >
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 border-2 border-emerald-300 flex items-center justify-center text-[#006c49] mb-4 transition-transform duration-300">
                        <span class="material-symbols-outlined text-4xl">forum</span>
                    </div>
                    <h4 class="text-lg font-extrabold text-black mb-2 font-sans">No Thread Cards Generated Yet</h4>
                    <p class="text-sm text-gray-500 max-w-xs leading-relaxed font-sans mb-4 font-medium">
                        Start typing on the left or click
                        <button
                            type="button"
                            x-on:click="loadSample()"
                            class="text-[#006c49] font-extrabold hover:underline cursor-pointer"
                        >"Load Sample Article"</button>
                        to preview your generated thread cards.
                    </p>
                </div>

                <!-- Live Tweet Cards -->
                <div
                    x-show="tweets.length > 0"
                    class="space-y-5 relative"
                    x-cloak
                >
                    <!-- Vertical Thread Connector Line -->
                    <div
                        class="absolute left-[19px] top-8 bottom-8 w-[3px] bg-gray-300 z-0 transition-opacity duration-300"
                        :class="{'thread-line-pulse': tweets.length > 1, 'opacity-0': tweets.length <= 1}"
                    ></div>

                    <template x-for="(tweet, index) in tweets" :key="index">
                        <div
                            class="relative z-10 flex gap-3.5 group tweet-card-enter"
                            :style="{ animationDelay: (index * 0.05) + 's' }"
                        >
                            <!-- Avatar Node -->
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-black text-white font-extrabold text-xs border-2 border-black flex items-center justify-center shadow-md font-mono shrink-0 transition-transform duration-200 group-hover:scale-105">
                                PP
                            </div>

                            <!-- Card Content -->
                            <div class="flex-grow bg-[#f8f9fa] border-2 border-gray-300 rounded-xl p-5 shadow-md group-hover:border-black group-hover:shadow-lg transition-all flex flex-col gap-3">
                                <!-- Card Header: Number + Char Counter -->
                                <div class="flex justify-between items-center font-mono">
                                    <span class="text-xs font-extrabold text-white bg-black px-2.5 py-0.5 rounded-md transition-all group-hover:scale-105" x-text="`${index + 1}/${tweets.length}`">1/1</span>

                                    <!-- Char count badge with progress bar -->
                                    <div class="flex items-center gap-1.5">
                                        <div
                                            class="w-16 h-2 rounded-full progress-bg overflow-hidden"
                                            title="Character limit progress"
                                        >
                                            <div
                                                class="h-full rounded-full transition-all duration-300"
                                                :class="getCharProgressClass(getTwitterLength(tweet))"
                                                :style="{ width: getCharPercentage(getTwitterLength(tweet)) + '%' }"
                                            ></div>
                                        </div>
                                        <span
                                            class="text-xs font-mono font-extrabold px-2 py-0.5 rounded transition-all"
                                            :class="getCharBadgeClass(getTwitterLength(tweet))"
                                            x-text="`${getTwitterLength(tweet)} / 280`"
                                        >0 / 280</span>
                                    </div>
                                </div>

                                <!-- Tweet Content Body -->
                                <p class="font-sans text-sm text-gray-800 whitespace-pre-wrap leading-relaxed bg-white p-4 rounded-xl border-2 border-gray-200 font-medium shadow-md break-words">
                                    <template x-if="tweet.length > 0">
                                        <span x-text="tweet"></span>
                                    </template>
                                    <template x-if="tweet.length === 0">
                                        <span class="text-gray-400 italic">Empty tweet</span>
                                    </template>
                                </p>

                                <!-- Tweet Actions -->
                                <div class="flex gap-2 pt-1 font-mono text-xs">
                                    <button
                                        type="button"
                                        x-on:click="copySingleTweet(tweet, index)"
                                        class="flex-1 py-2 bg-white text-black border-2 border-gray-300 hover:border-black rounded-xl transition-all flex items-center justify-center gap-1 font-bold cursor-pointer shadow-md active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#006c49]/30"
                                    >
                                        <span class="material-symbols-outlined text-[16px]" x-text="copiedIndex === index ? 'check' : 'content_copy'"></span>
                                        <span x-text="copiedIndex === index ? 'Copied!' : 'Copy'">Copy</span>
                                    </button>
                                    <button
                                        type="button"
                                        x-on:click="postToTwitter(tweet)"
                                        class="flex-1 py-2 bg-black text-white border-2 border-black hover:bg-[#006c49] hover:border-[#006c49] rounded-xl transition-all flex items-center justify-center gap-1 font-bold cursor-pointer shadow-md active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#006c49]/30"
                                    >
                                        <span class="material-symbols-outlined text-[16px]">send</span>
                                        Post to X
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- PostPilot Promotional CTA -->
    <section class="mt-16 bg-gradient-to-br from-black via-gray-900 to-[#004d34] text-white rounded-[1rem] p-8 sm:p-12 border-2 border-black shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-[#006c49]/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-mono text-xs font-extrabold uppercase tracking-widest mb-4">
                    <span class="material-symbols-outlined text-[14px]">rocket_launch</span>
                    <span>PostPilot Engine</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight mb-3 font-sans leading-tight">
                    30 Days of Content. Published on Autopilot with PostPilot.
                </h2>
                <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
                    Stop manually splitting threads and scheduling tweets one by one. PostPilot generates, formats, and schedules 30 days of high-converting X threads and social content automatically.
                </p>
                <div class="mt-4 flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs text-gray-300 font-mono">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-emerald-400 text-[16px]">check_circle</span> No credit card required</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-emerald-400 text-[16px]">check_circle</span> Instant setup</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-emerald-400 text-[16px]">check_circle</span> Multi-platform publishing</span>
                </div>
            </div>
            <div class="shrink-0">
                <a
                    href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-[#006c49] hover:bg-emerald-600 text-white font-extrabold rounded-xl text-base tracking-wide transition-all shadow-lg hover:shadow-emerald-900/40 transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer font-sans"
                >
                    <span>Start Free Trial →</span>
                </a>
            </div>
        </div>
    </section>

    {{-- FAQ Section (SSR Content for SEO) --}}
    <section class="mt-16 max-w-4xl mx-auto" x-data="{ openFaq: null }">
        <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-[#006c49] text-xl">help</span>
            <h2 class="text-xl font-extrabold text-black tracking-tight font-sans">Frequently Asked Questions</h2>
        </div>

        @php
            $faqs = [
                [
                    'question' => 'What is a Twitter thread splitter?',
                    'answer' => 'A Twitter (X) thread splitter is a free online tool that automatically divides long-form text, blog posts, or articles into individual, character-compliant tweets. It intelligently splits your content on natural word and sentence boundaries to preserve readability and logical flow across the thread. By automatically formatting and numbering each post, it saves creators hours of manual editing.',
                ],
                [
                    'question' => 'What is the character limit for X (Twitter) tweets?',
                    'answer' => 'Standard X (Twitter) accounts have a limit of 280 characters per tweet, while X Premium subscribers can post longer content up to 25,000 characters. For maximum reach and engagement, 280-character thread posts remain the optimal format because they are easily digestible for all users. Our thread splitter tracks weighted character counts in real time to ensure every card fits perfectly within standard limits.',
                ],
                [
                    'question' => 'How does auto-numbering work in threads?',
                    'answer' => 'Auto-numbering automatically attaches sequential sequence indicators—such as 1/N, (1/N), [1/N], or 1.—to each tweet in your generated thread. You can customize whether the numbers appear at the beginning or end of each tweet, or add custom emoji prefixes like 🧵. This gives your readers a clear navigational guide so they can follow your entire thread from start to finish without getting lost.',
                ],
                [
                    'question' => 'Does this tool count URLs toward the character limit?',
                    'answer' => 'Yes, our tool accurately accounts for the official Twitter link wrapping system, where all URLs are calculated as 23 characters regardless of their actual length. Whether you paste a short link or a lengthy URL, the thread splitter adjusts character limits dynamically to prevent your tweets from exceeding the threshold on X. This ensures your links do not cause accidental truncation when posted.',
                ],
                [
                    'question' => 'Can I export my thread to a text file?',
                    'answer' => 'Absolutely. Once your thread is generated, you can export the full sequence into Markdown (.md), plain text (.txt), or a clean text format without numbering. You can also copy all tweets to your clipboard with a single click or send individual posts directly to X via intent links. This flexibility makes it easy to save drafts, back up your content, or schedule posts in your favorite social media management tool.',
                ],
                [
                    'question' => 'What is the best thread length for engagement on X?',
                    'answer' => 'High-performing X threads typically contain between 5 and 10 tweets. This length provides enough space to deliver valuable insights, tell a compelling story, or explain a complex topic without losing reader attention. Keeping individual tweets concise and using clear visual hooks in your opening post helps maximize retweets, bookmarks, and overall thread reach.',
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
</div>

<!-- Copy Toast Notification -->
<div
    x-show="toastVisible"
    x-cloak
    class="fixed bottom-6 right-6 z-50 bg-black text-white border-2 border-[#006c49] rounded-xl px-5 py-3 shadow-2xl flex items-center gap-3 font-mono text-xs font-bold toast-enter toast-leave"
>
    <span class="material-symbols-outlined text-emerald-400 text-xl">check_circle</span>
    <span x-text="toastMessage">Action completed</span>
</div>

<!-- Alpine.js Controller -->
<script>
function twitterSplitter(presetText = '') {
    return {
        rawText: presetText,
        numberFormat: '1/N',
        numberPosition: 'end',
        prefixText: '🧵',
        separator: '\\n\\n',
        autoNumbering: true,
        tweets: [],
        copiedAll: false,
        copiedIndex: null,
        toastVisible: false,
        toastMessage: '',
        sampleText: "Why 90% of SaaS Founders Fail at Organic Content Marketing (and the exact 4-step framework we used to reach $100k MRR on autopilot):\n\n1. Stop writing generic advice. Real growth comes from documented stories, metrics, and actionable lessons that build trust. https://postpilot.co/case-study\n\n2. Master the hook cutoff. If your first 2 lines don't trigger massive curiosity, 80% of readers will scroll past without expanding your post.\n\n3. Use structured threads. Break long thoughts into digestible 280-character cards with clear numbering like (1/N) so readers can follow along effortlessly.\n\n4. Automate your scheduling. Use tools like PostPilot to plan 30 days of content in one sitting instead of stressing daily. https://postpilot.co/signup",

        init() {
            this.debouncedSplit();
        },

        get separatorValue() {
            if (this.separator === '\\n\\n') return '\n\n';
            if (this.separator === '\\n') return '\n';
            return this.separator;
        },

        get charWarning() {
            return this.rawText && this.rawText.length > 2500;
        },

        get wordCount() {
            if (!this.rawText || !this.rawText.trim()) return 0;
            return this.rawText.trim().split(/\s+/).filter(Boolean).length;
        },

        get readingTime() {
            if (!this.wordCount) return 0;
            return Math.ceil(this.wordCount / 200);
        },

        get largestTweetLen() {
            if (!this.tweets.length) return 0;
            let max = 0;
            this.tweets.forEach(t => {
                const len = this.getTwitterLength(t);
                if (len > max) max = len;
            });
            return max;
        },

        formatNumber(num) {
            if (!num && num !== 0) return '0';
            return num.toLocaleString();
        },

        // Calculates Twitter/X weighted length:
        // - URLs (http/https) count as 23 characters
        // - Astral Unicode characters (surrogate pairs in JS) count as 2 code units (which matches string.length in JS)
        getTwitterLength(text) {
            if (!text) return 0;
            const urlRegex = /https?:\/\/[^\s]+/g;
            let len = 0;
            let lastIndex = 0;
            let match;
            const maxIter = 500;
            let iter = 0;

            while ((match = urlRegex.exec(text)) !== null) {
                iter++;
                if (iter > maxIter) break;
                len += (match.index - lastIndex);
                len += 23;
                lastIndex = urlRegex.lastIndex;
            }
            len += (text.length - lastIndex);
            return len;
        },

        getCharPercentage(len) {
            return Math.min(Math.round((len / 280) * 100), 100);
        },

        getCharProgressClass(len) {
            if (len > 280) return 'bg-rose-500';
            if (len > 260) return 'bg-amber-500';
            if (len > 240) return 'bg-emerald-400';
            return 'bg-[#006c49]';
        },

        getCharBadgeClass(len) {
            if (len > 280) return 'bg-rose-50 text-rose-800 border border-rose-200';
            if (len > 260) return 'bg-amber-50 text-amber-800 border border-amber-200';
            return 'bg-emerald-50 text-[#006c49] border border-emerald-200';
        },

        // Returns affix prefix and suffix for a given tweet index
        getAffix(index, total) {
            if (this.numberFormat === 'none' || !this.autoNumbering || total <= 0) {
                const prefix = this.prefixText ? this.prefixText.trim() + ' ' : '';
                return { prefix: prefix, suffix: '' };
            }

            const i = index + 1;
            let label = '';
            switch (this.numberFormat) {
                case '1/N':       label = `${i}/${total}`; break;
                case '(1/N)':     label = `(${i}/${total})`; break;
                case '[1/N]':    label = `[${i}/${total}]`; break;
                case '1.':       label = `${i}.`; break;
                default:         label = `${i}/${total}`;
            }

            const prefixBase = this.prefixText ? this.prefixText.trim() + ' ' : '';

            if (this.numberPosition === 'start') {
                return { prefix: `${prefixBase}${label} `, suffix: '' };
            }
            if (this.numberPosition === 'end') {
                return { prefix: prefixBase, suffix: `\n\n${label}` };
            }
            return { prefix: prefixBase, suffix: '' };
        },

        // Helper to safely slice text without splitting surrogate pairs (emojis)
        safeSlice(str, start, end) {
            if (!str) return '';
            let sliced = str.slice(start, end);
            if (sliced.length > 0) {
                const lastCode = sliced.charCodeAt(sliced.length - 1);
                if (lastCode >= 0xD800 && lastCode <= 0xDBFF) {
                    sliced = sliced.slice(0, -1);
                }
            }
            return sliced;
        },

        splitThread() {
            this.debouncedSplit();
        },

        debouncedSplit() {
            const text = (this.rawText || '').trim();
            if (!text) {
                this.tweets = [];
                return;
            }

            const workingText = text.length > 10000 ? text.slice(0, 10000) : text;

            try {
                let maxChunkLen = 250;
                let chunks = this.doSplit(workingText, maxChunkLen);
                let total = chunks.length;
                let formattedTweets = this.applyFormatting(chunks, total);

                let maxTweetLen = 0;
                formattedTweets.forEach(t => {
                    const l = this.getTwitterLength(t);
                    if (l > maxTweetLen) maxTweetLen = l;
                });

                let retryCount = 0;
                const maxRetries = 6;

                while (maxTweetLen > 280 && retryCount < maxRetries) {
                    retryCount++;
                    const overflow = maxTweetLen - 280;
                    const reduction = Math.ceil(overflow / (total || 1)) + 4;
                    maxChunkLen = Math.max(40, maxChunkLen - reduction);

                    chunks = this.doSplit(workingText, maxChunkLen);
                    total = chunks.length;
                    formattedTweets = this.applyFormatting(chunks, total);

                    maxTweetLen = 0;
                    formattedTweets.forEach(t => {
                        const l = this.getTwitterLength(t);
                        if (l > maxTweetLen) maxTweetLen = l;
                    });
                }

                if (maxTweetLen > 280) {
                    const safeChunks = [];
                    formattedTweets.forEach(tweet => {
                        if (this.getTwitterLength(tweet) <= 280) {
                            safeChunks.push(tweet);
                        } else {
                            let rem = tweet;
                            while (rem.length > 0) {
                                let cutLen = 275;
                                while (cutLen > 0 && this.getTwitterLength(this.safeSlice(rem, 0, cutLen)) > 280) {
                                    cutLen -= 5;
                                }
                                if (cutLen <= 0) cutLen = 250;
                                safeChunks.push(this.safeSlice(rem, 0, cutLen));
                                rem = rem.slice(cutLen);
                            }
                        }
                    });
                    formattedTweets = safeChunks;
                }

                this.tweets = formattedTweets;
            } catch (e) {
                console.error('Thread split error:', e);
                this.tweets = [text.slice(0, 270)];
            }
        },

        applyFormatting(chunks, total) {
            return chunks.map((chunk, i) => {
                const { prefix, suffix } = this.getAffix(i, total);
                return prefix + chunk + suffix;
            });
        },

        doSplit(text, maxLength) {
            if (!text || !text.trim()) return [];

            const maxIter = 30000;
            let iterCount = 0;

            const safeCheck = (str) => {
                iterCount++;
                if (iterCount > maxIter) throw new Error('Split iteration limit exceeded');
                return this.getTwitterLength(str) <= maxLength;
            };

            const rawParagraphs = text.split(/\n\s*\n/).filter(p => p.trim().length > 0);
            let chunks = [];
            let currentChunk = '';

            const appendToCurrent = (piece, sep) => {
                if (!currentChunk) return piece;
                return currentChunk + sep + piece;
            };

            const flushCurrent = () => {
                if (currentChunk) {
                    chunks.push(currentChunk);
                    currentChunk = '';
                }
            };

            for (let para of rawParagraphs) {
                para = para.trim();
                if (!para) continue;

                if (safeCheck(appendToCurrent(para, '\n\n'))) {
                    currentChunk = appendToCurrent(para, '\n\n');
                    continue;
                }

                flushCurrent();

                if (safeCheck(para)) {
                    currentChunk = para;
                    continue;
                }

                const lines = para.split(/\n+/).map(l => l.trim()).filter(l => l.length > 0);

                for (let line of lines) {
                    if (safeCheck(appendToCurrent(line, '\n'))) {
                        currentChunk = appendToCurrent(line, '\n');
                        continue;
                    }

                    flushCurrent();

                    if (safeCheck(line)) {
                        currentChunk = line;
                        continue;
                    }

                    const urlMap = [];
                    let maskedLine = line.replace(/https?:\/\/[^\s]+/g, (match) => {
                        const idx = urlMap.length;
                        urlMap.push(match);
                        return `__URL_${idx}__`;
                    });

                    const sentenceRegex = /[^.!?]+[.!?]+(?:\s+|$)|[^.!?]+$/g;
                    const sentenceMatches = maskedLine.match(sentenceRegex) || [maskedLine];
                    const sentences = sentenceMatches.map(s => {
                        return s.replace(/__URL_(\d+)__/g, (_, idx) => urlMap[parseInt(idx)]);
                    });

                    for (let sentence of sentences) {
                        sentence = sentence.trim();
                        if (!sentence) continue;

                        if (safeCheck(appendToCurrent(sentence, ' '))) {
                            currentChunk = appendToCurrent(sentence, ' ');
                            continue;
                        }

                        flushCurrent();

                        if (safeCheck(sentence)) {
                            currentChunk = sentence;
                            continue;
                        }

                        const words = sentence.split(/\s+/).filter(w => w.length > 0);

                        for (let word of words) {
                            if (safeCheck(appendToCurrent(word, ' '))) {
                                currentChunk = appendToCurrent(word, ' ');
                                continue;
                            }

                            flushCurrent();

                            if (safeCheck(word)) {
                                currentChunk = word;
                                continue;
                            }

                            let rem = word;
                            while (rem.length > 0) {
                                let cutLen = maxLength;
                                while (cutLen > 0 && !safeCheck(this.safeSlice(rem, 0, cutLen))) {
                                    cutLen--;
                                }
                                if (cutLen <= 0) cutLen = Math.min(10, rem.length);
                                const chunkPiece = this.safeSlice(rem, 0, cutLen);
                                chunks.push(chunkPiece);
                                rem = rem.slice(chunkPiece.length);
                            }
                            currentChunk = '';
                        }
                    }
                }
            }

            flushCurrent();
            return chunks;
        },

        applySettings() {
            this.debouncedSplit();
        },

        loadSample() {
            this.rawText = this.sampleText;
            this.debouncedSplit();
        },

        clearText() {
            this.rawText = '';
            this.tweets = [];
            this.copiedAll = false;
            this.copiedIndex = null;
        },

        cleanSpaces() {
            if (!this.rawText) return;
            this.rawText = this.rawText
                .split('\n')
                .map(line => line.trimEnd())
                .join('\n')
                .replace(/[ \t]+/g, ' ')
                .replace(/\n{3,}/g, '\n\n')
                .trim();
            this.debouncedSplit();
            this.showToast('Whitespace cleaned & formatted!');
        },

        stripHtml() {
            if (!this.rawText) return;
            this.rawText = this.rawText.replace(/<[^>]*>/g, '');
            this.debouncedSplit();
            this.showToast('HTML tags stripped!');
        },

        showToast(message) {
            this.toastMessage = message;
            this.toastVisible = true;
            setTimeout(() => { this.toastVisible = false; }, 2200);
        },

        copyToClipboard(text) {
            if (!text) return Promise.reject(new Error('Empty text'));
            if (navigator.clipboard && window.isSecureContext) {
                return navigator.clipboard.writeText(text);
            }
            return new Promise((resolve, reject) => {
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.left = '-999999px';
                textarea.style.top = '-999999px';
                document.body.appendChild(textarea);
                try {
                    textarea.focus();
                    textarea.select();
                    const successful = document.execCommand('copy');
                    document.body.removeChild(textarea);
                    if (successful) {
                        resolve();
                    } else {
                        reject(new Error('execCommand failed'));
                    }
                } catch (err) {
                    document.body.removeChild(textarea);
                    reject(err);
                }
            });
        },

        copyAllTweets() {
            if (!this.tweets.length) return;
            const content = this.tweets.join(this.separatorValue);
            this.copyToClipboard(content).then(() => {
                this.copiedAll = true;
                this.showToast('All tweets copied to clipboard!');
                setTimeout(() => { this.copiedAll = false; }, 2000);
            }).catch(() => {
                this.showToast('Failed to copy. Please check permissions.');
            });
        },

        copySingleTweet(tweet, index) {
            this.copyToClipboard(tweet).then(() => {
                this.copiedIndex = index;
                this.showToast(`Tweet ${index + 1} copied!`);
                setTimeout(() => { this.copiedIndex = null; }, 1000);
            }).catch(() => {
                this.showToast('Failed to copy tweet.');
            });
        },

        postToTwitter(tweet) {
            const url = 'https://x.com/intent/post?text=' + encodeURIComponent(tweet);
            window.open(url, '_blank', 'noopener,noreferrer,width=550,height=420');
        },

        postAllToX() {
            if (!this.tweets.length) return;
            this.tweets.forEach((tweet, i) => {
                setTimeout(() => {
                    this.postToTwitter(tweet);
                }, i * 600);
            });
        },

        exportThread(format) {
            if (!this.tweets.length) return;

            let content = '';
            let filename = '';

            if (format === 'markdown') {
                content = this.tweets.map((t, i) => `### Tweet ${i + 1}\n\n\`\`\`\n${t}\n\`\`\`\n`).join('\n');
                filename = 'twitter-thread.md';
            } else if (format === 'txt') {
                content = this.tweets.join('\n\n---\n\n');
                filename = 'twitter-thread.txt';
            } else if (format === 'plain') {
                const cleanTweets = this.tweets.map(t => {
                    return t
                        .replace(/^[\s\S]*?(?<=\n\n)(?:\d+\/\d+|\(\d+\/\d+\)|\[\d+\/\d+\]|\d+\.|[\u{1F300}-\u{1F9FF}]\s)?\s*/u, '')
                        .replace(/^\s*\/\d+(?:\n\n)?/, '')
                        .trim();
                });
                content = cleanTweets.join('\n\n');
                filename = 'twitter-thread-clean.txt';
            }

            const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            this.showToast(`Thread exported as ${format.toUpperCase()}!`);
        }
    };
}
</script>
@endsection