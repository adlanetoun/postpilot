@extends('layouts.tool')

@section('title', $seo['title'] ?? 'Free LinkedIn Post Preview Tool [No Sign-Up] – See More Fold Checker | PostPilot')
@section('meta_description', $seo['meta_description'] ?? 'Preview exactly where LinkedIn truncates your post with the "see more" button. Free desktop & mobile simulator. No sign-up, no limits, instant results ➔')
@section('tool_name', 'Free LinkedIn Post Preview & See More Fold Checker')
@section('tool_route', 'tools.linkedin-preview')

@section('schema_json')
    @php
        $schemaFaqs = [
            [
                'question' => 'What is a LinkedIn post preview tool?',
                'answer' => 'A LinkedIn post preview tool is a free web utility that lets you test and visualize how your post content will appear live in the LinkedIn feed before publishing. It simulates desktop and mobile views, character counts, line breaks, and truncated text cutoffs so you can craft high-performing content without formatting surprises.'
            ],
            [
                'question' => 'How does the LinkedIn \'See More\' button work?',
                'answer' => 'LinkedIn automatically truncates post copy with a "...see more" link to save feed space and encourage reader interaction. If your hook or introduction exceeds LinkedIn\'s visible line or character threshold, the remainder of your post is hidden until a reader clicks the button. Optimizing text above this fold line ensures maximum impact.'
            ],
            [
                'question' => 'How many characters does LinkedIn show before truncating?',
                'answer' => 'On desktop displays, LinkedIn typically shows around 210 characters or up to 5 lines of text before inserting the "...see more" cutoff. On mobile devices, text truncates faster—usually around 140 characters or 3 lines. Keep your primary hook within these limits to hook readers immediately.'
            ],
            [
                'question' => 'Does this tool store my post content?',
                'answer' => 'No, your post content is processed entirely in your web browser using client-side JavaScript. None of your text, drafts, or ideas are transmitted to external servers, saved in databases, or logged anywhere, guaranteeing complete privacy and data security for your content.'
            ],
            [
                'question' => 'Can I preview mobile and desktop LinkedIn posts?',
                'answer' => 'Yes, our preview tool offers instant toggles between desktop and mobile feed simulation modes. Switching views allows you to check exact line breaks, font scaling, and truncated fold line positions across both screen types so your post looks clean for all LinkedIn users.'
            ],
            [
                'question' => 'How to format LinkedIn posts for maximum engagement?',
                'answer' => 'To maximize engagement, place your strongest value proposition or hook in the first 3 lines before the fold. Use short paragraphs (1-2 sentences), bullet points, and generous white space to enhance readability. End with a clear call-to-action or conversation starter, and add 3 to 5 relevant hashtags at the bottom.'
            ],
        ];
    @endphp
    <x-seo.faq-schema :faqs="$schemaFaqs" />
@endsection

