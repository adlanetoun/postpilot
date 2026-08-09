@extends('layouts.tool')

@section('title', 'Free LinkedIn Hook Generator Template Matrix - PostPilot')
@section('meta_description', 'Overcome writer\'s block with 50+ viral LinkedIn opening hook formulas filtered by topic, story, curiosity, and contrarian styles.')
@section('tool_name', 'Free LinkedIn Hook Generator Template Matrix')

@section('content')
<div class="mb-8" x-data="hookTemplates()">
    <div class="flex items-center gap-2 text-xs text-indigo-400 font-semibold uppercase tracking-wider mb-2">
        <span>Content Generation</span>
        <span>•</span>
        <span>100% Free & Client-Side</span>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
        LinkedIn Hook Generator Template Matrix
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-3xl leading-relaxed">
        Stop staring at a blank screen. Enter your post topic below to instantly customize 15 proven viral LinkedIn opening hooks.
    </p>

    <div class="mt-8 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            <div class="sm:col-span-8">
                <label for="topicInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                    Your Post Topic / Keyword
                </label>
                <input 
                    id="topicInput"
                    type="text" x-model="topic" 
                    placeholder="e.g. SaaS growth, remote work, AI tools, copywriting" 
                    class="w-full bg-slate-950 border border-slate-800 focus:border-indigo-500 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none"
                >
            </div>

            <div class="sm:col-span-4">
                <label for="categorySelect" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                    Hook Category
                </label>
                <select id="categorySelect" x-model="category" class="w-full bg-slate-950 border border-slate-800 focus:border-indigo-500 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none">
                    <option value="all">All Styles (15)</option>
                    <option value="contrarian">Contrarian / Hot Take</option>
                    <option value="story">Story / Lesson</option>
                    <option value="curiosity">Curiosity / Cliffhanger</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Hooks Output Grid -->
    <div class="space-y-4">
        <template x-for="(hook, index) in filteredHooks" :key="index">
            <div class="bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-xl p-4 shadow-md transition-colors flex items-center justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <span class="inline-block px-2 py-0.5 rounded bg-indigo-950 text-indigo-400 text-[10px] font-bold uppercase tracking-wider mb-1" x-text="hook.category"></span>
                    <p class="text-sm font-semibold text-slate-100 font-sans leading-relaxed" x-text="renderHook(hook.template)"></p>
                </div>
                <button 
                    x-on:click="copyHook(renderHook(hook.template), index)"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-lg shrink-0 transition-colors"
                >
                    <span x-text="copiedIndex === index ? 'Copied!' : 'Copy Hook'"></span>
                </button>
            </div>
        </template>
    </div>
</div>

<script>
function hookTemplates() {
    return {
        topic: 'SaaS Marketing',
        category: 'all',
        copiedIndex: null,

        templates: [
            { category: 'contrarian', template: "Most people fail at [TOPIC] because they follow advice from 2021." },
            { category: 'contrarian', template: "Unpopular opinion: You don't need a huge team to master [TOPIC]." },
            { category: 'contrarian', template: "Stop overcomplicating [TOPIC]. Here is the 1 thing that actually matters:" },
            { category: 'story', template: "In 2024, I knew nothing about [TOPIC]. Today, it generates 80% of our growth." },
            { category: 'story', template: "I spent 6 months testing [TOPIC] so you don't have to." },
            { category: 'story', template: "The biggest mistake I made when learning [TOPIC] cost me 100+ hours:" },
            { category: 'curiosity', template: "How to master [TOPIC] in 15 minutes a day (without spending a dollar):" },
            { category: 'curiosity', template: "95% of creators ignore this simple framework for [TOPIC]:" },
            { category: 'curiosity', template: "Here are 5 free tools that will completely change how you approach [TOPIC]:" },
            { category: 'contrarian', template: "9 out of 10 people get [TOPIC] completely backwards." },
            { category: 'story', template: "3 hard-learned lessons about [TOPIC] that I wish I knew earlier:" },
            { category: 'curiosity', template: "The exact step-by-step checklist we use for [TOPIC]:" }
        ],

        get filteredHooks() {
            if (this.category === 'all') return this.templates;
            return this.templates.filter(h => h.category === this.category);
        },

        renderHook(tmpl) {
            const t = this.topic.trim() || 'your topic';
            return tmpl.replace(/\[TOPIC\]/g, t);
        },

        copyHook(text, index) {
            navigator.clipboard.writeText(text);
            this.copiedIndex = index;
            setTimeout(() => this.copiedIndex = null, 2000);
        }
    }
}
</script>
@endsection
