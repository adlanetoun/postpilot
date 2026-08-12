@extends('layouts.tool')

@section('title', 'Free LinkedIn Hook Generator Template Matrix - PostPilot')
@section('meta_description', 'Generate viral LinkedIn hooks instantly. Filter 25+ proven opening hook templates across Contrarian, Story, Curiosity, Listicle, and Metric categories with live topic, metric, and year interpolation.')
@section('tool_name', 'Free LinkedIn Hook Generator Template Matrix')
@section('tool_route', 'tools.linkedin-hooks')

@section('schema_json')
    <x-seo.faq-schema :faqs="[
        [
            'question' => 'What is a LinkedIn hook and why does it matter?',
            'answer' => 'A LinkedIn hook is the opening sentence or line of your post visible before the &quot;see more&quot; truncation cutoff. It matters because it determines whether a reader stops scrolling (dwell time) and expands your post, directly impacting your organic reach in the LinkedIn algorithm.'
        ],
        [
            'question' => 'What are the best-performing LinkedIn post hooks?',
            'answer' => 'The best-performing LinkedIn post hooks fall into five core categories: contrarian hot takes that challenge industry myths, data-backed metric claims, personal story case studies, resource listicles, and curiosity cliffhangers. Hooks that combine specific numbers with strong emotional tension consistently drive the highest engagement.'
        ],
        [
            'question' => 'How many words should a LinkedIn hook be?',
            'answer' => 'A LinkedIn hook should ideally be between 6 and 15 words, keeping line 1 under 140 characters so it displays in full on mobile screens. Keeping your hook concise and following it with a blank line break maximizes readability and encourages users to tap &quot;see more&quot;.'
        ],
        [
            'question' => 'Do hook templates actually increase engagement?',
            'answer' => 'Yes, using proven hook templates increases post engagement by tapping into established psychological triggers like curiosity, fear of missing out, and social proof. Creators and founders who use structured opening formulas regularly report 2x to 5x higher impression counts and dwell times.'
        ],
        [
            'question' => 'Can I use these hooks for X (Twitter) or Facebook posts?',
            'answer' => 'Absolutely. The psychological principles behind viral LinkedIn hooks work seamlessly for X (Twitter) thread openers, Facebook post captions, YouTube titles, and email subject lines. You can easily adapt these 25+ formulas for any short-form or long-form social content strategy.'
        ],
        [
            'question' => 'How often should I change my LinkedIn post hooks?',
            'answer' => 'You should rotate across different hook styles (contrarian, metric, story, listicle, curiosity) throughout the week to keep your content feed fresh. Avoid using the exact same formula consecutively, but feel free to reuse high-performing hook structures across different topics and industry angles.'
        ],
    ]" />
@endsection