@section('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<style>
    [x-cloak] {
        display: none !important;
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 1;
    }
    textarea::-webkit-scrollbar {
        width: 8px;
    }
    textarea::-webkit-scrollbar-track {
        background: #e5e7eb;
        border-radius: 4px;
    }
    textarea::-webkit-scrollbar-thumb {
        background: #9ca3af;
        border-radius: 4px;
    }
    textarea::-webkit-scrollbar-thumb:hover {
        background: #4b5563;
    }
</style>
@endsection

@section('content')
<div class="mb-12 font-sans" x-data="linkedinPreview()">
    <!-- Toast Notification Popup -->
    <div 
        x-show="toastShow" 
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-4"
        x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-4"
        class="fixed bottom-5 right-5 z-50 bg-black text-white px-5 py-3.5 rounded-xl border-2 border-gray-800 shadow-2xl flex items-center gap-3 font-mono text-xs font-bold"
        x-cloak
    >
        <span class="material-symbols-outlined text-[#006c49] text-[20px]">check_circle</span>
        <span x-text="toastMsg">Action completed successfully!</span>
    </div>

    <!-- Centered Hero Section -->
    <section class="flex flex-col items-center text-center gap-4 max-w-3xl mx-auto mb-10 font-sans">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#006c49]/10 border border-[#006c49]/30 rounded-full shadow-md">
            <span class="material-symbols-outlined text-[16px] text-[#006c49]">verified</span>
            <span class="font-mono text-xs text-[#006c49] uppercase tracking-wider font-extrabold">LINKEDIN TOOLS • 100% FREE &amp; CLIENT-SIDE</span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-black tracking-tight leading-tight font-sans text-center">
            {{ $seo['h1'] ?? 'LinkedIn Post Preview & Fold Checker' }}
        </h1>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl font-medium leading-relaxed text-center font-sans">
            Preview how your LinkedIn posts will look on desktop &amp; mobile before publishing. Check the exact "...see more" fold cutoff, line breaks, formatting, and character limits.
        </p>
    </section>

    {{-- GEO / Answer-First Content --}}
    <div class="max-w-3xl mx-auto mb-8 px-4 sm:px-0">
        <p class="text-[15px] leading-relaxed text-gray-700 font-medium bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <strong>What is this tool?</strong> {{ $seo['answer_first'] ?? 'The LinkedIn Post Preview is a free utility that simulates how your post will render on desktop and mobile feeds before publishing. Content creators use it to eliminate awkward line breaks and prevent truncated hooks. By accurately previewing the "...see more" fold cutoff, it ensures your critical opening message drives maximum reader engagement.' }}
        </p>
    </div>

    <!-- Quick Sample Hooks Selector Bar -->
    <div class="mb-8 flex flex-wrap items-center gap-2.5 bg-[#f8f9fa] p-4 rounded-[1rem] border-2 border-gray-300 shadow-md">
        <span class="text-xs font-mono font-extrabold text-[#4c4546] uppercase tracking-wider mr-1 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px] text-[#006c49]">auto_awesome</span>
            Load Sample:
        </span>
        <button 
            type="button" 
            x-on:click="loadSample('default')" 
            class="text-xs bg-white text-black font-extrabold px-3.5 py-2 rounded-xl border-2 border-gray-300 hover:border-black hover:bg-black hover:text-white transition-all cursor-pointer shadow-md active:scale-95 flex items-center gap-1"
        >
            🚀 Growth Hook
        </button>
        <button 
            type="button" 
            x-on:click="loadSample('story')" 
            class="text-xs bg-white text-black font-extrabold px-3.5 py-2 rounded-xl border-2 border-gray-300 hover:border-black hover:bg-black hover:text-white transition-all cursor-pointer shadow-md active:scale-95 flex items-center gap-1"
        >
            💡 Founder Story
        </button>
        <button 
            type="button" 
            x-on:click="loadSample('metric')" 
            class="text-xs bg-white text-black font-extrabold px-3.5 py-2 rounded-xl border-2 border-gray-300 hover:border-black hover:bg-black hover:text-white transition-all cursor-pointer shadow-md active:scale-95 flex items-center gap-1"
        >
            📈 ARR Metric
        </button>
        <button 
            type="button" 
            x-on:click="loadSample('carousel')" 
            class="text-xs bg-white text-black font-extrabold px-3.5 py-2 rounded-xl border-2 border-gray-300 hover:border-black hover:bg-black hover:text-white transition-all cursor-pointer shadow-md active:scale-95 flex items-center gap-1"
        >
            🔄 Carousel Teaser
        </button>
        <button 
            type="button" 
            x-on:click="clearText()" 
            x-show="text.length > 0"
            class="text-xs text-gray-500 hover:text-red-600 font-mono font-bold uppercase tracking-wider ml-auto transition-colors cursor-pointer flex items-center gap-1"
            x-cloak
        >
            <span class="material-symbols-outlined text-[15px]">delete</span>
            Clear Text
        </button>
    </div>

    <!-- Main Workspace Grid (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Editor Pane -->
        <div class="lg:col-span-6 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md flex flex-col justify-between space-y-6">
            <div>
                <!-- Editor Top Header -->
                <div class="flex items-center justify-between mb-4 border-b border-gray-300 pb-3">
                    <label for="postEditor" class="text-xs font-extrabold uppercase tracking-wider text-black flex items-center gap-2 font-mono">
                        <span class="material-symbols-outlined text-[18px] text-[#006c49]">edit_note</span>
                        <span>Write or Paste Your Post</span>
                    </label>
                    <div 
                        class="px-3.5 py-1 rounded-full flex items-center gap-1.5 font-mono text-[11px] font-extrabold uppercase tracking-wider transition-colors shadow-md border"
                        :class="isCutoff ? 'bg-amber-100 text-amber-900 border-amber-300' : 'bg-emerald-100 text-[#006c49] border-emerald-300'"
                        id="foldBadge"
                    >
                        <span class="material-symbols-outlined text-[15px]" x-text="isCutoff ? 'warning' : 'check_circle'"></span>
                        <span x-text="isCutoff ? 'Fold Truncated' : 'Fold Safe'">Fold Safe</span>
                    </div>
                </div>

                <!-- Editor Textarea & Fold Line Overlay -->
                <div class="relative">
                    <!-- Fold Cutoff Line Indicator Overlay -->
                    <div 
                        class="absolute left-0 right-0 h-px border-b-2 border-dashed border-amber-500/80 z-10 pointer-events-none transition-opacity duration-200" 
                        style="top: 120px;" 
                        x-show="text.length > 0 && isCutoff"
                        x-cloak
                    >
                        <span class="absolute right-3 -top-3.5 bg-amber-500 text-white font-mono text-[10px] font-extrabold px-2.5 py-0.5 rounded-full shadow-md flex items-center gap-1">
                            <span class="material-symbols-outlined text-[12px]">content_cut</span>
                            ...see more fold line (~<span x-text="foldLimit">210</span> chars / <span x-text="lineLimit">5</span> lines)
                        </span>
                    </div>

                    <textarea 
                        id="postEditor"
                        x-model="text"
                        rows="11"
                        placeholder="Start typing your LinkedIn post here...&#10;&#10;Pro tip: Keep your first 3-5 lines punchy. This is your hook before the '...see more' link appears."
                        class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-[#006c49]/20 rounded-xl p-4 text-sm text-gray-900 placeholder-gray-400 font-sans leading-relaxed resize-y focus:outline-none transition-all shadow-md"
                    ></textarea>
                </div>

                <!-- Real-Time Metrics Grid -->
                <div class="mt-5 grid grid-cols-2 sm:grid-cols-4 gap-3 font-mono">
                    <div class="bg-white p-3.5 rounded-xl border-2 border-gray-300 text-center hover:border-gray-400 transition-colors shadow-md">
                        <div class="text-[10px] text-[#4c4546] mb-0.5 uppercase font-extrabold font-sans">Characters</div>
                        <div class="text-lg font-extrabold" :class="charCount > charLimit ? 'text-red-600' : 'text-black'" id="charCount">
                            <span x-text="charCount">0</span><span class="text-xs text-gray-400 font-normal"> / 3k</span>
                        </div>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border-2 border-gray-300 text-center hover:border-gray-400 transition-colors shadow-md">
                        <div class="text-[10px] text-[#4c4546] mb-0.5 uppercase font-extrabold font-sans">Words</div>
                        <div class="text-lg font-extrabold text-black" id="wordCount" x-text="wordCount">0</div>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border-2 border-gray-300 text-center hover:border-gray-400 transition-colors shadow-md">
                        <div class="text-[10px] text-[#4c4546] mb-0.5 uppercase font-extrabold font-sans">Lines</div>
                        <div class="text-lg font-extrabold text-black" id="lineCount">
                            <span x-text="lineCount">0</span><span class="text-xs text-gray-400 font-normal"> / <span x-text="lineLimit">5</span></span>
                        </div>
                    </div>
                    <div class="bg-white p-3.5 rounded-xl border-2 border-gray-300 text-center hover:border-gray-400 transition-colors shadow-md">
                        <div class="text-[10px] text-[#4c4546] mb-0.5 uppercase font-extrabold font-sans">Hashtags</div>
                        <div class="text-lg font-extrabold text-[#006c49]" id="tagCount" x-text="tagCount">0</div>
                    </div>
                </div>

                <!-- Extracted Hashtags Pills Box -->
                <div class="mt-4 p-3.5 bg-white rounded-xl border-2 border-gray-300 shadow-md" x-show="hashtags.length > 0" x-cloak>
                    <span class="text-[11px] font-mono font-extrabold text-[#4c4546] uppercase tracking-wider block mb-2">Detected Hashtags:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <template x-for="tag in hashtags" :key="tag">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-bold bg-emerald-50 text-[#006c49] border border-emerald-300" x-text="tag"></span>
                        </template>
                    </div>
                </div>

                <!-- Hook Strength Analysis Score Box -->
                <div class="mt-5 bg-white p-5 rounded-xl border-2 border-gray-300 shadow-md space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px] text-[#006c49]">equalizer</span>
                            <span class="text-xs font-extrabold uppercase font-mono tracking-wider text-black">Hook Strength Analysis</span>
                        </div>
                        <span 
                            class="px-2.5 py-1 rounded-full text-[11px] font-mono font-extrabold uppercase tracking-wider border"
                            :class="hookAnalysis.badgeClass"
                            x-text="hookAnalysis.label"
                        ></span>
                    </div>

                    <!-- Progress Score Bar -->
                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-xs font-mono font-bold text-gray-700">
                            <span>Engagement Score</span>
                            <span x-text="hookAnalysis.score + '/100'">0/100</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                            <div 
                                class="h-2.5 rounded-full transition-all duration-500" 
                                :class="hookAnalysis.barClass" 
                                :style="'width: ' + hookAnalysis.score + '%'"
                            ></div>
                        </div>
                    </div>

                    <!-- Actionable Optimization Tips -->
                    <div class="pt-2 border-t border-gray-200">
                        <span class="text-[11px] font-mono font-extrabold text-gray-500 uppercase tracking-wider block mb-1.5">Optimization Tips:</span>
                        <ul class="space-y-1">
                            <template x-for="tip in hookAnalysis.tips" :key="tip">
                                <li class="text-xs text-gray-700 font-medium flex items-start gap-1.5">
                                    <span class="material-symbols-outlined text-[14px] text-[#006c49] shrink-0 mt-0.5">check_small</span>
                                    <span x-text="tip"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <!-- Fold Cutoff Notice Box -->
                <div class="mt-4 p-4 rounded-xl text-xs font-medium leading-relaxed border-2 transition-all shadow-md"
                    :class="isCutoff ? 'bg-amber-50 border-amber-300 text-amber-950' : 'bg-emerald-50 border-emerald-300 text-emerald-950'">
                    <div class="flex items-center gap-1.5 mb-1 font-extrabold font-mono text-[11px] uppercase tracking-wider"
                        :class="isCutoff ? 'text-amber-900' : 'text-[#006c49]'">
                        <span class="material-symbols-outlined text-[16px]" x-text="isCutoff ? 'analytics' : 'thumb_up'"></span>
                        <span x-text="isCutoff ? 'Fold Cutoff Notice' : 'Hook Optimization'"></span>
                    </div>
                    <template x-if="isCutoff">
                        <span>Your hook exceeds the <strong x-text="mode">desktop</strong> fold cutoff (<span x-text="foldLimit">210</span> chars or <span x-text="lineLimit">5</span> lines). Readers will need to click <em>"...see more"</em> to read the rest. Make sure your lines 1-3 contain your highest-value curiosity trigger!</span>
                    </template>
                    <template x-if="!isCutoff">
                        <span>Your entire hook is fully visible above the fold on <strong x-text="mode">desktop</strong>! No content will be hidden behind <em>"...see more"</em> before the main message.</span>
                    </template>
                </div>
            </div>

            <!-- Action Toolbar -->
            <div class="pt-5 border-t border-gray-300 flex flex-wrap items-center justify-between gap-3">
                <button 
                    type="button"
                    x-on:click="cleanWhitespace()"
                    class="py-3 px-4 border-2 border-gray-300 rounded-xl text-black bg-white font-mono font-extrabold text-xs uppercase tracking-wider hover:border-black hover:bg-gray-100 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-md active:scale-95" 
                    id="cleanBtn"
                >
                    <span class="material-symbols-outlined text-[18px] text-[#006c49]">cleaning_services</span>
                    Clean Spaces
                </button>

                <button 
                    type="button"
                    x-on:click="copyText()"
                    :disabled="!text"
                    :class="copied ? 'bg-emerald-600 hover:bg-emerald-700 text-white border-2 border-emerald-600' : (!text ? 'bg-gray-200 text-gray-400 border-2 border-gray-300 cursor-not-allowed' : 'bg-black hover:bg-gray-800 text-white border-2 border-black active:scale-95')"
                    class="py-3 px-6 rounded-xl font-mono font-extrabold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 cursor-pointer shadow-md" 
                    id="copyBtn"
                >
                    <span class="material-symbols-outlined text-[18px]" x-text="copied ? 'done' : 'content_copy'"></span>
                    <span x-text="copied ? 'Copied to Clipboard!' : 'Copy Post Text'">Copy Post Text</span>
                </button>
            </div>
        </div>

        <!-- Right Column: Live Feed Preview Card Pane -->
        <div class="lg:col-span-6 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 flex flex-col items-center self-start shadow-md">
            <div class="w-full flex items-center justify-between mb-6 pb-3 border-b border-gray-300">
                <h2 class="font-mono text-xs text-black uppercase tracking-widest font-extrabold flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-[#006c49]">devices</span>
                    <span>Live Feed Preview</span>
                </h2>

                <!-- Desktop / Mobile Mode Switcher -->
                <div class="flex bg-white rounded-xl p-1 border-2 border-gray-300 font-mono shadow-md">
                    <button 
                        type="button"
                        x-on:click="mode = 'desktop'; expanded = false"
                        :class="mode === 'desktop' ? 'bg-black text-white font-extrabold shadow-md' : 'text-[#4c4546] hover:text-black font-semibold'"
                        class="px-3.5 py-1.5 rounded-lg text-xs tracking-wider transition-all cursor-pointer flex items-center gap-1.5" 
                        id="desktopToggle"
                    >
                        <span class="material-symbols-outlined text-[14px]">desktop_windows</span>
                        DESKTOP
                    </button>
                    <button 
                        type="button"
                        x-on:click="mode = 'mobile'; expanded = false"
                        :class="mode === 'mobile' ? 'bg-black text-white font-extrabold shadow-md' : 'text-[#4c4546] hover:text-black font-semibold'"
                        class="px-3.5 py-1.5 rounded-lg text-xs tracking-wider transition-all cursor-pointer flex items-center gap-1.5" 
                        id="mobileToggle"
                    >
                        <span class="material-symbols-outlined text-[14px]">smartphone</span>
                        MOBILE
                    </button>
                </div>
            </div>

            <!-- LinkedIn Feed Post Container Mockup -->
            <div 
                class="w-full transition-all duration-300 ease-in-out" 
                :class="mode === 'mobile' ? 'max-w-[360px]' : 'max-w-[552px]'" 
                id="previewContainer"
            >
                <div class="bg-white rounded-xl border-2 border-gray-300 shadow-md overflow-hidden flex flex-col">
                    <!-- LinkedIn Profile Header -->
                    <div class="p-4 flex items-start gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#006c49] to-black text-white flex items-center justify-center shrink-0 font-extrabold text-base font-sans shadow-md border border-emerald-500/20">
                            PP
                        </div>
                        <div class="flex-grow pt-0.5 font-sans min-w-0">
                            <div class="flex items-center gap-1">
                                <span class="font-bold text-gray-900 text-[14px] leading-tight hover:text-[#006c49] hover:underline cursor-pointer truncate">Jane Doe</span>
                                <span class="text-gray-500 text-[13px]">• 1st</span>
                            </div>
                            <div class="text-gray-500 text-[12px] leading-tight mt-0.5 truncate font-normal">Founder &amp; Content Strategist @ PostPilot | 10k+ Audience</div>
                            <div class="text-gray-400 text-[11px] flex items-center gap-1 mt-1 font-mono">
                                1h • <span class="material-symbols-outlined text-[13px]">public</span>
                            </div>
                        </div>
                        <button type="button" class="text-gray-400 hover:bg-gray-100 p-1 rounded-full transition-colors shrink-0 cursor-pointer">
                            <span class="material-symbols-outlined text-[20px]">more_horiz</span>
                        </button>
                    </div>

                    <!-- LinkedIn Post Content Body -->
                    <div class="px-4"><div class="text-gray-900 text-[14px] leading-relaxed break-words font-sans" id="previewText"><template x-if="!text || text.length === 0"><span class="text-gray-400 italic font-normal block py-3">Start typing your LinkedIn post in the editor to see your live preview here...</span></template><template x-if="text && text.length > 0"><div><span class="whitespace-pre-wrap" x-text="displayedText"></span><template x-if="isCutoff && !expanded"><button type="button" x-on:click="expanded = true" id="seeMoreBtn" class="text-gray-500 hover:text-black hover:underline text-[14px] ml-1 cursor-pointer font-bold inline-block">…see more</button></template><template x-if="isCutoff && expanded"><div class="mt-2 text-right"><button type="button" x-on:click="expanded = false" class="text-xs text-gray-400 hover:text-gray-700 underline cursor-pointer font-mono">(Collapse preview)</button></div></template></div></template></div></div>

                    <!-- LinkedIn Reactions Bar -->
                    <div class="px-4 py-2 flex items-center justify-between border-b border-t border-gray-100 mx-4 mt-2 text-gray-500 text-[12px] font-sans">
                        <div class="flex items-center gap-1.5">
                            <div class="flex -space-x-1">
                                <div class="w-4 h-4 rounded-full bg-blue-600 flex items-center justify-center border border-white z-20 text-[9px] text-white">👍</div>
                                <div class="w-4 h-4 rounded-full bg-red-500 flex items-center justify-center border border-white z-10 text-[9px] text-white">❤️</div>
                                <div class="w-4 h-4 rounded-full bg-emerald-600 flex items-center justify-center border border-white z-0 text-[9px] text-white">👏</div>
                            </div>
                            <span class="hover:text-[#006c49] hover:underline cursor-pointer font-medium ml-1">42</span>
                        </div>
                        <div class="hover:text-[#006c49] hover:underline cursor-pointer font-medium text-[12px]">
                            12 comments • 3 reposts
                        </div>
                    </div>

                    <!-- LinkedIn Action Buttons Bar -->
                    <div class="px-2 py-1 flex justify-between text-gray-600 font-sans">
                        <button type="button" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 hover:bg-gray-100 rounded-lg transition-colors text-[13px] font-bold cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">thumb_up</span> Like
                        </button>
                        <button type="button" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 hover:bg-gray-100 rounded-lg transition-colors text-[13px] font-bold cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">chat_bubble_outline</span> Comment
                        </button>
                        <button type="button" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 hover:bg-gray-100 rounded-lg transition-colors text-[13px] font-bold cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">repeat</span> Repost
                        </button>
                        <button type="button" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 hover:bg-gray-100 rounded-lg transition-colors text-[13px] font-bold cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">send</span> Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Best Practices & Educational Insights Section -->
    <div class="mt-16 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-10 shadow-md">
        <h2 class="text-xl sm:text-2xl font-extrabold text-black tracking-tight mb-6 font-sans flex items-center gap-2">
            <span class="material-symbols-outlined text-[#006c49]">insights</span>
            LinkedIn Post Optimization Best Practices
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-5 rounded-xl border-2 border-gray-300 shadow-md">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#006c49] flex items-center justify-center font-mono font-extrabold text-sm mb-3">1</div>
                <h3 class="font-extrabold text-black text-base mb-2 font-sans">The 3-Line Golden Rule</h3>
                <p class="text-gray-600 text-xs leading-relaxed font-medium">
                    Over 80% of LinkedIn feed readers never click "...see more". Your first 3 lines must deliver a high-impact hook or curiosity gap to earn the click.
                </p>
            </div>
            <div class="bg-white p-5 rounded-xl border-2 border-gray-300 shadow-md">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#006c49] flex items-center justify-center font-mono font-extrabold text-sm mb-3">2</div>
                <h3 class="font-extrabold text-black text-base mb-2 font-sans">Mobile-First Formatting</h3>
                <p class="text-gray-600 text-xs leading-relaxed font-medium">
                    Mobile screens truncate text at ~140 characters or 3 lines. Keep paragraphs short (1-2 lines) with generous line breaks to prevent wall-of-text fatigue.
                </p>
            </div>
            <div class="bg-white p-5 rounded-xl border-2 border-gray-300 shadow-md">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#006c49] flex items-center justify-center font-mono font-extrabold text-sm mb-3">3</div>
                <h3 class="font-extrabold text-black text-base mb-2 font-sans">Strategic Hashtags</h3>
                <p class="text-gray-600 text-xs leading-relaxed font-medium">
                    Use 3 to 5 targeted hashtags placed at the bottom of your post. Avoid clogging your hook with tags so your core message stays clean.
                </p>
            </div>
        </div>
    </div>

    <!-- High-Converting PostPilot Promotional CTA Section -->
    <div class="mt-12 bg-gradient-to-br from-black via-gray-900 to-[#004d34] text-white rounded-[1rem] p-8 sm:p-12 border-2 border-gray-800 shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-[#006c49]/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-mono text-xs font-extrabold uppercase tracking-widest mb-4">
                    <span class="material-symbols-outlined text-[14px]">rocket_launch</span>
                    <span>PostPilot Engine</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight mb-3 font-sans leading-tight">
                    30 Days of Content. Published on Autopilot with PostPilot.
                </h2>
                <p class="text-gray-300 text-sm sm:text-base leading-relaxed font-medium">
                    Stop manually formatting hooks and writing posts one by one. PostPilot generates, formats, and schedules 30 days of high-converting LinkedIn posts automatically.
                </p>
                <div class="mt-4 flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs text-gray-400 font-mono">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-emerald-400 text-[16px]">check_circle</span> No credit card required</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-emerald-400 text-[16px]">check_circle</span> Instant setup</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-emerald-400 text-[16px]">check_circle</span> Multi-platform publishing</span>
                </div>
            </div>
            <div class="shrink-0">
                <a 
                    href="{{ route('register') }}" 
                    class="inline-flex items-center gap-2 px-8 py-4 bg-[#006c49] hover:bg-emerald-600 text-white font-extrabold rounded-xl border-2 border-[#006c49] text-base tracking-wide transition-all shadow-lg hover:shadow-emerald-900/40 transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer font-sans"
                >
                    <span>Start Free Trial →</span>
                </a>
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
                    'question' => 'What is a LinkedIn post preview tool?',
                    'answer' => 'A LinkedIn post preview tool is a free web utility that lets you test and visualize how your post content will appear live in the LinkedIn feed before publishing. It simulates desktop and mobile views, character counts, line breaks, and truncated text cutoffs so you can craft high-performing content without formatting surprises.'
                ],
                [
                    'question' => 'How does the LinkedIn \'See More\' button work?',
                    'answer' => 'LinkedIn automatically truncates post copy with a "...see more" link to save feed space and encourage reader interaction. If your hook or introduction exceeds LinkedIn\'s visible line or character threshold, the remainder of your post is hidden until a reader clicks the button. Optimizing text above this fold line ensures maximum impact.'
                ],
                [
                    'question' => 'How many characters does LinkedIn show before truncating?',
                    'answer' => 'On desktop displays, LinkedIn typically shows around 210 characters or up to 5 lines of text before inserting the "...see more" cutoff. On mobile devices, text truncates faster—usually around 140 characters or 3 lines. Keep your primary hook within these limits to hook readers immediately.'
                ],
                [
                    'question' => 'Does this tool store my post content?',
                    'answer' => 'No, your post content is processed entirely in your web browser using client-side JavaScript. None of your text, drafts, or ideas are transmitted to external servers, saved in databases, or logged anywhere, guaranteeing complete privacy and data security for your content.'
                ],
                [
                    'question' => 'Can I preview mobile and desktop LinkedIn posts?',
                    'answer' => 'Yes, our preview tool offers instant toggles between desktop and mobile feed simulation modes. Switching views allows you to check exact line breaks, font scaling, and truncated fold line positions across both screen types so your post looks clean for all LinkedIn users.'
                ],
                [
                    'question' => 'How to format LinkedIn posts for maximum engagement?',
                    'answer' => 'To maximize engagement, place your strongest value proposition or hook in the first 3 lines before the fold. Use short paragraphs (1-2 sentences), bullet points, and generous white space to enhance readability. End with a clear call-to-action or conversation starter, and add 3 to 5 relevant hashtags at the bottom.'
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

<!-- Alpine.js Controller -->
<script>
function linkedinPreview() {
    return {
        text: '',
        mode: 'desktop',
        expanded: false,
        copied: false,
        toastShow: false,
        toastMsg: '',

        get charCount() {
            return this.text ? this.text.length : 0;
        },

        get wordCount() {
            if (!this.text || !this.text.trim()) return 0;
            return this.text.trim().split(/\s+/).filter(Boolean).length;
        },

        get lineCount() {
            if (!this.text) return 0;
            return this.text.split(/\r\n|\r|\n/).length;
        },

        get tagCount() {
            return this.hashtags.length;
        },

        get hashtags() {
            if (!this.text) return [];
            const matches = this.text.match(/#[a-zA-Z0-9_\u00C0-\u024F]+/g);
            return matches ? [...new Set(matches)] : [];
        },

        get foldLimit() {
            return this.mode === 'mobile' ? 140 : 210;
        },

        get lineLimit() {
            return this.mode === 'mobile' ? 3 : 5;
        },

        get charLimit() {
            return 3000;
        },

        get isCutoff() {
            if (!this.text) return false;
            return this.lineCount > this.lineLimit || this.charCount > this.foldLimit;
        },

        get displayedText() {
            if (!this.text) return '';
            let sanitized = this.text.replace(/^(\s*\n)+/, '').replace(/(\n\s*)+$/, '');
            if (!sanitized) return '';
            if (!this.isCutoff || this.expanded) {
                return sanitized;
            }
            let lines = sanitized.split(/\r\n|\r|\n/);
            if (lines.length > this.lineLimit) {
                let sliced = lines.slice(0, this.lineLimit).join('\n');
                if (sliced.length > this.foldLimit) {
                    return sliced.substring(0, this.foldLimit);
                }
                return sliced;
            }
            return sanitized.substring(0, this.foldLimit);
        },

        get hookAnalysis() {
            if (!this.text || !this.text.trim()) {
                return {
                    score: 0,
                    label: 'No Hook Detected',
                    badgeClass: 'bg-gray-100 text-gray-600 border-gray-300',
                    barClass: 'bg-gray-300',
                    tips: ['Start typing to see your hook strength analysis.']
                };
            }

            let score = 0;
            let tips = [];
            const lines = this.text.trim().split(/\r\n|\r|\n/);
            const firstLine = lines[0] || '';

            // 1. First line length check
            if (firstLine.length >= 10 && firstLine.length <= 75) {
                score += 25;
            } else if (firstLine.length > 75) {
                score += 10;
                tips.push('First line is long. Shorten line 1 (< 70 chars) to make your hook punchier.');
            } else {
                score += 10;
                tips.push('First line is very short. Add a clear promise or curiosity trigger.');
            }

            // 2. Fold cutoff status check
            if (!this.isCutoff) {
                score += 25;
            } else {
                score += 10;
                tips.push('Hook is truncated by fold line. Ensure your key teaser is visible before "...see more".');
            }

            // 3. Number or Metric check
            if (/\d+/.test(firstLine) || /\d+/.test(this.text.substring(0, 200))) {
                score += 20;
            } else {
                tips.push('Add numbers or metrics (e.g. "$100k", "3 steps", "80%") to boost credibility.');
            }

            // 4. Emoji check
            if (/[\u{1F300}-\u{1F9FF}]|[\u{2600}-\u{26FF}]|[\u{2700}-\u{27BF}]/u.test(this.text.substring(0, 150))) {
                score += 15;
            } else {
                tips.push('Include a visual emoji anchor (e.g. 🚀, 💡, 📈) in your first 2 lines.');
            }

            // 5. Power words check
            const powerWords = ['how', 'secret', 'stop', 'mistake', 'learned', 'growth', 'viral', 'proven', 'revenue', 'system', 'formula', 'never', 'strategy', 'framework', 'why', 'lesson', 'built', 'scaled'];
            const textLower = this.text.toLowerCase();
            const hasPowerWord = powerWords.some(word => textLower.includes(word));
            if (hasPowerWord) {
                score += 15;
            } else {
                tips.push('Use power words like "proven", "system", "mistake", or "how" to trigger curiosity.');
            }

            score = Math.min(100, Math.max(10, score));

            let label = 'Needs Work';
            let badgeClass = 'bg-red-100 text-red-800 border-red-300';
            let barClass = 'bg-red-500';

            if (score >= 80) {
                label = '🔥 High-Converting Hook';
                badgeClass = 'bg-emerald-100 text-[#006c49] border-emerald-300';
                barClass = 'bg-[#006c49]';
            } else if (score >= 55) {
                label = '👍 Good Hook';
                badgeClass = 'bg-amber-100 text-amber-900 border-amber-300';
                barClass = 'bg-amber-500';
            }

            if (tips.length === 0) {
                tips.push('Great job! Your hook hits all key engagement triggers.');
            }

            return { score, label, badgeClass, barClass, tips };
        },

        loadSample(type = 'default') {
            if (type === 'story') {
                this.text = "I almost lost my entire SaaS company in 2024.\n\nHere is the painful mistake that nearly cost us everything (and how we turned it around to hit $100k MRR):\n\n1. Stop ignoring churn metrics\n2. Focus on customer feedback over vanity features\n3. Automate content distribution with PostPilot\n\n#SaaS #FounderStory #StartupGrowth";
            } else if (type === 'metric') {
                this.text = "From $10k to $100k ARR in 6 months.\n\nWe didn't spend a dollar on paid ads. Here is the exact content autopilot system we used to scale organically:\n\n• 3-5 posts per week\n• Strong hooks above the fold\n• Zero fluff, maximum value\n\n#ContentMarketing #OrganicGrowth #PostPilot";
            } else if (type === 'carousel') {
                this.text = "7 LinkedIn Post Formulas That Go Viral Every Time 🧵👇\n\nIf your posts are stuck at 50 views, you are making one of these 3 critical formatting errors.\n\nSlide 1: The Curiosity Gap Hook\nSlide 2: The Data-Driven Proof\nSlide 3: The Actionable Breakdown\n\n#LinkedInTips #ContentStrategy #CreatorEconomy";
            } else {
                this.text = "Stop posting on LinkedIn without testing your fold cutoff line. 🚀\n\n90% of your audience will NEVER click \"...see more\" if your first 3 lines don't trigger massive curiosity.\n\nHere are 3 rules we use at PostPilot to write high-converting hooks:\n\n1. Put the result in line 1\n2. Create a curiosity gap in line 2\n3. Format with clean line breaks\n\n#LinkedInMarketing #PostPilot #ContentCreator";
            }
            this.expanded = false;
            this.triggerToast('Sample hook preset loaded!');
        },

        clearText() {
            this.text = '';
            this.copied = false;
            this.expanded = false;
            this.triggerToast('Text cleared!');
        },

        cleanWhitespace() {
            if (!this.text) return;
            this.text = this.text
                .split('\n')
                .map(line => line.trimEnd())
                .join('\n')
                .replace(/[ \t]+/g, ' ')
                .replace(/\n{3,}/g, '\n\n')
                .trim();
            this.triggerToast('Extra whitespace cleaned!');
        },

        copyText() {
            if (!this.text) return;
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(this.text).then(() => {
                    this.copied = true;
                    this.triggerToast('Post copied to clipboard!');
                    setTimeout(() => { this.copied = false; }, 2000);
                }).catch(() => {
                    this.fallbackCopy();
                });
            } else {
                this.fallbackCopy();
            }
        },

        fallbackCopy() {
            if (!this.text) return;
            const textarea = document.createElement('textarea');
            textarea.value = this.text;
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            textarea.style.top = '0';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                this.copied = true;
                this.triggerToast('Post copied to clipboard!');
                setTimeout(() => { this.copied = false; }, 2000);
            } catch (err) {
                console.error('Fallback copy failed', err);
            }
            document.body.removeChild(textarea);
        },

        triggerToast(message) {
            this.toastMsg = message;
            this.toastShow = true;
            setTimeout(() => {
                this.toastShow = false;
            }, 3000);
        }
    };
}
</script>
@endsection
