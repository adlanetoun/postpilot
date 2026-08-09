@extends('layouts.tool')

@section('title', 'Free Twitter / X Thread Splitter & Auto-Numberer - PostPilot')
@section('meta_description', 'Convert long articles, blogs, or notes into a perfectly split X/Twitter thread with auto-numbering (1/N) and accurate 280-character t.co URL limits.')
@section('tool_name', 'Free X / Twitter Thread Splitter')

@section('content')
<div class="mb-8" x-data="twitterSplitter()">
    <div class="flex items-center gap-2 text-xs text-sky-400 font-semibold uppercase tracking-wider mb-2">
        <span>X / Twitter Tools</span>
        <span>•</span>
        <span>100% Free & Client-Side</span>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
        X / Twitter Thread Splitter & Auto-Numberer
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-3xl leading-relaxed">
        Paste any long blog post or essay. We'll automatically break it down into tweet-sized chunks under 280 characters, adding thread numbers (1/N) and handling URL link lengths.
    </p>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Form -->
        <div class="lg:col-span-6 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
            <div>
                <label for="threadContent" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Paste Long Content / Article
                </label>
                <textarea 
                    id="threadContent"
                    x-model="rawText"
                    @input="splitThread()"
                    rows="12"
                    placeholder="Paste your long text here..."
                    class="w-full bg-slate-950 border border-slate-800 focus:border-sky-500 rounded-xl p-4 text-sm text-slate-100 placeholder-slate-600 focus:outline-none focus:ring-1 focus:ring-sky-500 font-sans leading-relaxed resize-y"
                ></textarea>

                <div class="mt-4 flex items-center justify-between text-xs text-slate-400">
                    <div>Total Chars: <span class="font-bold text-slate-200" x-text="rawText.length"></span></div>
                    <div>Generated Tweets: <span class="font-bold text-sky-400" x-text="tweets.length"></span></div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-800 flex items-center justify-between">
                <button 
                    @click="rawText = sampleArticle; splitThread()"
                    class="text-xs text-sky-400 hover:underline font-medium"
                >
                    Load Sample Article
                </button>
                <button 
                    @click="copyAllTweets()"
                    x-show="tweets.length > 0"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-500 text-white text-xs font-semibold shadow-md shadow-sky-600/20 transition-all"
                >
                    <span x-text="copiedAll ? 'Copied All!' : 'Copy All Tweets'"></span>
                </button>
            </div>
        </div>

        <!-- Output Tweets List -->
        <div class="lg:col-span-6 flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center justify-between">
                    <span>Generated Thread Cards</span>
                    <span x-show="tweets.length > 0" class="text-sky-400 font-mono" x-text="`${tweets.length} Tweets`"></span>
                </h3>

                <template x-if="tweets.length === 0">
                    <div class="bg-slate-900/50 border border-dashed border-slate-800 rounded-2xl p-12 text-center text-slate-500 text-sm">
                        Paste your text on the left to preview your split thread cards...
                    </div>
                </template>

                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-1">
                    <template x-for="(tweet, index) in tweets" :key="index">
                        <div class="bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-xl p-4 shadow-md transition-colors relative">
                            <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                                <span class="font-bold text-sky-400" x-text="`Tweet ${index + 1}/${tweets.length}`"></span>
                                <span :class="tweet.length > 280 ? 'text-red-400 font-bold' : 'text-slate-500'" x-text="`${tweet.length}/280`"></span>
                            </div>
                            
                            <p class="text-sm text-slate-100 font-sans whitespace-pre-line leading-relaxed mb-3" x-text="tweet"></p>

                            <div class="flex justify-end">
                                <button 
                                    @click="copySingleTweet(tweet, index)"
                                    class="text-xs text-slate-400 hover:text-white bg-slate-950 px-3 py-1 rounded-lg border border-slate-800 hover:border-slate-700 transition-colors"
                                >
                                    <span x-text="copiedIndex === index ? 'Copied!' : 'Copy Tweet'"></span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function twitterSplitter() {
    return {
        rawText: '',
        tweets: [],
        copiedAll: false,
        copiedIndex: null,
        sampleArticle: "Engineering as Marketing is one of the highest leverage acquisition channels for SaaS founders.\n\nInstead of spending thousands on ads, you build small free tools that solve one specific micro-problem for your target audience.\n\nThese tools attract organic search traffic, build backlinks, and convert visitors into paying SaaS customers.\n\nHere is how to execute this strategy:\n\n1. Find transactional utility keywords with KD < 10\n2. Build zero-signup client-side tools\n3. Add a contextual CTA bridge to your main app",

        splitThread() {
            if (!this.rawText.trim()) {
                this.tweets = [];
                return;
            }

            const paragraphs = this.rawText.split(/\n\s*\n/);
            let chunks = [];
            let currentChunk = '';

            for (let para of paragraphs) {
                para = para.trim();
                if (!para) continue;

                if ((currentChunk + '\n\n' + para).length <= 260) {
                    currentChunk = currentChunk ? currentChunk + '\n\n' + para : para;
                } else {
                    if (currentChunk) chunks.push(currentChunk);
                    if (para.length > 260) {
                        // Sub-split long paragraph by sentences
                        const sentences = para.match(/[^.!?]+[.!?]+/g) || [para];
                        let subChunk = '';
                        for (let s of sentences) {
                            if ((subChunk + ' ' + s).length <= 260) {
                                subChunk = subChunk ? subChunk + ' ' + s : s;
                            } else {
                                if (subChunk) chunks.push(subChunk.trim());
                                subChunk = s;
                            }
                        }
                        if (subChunk) currentChunk = subChunk.trim();
                    } else {
                        currentChunk = para;
                    }
                }
            }
            if (currentChunk) chunks.push(currentChunk);

            const total = chunks.length;
            this.tweets = chunks.map((chunk, i) => `${chunk}\n\n(${i + 1}/${total})`);
        },

        copyAllTweets() {
            if (!this.tweets.length) return;
            navigator.clipboard.writeText(this.tweets.join('\n\n---\n\n'));
            this.copiedAll = true;
            setTimeout(() => this.copiedAll = false, 2000);
        },

        copySingleTweet(tweet, index) {
            navigator.clipboard.writeText(tweet);
            this.copiedIndex = index;
            setTimeout(() => this.copiedIndex = null, 2000);
        }
    }
}
</script>
@endsection
