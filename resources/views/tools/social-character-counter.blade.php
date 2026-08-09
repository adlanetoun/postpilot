@extends('layouts.tool')

@section('title', 'Free Multi-Platform Social Media Character Counter - PostPilot')
@section('meta_description', 'Track character limits, word counts, and line counts simultaneously across LinkedIn, Twitter/X, and Facebook in real time.')
@section('tool_name', 'Free Multi-Platform Social Media Character Counter')

@section('content')
<div class="mb-8" x-data="socialCounter()">
    <div class="flex items-center gap-2 text-xs text-purple-400 font-semibold uppercase tracking-wider mb-2">
        <span>Character Counter</span>
        <span>•</span>
        <span>100% Free & Client-Side</span>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
        Multi-Platform Social Character Limit Counter
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-3xl leading-relaxed">
        Type or paste your post below to monitor character limits and line counts across LinkedIn, X/Twitter, and Facebook in a real-time progress dashboard.
    </p>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Area -->
        <div class="lg:col-span-7 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="counterInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                        Post Content
                    </label>
                    <button x-on:click="text = ''" x-show="text.length > 0" class="text-xs text-slate-500 hover:text-slate-300">Clear</button>
                </div>
                
                <textarea 
                    id="counterInput"
                    x-model="text"
                    rows="10"
                    placeholder="Start typing your post..."
                    class="w-full bg-slate-950 border border-slate-800 focus:border-purple-500 rounded-xl p-4 text-base text-slate-100 placeholder-slate-600 focus:outline-none focus:ring-1 focus:ring-purple-500 font-sans leading-relaxed resize-y"
                ></textarea>

                <div class="mt-4 grid grid-cols-4 gap-2 text-center text-xs">
                    <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800">
                        <span class="block text-slate-500 mb-0.5">Chars</span>
                        <span class="font-bold text-white text-sm" x-text="text.length"></span>
                    </div>
                    <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800">
                        <span class="block text-slate-500 mb-0.5">Words</span>
                        <span class="font-bold text-white text-sm" x-text="wordCount"></span>
                    </div>
                    <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800">
                        <span class="block text-slate-500 mb-0.5">Sentences</span>
                        <span class="font-bold text-white text-sm" x-text="sentenceCount"></span>
                    </div>
                    <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800">
                        <span class="block text-slate-500 mb-0.5">Read Time</span>
                        <span class="font-bold text-purple-400 text-sm" x-text="readTime"></span>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-800 flex items-center justify-between">
                <button 
                    x-on:click="copyAll()"
                    class="px-4 py-2 bg-purple-600 hover:bg-purple-500 text-white text-xs font-semibold rounded-xl shadow-md transition-colors"
                >
                    <span x-text="copied ? 'Copied!' : 'Copy Text'"></span>
                </button>
            </div>
        </div>

        <!-- Limits Progress Column -->
        <div class="lg:col-span-5 space-y-4">
            <!-- Twitter/X -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-md">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-bold text-sky-400">X / Twitter</span>
                    <span class="text-xs font-mono" :class="text.length > 280 ? 'text-red-400 font-bold' : 'text-slate-400'" x-text="`${text.length} / 280`"></span>
                </div>
                <div class="w-full bg-slate-950 h-2 rounded-full overflow-hidden border border-slate-800">
                    <div class="h-full transition-all duration-300" :style="`width: ${Math.min((text.length / 280) * 100, 100)}%`" :class="text.length > 280 ? 'bg-red-500' : 'bg-sky-500'"></div>
                </div>
                <span class="block text-xs mt-2" :class="text.length > 280 ? 'text-red-400 font-semibold' : 'text-slate-500'" x-text="text.length > 280 ? `Exceeds limit by ${text.length - 280} chars` : `${280 - text.length} chars remaining`"></span>
            </div>

            <!-- LinkedIn -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-md">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-bold text-blue-400">LinkedIn Post</span>
                    <span class="text-xs font-mono" :class="text.length > 3000 ? 'text-red-400 font-bold' : 'text-slate-400'" x-text="`${text.length} / 3,000`"></span>
                </div>
                <div class="w-full bg-slate-950 h-2 rounded-full overflow-hidden border border-slate-800">
                    <div class="h-full transition-all duration-300" :style="`width: ${Math.min((text.length / 3000) * 100, 100)}%`" :class="text.length > 3000 ? 'bg-red-500' : 'bg-blue-500'"></div>
                </div>
                <span class="block text-xs mt-2" :class="text.length > 3000 ? 'text-red-400 font-semibold' : 'text-slate-500'" x-text="text.length > 3000 ? `Exceeds limit by ${text.length - 3000} chars` : `${3000 - text.length} chars remaining`"></span>
            </div>

            <!-- Facebook -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-md">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-bold text-indigo-400">Facebook Post</span>
                    <span class="text-xs font-mono text-slate-400" x-text="`${text.length} / 63,206`"></span>
                </div>
                <div class="w-full bg-slate-950 h-2 rounded-full overflow-hidden border border-slate-800">
                    <div class="h-full transition-all duration-300 bg-indigo-500" :style="`width: ${Math.min((text.length / 63206) * 100, 100)}%`"></div>
                </div>
                <span class="block text-xs text-slate-500 mt-2">Optimal length for Facebook is ~250-400 characters.</span>
            </div>
        </div>
    </div>
</div>

<script>
function socialCounter() {
    return {
        text: '',
        copied: false,
        get wordCount() { return this.text.trim() ? this.text.trim().split(/\s+/).length : 0; },
        get sentenceCount() { return this.text.trim() ? (this.text.match(/[^.!?]+[.!?]+/g) || [this.text]).length : 0; },
        get readTime() {
            const words = this.wordCount;
            const minutes = Math.ceil(words / 200);
            return minutes <= 1 ? '< 1 min' : `${minutes} mins`;
        },
        copyAll() {
            if (!this.text) return;
            navigator.clipboard.writeText(this.text);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
    }
}
</script>
@endsection
