@extends('layouts.tool')

@section('title', 'Free LinkedIn Bold & Italic Text Generator [No Sign-Up] – Unicode Formatter | PostPilot')
@section('meta_description', 'Make your LinkedIn posts & headlines stand out with bold and italic unicode text. Instant formatting, copy & paste ready. 100% free, no account needed ➔')
@section('tool_name', 'Free LinkedIn Bold & Italic Unicode Text Formatter')
@section('tool_route', 'tools.linkedin-bold-italic')

@section('schema_json')
    <x-seo.faq-schema :faqs="[
        [
            'question' => 'How does Unicode bold text work on LinkedIn?',
            'answer' => 'Standard plain text editors on LinkedIn do not support rich text HTML tags like <b> or <i>. This tool converts regular Latin characters into Mathematical Alphanumeric Symbols from the Unicode standard. Because these styled characters are distinct Unicode code points, LinkedIn displays them as bold or italic text everywhere.'
        ],
        [
            'question' => 'Is Unicode bold text accessible to screen readers?',
            'answer' => 'Unicode mathematical symbols are designed for mathematical notation, so screen readers like NVDA or JAWS may pronounce them as individual mathematical symbols rather than plain words. To maintain accessibility for visually impaired users, use bold or italic formatting selectively on headlines, short hooks, and key numbers rather than entire paragraphs.'
        ],
        [
            'question' => 'Does LinkedIn support native bold or italic formatting?',
            'answer' => 'Currently, LinkedIn does not offer built-in rich text formatting options like bold or italic buttons in its post composer window. Using Unicode text converters like this generator is the standard method for adding stylized typography to your LinkedIn posts, articles, comments, and profile headline.'
        ],
        [
            'question' => 'Will Unicode text affect my LinkedIn post reach?',
            'answer' => 'Using Unicode bold text does not penalize your reach in the LinkedIn algorithm. In fact, strategic bold formatting on your hook line can improve stopping power, increase dwell time, and boost click-through rates. However, overusing styled characters can hinder readability, so keep formatting subtle and purposeful.'
        ],
        [
            'question' => 'What Unicode styles are available in this tool?',
            'answer' => 'Our converter provides 15 distinct font styles, including Sans-Serif Bold, Serif Bold, Sans-Serif Italic, Bold Italic, Monospace, Cursive Script, Bold Script, Double-Struck, Fraktur Gothic, Circled Bubble, Small Caps, Underline, and Strikethrough. You can copy any style instantly with one click.'
        ],
        [
            'question' => 'Does this tool work for Facebook and Instagram too?',
            'answer' => 'Yes! Unicode characters are universally supported across almost all modern social media platforms and messaging apps. You can copy and paste your formatted text directly into Facebook posts, Instagram captions and bios, X (Twitter) tweets, TikTok profiles, WhatsApp messages, and YouTube descriptions.'
        ],
    ]" />
@endsection

