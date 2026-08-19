@extends('layouts.tool')

@section('title', 'Free LinkedIn Line Break Generator [No Sign-Up] – Fix Mobile Formatting | PostPilot')
@section('meta_description', 'Stop LinkedIn from collapsing your paragraphs on mobile. Add invisible line breaks that work on all devices. Free formatter, no login required. Try now ➔')
@section('tool_name', 'Free LinkedIn Line Break Formatter')
@section('tool_route', 'tools.linkedin-line-break')

@section('schema_json')
    <x-seo.faq-schema :faqs="[
        [
            'question' => 'Why does LinkedIn remove my line breaks?',
            'answer' => 'LinkedIn\'s rich-text post parser automatically collapses consecutive empty line breaks to preserve compact feed layout. Inserting an invisible zero-width space character (\u200B) tricks the LinkedIn editor into recognizing content on empty lines, preventing paragraph breaks from collapsing upon posting.'
        ],
        [
            'question' => 'What is a zero-width space character (\u200B)?',
            'answer' => 'A zero-width space (\u200B or U+200B) is a non-printing Unicode character that occupies zero horizontal space in text formatting. It acts as an invisible placeholder in your post, keeping line breaks intact without adding unwanted symbols, periods, or extra visible characters.'
        ],
        [
            'question' => 'How do I add blank lines in LinkedIn posts?',
            'answer' => 'Paste your draft post into our free generator tool, which automatically replaces empty line gaps with invisible zero-width space characters. Click &quot;Copy Formatted Text&quot; and paste directly into LinkedIn on desktop or mobile for perfect paragraph spacing.'
        ],
        [
            'question' => 'Does this tool work for Instagram captions too?',
            'answer' => 'Yes! Zero-width invisible space characters work across all major social platforms including Instagram captions and bios, Facebook posts, X (Twitter) threads, and TikTok descriptions to prevent line breaks from collapsing.'
        ],
        [
            'question' => 'Will invisible characters affect my post\'s SEO or reach?',
            'answer' => 'No. Zero-width space characters are standard Unicode compliance characters that are completely ignored by search engines, LinkedIn feed ranking algorithms, and screen readers. Your post reach, indexing, and accessibility remain 100% unaffected.'
        ],
        [
            'question' => 'How many line breaks can I add to a LinkedIn post?',
            'answer' => 'You can add as many line breaks as you need within LinkedIn\'s 3,000-character limit. However, keeping paragraphs to 1 to 3 short sentences with single empty line breaks maximizes mobile readability and scroll-stopping engagement.'
        ],
    ]" />
@endsection