@section('head')
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0.75; }
    [x-cloak] { display: none !important; }
    
    /* Toast animation */
    .toast-enter {
        opacity: 0;
        transform: translateY(1rem);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .toast-enter-active {
        opacity: 1;
        transform: translateY(0);
    }
    .toast-leave {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .toast-leave-end {
        opacity: 0;
        transform: translateY(1rem);
    }
</style>
@endsection

@section('content')
<div class="mb-16 font-sans" x-data="hookTemplates()">
    
    <!-- Hero Section -->
    <section class="flex flex-col items-center text-center gap-4 max-w-3xl mx-auto mb-10 font-sans">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#006c49]/10 border border-[#006c49]/30 rounded-full shadow-md">
            <span class="material-symbols-outlined text-[16px] text-[#006c49]">verified</span>
            <span class="font-mono text-xs text-[#006c49] uppercase tracking-wider font-extrabold">LINKEDIN TOOLS • 100% FREE &amp; CLIENT-SIDE</span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-black tracking-tight leading-tight font-sans text-center">
            LinkedIn Viral Hook Templates &amp; Generator
        </h1>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl font-medium leading-relaxed text-center font-sans">
            Browse 25 battle-tested viral LinkedIn hook formulas across Contrarian, Story, Curiosity, Listicle, and Metric categories. Customize live with your topic, metrics, and year.
        </p>
    </section>

    {{-- GEO / Answer-First Content --}}
    <div class="max-w-3xl mx-auto mb-8 px-4 sm:px-0">
        <p class="text-[15px] leading-relaxed text-gray-700 font-medium bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <strong>What is this tool?</strong> The LinkedIn Hook Templates tool is a free utility that allows content creators, marketers, and founders to browse, filter, and customize battle-tested LinkedIn post openers. By inserting custom topics, metrics, and dates, it solves weak post engagement and low dwell time by crafting high-converting hooks that stop scrolling and encourage readers to click 'see more'.
        </p>
    </div>

    <!-- Interactive Category Filter Summary Cards Grid (6 Categories) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5 mb-8">
        <!-- 1. All Styles -->
        <button 
            type="button"
            @click="category = 'all'"
            :class="category === 'all' ? 'bg-black text-white border-black shadow-md scale-[1.02]' : 'bg-white text-gray-900 border-2 border-gray-300 hover:border-black hover:bg-gray-50'"
            class="p-4 rounded-xl border-2 transition-all text-left flex flex-col justify-between cursor-pointer group active:scale-95 shadow-md"
        >
            <div class="flex items-center justify-between mb-2">
                <span class="font-mono text-[10px] font-extrabold uppercase tracking-wider opacity-90 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">auto_awesome</span>
                    All Styles
                </span>
                <span class="w-2.5 h-2.5 rounded-full" :class="category === 'all' ? 'bg-emerald-400' : 'bg-gray-300'"></span>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-black font-mono" x-text="totalCount">25</span>
                <span class="text-[11px] font-mono font-semibold opacity-70">Formulas</span>
            </div>
        </button>

        <!-- 2. Contrarian / Hot Take -->
        <button 
            type="button"
            @click="category = 'contrarian'"
            :class="category === 'contrarian' ? 'bg-black text-white border-black shadow-md scale-[1.02]' : 'bg-white text-gray-900 border-2 border-gray-300 hover:border-black hover:bg-gray-50'"
            class="p-4 rounded-xl border-2 transition-all text-left flex flex-col justify-between cursor-pointer group active:scale-95 shadow-md"
        >
            <div class="flex items-center justify-between mb-2">
                <span class="font-mono text-[10px] font-extrabold uppercase tracking-wider text-rose-600 group-hover:text-rose-700 flex items-center gap-1" :class="category === 'contrarian' ? 'text-rose-400' : ''">
                    <span class="material-symbols-outlined text-sm">local_fire_department</span>
                    Contrarian
                </span>
                <span class="w-2.5 h-2.5 rounded-full" :class="category === 'contrarian' ? 'bg-rose-400' : 'bg-rose-300'"></span>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-black font-mono" x-text="contrarianCount">5</span>
                <span class="text-[11px] font-mono font-semibold opacity-70">Hot Takes</span>
            </div>
        </button>

        <!-- 3. Story / Lesson -->
        <button 
            type="button"
            @click="category = 'story'"
            :class="category === 'story' ? 'bg-black text-white border-black shadow-md scale-[1.02]' : 'bg-white text-gray-900 border-2 border-gray-300 hover:border-black hover:bg-gray-50'"
            class="p-4 rounded-xl border-2 transition-all text-left flex flex-col justify-between cursor-pointer group active:scale-95 shadow-md"
        >
            <div class="flex items-center justify-between mb-2">
                <span class="font-mono text-[10px] font-extrabold uppercase tracking-wider text-indigo-600 group-hover:text-indigo-700 flex items-center gap-1" :class="category === 'story' ? 'text-indigo-300' : ''">
                    <span class="material-symbols-outlined text-sm">auto_stories</span>
                    Story
                </span>
                <span class="w-2.5 h-2.5 rounded-full" :class="category === 'story' ? 'bg-indigo-400' : 'bg-indigo-300'"></span>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-black font-mono" x-text="storyCount">5</span>
                <span class="text-[11px] font-mono font-semibold opacity-70">Lessons</span>
            </div>
        </button>

        <!-- 4. Curiosity / Cliffhanger -->
        <button 
            type="button"
            @click="category = 'curiosity'"
            :class="category === 'curiosity' ? 'bg-black text-white border-black shadow-md scale-[1.02]' : 'bg-white text-gray-900 border-2 border-gray-300 hover:border-black hover:bg-gray-50'"
            class="p-4 rounded-xl border-2 transition-all text-left flex flex-col justify-between cursor-pointer group active:scale-95 shadow-md"
        >
            <div class="flex items-center justify-between mb-2">
                <span class="font-mono text-[10px] font-extrabold uppercase tracking-wider text-[#006c49] group-hover:text-emerald-700 flex items-center gap-1" :class="category === 'curiosity' ? 'text-emerald-400' : ''">
                    <span class="material-symbols-outlined text-sm">psychology</span>
                    Curiosity
                </span>
                <span class="w-2.5 h-2.5 rounded-full" :class="category === 'curiosity' ? 'bg-emerald-400' : 'bg-emerald-300'"></span>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-black font-mono" x-text="curiosityCount">5</span>
                <span class="text-[11px] font-mono font-semibold opacity-70">Blueprints</span>
            </div>
        </button>

        <!-- 5. Listicle / Frameworks -->
        <button 
            type="button"
            @click="category = 'listicle'"
            :class="category === 'listicle' ? 'bg-black text-white border-black shadow-md scale-[1.02]' : 'bg-white text-gray-900 border-2 border-gray-300 hover:border-black hover:bg-gray-50'"
            class="p-4 rounded-xl border-2 transition-all text-left flex flex-col justify-between cursor-pointer group active:scale-95 shadow-md"
        >
            <div class="flex items-center justify-between mb-2">
                <span class="font-mono text-[10px] font-extrabold uppercase tracking-wider text-amber-600 group-hover:text-amber-700 flex items-center gap-1" :class="category === 'listicle' ? 'text-amber-400' : ''">
                    <span class="material-symbols-outlined text-sm">format_list_bulleted</span>
                    Listicle
                </span>
                <span class="w-2.5 h-2.5 rounded-full" :class="category === 'listicle' ? 'bg-amber-400' : 'bg-amber-300'"></span>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-black font-mono" x-text="listicleCount">5</span>
                <span class="text-[11px] font-mono font-semibold opacity-70">Stacks</span>
            </div>
        </button>

        <!-- 6. Metric / ROI -->
        <button 
            type="button"
            @click="category = 'metric'"
            :class="category === 'metric' ? 'bg-black text-white border-black shadow-md scale-[1.02]' : 'bg-white text-gray-900 border-2 border-gray-300 hover:border-black hover:bg-gray-50'"
            class="p-4 rounded-xl border-2 transition-all text-left flex flex-col justify-between cursor-pointer group active:scale-95 shadow-md"
        >
            <div class="flex items-center justify-between mb-2">
                <span class="font-mono text-[10px] font-extrabold uppercase tracking-wider text-sky-600 group-hover:text-sky-700 flex items-center gap-1" :class="category === 'metric' ? 'text-sky-400' : ''">
                    <span class="material-symbols-outlined text-sm">query_stats</span>
                    Metric / ROI
                </span>
                <span class="w-2.5 h-2.5 rounded-full" :class="category === 'metric' ? 'bg-sky-400' : 'bg-sky-300'"></span>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-black font-mono" x-text="metricCount">5</span>
                <span class="text-[11px] font-mono font-semibold opacity-70">Data Proof</span>
            </div>
        </button>
    </div>

    <!-- Filter Bar & Input Controls Main Container Card -->
    <div class="bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md mb-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
            <!-- Dynamic Topic Input Box -->
            <div class="md:col-span-4 space-y-2">
                <label for="topicInput" class="block text-xs font-extrabold uppercase tracking-wider text-black font-mono flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base text-[#006c49]">edit_note</span>
                    <span>Post Topic ([TOPIC])</span>
                </label>
                <div class="relative">
                    <input 
                        id="topicInput"
                        type="text" 
                        x-model="topic" 
                        placeholder="e.g. SaaS Marketing, Personal Branding, AI Tools" 
                        class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-sm text-gray-900 font-semibold focus:outline-none transition-colors placeholder:text-gray-400 font-sans shadow-md"
                    >
                    <button 
                        type="button"
                        x-show="topic.length > 0" 
                        @click="topic = ''" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black text-xs font-mono font-bold px-2 py-1 transition-colors rounded-lg"
                        title="Clear topic"
                    >
                        Clear
                    </button>
                </div>
            </div>

            <!-- Dynamic Metric Input Box -->
            <div class="md:col-span-3 space-y-2">
                <label for="metricInput" class="block text-xs font-extrabold uppercase tracking-wider text-black font-mono flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base text-[#006c49]">equalizer</span>
                    <span>Target Metric ([METRIC])</span>
                </label>
                <div class="relative">
                    <input 
                        id="metricInput"
                        type="text" 
                        x-model="metric" 
                        placeholder="e.g. $100k ARR, 10k Followers, 300% ROI" 
                        class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-sm text-gray-900 font-semibold focus:outline-none transition-colors placeholder:text-gray-400 font-sans shadow-md"
                    >
                    <button 
                        type="button"
                        x-show="metric.length > 0" 
                        @click="metric = ''" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black text-xs font-mono font-bold px-2 py-1 transition-colors rounded-lg"
                        title="Clear metric"
                    >
                        Clear
                    </button>
                </div>
            </div>

            <!-- Dynamic Target Year Input Box -->
            <div class="md:col-span-2 space-y-2">
                <label for="yearInput" class="block text-xs font-extrabold uppercase tracking-wider text-black font-mono flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base text-[#006c49]">calendar_today</span>
                    <span>Year ([YEAR])</span>
                </label>
                <input 
                    id="yearInput"
                    type="text" 
                    x-model="year" 
                    placeholder="2026" 
                    class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-sm text-gray-900 font-semibold focus:outline-none transition-colors placeholder:text-gray-400 font-sans shadow-md"
                >
            </div>

            <!-- Category Select Filter -->
            <div class="md:col-span-3 space-y-2">
                <label for="categorySelect" class="block text-xs font-extrabold uppercase tracking-wider text-black font-mono flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base text-[#006c49]">filter_list</span>
                    <span>Hook Category</span>
                </label>
                <select 
                    id="categorySelect" 
                    x-model="category" 
                    class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-sm text-gray-900 font-semibold focus:outline-none transition-colors cursor-pointer font-sans shadow-md"
                >
                    <option value="all">All Styles (25 Formulas)</option>
                    <option value="contrarian">Contrarian / Hot Take (5 Formulas)</option>
                    <option value="story">Story / Lesson (5 Formulas)</option>
                    <option value="curiosity">Curiosity / Cliffhanger (5 Formulas)</option>
                    <option value="listicle">Listicle / Resource Stack (5 Formulas)</option>
                    <option value="metric">Metric / ROI (5 Formulas)</option>
                </select>
            </div>
        </div>

        <!-- Live Search Bar -->
        <div class="pt-4 border-t border-gray-200 grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
            <div class="md:col-span-6 space-y-2">
                <label for="searchQuery" class="block text-xs font-extrabold uppercase tracking-wider text-black font-mono flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base text-[#006c49]">search</span>
                    <span>Live Search Formulas</span>
                </label>
                <div class="relative">
                    <input 
                        id="searchQuery"
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Search hooks by keyword or style tag..." 
                        class="w-full bg-white border-2 border-gray-300 focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-sm text-gray-900 font-semibold focus:outline-none transition-colors placeholder:text-gray-400 font-sans shadow-md"
                    >
                    <button 
                        type="button"
                        x-show="searchQuery.length > 0" 
                        @click="searchQuery = ''" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black text-xs font-mono font-bold px-2 py-1 transition-colors"
                    >
                        Clear
                    </button>
                </div>
            </div>

            <!-- Quick Topics & Metrics Presets -->
            <div class="md:col-span-6 space-y-2">
                <span class="block text-xs font-mono font-extrabold text-gray-500 uppercase tracking-wider">Quick Preset Topics:</span>
                <div class="flex flex-wrap items-center gap-1.5">
                    <template x-for="preset in topicPresets" :key="preset">
                        <button 
                            type="button"
                            @click="topic = preset"
                            :class="topic === preset ? 'bg-black text-white border-black shadow-md' : 'bg-white hover:bg-emerald-50 hover:text-[#006c49] hover:border-[#006c49] text-gray-800 border-2 border-gray-300'"
                            class="text-xs font-mono font-bold px-2.5 py-1 rounded-lg border-2 transition-all cursor-pointer active:scale-95 shadow-sm"
                            x-text="preset"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Hook Sandbox & Generator Input -->
    <div class="bg-white border-2 border-gray-300 rounded-[1rem] p-6 shadow-md mb-8 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-200 pb-3">
            <h3 class="text-xs font-extrabold text-black uppercase tracking-wider font-mono flex items-center gap-1.5">
                <span class="material-symbols-outlined text-base text-[#006c49]">build</span>
                <span>Custom Hook Sandbox &amp; Generator</span>
            </h3>
            <span class="text-xs font-mono text-gray-500">Supports [TOPIC], [METRIC], [YEAR] tags</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            <div class="md:col-span-9">
                <input 
                    type="text" 
                    x-model="customHookTemplate" 
                    placeholder="e.g. How I used [TOPIC] to hit [METRIC] before [YEAR]:" 
                    class="w-full bg-gray-50 border-2 border-gray-300 focus:border-black focus:ring-0 rounded-xl px-4 py-3 text-sm text-gray-900 font-semibold focus:outline-none transition-colors font-sans shadow-inner"
                >
            </div>
            <div class="md:col-span-3 flex gap-2">
                <button 
                    type="button"
                    @click="addCustomHook()"
                    class="w-full bg-[#006c49] hover:bg-emerald-700 text-white font-mono font-bold text-xs uppercase tracking-wider rounded-xl px-4 py-3 border-2 border-[#006c49] transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer active:scale-95"
                >
                    <span class="material-symbols-outlined text-sm">add_circle</span>
                    <span>Add to Matrix</span>
                </button>
            </div>
        </div>

        <!-- Custom Hook Live Preview -->
        <div x-show="customHookTemplate.length > 0" class="p-4 bg-emerald-50/80 border-2 border-emerald-200 rounded-xl flex items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-[10px] font-mono font-extrabold text-[#006c49] uppercase tracking-wider">Live Interpolated Preview:</span>
                <p class="text-sm font-bold text-gray-900 font-sans" x-text="renderHook(customHookTemplate)"></p>
            </div>
            <button 
                type="button"
                @click="copyHook(renderHook(customHookTemplate), 'custom')"
                class="bg-black hover:bg-[#006c49] text-white font-mono font-bold text-xs uppercase tracking-wider px-3 py-2 rounded-lg border-2 border-black transition-all shrink-0 cursor-pointer shadow-md flex items-center gap-1"
            >
                <span class="material-symbols-outlined text-xs">content_copy</span>
                <span>Copy Preview</span>
            </button>
        </div>
    </div>

    <!-- Hooks Header Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 px-1">
        <div>
            <h2 class="text-xs font-extrabold text-black uppercase tracking-wider font-mono flex items-center gap-1.5">
                <span class="material-symbols-outlined text-base text-[#006c49]">auto_awesome</span>
                <span>Customized Hook Formulas</span>
                <span class="text-xs text-gray-500 font-semibold normal-case font-mono" x-text="`(${filteredHooks.length} matching)`"></span>
            </h2>
            <p class="text-xs text-gray-500 font-medium font-sans">Click any formula card or copy button to instantly copy to your clipboard</p>
        </div>
        <button 
            type="button"
            @click="copyAllFiltered()"
            :class="copiedAll ? 'bg-[#006c49] border-[#006c49] text-white' : 'bg-black hover:bg-[#006c49] border-black hover:border-[#006c49] text-white'"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border-2 text-xs font-mono font-bold uppercase tracking-wider transition-all shadow-md cursor-pointer active:scale-95 shrink-0"
        >
            <span class="material-symbols-outlined text-sm" x-text="copiedAll ? 'check_circle' : 'content_copy'"></span>
            <span x-text="copiedAll ? 'All Hooks Copied!' : 'Copy All Visible Hooks'"></span>
        </button>
    </div>

    <!-- Hooks Output Grid -->
    <div class="space-y-4">
        <template x-for="hook in filteredHooks" :key="hook.id">
            <div 
                @click="copyHook(renderHook(hook.template), hook.id)"
                class="bg-white border-2 border-gray-300 hover:border-black rounded-xl p-5 sm:p-6 transition-all shadow-md hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 group cursor-pointer"
            >
                <div class="min-w-0 flex-1 space-y-2">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <span 
                            class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase font-mono tracking-wider border-2"
                            :class="getCategoryBadgeClass(hook.category)"
                            x-text="getCategoryLabel(hook.category)"
                        ></span>
                        <span class="text-xs font-mono font-semibold text-gray-400 group-hover:text-gray-600 transition-colors" x-text="`Formula #${hook.id}`"></span>
                        <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 border border-gray-300" x-text="hook.styleTag || 'Viral Formula'"></span>
                    </div>
                    <p class="text-base sm:text-lg font-bold text-gray-900 font-sans leading-relaxed tracking-tight" x-text="renderHook(hook.template)"></p>
                </div>
                <div class="flex items-center shrink-0">
                    <button 
                        type="button"
                        @click.stop="copyHook(renderHook(hook.template), hook.id)"
                        :class="copiedId === hook.id ? 'bg-[#006c49] hover:bg-emerald-700 text-white border-[#006c49]' : 'bg-black hover:bg-[#006c49] text-white border-black hover:border-[#006c49]'"
                        class="w-full sm:w-auto font-mono font-bold text-xs uppercase tracking-wider rounded-xl px-4 py-2.5 border-2 transition-all shrink-0 shadow-md flex items-center justify-center gap-2 cursor-pointer active:scale-95"
                    >
                        <span class="material-symbols-outlined text-sm" x-text="copiedId === hook.id ? 'check' : 'content_copy'"></span>
                        <span x-text="copiedId === hook.id ? 'Copied!' : 'Copy Hook'"></span>
                    </button>
                </div>
            </div>
        </template>

        <!-- Empty State -->
        <div x-show="filteredHooks.length === 0" class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-8 text-center space-y-3 font-sans">
            <span class="material-symbols-outlined text-3xl text-gray-400">search_off</span>
            <p class="text-sm font-semibold text-gray-700">No hook templates match your selected category or search filters.</p>
            <button 
                type="button" 
                @click="resetFilters()" 
                class="inline-flex items-center gap-1.5 text-xs font-mono font-bold text-black uppercase tracking-wider bg-white border-2 border-black px-4 py-2 rounded-xl hover:bg-gray-100 transition-colors cursor-pointer shadow-md active:scale-95"
            >
                Reset All Filters
            </button>
        </div>
    </div>

    <!-- Editorial Best Practices Banner -->
    <div class="mt-10 bg-emerald-50/90 border-2 border-emerald-200/90 text-[#006c49] rounded-[1rem] p-6 sm:p-8 shadow-md space-y-4">
        <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-[#006c49] text-white flex items-center justify-center shrink-0 mt-0.5 shadow-md">
                <span class="material-symbols-outlined text-xl">lightbulb</span>
            </div>
            <div class="space-y-2 flex-1">
                <h3 class="text-base font-extrabold text-black tracking-tight font-sans">
                    Viral LinkedIn Hook Blueprint (Taplio &amp; Justin Welsh Best Practices)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-1">
                    <div class="bg-white border-2 border-emerald-200/80 rounded-xl p-4 space-y-1 shadow-md">
                        <div class="text-xs font-mono font-extrabold text-[#006c49] uppercase tracking-wider flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            1. Tension in Line 1 (140 Chars)
                        </div>
                        <p class="text-xs text-gray-700 font-medium leading-relaxed font-sans">
                            Mobile LinkedIn feeds truncate posts after 2–3 lines. Your opening line MUST trigger high curiosity or tension before the "see more" fold.
                        </p>
                    </div>
                    <div class="bg-white border-2 border-emerald-200/80 rounded-xl p-4 space-y-1 shadow-md">
                        <div class="text-xs font-mono font-extrabold text-[#006c49] uppercase tracking-wider flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">space_bar</span>
                            2. White Space &amp; Line Breaks
                        </div>
                        <p class="text-xs text-gray-700 font-medium leading-relaxed font-sans">
                            Follow your hook with a blank line break. Readers skim on mobile; isolated single-sentence lines boost read-through rates by up to 3x.
                        </p>
                    </div>
                    <div class="bg-white border-2 border-emerald-200/80 rounded-xl p-4 space-y-1 shadow-md">
                        <div class="text-xs font-mono font-extrabold text-[#006c49] uppercase tracking-wider flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">pin_drop</span>
                            3. Specificity &amp; Metrics
                        </div>
                        <p class="text-xs text-gray-700 font-medium leading-relaxed font-sans">
                            Replace generic claims with concrete timeframes, percentages, or dollar amounts to build immediate authority and trust.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO & Educational Content Section -->
    <div class="mt-12 bg-white border-2 border-gray-300 rounded-[1rem] p-6 sm:p-10 shadow-md space-y-8 font-sans">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#006c49]/10 border border-[#006c49]/30 rounded-full">
                <span class="material-symbols-outlined text-sm text-[#006c49]">auto_stories</span>
                <span class="font-mono text-xs text-[#006c49] font-extrabold uppercase tracking-wider">LINKEDIN GROWTH GUIDE</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-black tracking-tight">
                How to Write High-Converting LinkedIn Opening Hooks
            </h2>
            <p class="text-sm sm:text-base text-gray-600 font-medium leading-relaxed">
                The opening line of your LinkedIn post is responsible for 90% of your total reach and engagement. On mobile devices, LinkedIn truncates posts after approximately 140 to 210 characters, displaying a small blue <strong>"see more"</strong> button. If your hook fails to generate immediate curiosity, readers scroll past—and the LinkedIn algorithm registers low dwell time, throttling your organic reach.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-[#f8f9fa] border-2 border-gray-300 rounded-xl p-5 space-y-2">
                <h3 class="text-base font-extrabold text-black flex items-center gap-2 font-mono">
                    <span class="material-symbols-outlined text-[#006c49]">speed</span>
                    Algorithm Dwell Time Mechanics
                </h3>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                    LinkedIn's algorithm prioritizes <em>Dwell Time</em>—the exact amount of milliseconds a user stays paused over your post in their feed. A compelling hook forces the reader to stop scrolling and tap "see more", sending an immediate positive signal to the recommendation engine.
                </p>
            </div>
            <div class="bg-[#f8f9fa] border-2 border-gray-300 rounded-xl p-5 space-y-2">
                <h3 class="text-base font-extrabold text-black flex items-center gap-2 font-mono">
                    <span class="material-symbols-outlined text-[#006c49]">pie_chart</span>
                    The 5 Core Hook Archetypes
                </h3>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                    Top creators use 5 primary hook psychological patterns: <strong>Contrarian</strong> (challenges status quo), <strong>Story</strong> (personal transformation), <strong>Curiosity</strong> (open loop framework), <strong>Listicle</strong> (resource stack), and <strong>Metric</strong> (data proof).
                </p>
            </div>
        </div>

    </div>

    <!-- Elegant PostPilot Promotional CTA Section -->
    <div class="mt-12 bg-black text-white border-2 border-black rounded-[1rem] p-8 sm:p-10 shadow-[8px_8px_0px_0px_rgba(0,108,73,1)] relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-[#006c49]/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="space-y-3 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#006c49]/40 border border-[#006c49] text-emerald-400 text-[11px] font-extrabold uppercase tracking-widest font-mono">
                    <span class="material-symbols-outlined text-sm">bolt</span>
                    <span>Turn Hooks Into 30 Days of Content</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight font-sans">
                    Never write a LinkedIn post manually again.
                </h3>
                <p class="text-gray-300 text-sm sm:text-base max-w-xl font-medium leading-relaxed font-sans">
                    Input your brand brief once, and <strong class="text-emerald-400 font-bold">PostPilot</strong> uses AI to generate, format, and schedule an entire month of high-converting LinkedIn &amp; X posts complete with viral hooks.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0 w-full lg:w-auto">
                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-6 py-3.5 bg-[#006c49] hover:bg-emerald-600 text-white font-mono font-bold text-xs uppercase tracking-wider rounded-xl border-2 border-[#006c49] transition-all shadow-md active:scale-95">
                    <span>Start Free Trial</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white/10 hover:bg-white/20 text-white font-mono font-bold text-xs uppercase tracking-wider rounded-xl border border-white/20 transition-all font-sans">
                    <span>Learn How It Works</span>
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
                    'question' => 'What is a LinkedIn hook and why does it matter?',
                    'answer' => 'A LinkedIn hook is the opening sentence or line of your post visible before the "see more" truncation cutoff. It matters because it determines whether a reader stops scrolling (dwell time) and expands your post, directly impacting your organic reach in the LinkedIn algorithm.'
                ],
                [
                    'question' => 'What are the best-performing LinkedIn post hooks?',
                    'answer' => 'The best-performing LinkedIn post hooks fall into five core categories: contrarian hot takes that challenge industry myths, data-backed metric claims, personal story case studies, resource listicles, and curiosity cliffhangers. Hooks that combine specific numbers with strong emotional tension consistently drive the highest engagement.'
                ],
                [
                    'question' => 'How many words should a LinkedIn hook be?',
                    'answer' => 'A LinkedIn hook should ideally be between 6 and 15 words, keeping line 1 under 140 characters so it displays in full on mobile screens. Keeping your hook concise and following it with a blank line break maximizes readability and encourages users to tap "see more".'
                ],
                [
                    'question' => 'Do hook templates actually increase engagement?',
                    'answer' => 'Yes, using proven hook templates increases post engagement by tapping into established psychological triggers like curiosity, fear of missing out, and social proof. Creators and founders who use structured opening formulas regularly report 2x to 5x higher impression counts and dwell times.'
                ],
                [
                    'question' => 'Can I use these hooks for X (Twitter) or Facebook posts?',
                    'answer' => 'Absolutely. The psychological principles behind viral LinkedIn hooks work seamlessly for X (Twitter) thread openers, Facebook post captions, YouTube titles, and email subject lines. You can easily adapt these 25+ formulas for any short-form or long-form social content strategy.'
                ],
                [
                    'question' => 'How often should I change my LinkedIn post hooks?',
                    'answer' => 'You should rotate across different hook styles (contrarian, metric, story, listicle, curiosity) throughout the week to keep your content feed fresh. Avoid using the exact same formula consecutively, but feel free to reuse high-performing hook structures across different topics and industry angles.'
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

    <!-- Toast Notification Banner -->
    <div 
        x-show="toast.visible" 
        x-cloak
        x-transition:enter="toast-enter"
        x-transition:enter-start="toast-enter"
        x-transition:enter-end="toast-enter-active"
        x-transition:leave="toast-leave"
        x-transition:leave-start="toast-leave"
        x-transition:leave-end="toast-leave-end"
        class="fixed bottom-5 right-5 z-50 flex items-center gap-3 bg-black text-white px-5 py-3.5 rounded-xl shadow-2xl border-2 border-[#006c49]"
    >
        <span class="material-symbols-outlined text-[#006c49] text-xl">check_circle</span>
        <span class="font-mono text-xs font-bold tracking-wide" x-text="toast.message"></span>
    </div>

</div>

<!-- JSON-LD Structured Data Schema for SEO -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebApplication",
  "name": "LinkedIn Viral Hook Templates & Generator",
  "url": "{{ url()->current() }}",
  "description": "Free client-side tool to generate, interpolate, and filter viral LinkedIn opening hooks across Contrarian, Story, Curiosity, Listicle, and Metric categories.",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "All",
  "offers": {
    "@@type": "Offer",
    "price": "0",
    "priceCurrency": "USD"
  }
}
</script>

<script>
function hookTemplates() {
    return {
        topic: 'SaaS Marketing',
        metric: '$100k ARR',
        year: '2026',
        category: 'all',
        searchQuery: '',
        copiedId: null,
        copiedAll: false,
        customHookTemplate: '',

        toast: {
            visible: false,
            message: '',
            timer: null
        },

        topicPresets: [
            'SaaS Marketing', 
            'Personal Branding', 
            'AI Tools', 
            'Remote Work', 
            'B2B Sales', 
            'Copywriting', 
            'Solopreneurship', 
            'Growth Hacking'
        ],

        templates: [
            // Contrarian (5)
            { id: 1, category: 'contrarian', styleTag: 'Pattern Interrupt', template: "Most people fail at [TOPIC] because they follow advice from 2021." },
            { id: 2, category: 'contrarian', styleTag: 'Unpopular Opinion', template: "Unpopular opinion: You don't need a huge team or budget to master [TOPIC] in [YEAR]." },
            { id: 3, category: 'contrarian', styleTag: 'Myth Busting', template: "Stop overcomplicating [TOPIC]. Here is the 1 thing that actually matters:" },
            { id: 4, category: 'contrarian', styleTag: 'Counter-Intuitive', template: "9 out of 10 people get [TOPIC] completely backwards. Here is why:" },
            { id: 5, category: 'contrarian', styleTag: 'Industry Flaw', template: "Everyone is talking about [TOPIC], but almost nobody is talking about this key flaw:" },

            // Story / Lesson (5)
            { id: 6, category: 'story', styleTag: 'Origin Story', template: "In 2024, I knew nothing about [TOPIC]. Today, it generated [METRIC]." },
            { id: 7, category: 'story', styleTag: 'Case Study', template: "I spent 6 months testing [TOPIC] so you don't have to. Here is what happened:" },
            { id: 8, category: 'story', styleTag: 'Hard Truths', template: "The biggest mistake I made when learning [TOPIC] cost me [METRIC] and 100+ hours:" },
            { id: 9, category: 'story', styleTag: 'Lessons Learned', template: "3 hard-learned lessons about [TOPIC] that I wish I knew 3 years ago:" },
            { id: 10, category: 'story', styleTag: 'Comeback Story', template: "My first attempt at [TOPIC] was a complete disaster. Here is how we turned it into [METRIC]:" },

            // Curiosity / Cliffhanger (5)
            { id: 11, category: 'curiosity', styleTag: 'Teardown', template: "How to master [TOPIC] in 15 minutes a day (and hit [METRIC] without spending a dollar):" },
            { id: 12, category: 'curiosity', styleTag: 'Secret Framework', template: "95% of creators ignore this simple framework for [TOPIC] in [YEAR]:" },
            { id: 13, category: 'curiosity', styleTag: 'Weekly Checklist', template: "The exact step-by-step checklist we use for [TOPIC] every single week:" },
            { id: 14, category: 'curiosity', styleTag: 'Growth Hack', template: "The single most underrated strategy for [TOPIC] in [YEAR]:" },
            { id: 15, category: 'curiosity', styleTag: 'Day 1 Blueprint', template: "If I had to restart my journey in [TOPIC] from scratch in [YEAR], I'd do these 4 things:" },

            // Listicle / Framework (5)
            { id: 16, category: 'listicle', styleTag: 'Tool Stack', template: "Here are 5 free tools that will completely change how you approach [TOPIC]:" },
            { id: 17, category: 'listicle', styleTag: 'Rule Book', template: "7 non-obvious [TOPIC] rules that top 1% creators use to reach [METRIC]:" },
            { id: 18, category: 'listicle', styleTag: 'Automation Stack', template: "The 4-step [TOPIC] stack I use to automate 80% of my work and hit [METRIC]:" },
            { id: 19, category: 'listicle', styleTag: 'Core Principles', template: "5 bulletproof principles for [TOPIC] that every founder should memorize in [YEAR]:" },
            { id: 20, category: 'listicle', styleTag: 'Prompt Matrix', template: "A cheat sheet of 6 actionable prompts to level up your [TOPIC] strategy:" },

            // Metric / ROI (5)
            { id: 21, category: 'metric', styleTag: 'Data Proof', template: "How we generated [METRIC] using a simple 3-step [TOPIC] strategy in [YEAR]:" },
            { id: 22, category: 'metric', styleTag: 'Benchmark Stats', template: "We analyzed 500+ campaigns in [TOPIC]. The top 1% all share this [METRIC] milestone:" },
            { id: 23, category: 'metric', styleTag: 'Time ROI', template: "How to save 10 hours a week on [TOPIC] while scaling to [METRIC]:" },
            { id: 24, category: 'metric', styleTag: 'Revenue Breakdown', template: "The exact breakdown of how [TOPIC] drove [METRIC] in under 90 days:" },
            { id: 25, category: 'metric', styleTag: 'Efficiency System', template: "We cut [TOPIC] execution time by 65% while increasing results to [METRIC]. Here is how:" }
        ],

        get totalCount() {
            return this.templates.length;
        },

        get contrarianCount() {
            return this.templates.filter(h => h.category === 'contrarian').length;
        },

        get storyCount() {
            return this.templates.filter(h => h.category === 'story').length;
        },

        get curiosityCount() {
            return this.templates.filter(h => h.category === 'curiosity').length;
        },

        get listicleCount() {
            return this.templates.filter(h => h.category === 'listicle').length;
        },

        get metricCount() {
            return this.templates.filter(h => h.category === 'metric').length;
        },

        get filteredHooks() {
            const q = (this.searchQuery || '').trim().toLowerCase();
            return this.templates.filter(h => {
                const catMatch = this.category === 'all' || h.category === this.category;
                let searchMatch = true;
                if (q !== '') {
                    const rendered = this.renderHook(h.template).toLowerCase();
                    const catLabel = this.getCategoryLabel(h.category).toLowerCase();
                    const styleTag = (h.styleTag || '').toLowerCase();
                    searchMatch = rendered.includes(q) || catLabel.includes(q) || styleTag.includes(q);
                }
                return catMatch && searchMatch;
            });
        },

        renderHook(tmpl) {
            if (!tmpl) return '';
            const rawTopic = (this.topic || '').trim();
            const t = rawTopic !== '' ? rawTopic : 'your topic';

            const rawMetric = (this.metric || '').trim();
            const m = rawMetric !== '' ? rawMetric : '$100k ARR';

            const rawYear = (this.year || '').trim();
            const y = rawYear !== '' ? rawYear : '2026';

            return tmpl
                .replace(/\[TOPIC\]/gi, t)
                .replace(/\[METRIC\]/gi, m)
                .replace(/\[YEAR\]/gi, y);
        },

        addCustomHook() {
            const raw = (this.customHookTemplate || '').trim();
            if (!raw) return;
            const newId = this.templates.length > 0 ? Math.max(...this.templates.map(t => t.id)) + 1 : 1;
            this.templates.unshift({
                id: newId,
                category: 'curiosity',
                styleTag: 'Custom Sandbox Hook',
                template: raw
            });
            this.showToast(`Custom Hook #${newId} added to template matrix!`);
            this.customHookTemplate = '';
        },

        getCategoryBadgeClass(cat) {
            switch (cat) {
                case 'contrarian':
                    return 'bg-rose-50 text-rose-800 border-rose-200 font-mono';
                case 'story':
                    return 'bg-indigo-50 text-indigo-800 border-indigo-200 font-mono';
                case 'curiosity':
                    return 'bg-emerald-50 text-[#006c49] border-emerald-200 font-mono';
                case 'listicle':
                    return 'bg-amber-50 text-amber-900 border-amber-200 font-mono';
                case 'metric':
                    return 'bg-sky-50 text-sky-900 border-sky-200 font-mono';
                default:
                    return 'bg-gray-100 text-gray-800 border-gray-300 font-mono';
            }
        },

        getCategoryLabel(cat) {
            switch (cat) {
                case 'contrarian':
                    return 'Contrarian';
                case 'story':
                    return 'Story / Lesson';
                case 'curiosity':
                    return 'Curiosity';
                case 'listicle':
                    return 'Listicle';
                case 'metric':
                    return 'Metric / ROI';
                default:
                    return cat;
            }
        },

        copyHook(text, id) {
            if (!text) return;
            this.writeClipboard(text, () => {
                this.copiedId = id;
                this.showToast('Hook copied to clipboard!');
                setTimeout(() => {
                    if (this.copiedId === id) {
                        this.copiedId = null;
                    }
                }, 2000);
            });
        },

        copyAllFiltered() {
            const allText = this.filteredHooks
                .map(h => this.renderHook(h.template))
                .join('\n\n');
            if (!allText) return;
            this.writeClipboard(allText, () => {
                this.copiedAll = true;
                this.showToast(`All ${this.filteredHooks.length} visible hooks copied!`);
                setTimeout(() => this.copiedAll = false, 2000);
            });
        },

        resetFilters() {
            this.category = 'all';
            this.searchQuery = '';
            this.topic = 'SaaS Marketing';
            this.metric = '$100k ARR';
            this.year = '2026';
            this.showToast('Filters reset to default.');
        },

        showToast(msg) {
            this.toast.message = msg;
            this.toast.visible = true;
            if (this.toast.timer) clearTimeout(this.toast.timer);
            this.toast.timer = setTimeout(() => {
                this.toast.visible = false;
            }, 3000);
        },

        writeClipboard(text, callback) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    callback();
                }).catch(() => {
                    this.fallbackCopy(text);
                    callback();
                });
            } else {
                this.fallbackCopy(text);
                callback();
            }
        },

        fallbackCopy(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-9999px';
            textArea.style.top = '-9999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
            } catch (err) {
                console.error('Fallback copy failed', err);
            }
            document.body.removeChild(textArea);
        }
    }
}
</script>
@endsection