@section('content')
<div class="mb-16 font-sans" x-data="unicodeFormatter()">
    <!-- Centered Hero Section -->
    <section class="flex flex-col items-center text-center gap-4 max-w-3xl mx-auto mb-10 font-sans">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#006c49]/10 border border-[#006c49]/30 rounded-full shadow-md">
            <span class="material-symbols-outlined text-[16px] text-[#006c49]">verified</span>
            <span class="font-mono text-xs text-[#006c49] uppercase tracking-wider font-extrabold">LINKEDIN TOOLS • 100% FREE &amp; CLIENT-SIDE</span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-black tracking-tight leading-tight font-sans text-center">
            LinkedIn Bold &amp; Italic Unicode Text Generator
        </h1>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl font-medium leading-relaxed text-center font-sans">
            Convert plain text into eye-catching Unicode bold, italic, script, and monospace font styles for LinkedIn posts, comments, and bios.
        </p>
    </section>

    {{-- GEO / Answer-First Content --}}
    <div class="max-w-3xl mx-auto mb-8 px-4 sm:px-0">
        <p class="text-[15px] leading-relaxed text-gray-700 font-medium bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <strong>What is this tool?</strong> The LinkedIn Bold &amp; Italic Unicode Text Generator is a free utility that transforms standard text into stylized Unicode fonts, including bold, italic, script, and monospace. Creators use it to bypass LinkedIn's native formatting limitations, adding visual hierarchy to post hooks and bios to instantly capture reader attention in crowded feeds.
        </p>
    </div>

    <!-- Stats Bar (4 High-Contrast Soft Cards) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 w-full mb-8 font-mono">
        <div class="bg-white p-5 rounded-xl border-2 border-gray-300 shadow-md flex flex-col items-center justify-center text-center">
            <span class="text-xs text-gray-500 uppercase tracking-wider font-extrabold block mb-1">Total Characters</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-black" x-text="formatNumber(charCount)">0</span>
        </div>
        <div class="bg-white p-5 rounded-xl border-2 border-gray-300 shadow-md flex flex-col items-center justify-center text-center">
            <span class="text-xs text-gray-500 uppercase tracking-wider font-extrabold block mb-1">No Spaces</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-black" x-text="formatNumber(charsNoSpaces)">0</span>
        </div>
        <div class="bg-white p-5 rounded-xl border-2 border-gray-300 shadow-md flex flex-col items-center justify-center text-center">
            <span class="text-xs text-gray-500 uppercase tracking-wider font-extrabold block mb-1">Word Count</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-black" x-text="formatNumber(wordCount)">0</span>
        </div>
        <div class="bg-emerald-50 p-5 rounded-xl border-2 border-emerald-300 shadow-md flex flex-col items-center justify-center text-center">
            <span class="text-xs text-[#006c49] uppercase tracking-wider font-extrabold block mb-1">Available Styles</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-[#006c49]" x-text="stylesList.length">15</span>
        </div>
    </div>

    <!-- Dual Pane Layout Grid (12 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Input Control Panel (5 cols) -->
        <div class="lg:col-span-5 flex flex-col gap-6 self-start bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 shadow-md">
            
            <!-- Panel Header -->
            <div class="flex items-center justify-between border-b border-gray-300 pb-3">
                <label for="inputText" class="inline-flex items-center gap-2 font-mono text-xs font-extrabold text-black uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[18px] text-[#006c49]">edit_note</span>
                    Enter Text to Format
                </label>
                <div class="flex items-center gap-2">
                    <button 
                        type="button" 
                        x-on:click="loadSample()"
                        class="text-xs font-mono font-bold text-[#006c49] hover:underline cursor-pointer uppercase tracking-wider flex items-center gap-1 bg-emerald-50 border border-emerald-300 px-2.5 py-1 rounded-md transition-colors"
                    >
                        <span class="material-symbols-outlined text-xs">auto_fix_high</span>
                        Sample
                    </button>
                    <button 
                        type="button"
                        x-on:click="clearText()" 
                        x-show="text.length > 0"
                        class="text-xs font-mono font-bold text-gray-500 hover:text-red-600 border border-gray-300 hover:border-red-300 bg-white px-2 py-1 rounded-md transition-colors cursor-pointer uppercase tracking-wider"
                        x-cloak
                    >
                        Clear
                    </button>
                </div>
            </div>

            <!-- Text Input Area -->
            <div class="relative">
                <textarea 
                    id="inputText"
                    x-model="text"
                    rows="7"
                    placeholder="Type or paste your post text here (e.g. key hooks, headers, metrics, bullet points)..."
                    class="w-full bg-white border-2 border-gray-300 rounded-xl p-4 font-sans text-sm text-gray-900 focus:outline-none focus:border-black focus:ring-2 focus:ring-[#006c49]/20 transition-all resize-y shadow-md leading-relaxed font-medium"
                ></textarea>
                <div class="absolute bottom-3 right-3 text-[11px] font-mono font-bold text-gray-500 bg-gray-100 border border-gray-300 px-2 py-0.5 rounded shadow-md">
                    <span x-text="charCount">0</span> chars
                </div>
            </div>

            <!-- Text Case & Formatting Controls -->
            <div class="bg-white border-2 border-gray-300 rounded-xl p-4 shadow-md">
                <p class="font-mono text-[11px] font-extrabold text-gray-600 uppercase tracking-wider mb-2.5">Text Case Transformations:</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    <button 
                        type="button"
                        x-on:click="transformCase('upper')"
                        class="px-2.5 py-1.5 bg-[#f8f9fa] border-2 border-gray-300 hover:border-black hover:bg-black hover:text-white text-black text-xs font-mono font-bold rounded-lg transition-all cursor-pointer text-center active:scale-95"
                    >UPPER</button>
                    <button 
                        type="button"
                        x-on:click="transformCase('lower')"
                        class="px-2.5 py-1.5 bg-[#f8f9fa] border-2 border-gray-300 hover:border-black hover:bg-black hover:text-white text-black text-xs font-mono font-bold rounded-lg transition-all cursor-pointer text-center active:scale-95"
                    >lower</button>
                    <button 
                        type="button"
                        x-on:click="transformCase('title')"
                        class="px-2.5 py-1.5 bg-[#f8f9fa] border-2 border-gray-300 hover:border-black hover:bg-black hover:text-white text-black text-xs font-mono font-bold rounded-lg transition-all cursor-pointer text-center active:scale-95"
                    >Title Case</button>
                    <button 
                        type="button"
                        x-on:click="cleanSpaces()"
                        class="px-2.5 py-1.5 bg-[#f8f9fa] border-2 border-gray-300 hover:border-black hover:bg-black hover:text-white text-black text-xs font-mono font-bold rounded-lg transition-all cursor-pointer text-center active:scale-95"
                    >Trim Spaces</button>
                </div>
            </div>

            <!-- Quick Bullet & Emoji Helpers -->
            <div class="bg-white border-2 border-gray-300 rounded-xl p-4 shadow-md">
                <p class="font-mono text-[11px] font-extrabold text-gray-600 uppercase tracking-wider mb-2.5">Click to Prepend Bullet / Icon:</p>
                <div class="flex flex-wrap gap-2">
                    <template x-for="icon in bulletIcons" :key="icon">
                        <button 
                            type="button"
                            x-on:click="prependSymbol(icon)"
                            class="w-8 h-8 rounded-lg border-2 border-gray-300 bg-[#f8f9fa] hover:border-black hover:bg-white text-xs flex items-center justify-center transition-all cursor-pointer active:scale-95"
                            x-text="icon"
                        ></button>
                    </template>
                </div>
            </div>

            <!-- Quick Sample Prompts -->
            <div>
                <p class="font-mono text-[11px] font-extrabold text-gray-500 uppercase tracking-wider mb-2">Quick Sample Prompts:</p>
                <div class="flex flex-wrap gap-2">
                    <button 
                        type="button"
                        x-on:click="text = '3-Step SaaS Marketing Strategy for 2026'"
                        class="px-3 py-1.5 rounded-full border-2 border-black bg-white text-xs font-sans text-black font-bold hover:bg-black hover:text-white transition-all cursor-pointer active:scale-95 shadow-md"
                    >⚡ Headline Hook</button>
                    <button 
                        type="button"
                        x-on:click="text = 'ARR grew from $10k to $100k in 6 months'"
                        class="px-3 py-1.5 rounded-full border-2 border-black bg-white text-xs font-sans text-black font-bold hover:bg-black hover:text-white transition-all cursor-pointer active:scale-95 shadow-md"
                    >🚀 Growth Metric</button>
                    <button 
                        type="button"
                        x-on:click="text = 'Key Takeaways for Founders & Creators'"
                        class="px-3 py-1.5 rounded-full border-2 border-black bg-white text-xs font-sans text-black font-bold hover:bg-black hover:text-white transition-all cursor-pointer active:scale-95 shadow-md"
                    >💡 Key Takeaways</button>
                    <button 
                        type="button"
                        x-on:click="text = 'BREAKING: Product v2.0 is officially Live!'"
                        class="px-3 py-1.5 rounded-full border-2 border-black bg-white text-xs font-sans text-black font-bold hover:bg-black hover:text-white transition-all cursor-pointer active:scale-95 shadow-md"
                    >🔥 Launch Post</button>
                </div>
            </div>

            <!-- Pro Tip Callout Card -->
            <div class="bg-emerald-50 border-2 border-emerald-300 rounded-xl p-4 text-xs font-medium text-emerald-950 shadow-md">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-[#006c49] text-xl shrink-0 mt-0.5">lightbulb</span>
                    <div>
                        <h4 class="font-mono text-xs font-extrabold text-[#006c49] uppercase tracking-wider mb-1">LinkedIn Pro Tip</h4>
                        <p class="leading-relaxed font-sans text-gray-700">
                            Use bold Unicode formatting selectively on header hooks, key numbers, or bullet prefixes. Over-formatting entire paragraphs can reduce mobile readability and screen-reader accessibility.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Output Results Stack (7 cols) -->
        <div class="lg:col-span-7 flex flex-col gap-6 self-start bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 shadow-md">
            
            <!-- Category Filter Pills & Search Bar -->
            <div class="flex flex-col gap-4">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 border-b border-gray-300 pb-4">
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-bold font-sans text-black">Formatted Styles</h2>
                        <span class="font-mono text-xs font-extrabold text-[#006c49] bg-emerald-100 border border-emerald-300 px-2.5 py-0.5 rounded-full" x-text="`${filteredStyles.length} Styles`"></span>
                    </div>
                    
                    <!-- Search Input -->
                    <div class="relative w-full sm:w-48">
                        <input 
                            type="text" 
                            x-model="searchQuery" 
                            placeholder="Search styles..." 
                            class="w-full bg-white border-2 border-gray-300 rounded-xl pl-8 pr-3 py-1.5 text-xs font-sans text-black placeholder-gray-400 focus:outline-none focus:border-black"
                        />
                        <span class="material-symbols-outlined absolute left-2.5 top-2 text-gray-400 text-sm pointer-events-none">search</span>
                    </div>
                </div>

                <!-- Filter Pills -->
                <div class="flex flex-wrap items-center gap-2 font-mono text-xs">
                    <template x-for="cat in categories" :key="cat.id">
                        <button 
                            type="button"
                            x-on:click="selectedCategory = cat.id"
                            :class="selectedCategory === cat.id ? 'bg-black text-white border-black font-bold' : 'bg-white text-gray-700 border-gray-300 hover:border-black font-semibold'"
                            class="px-3 py-1.5 rounded-lg border-2 transition-all cursor-pointer shadow-md active:scale-95"
                            x-text="cat.name"
                        ></button>
                    </template>
                </div>
            </div>

            <!-- Generated Styles Stack -->
            <div class="space-y-4">
                <template x-for="styleObj in filteredStyles" :key="styleObj.key">
                    <div class="bg-white rounded-xl border-2 border-gray-300 p-5 group hover:border-black transition-all shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 mb-2 font-mono">
                                <span class="text-xs font-extrabold text-black uppercase tracking-wide" x-text="styleObj.name"></span>
                                <span class="text-[10px] font-extrabold text-[#006c49] bg-emerald-50 px-2 py-0.5 rounded border border-emerald-300/80" x-text="styleObj.sample"></span>
                            </div>
                            <div 
                                class="text-base sm:text-lg font-medium text-black select-all font-sans break-words min-h-[44px] bg-[#f8f9fa] p-3.5 rounded-xl border-2 border-gray-200 shadow-md leading-relaxed" 
                                x-text="convert(text, styleObj.key) || 'Your formatted text will appear here...'"
                            ></div>
                        </div>
                        <button 
                            type="button"
                            x-on:click="copyStyle(convert(text, styleObj.key), styleObj.key)"
                            :class="copiedStyle === styleObj.key ? 'bg-[#006c49] border-[#006c49] text-white' : 'bg-black border-black text-white hover:bg-gray-800'"
                            class="shrink-0 px-5 py-3 rounded-xl font-mono text-xs font-extrabold border-2 transition-all flex items-center justify-center gap-2 shadow-md cursor-pointer active:scale-95"
                        >
                            <span class="material-symbols-outlined text-[18px]" x-text="copiedStyle === styleObj.key ? 'check' : 'content_copy'"></span>
                            <span x-text="copiedStyle === styleObj.key ? 'COPIED!' : 'COPY'">COPY</span>
                        </button>
                    </div>
                </template>

                <!-- Empty Search Result -->
                <div x-show="filteredStyles.length === 0" class="bg-white border-2 border-gray-300 rounded-xl p-8 text-center text-gray-500 font-mono" x-cloak>
                    <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">search_off</span>
                    <p class="text-sm font-bold text-black mb-1">No Unicode styles matched your filter.</p>
                    <p class="text-xs text-gray-500">Try clearing your search query or selecting "All Styles".</p>
                </div>
            </div>

        </div>

    </div>

    <!-- Floating Copy Toast Notification -->
    <div 
        x-show="toastVisible" 
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-6 right-6 z-50 bg-black text-white border-2 border-[#006c49] rounded-xl px-5 py-3 shadow-2xl flex items-center gap-3 font-mono text-xs font-bold"
        x-cloak
    >
        <span class="material-symbols-outlined text-emerald-400 text-xl">check_circle</span>
        <span>Copied formatted Unicode text to clipboard!</span>
    </div>

    <!-- Educational & Best Practices Section -->
    <div class="mt-16 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-8 shadow-md">
        <h2 class="text-2xl font-extrabold text-black mb-4 font-sans flex items-center gap-2">
            <span class="material-symbols-outlined text-[#006c49]">auto_awesome</span>
            How LinkedIn &amp; X Unicode Formatting Works
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 font-sans text-sm">
            <div class="bg-white p-5 rounded-xl border-2 border-gray-300 shadow-md">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 border-2 border-emerald-200 flex items-center justify-center mb-3 text-[#006c49]">
                    <span class="material-symbols-outlined">font_download</span>
                </div>
                <h3 class="font-extrabold text-black mb-2">Mathematical Alphanumeric Symbols</h3>
                <p class="text-gray-600 leading-relaxed">
                    Unlike standard HTML tags (`&lt;b&gt;`), social platforms do not allow rich HTML in posts. This tool converts standard Latin letters into Unicode Mathematical Alphanumeric Symbols (U+1D400 block), which render natively across all modern devices.
                </p>
            </div>
            <div class="bg-white p-5 rounded-xl border-2 border-gray-300 shadow-md">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 border-2 border-emerald-200 flex items-center justify-center mb-3 text-[#006c49]">
                    <span class="material-symbols-outlined">trending_up</span>
                </div>
                <h3 class="font-extrabold text-black mb-2">Increase Hook Readability</h3>
                <p class="text-gray-600 leading-relaxed">
                    Adding bold formatting to the first line of your LinkedIn post creates a visual hierarchy in the newsfeed, catching the reader's eye before they scroll past or click "see more".
                </p>
            </div>
            <div class="bg-white p-5 rounded-xl border-2 border-gray-300 shadow-md">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 border-2 border-emerald-200 flex items-center justify-center mb-3 text-[#006c49]">
                    <span class="material-symbols-outlined">accessibility_new</span>
                </div>
                <h3 class="font-extrabold text-black mb-2">Accessibility Best Practices</h3>
                <p class="text-gray-600 leading-relaxed">
                    Screen readers interpret Unicode mathematical symbols letter-by-letter as math variables. Use bold formatting strategically for short hooks, stats, and section headers rather than long paragraphs.
                </p>
            </div>
        </div>
    </div>

    <!-- High-Converting PostPilot Promotional CTA Section -->
    <section class="mt-12 bg-gradient-to-br from-black via-gray-900 to-[#004d34] text-white rounded-[1rem] p-8 sm:p-12 border-2 border-black shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-[#006c49]/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-mono text-xs font-extrabold uppercase tracking-widest mb-4">
                    <span class="material-symbols-outlined text-[14px]">rocket_launch</span>
                    <span>PostPilot Engine</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight mb-3 font-sans leading-tight">
                    Format Once. Automate Your Content Pipeline.
                </h2>
                <p class="text-gray-300 text-sm sm:text-base leading-relaxed font-medium font-sans">
                    Stop manually copying and pasting bold text every single day. PostPilot auto-formats, schedules, and publishes your content across LinkedIn and X on complete autopilot.
                </p>
                <div class="mt-4 flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs text-gray-400 font-mono">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-emerald-400 text-[16px]">check_circle</span> No credit card required</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-emerald-400 text-[16px]">check_circle</span> 100% Free Trial</span>
                </div>
            </div>
            <div class="shrink-0">
                <a 
                    href="{{ route('register') }}" 
                    class="inline-flex items-center gap-2 px-8 py-4 bg-[#006c49] hover:bg-emerald-600 text-white font-extrabold rounded-xl text-base tracking-wide transition-all shadow-lg hover:shadow-emerald-900/40 transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer font-sans border-2 border-[#006c49]"
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
                    'question' => 'How does Unicode bold text work on LinkedIn?',
                    'answer' => 'Standard plain text editors on LinkedIn do not support rich text HTML tags like <b> or <i>. This tool converts regular Latin characters into Mathematical Alphanumeric Symbols from the Unicode standard. Because these styled characters are distinct Unicode code points, LinkedIn displays them as bold or italic text everywhere.'
                ],
                [
                    'question' => 'Is Unicode bold text accessible to screen readers?',
                    'answer' => 'Unicode mathematical symbols are designed for mathematical notation, so screen readers like NVDA or JAWS may pronounce them as individual mathematical symbols rather than plain words. To maintain accessibility for visually impaired users, use bold or italic formatting selectively on headlines, short hooks, and key numbers rather than entire paragraphs.'
                ],
                [
                    'question' => 'Does LinkedIn support native bold or italic formatting?',
                    'answer' => 'Currently, LinkedIn does not offer built-in rich text formatting options like bold or italic buttons in its post composer window. Using Unicode text converters like this generator is the standard method for adding stylized typography to your LinkedIn posts, articles, comments, and profile headline.'
                ],
                [
                    'question' => 'Will Unicode text affect my LinkedIn post reach?',
                    'answer' => 'Using Unicode bold text does not penalize your reach in the LinkedIn algorithm. In fact, strategic bold formatting on your hook line can improve stopping power, increase dwell time, and boost click-through rates. However, overusing styled characters can hinder readability, so keep formatting subtle and purposeful.'
                ],
                [
                    'question' => 'What Unicode styles are available in this tool?',
                    'answer' => 'Our converter provides 15 distinct font styles, including Sans-Serif Bold, Serif Bold, Sans-Serif Italic, Bold Italic, Monospace, Cursive Script, Bold Script, Double-Struck, Fraktur Gothic, Circled Bubble, Small Caps, Underline, and Strikethrough. You can copy any style instantly with one click.'
                ],
                [
                    'question' => 'Does this tool work for Facebook and Instagram too?',
                    'answer' => 'Yes! Unicode characters are universally supported across almost all modern social media platforms and messaging apps. You can copy and paste your formatted text directly into Facebook posts, Instagram captions and bios, X (Twitter) tweets, TikTok profiles, WhatsApp messages, and YouTube descriptions.'
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

<!-- Alpine.js Controller for Unicode Mathematical Transformations -->
<script>
function unicodeFormatter() {
    return {
        text: '',
        searchQuery: '',
        selectedCategory: 'all',
        copiedStyle: null,
        toastVisible: false,
        sampleText: "Growth Metric: ARR increased from $10,000 to $100,000 in 6 months.",
        bulletIcons: ['⚡', '🚀', '💡', '🔥', '✅', '📌', '👉', '📈', '❶', '❷', '❸', '🔹'],

        categories: [
            { id: 'all', name: 'All Styles' },
            { id: 'sans', name: 'Sans-Serif' },
            { id: 'serif', name: 'Serif' },
            { id: 'decorative', name: 'Decorative' },
            { id: 'special', name: 'Special' }
        ],

        stylesList: [
            { key: 'boldSans', name: 'Bold Sans-Serif', sample: '𝗕𝗼𝗹𝗱 𝗦𝗮𝗻𝘀', category: 'sans' },
            { key: 'italicSans', name: 'Italic Sans-Serif', sample: '𝘐𝘵𝘢𝘭𝘪𝘤 𝘚𝘢𝘯𝘴', category: 'sans' },
            { key: 'boldItalicSans', name: 'Bold Italic Sans', sample: '𝘽𝙤𝙡𝙙 𝙄𝙩𝙖𝙡𝙞𝙘', category: 'sans' },
            { key: 'boldSerif', name: 'Bold Serif', sample: '𝐁𝐨𝐥𝐝 𝐒𝐞𝐫𝐢𝐟', category: 'serif' },
            { key: 'italicSerif', name: 'Italic Serif', sample: '𝐼𝑡𝑎𝑙𝑖𝑐 𝑆𝑒𝑟𝑖𝑓', category: 'serif' },
            { key: 'boldItalicSerif', name: 'Bold Italic Serif', sample: '𝑩𝒐𝒍𝒅 𝑰𝒕𝒂𝒍𝒊𝒄', category: 'serif' },
            { key: 'monospace', name: 'Monospace', sample: '𝙼𝚘𝚗𝚘𝚜𝚙𝚊𝚌𝚎', category: 'decorative' },
            { key: 'script', name: 'Script (Cursive)', sample: '𝒮𝒸𝓇𝒾𝓅𝓉', category: 'decorative' },
            { key: 'boldScript', name: 'Bold Script', sample: '𝓡𝓸𝓓𝓯', category: 'decorative' },
            { key: 'doubleStruck', name: 'Double-Struck', sample: '𝔻𝕠𝕦𝕓𝕝𝕖', category: 'decorative' },
            { key: 'fraktur', name: 'Fraktur / Gothic', sample: '𝔉𝔯𝔞𝔨𝔱𝔲𝔯', category: 'decorative' },
            { key: 'circled', name: 'Circled Bubble', sample: 'Ⓒⓘⓡⓒⓛⓔⓓ', category: 'decorative' },
            { key: 'smallCaps', name: 'Small Caps', sample: 'ꜱᴍᴀʟʟ ᴄᴀᴘꜱ', category: 'special' },
            { key: 'underline', name: 'Underline', sample: 'U̲n̲d̲e̲r̲l̲i̲n̲e̲d̲', category: 'special' },
            { key: 'strikethrough', name: 'Strikethrough', sample: 'S̶t̶r̶i̶k̶e̶t̶h̶r̶o̶u̶g̶h̶', category: 'special' }
        ],

        get charCount() {
            return this.text ? Array.from(this.text).length : 0;
        },

        get charsNoSpaces() {
            return this.text ? Array.from(this.text.replace(/\s/g, '')).length : 0;
        },

        get wordCount() {
            if (!this.text || !this.text.trim()) return 0;
            return this.text.trim().split(/\s+/).filter(Boolean).length;
        },

        formatNumber(num) {
            return num ? num.toLocaleString() : '0';
        },

        get filteredStyles() {
            let list = this.stylesList;
            if (this.selectedCategory !== 'all') {
                list = list.filter(s => s.category === this.selectedCategory);
            }
            if (this.searchQuery.trim()) {
                const q = this.searchQuery.toLowerCase();
                list = list.filter(s => s.name.toLowerCase().includes(q) || s.sample.toLowerCase().includes(q));
            }
            return list;
        },

        loadSample() {
            this.text = this.sampleText;
        },

        clearText() {
            this.text = '';
            this.copiedStyle = null;
        },

        transformCase(mode) {
            if (!this.text) return;
            if (mode === 'upper') {
                this.text = this.text.toUpperCase();
            } else if (mode === 'lower') {
                this.text = this.text.toLowerCase();
            } else if (mode === 'title') {
                this.text = this.text.replace(/\w\S*/g, (w) => w.charAt(0).toUpperCase() + w.substr(1).toLowerCase());
            }
        },

        cleanSpaces() {
            if (!this.text) return;
            this.text = this.text.replace(/[ \t]+/g, ' ').trim();
        },

        prependSymbol(sym) {
            if (!this.text) {
                this.text = sym + ' ';
            } else {
                this.text = sym + ' ' + this.text;
            }
        },

        convert(input, styleKey) {
            if (!input) return '';

            // Combining marks and Small Caps
            if (styleKey === 'underline') {
                return Array.from(input).map(ch => ch === '\n' ? '\n' : ch + '\u0332').join('');
            }
            if (styleKey === 'strikethrough') {
                return Array.from(input).map(ch => ch === '\n' ? '\n' : ch + '\u0336').join('');
            }
            if (styleKey === 'smallCaps') {
                const smallCapsMap = {
                    'a': 'ᴀ', 'b': 'ʙ', 'c': 'ᴄ', 'd': 'ᴅ', 'e': 'ᴇ', 'f': 'ꜰ', 'g': 'ɢ',
                    'h': 'ʜ', 'i': 'ɪ', 'j': 'ᴊ', 'k': 'ᴋ', 'l': 'ʟ', 'm': 'ᴍ', 'n': 'ɴ',
                    'o': 'ᴏ', 'p': 'ᴘ', 'q': 'ꞯ', 'r': 'ʀ', 's': 'ꜱ', 't': 'ᴛ', 'u': 'ᴜ',
                    'v': 'ᴠ', 'w': 'ᴡ', 'x': 'x', 'y': 'ʏ', 'z': 'ᴢ'
                };
                return Array.from(input).map(ch => smallCapsMap[ch.toLowerCase()] || ch).join('');
            }
            if (styleKey === 'circled') {
                return Array.from(input).map(ch => {
                    if (ch.length > 1) return ch;
                    const code = ch.charCodeAt(0);
                    if (code >= 65 && code <= 90) return String.fromCodePoint(0x24B6 + (code - 65));
                    if (code >= 97 && code <= 122) return String.fromCodePoint(0x24D0 + (code - 97));
                    if (code >= 49 && code <= 57) return String.fromCodePoint(0x2460 + (code - 49));
                    if (code === 48) return String.fromCodePoint(0x24EA);
                    return ch;
                }).join('');
            }

            const maps = {
                boldSans: { uppercase: 0x1D5A0, lowercase: 0x1D5BA, digits: 0x1D7E2 },
                italicSans: { uppercase: 0x1D608, lowercase: 0x1D622 },
                boldItalicSans: { uppercase: 0x1D63C, lowercase: 0x1D656 },
                boldSerif: { uppercase: 0x1D400, lowercase: 0x1D41A, digits: 0x1D7CE },
                italicSerif: { uppercase: 0x1D434, lowercase: 0x1D44E },
                boldItalicSerif: { uppercase: 0x1D468, lowercase: 0x1D482 },
                monospace: { uppercase: 0x1D670, lowercase: 0x1D68A, digits: 0x1D7F6 },
                script: { uppercase: 0x1D49C, lowercase: 0x1D4B6 },
                boldScript: { uppercase: 0x1D4D0, lowercase: 0x1D4EA },
                doubleStruck: { uppercase: 0x1D538, lowercase: 0x1D552, digits: 0x1D7D8 },
                fraktur: { uppercase: 0x1D504, lowercase: 0x1D51E }
            };

            // BMP exception code points for mathematical alphanumeric symbols
            const exceptions = {
                italicSerif: { 'h': 0x210E }, // Planck constant
                script: {
                    'B': 0x212C, 'E': 0x2130, 'F': 0x2131, 'H': 0x210B, 'I': 0x2110,
                    'L': 0x2112, 'M': 0x2133, 'R': 0x211B, 'e': 0x212F, 'g': 0x210A,
                    'o': 0x2134
                },
                fraktur: { 'C': 0x212D, 'H': 0x210C, 'I': 0x2111, 'R': 0x211C, 'Z': 0x2128 },
                doubleStruck: {
                    'C': 0x2102, 'H': 0x210D, 'N': 0x2115, 'P': 0x2119, 'Q': 0x211A,
                    'R': 0x211D, 'Z': 0x2124
                }
            };

            const m = maps[styleKey];
            if (!m) return input;

            const ex = exceptions[styleKey] || {};

            return Array.from(input).map(ch => {
                if (ex[ch]) return String.fromCodePoint(ex[ch]);
                if (ch.length > 1) return ch; // BMP surrogate pair safety: preserve emojis/multibyte chars intact

                const code = ch.charCodeAt(0);
                if (m.uppercase && code >= 65 && code <= 90) {
                    return String.fromCodePoint(m.uppercase + (code - 65));
                }
                if (m.lowercase && code >= 97 && code <= 122) {
                    return String.fromCodePoint(m.lowercase + (code - 97));
                }
                if (m.digits && code >= 48 && code <= 57) {
                    return String.fromCodePoint(m.digits + (code - 48));
                }
                return ch;
            }).join('');
        },

        fallbackCopy(text) {
            let textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            return new Promise((resolve, reject) => {
                const successful = document.execCommand('copy');
                textArea.remove();
                successful ? resolve() : reject();
            });
        },

        copyStyle(formattedText, styleKey) {
            if (!formattedText) return;
            
            const doSuccess = () => {
                this.copiedStyle = styleKey;
                this.toastVisible = true;
                setTimeout(() => {
                    this.copiedStyle = null;
                    this.toastVisible = false;
                }, 2500);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(formattedText).then(doSuccess).catch(() => {
                    this.fallbackCopy(formattedText).then(doSuccess).catch(() => {});
                });
            } else {
                this.fallbackCopy(formattedText).then(doSuccess).catch(() => {});
            }
        }
    };
}
</script>
@endsection