@section('content')
<div class="mb-16" x-data="lineBreakFormatter()">
    <!-- Hero Section -->
    <section class="flex flex-col items-center text-center gap-4 max-w-3xl mx-auto mb-10 font-sans">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#006c49]/10 border border-[#006c49]/30 rounded-full shadow-md">
            <span class="material-symbols-outlined text-[16px] text-[#006c49]">verified</span>
            <span class="font-mono text-xs text-[#006c49] uppercase tracking-wider font-extrabold">LINKEDIN TOOLS • 100% FREE &amp; CLIENT-SIDE</span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-black tracking-tight leading-tight font-sans text-center">
            LinkedIn Spacing &amp; Line Break Generator
        </h1>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl font-medium leading-relaxed text-center font-sans">
            Format your LinkedIn posts with invisible zero-width space characters (\u200B) to prevent collapsed paragraphs and keep clean line spacing.
        </p>
    </section>

    {{-- GEO / Answer-First Content --}}
    <div class="max-w-3xl mx-auto mb-8 px-4 sm:px-0">
        <p class="text-[15px] leading-relaxed text-gray-700 font-medium bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <strong>What is this tool?</strong> The LinkedIn Line Break Generator is a free utility that formats social media posts with invisible zero-width space characters. Creators and marketers use it to prevent LinkedIn from collapsing empty paragraph breaks upon publishing, ensuring clean spacing, improved mobile readability, and professional post structure without adding messy symbols or extra punctuation.
        </p>
    </div>

    <!-- Top Stats Bar Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 flex flex-col justify-between shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-gray-500 uppercase tracking-wider font-extrabold">Paragraphs</span>
            <span class="font-mono text-2xl sm:text-3xl font-extrabold text-black mt-1" x-text="paragraphCount">0</span>
        </div>
        <div class="bg-emerald-50/80 border-2 border-[#006c49]/30 rounded-xl p-4 flex flex-col justify-between shadow-md hover:border-[#006c49] transition-all">
            <span class="font-mono text-xs text-[#006c49] uppercase tracking-wider font-extrabold flex items-center justify-between">
                <span>Injected Spaces</span>
                <span class="text-[10px] bg-[#006c49] text-white px-1.5 py-0.5 rounded font-mono font-normal">\u200B</span>
            </span>
            <span class="font-mono text-2xl sm:text-3xl font-extrabold text-[#006c49] mt-1" x-text="injectedCount">0</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 flex flex-col justify-between shadow-md hover:border-gray-400 transition-all relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="font-mono text-xs text-gray-500 uppercase tracking-wider font-extrabold">Characters</span>
                <span class="font-mono text-xs text-gray-400 font-bold" x-text="`${charCount}/3,000`">0/3,000</span>
            </div>
            <div class="font-mono text-2xl sm:text-3xl font-extrabold mt-1" :class="charCount > 3000 ? 'text-red-600' : 'text-black'" x-text="charCount.toLocaleString()">0</div>
            <div class="w-full bg-gray-200 h-1.5 rounded-full mt-2 overflow-hidden">
                <div class="h-full transition-all duration-300" :class="charCount > 3000 ? 'bg-red-500' : (charCount > 2500 ? 'bg-amber-500' : 'bg-[#006c49]')" :style="`width: ${Math.min(100, (charCount / 3000) * 100)}%`"></div>
            </div>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 flex flex-col justify-between shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-gray-500 uppercase tracking-wider font-extrabold">Word Count</span>
            <span class="font-mono text-2xl sm:text-3xl font-extrabold text-black mt-1" x-text="wordCount.toLocaleString()">0</span>
        </div>
    </div>

    <!-- Dual-Pane Workspace Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Column 1: Raw Post Input (Left - 6 cols) -->
        <div class="lg:col-span-6 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex flex-wrap items-center justify-between border-b border-gray-300 pb-4 gap-3">
                    <label for="rawInputText" class="text-xs font-extrabold uppercase tracking-wider text-black flex items-center gap-2 font-mono">
                        <span class="material-symbols-outlined text-base text-[#006c49]">edit_note</span>
                        <span>Raw Post Content</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <button type="button" x-on:click="loadSample('story')" class="text-xs font-bold text-[#006c49] hover:text-emerald-800 transition-colors font-mono uppercase tracking-wider cursor-pointer flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">auto_fix_high</span>
                            <span>Load Sample</span>
                        </button>
                        <span class="text-gray-300" x-show="rawText.length > 0" x-cloak>|</span>
                        <button type="button" x-on:click="clearText()" x-show="rawText.length > 0" class="text-xs font-bold text-gray-400 hover:text-rose-600 transition-colors font-mono uppercase tracking-wider cursor-pointer flex items-center gap-1" x-cloak>
                            <span class="material-symbols-outlined text-xs">delete</span>
                            <span>Clear</span>
                        </button>
                    </div>
                </div>

                <!-- Input Textarea -->
                <textarea 
                    id="rawInputText"
                    x-model="rawText"
                    rows="12"
                    placeholder="Paste or type your draft LinkedIn post here..."
                    class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-2 focus:ring-black/10 rounded-xl p-4 text-sm text-gray-900 placeholder-gray-400 font-sans leading-relaxed resize-y focus:outline-none transition-all shadow-md min-h-[260px]"
                ></textarea>

                <!-- Quick Presets -->
                <div class="space-y-2">
                    <span class="text-[11px] font-mono font-extrabold text-gray-500 uppercase tracking-wider block">Quick Presets</span>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" x-on:click="loadSample('story')" class="text-xs font-bold font-mono tracking-wider bg-white border-2 border-gray-300 text-black hover:border-black hover:bg-gray-50 rounded-lg px-3 py-1.5 transition-all flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95">
                            <span>⚡ Story Post</span>
                        </button>
                        <button type="button" x-on:click="loadSample('listicle')" class="text-xs font-bold font-mono tracking-wider bg-white border-2 border-gray-300 text-black hover:border-black hover:bg-gray-50 rounded-lg px-3 py-1.5 transition-all flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95">
                            <span>🚀 5-Step List</span>
                        </button>
                        <button type="button" x-on:click="loadSample('launch')" class="text-xs font-bold font-mono tracking-wider bg-white border-2 border-gray-300 text-black hover:border-black hover:bg-gray-50 rounded-lg px-3 py-1.5 transition-all flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95">
                            <span>💡 Product Launch</span>
                        </button>
                        <button type="button" x-on:click="loadSample('rant')" class="text-xs font-bold font-mono tracking-wider bg-white border-2 border-gray-300 text-black hover:border-black hover:bg-gray-50 rounded-lg px-3 py-1.5 transition-all flex items-center gap-1.5 cursor-pointer shadow-md active:scale-95">
                            <span>🔥 Short Take</span>
                        </button>
                    </div>
                </div>

                <!-- Toggles / Cleaning Settings -->
                <div class="bg-white border-2 border-gray-300 rounded-xl p-4 space-y-3 shadow-md">
                    <span class="text-xs font-mono font-extrabold text-black uppercase tracking-wider block border-b border-gray-100 pb-2">Formatting Options</span>
                    
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input x-model="trimLeadingTrailing" type="checkbox" class="sr-only peer"/>
                            <div class="w-10 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#006c49]"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold font-sans text-black">Trim Empty Top &amp; Bottom Lines</span>
                            <span class="text-[11px] text-gray-500 font-sans">Eliminates awkward blank line gaps at start and end of post</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input x-model="cleanExtraSpaces" type="checkbox" class="sr-only peer"/>
                            <div class="w-10 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#006c49]"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold font-sans text-black">Trim Trailing Spaces</span>
                            <span class="text-[11px] text-gray-500 font-sans">Strips invisible whitespace characters at line ends</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input x-model="convertMultipleBreaks" type="checkbox" class="sr-only peer"/>
                            <div class="w-10 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#006c49]"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold font-sans text-black">Compress Multiple Consecutive Blank Lines</span>
                            <span class="text-[11px] text-gray-500 font-sans">Converts 3+ consecutive line breaks into single spacing</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Column 2: Formatted Output & Mobile Preview (Right - 6 cols) -->
        <div class="lg:col-span-6 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md flex flex-col justify-between">
            <div class="flex-grow flex flex-col">
                <!-- View Switcher & Injected Counter Header -->
                <div class="flex flex-wrap gap-4 items-center justify-between border-b border-gray-300 pb-4 mb-4">
                    <div class="flex bg-gray-200/80 rounded-xl p-1 border-2 border-gray-300 font-sans">
                        <button type="button" x-on:click="activeTab = 'editor'" :class="activeTab === 'editor' ? 'bg-white text-black shadow-md font-extrabold border-gray-300' : 'text-gray-600 hover:text-black font-semibold border-transparent'" class="text-xs rounded-lg px-3.5 py-1.5 transition-all border-2 cursor-pointer">
                            Formatted Output
                        </button>
                        <button type="button" x-on:click="activeTab = 'feed'" :class="activeTab === 'feed' ? 'bg-white text-black shadow-md font-extrabold border-gray-300' : 'text-gray-600 hover:text-black font-semibold border-transparent'" class="text-xs rounded-lg px-3.5 py-1.5 transition-all border-2 cursor-pointer flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">phone_iphone</span>
                            <span>LinkedIn Preview</span>
                        </button>
                    </div>

                    <div class="bg-emerald-50 border border-emerald-200 rounded-full px-3 py-1 flex items-center gap-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[14px] text-[#006c49]">verified</span>
                        <span class="text-xs font-bold font-mono text-[#006c49]"><span x-text="injectedCount">0</span> \u200B Injected</span>
                    </div>
                </div>

                <!-- View Mode 1: Editor View with visual zero-width space indicator -->
                <div x-show="activeTab === 'editor'" class="w-full flex-grow bg-white border-2 border-gray-300 rounded-xl p-5 text-sm font-sans text-gray-900 overflow-y-auto whitespace-pre-wrap relative min-h-[340px] max-h-[520px] shadow-md">
                    <template x-if="!formattedText">
                        <div class="h-full flex flex-col items-center justify-center text-center text-gray-400 py-12 space-y-3 min-h-[260px]">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 text-[#006c49] flex items-center justify-center border border-emerald-200 shadow-sm">
                                <span class="material-symbols-outlined text-2xl">format_paragraph</span>
                            </div>
                            <p class="font-bold text-sm text-gray-700">Formatted output preview</p>
                            <p class="text-xs max-w-xs text-gray-500 leading-relaxed">
                                Copy with zero-width safe line breaks will render here automatically as you type on the left.
                            </p>
                        </div>
                    </template>
                    <template x-if="formattedText">
                        <div x-html="highlightedFormattedText" class="leading-relaxed"></div>
                    </template>
                </div>

                <!-- View Mode 2: Authentic LinkedIn Mobile & Feed Preview Card -->
                <div x-show="activeTab === 'feed'" x-cloak class="w-full flex-grow flex flex-col justify-start min-h-[340px] max-h-[520px] overflow-y-auto">
                    <div class="bg-white rounded-xl border-2 border-gray-300 shadow-md overflow-hidden flex flex-col w-full">
                        <!-- Mock LinkedIn Profile Header -->
                        <div class="p-4 flex items-start gap-3 border-b border-gray-100 bg-white">
                            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-[#006c49] to-black text-white flex items-center justify-center shrink-0 font-extrabold text-sm font-sans shadow-md border border-emerald-500/20">
                                AR
                            </div>
                            <div class="flex-grow pt-0.5 font-sans min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-bold text-gray-900 text-[14px] leading-tight hover:text-[#006c49] hover:underline cursor-pointer truncate">Alex Rivera</span>
                                    <span class="text-gray-500 text-[12px] font-medium">• 1st</span>
                                </div>
                                <div class="text-gray-500 text-[12px] leading-tight mt-0.5 truncate font-normal">Founder @ PostPilot | SaaS Growth &amp; Content Strategy</div>
                                <div class="text-gray-400 text-[11px] flex items-center gap-1 mt-1 font-mono">
                                    <span>2h</span>
                                    <span>•</span>
                                    <span class="material-symbols-outlined text-[13px]">public</span>
                                </div>
                            </div>
                            <button type="button" class="text-gray-400 hover:bg-gray-100 p-1.5 rounded-full transition-colors shrink-0 cursor-pointer">
                                <span class="material-symbols-outlined text-[20px]">more_horiz</span>
                            </button>
                        </div>

                        <!-- Mock LinkedIn Post Content Body -->
                        <div class="p-4 bg-white flex-grow">
                            <template x-if="!formattedText">
                                <div class="py-10 text-center space-y-2">
                                    <p class="text-gray-400 italic text-xs font-sans">Start typing your draft post on the left to see live LinkedIn feed preview with exact line break spacing...</p>
                                </div>
                            </template>
                            <template x-if="formattedText">
                                <div class="text-xs sm:text-sm text-gray-900 leading-relaxed font-sans whitespace-pre-wrap break-words" x-text="formattedText"></div>
                            </template>
                        </div>

                        <!-- Mock LinkedIn Reactions Bar -->
                        <div class="px-4 py-2.5 flex items-center justify-between border-t border-b border-gray-100 bg-gray-50/50 text-[11px] text-gray-500 font-sans">
                            <div class="flex items-center gap-1.5">
                                <div class="flex -space-x-1">
                                    <div class="w-4 h-4 rounded-full bg-[#006c49] flex items-center justify-center border border-white z-20 text-[9px] text-white shadow-xs">👍</div>
                                    <div class="w-4 h-4 rounded-full bg-blue-600 flex items-center justify-center border border-white z-10 text-[9px] text-white shadow-xs">💡</div>
                                    <div class="w-4 h-4 rounded-full bg-red-500 flex items-center justify-center border border-white z-0 text-[9px] text-white shadow-xs">❤️</div>
                                </div>
                                <span class="hover:text-[#006c49] hover:underline cursor-pointer font-bold text-gray-700 ml-1">284</span>
                            </div>
                            <div class="hover:text-[#006c49] hover:underline cursor-pointer font-medium text-gray-500">
                                42 comments • 18 reposts
                            </div>
                        </div>

                        <!-- Mock LinkedIn Action Buttons Bar -->
                        <div class="px-2 py-1 flex justify-between text-gray-600 font-sans bg-white">
                            <button type="button" class="flex-1 flex items-center justify-center gap-1.5 py-2 hover:bg-gray-100 rounded-lg transition-colors text-[12px] font-bold text-gray-600 cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">thumb_up</span>
                                <span>Like</span>
                            </button>
                            <button type="button" class="flex-1 flex items-center justify-center gap-1.5 py-2 hover:bg-gray-100 rounded-lg transition-colors text-[12px] font-bold text-gray-600 cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">chat_bubble</span>
                                <span>Comment</span>
                            </button>
                            <button type="button" class="flex-1 flex items-center justify-center gap-1.5 py-2 hover:bg-gray-100 rounded-lg transition-colors text-[12px] font-bold text-gray-600 cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">repeat</span>
                                <span>Repost</span>
                            </button>
                            <button type="button" class="flex-1 flex items-center justify-center gap-1.5 py-2 hover:bg-gray-100 rounded-lg transition-colors text-[12px] font-bold text-gray-600 cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">send</span>
                                <span>Send</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Primary Copy Button -->
            <div class="pt-4">
                <button 
                    type="button" 
                    x-on:click="copyFormatted()" 
                    :disabled="!formattedText" 
                    class="w-full bg-black text-white hover:bg-gray-800 text-base sm:text-lg font-extrabold font-sans rounded-xl py-4 transition-all flex items-center justify-center gap-2 border-2 border-black group disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer shadow-md active:translate-y-0.5"
                >
                    <template x-if="!copied">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-xl group-hover:scale-110 transition-transform">content_copy</span>
                            <span>Copy Formatted Text</span>
                        </div>
                    </template>
                    <template x-if="copied">
                        <div class="flex items-center gap-2 text-emerald-400">
                            <span class="material-symbols-outlined text-xl">check_circle</span>
                            <span>Copied to Clipboard!</span>
                        </div>
                    </template>
                </button>
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
        <span>Copied LinkedIn post with zero-width line breaks!</span>
    </div>

    <!-- Integrated PostPilot Promotional CTA Section -->
    <div class="mt-12 bg-white border-2 border-black rounded-[16px] p-6 sm:p-8 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] relative overflow-hidden">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-[#006c49] text-[11px] font-extrabold uppercase font-mono tracking-wider">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    PostPilot Velocity Post Engine
                </div>
                <h3 class="text-xl sm:text-2xl font-extrabold text-black tracking-tight font-sans">
                    Automate LinkedIn formatting &amp; scheduling in 1 click.
                </h3>
                <p class="text-xs sm:text-sm text-gray-600 font-medium leading-relaxed">
                    Stop manually formatting posts. PostPilot automatically applies optimal paragraph spacing, generates high-converting hooks, designs multi-slide carousels, and publishes directly to LinkedIn, X, and Facebook.
                </p>
            </div>
            <a 
                href="{{ route('register') }}" 
                class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-black hover:bg-gray-800 text-white text-xs font-bold rounded-[8px] transition-all shadow-md font-mono shrink-0 cursor-pointer"
            >
                <span>Start Free Trial</span>
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Feature Highlights Cards Grid -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border-2 border-gray-300 rounded-[16px] p-6 shadow-md hover:border-gray-400 transition-all space-y-3">
            <div class="w-10 h-10 rounded-[10px] bg-emerald-50 text-[#006c49] border border-emerald-200 flex items-center justify-center font-mono font-extrabold text-xs shadow-md">
                \u200B
            </div>
            <h3 class="text-sm font-extrabold text-black uppercase font-mono tracking-wide">Invisible Zero-Width Space</h3>
            <p class="text-xs text-gray-600 leading-relaxed font-medium">
                Injects invisible Unicode space characters (<code class="text-[#006c49] font-mono text-[11px] bg-emerald-50 px-1 py-0.5 rounded border border-emerald-200/60">\u200B</code>) into empty lines, preventing LinkedIn from squishing your paragraph breaks.
            </p>
        </div>

        <div class="bg-white border-2 border-gray-300 rounded-[16px] p-6 shadow-md hover:border-gray-400 transition-all space-y-3">
            <div class="w-10 h-10 rounded-[10px] bg-emerald-50 text-[#006c49] border border-emerald-200 flex items-center justify-center shadow-md">
                <span class="material-symbols-outlined text-xl">devices</span>
            </div>
            <h3 class="text-sm font-extrabold text-black uppercase font-mono tracking-wide">Cross-Platform Support</h3>
            <p class="text-xs text-gray-600 leading-relaxed font-medium">
                Guarantees your post copy remains clean, readable, and perfectly separated across LinkedIn iOS, Android, and Desktop web interfaces.
            </p>
        </div>

        <div class="bg-white border-2 border-gray-300 rounded-[16px] p-6 shadow-md hover:border-gray-400 transition-all space-y-3">
            <div class="w-10 h-10 rounded-[10px] bg-emerald-50 text-[#006c49] border border-emerald-200 flex items-center justify-center shadow-md">
                <span class="material-symbols-outlined text-xl">lock</span>
            </div>
            <h3 class="text-sm font-extrabold text-black uppercase font-mono tracking-wide">100% Client-Side Privacy</h3>
            <p class="text-xs text-gray-600 leading-relaxed font-medium">
                Runs completely in your browser. Draft post copy is processed strictly in local client memory and is never transmitted or saved to external servers.
            </p>
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
                    'question' => 'Why does LinkedIn remove my line breaks?',
                    'answer' => 'LinkedIn\'s rich-text post parser automatically collapses consecutive empty line breaks to preserve compact feed layout. Inserting an invisible zero-width space character (\u200B) tricks the LinkedIn editor into recognizing content on empty lines, preventing paragraph breaks from collapsing upon posting.'
                ],
                [
                    'question' => 'What is a zero-width space character (\u200B)?',
                    'answer' => 'A zero-width space (\u200B or U+200B) is a non-printing Unicode character that occupies zero horizontal space in text formatting. It acts as an invisible placeholder in your post, keeping line breaks intact without adding unwanted symbols, periods, or extra visible characters.'
                ],
                [
                    'question' => 'How do I add blank lines in LinkedIn posts?',
                    'answer' => 'Paste your draft post into our free generator tool, which automatically replaces empty line gaps with invisible zero-width space characters. Click "Copy Formatted Text" and paste directly into LinkedIn on desktop or mobile for perfect paragraph spacing.'
                ],
                [
                    'question' => 'Does this tool work for Instagram captions too?',
                    'answer' => 'Yes! Zero-width invisible space characters work across all major social platforms including Instagram captions and bios, Facebook posts, X (Twitter) threads, and TikTok descriptions to prevent line breaks from collapsing.'
                ],
                [
                    'question' => 'Will invisible characters affect my post\'s SEO or reach?',
                    'answer' => 'No. Zero-width space characters are standard Unicode compliance characters that are completely ignored by search engines, LinkedIn feed ranking algorithms, and screen readers. Your post reach, indexing, and accessibility remain 100% unaffected.'
                ],
                [
                    'question' => 'How many line breaks can I add to a LinkedIn post?',
                    'answer' => 'You can add as many line breaks as you need within LinkedIn\'s 3,000-character limit. However, keeping paragraphs to 1 to 3 short sentences with single empty line breaks maximizes mobile readability and scroll-stopping engagement.'
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

<script>
function lineBreakFormatter() {
    return {
        rawText: '',
        formattedText: '',
        copied: false,
        toastVisible: false,
        toastTimeout: null,
        activeTab: 'editor',
        cleanExtraSpaces: true,
        convertMultipleBreaks: false,
        trimLeadingTrailing: true,
        
        init() {
            this.$watch('rawText', () => this.formatText());
            this.$watch('cleanExtraSpaces', () => this.formatText());
            this.$watch('convertMultipleBreaks', () => this.formatText());
            this.$watch('trimLeadingTrailing', () => this.formatText());
        },

        get charCount() {
            return this.rawText ? this.rawText.length : 0;
        },

        get wordCount() {
            if (!this.rawText || !this.rawText.trim()) return 0;
            const normalized = this.rawText.replace(/\r\n/g, '\n').replace(/\r/g, '\n');
            return normalized.trim().split(/\s+/).filter(w => w.length > 0).length;
        },

        get paragraphCount() {
            if (!this.rawText || !this.rawText.trim()) return 0;
            const normalized = this.rawText.replace(/\r\n/g, '\n').replace(/\r/g, '\n');
            const paragraphs = normalized.split(/\n\s*\n/).filter(p => p.replace(/\u200B/g, '').trim().length > 0);
            return paragraphs.length;
        },

        get injectedCount() {
            if (!this.formattedText) return 0;
            const lines = this.formattedText.split('\n');
            return lines.filter(line => line === '\u200B').length;
        },

        get highlightedFormattedText() {
            if (!this.formattedText) return '';
            const highlightHtml = `<div class="relative group my-1.5"><span class="absolute -left-6 text-[10px] text-[#006c49] opacity-0 group-hover:opacity-100 transition-opacity font-mono font-bold select-none">\\u200B</span><span class="block w-full h-[1px] bg-[#006c49]/30 border-dashed border-b border-[#006c49]/40 group-hover:bg-[#006c49]/60"></span></div>`;
            
            const lines = this.formattedText.split('\n');
            const processed = lines.map(line => {
                if (line === '\u200B') {
                    return highlightHtml;
                }
                return this.escapeHtml(line);
            });
            return processed.join('<br/>');
        },

        escapeHtml(str) {
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        },

        formatText() {
            if (!this.rawText) {
                this.formattedText = '';
                return;
            }
            let normalized = this.rawText.replace(/\r\n/g, '\n').replace(/\r/g, '\n');
            
            if (this.cleanExtraSpaces) {
                normalized = normalized.split('\n').map(line => line.trimEnd()).join('\n');
            }

            if (this.convertMultipleBreaks) {
                normalized = normalized.replace(/\n{3,}/g, '\n\n');
            }

            if (this.trimLeadingTrailing) {
                normalized = normalized.replace(/^(\s*\n)+/, '');
                normalized = normalized.replace(/(\n\s*)+$/, '');
            }

            if (!normalized) {
                this.formattedText = '';
                return;
            }

            const lines = normalized.split('\n');
            const processed = lines.map(line => line.replace(/\u200B/g, '').trim() === '' ? '\u200B' : line);
            this.formattedText = processed.join('\n');
        },

        loadSample(type = 'story') {
            if (type === 'story') {
                this.rawText = `Most LinkedIn posts look cramped because LinkedIn automatically collapses blank lines.\n\nHere is paragraph 1 with safe line breaks.\n\nHere is paragraph 2 with safe line breaks.\n\nBy using invisible zero-width spaces (\\u200B), your formatting stays clean across Mobile & Desktop.`;
            } else if (type === 'listicle') {
                this.rawText = `5 Simple Habits That Scaled Our SaaS to $50k MRR:\n\n1. Shipping micro-updates weekly\n\n2. Repurposing customer feedback into feature hooks\n\n3. Automating social distribution across LinkedIn & X\n\n4. Focusing on user retention over vanity acquisition\n\n5. Staying consistent for 12 months straight.\n\nWhich habit are you focusing on this quarter?`;
            } else if (type === 'launch') {
                this.rawText = `We just launched PostPilot Velocity Engine 🚀\n\nCreating consistent social content used to take 10+ hours a week.\n\nNow you can input your brand guidelines once and generate a complete 30-day content calendar with safe formatting.\n\nTry it free today - link in comments!`;
            } else if (type === 'rant') {
                this.rawText = `Unpopular opinion: Stop writing 1-sentence paragraphs that say nothing.\n\nLength doesn't equal depth.\n\nIf your post can be summarized in 3 words, write 3 words.\n\nValue > Volume. Every single time.`;
            }
        },

        clearText() {
            this.rawText = '';
            this.formattedText = '';
            this.copied = false;
        },

        triggerToast() {
            this.copied = true;
            this.toastVisible = true;
            if (this.toastTimeout) clearTimeout(this.toastTimeout);
            this.toastTimeout = setTimeout(() => {
                this.copied = false;
                this.toastVisible = false;
            }, 2500);
        },

        copyFormatted() {
            if (!this.formattedText) return;
            
            if (navigator.clipboard && window.isSecureContext && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(this.formattedText)
                    .then(() => {
                        this.triggerToast();
                    })
                    .catch(() => {
                        this.fallbackCopy();
                    });
            } else {
                this.fallbackCopy();
            }
        },

        fallbackCopy() {
            try {
                const el = document.createElement('textarea');
                el.value = this.formattedText;
                el.setAttribute('readonly', '');
                el.style.position = 'absolute';
                el.style.left = '-9999px';
                el.style.top = (window.pageYOffset || document.documentElement.scrollTop) + 'px';
                document.body.appendChild(el);
                
                if (navigator.userAgent.match(/ipad|ipod|iphone/i)) {
                    const range = document.createRange();
                    range.selectNodeContents(el);
                    const selection = window.getSelection();
                    selection.removeAllRanges();
                    selection.addRange(range);
                    el.setSelectionRange(0, 999999);
                } else {
                    el.select();
                }
                
                const successful = document.execCommand('copy');
                document.body.removeChild(el);

                if (successful) {
                    this.triggerToast();
                }
            } catch (e) {
                console.error('Fallback copy failed', e);
            }
        }
    }
}
</script>
@endsection
