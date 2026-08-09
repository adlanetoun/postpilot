@extends('layouts.tool')

@section('title', 'Free Social Media Engagement Rate Calculator - PostPilot')
@section('meta_description', 'Compute post or account engagement percentage with industry benchmarks and receive an instant A+ through F engagement grade.')
@section('tool_name', 'Free Engagement Rate Calculator')

@section('content')
<div class="mb-8" x-data="engagementCalc()">
    <div class="flex items-center gap-2 text-xs text-rose-400 font-semibold uppercase tracking-wider mb-2">
        <span>Audit & Grade</span>
        <span>•</span>
        <span>100% Free & Client-Side</span>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
        Social Media Engagement Rate Calculator
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-3xl leading-relaxed">
        Test how well your content performs. Enter your follower count and engagement metrics below to calculate your exact Engagement Rate % and letter grade.
    </p>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Form -->
        <div class="lg:col-span-6 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
            <div>
                <label for="followersCount" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                    Total Followers / Connections *
                </label>
                <input 
                    id="followersCount"
                    type="number" min="1" x-model.number="followers" 
                    placeholder="e.g. 5000" 
                    class="w-full bg-slate-950 border border-slate-800 focus:border-rose-500 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none"
                >
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label for="likesCount" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Likes
                    </label>
                    <input 
                        id="likesCount"
                        type="number" min="0" x-model.number="likes" 
                        class="w-full bg-slate-950 border border-slate-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white focus:outline-none"
                    >
                </div>
                <div>
                    <label for="commentsCount" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Comments
                    </label>
                    <input 
                        id="commentsCount"
                        type="number" min="0" x-model.number="comments" 
                        class="w-full bg-slate-950 border border-slate-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white focus:outline-none"
                    >
                </div>
                <div>
                    <label for="sharesCount" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Shares / Reposts
                    </label>
                    <input 
                        id="sharesCount"
                        type="number" min="0" x-model.number="shares" 
                        class="w-full bg-slate-950 border border-slate-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white focus:outline-none"
                    >
                </div>
            </div>
        </div>

        <!-- Grade Result Output -->
        <div class="lg:col-span-6 bg-slate-900 border border-rose-500/30 rounded-2xl p-6 shadow-xl flex flex-col justify-between text-center relative overflow-hidden">
            <div class="absolute -left-12 -top-12 w-48 h-48 bg-rose-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-rose-400 block mb-2">
                    Engagement Performance Grade
                </span>

                <div class="my-4">
                    <span class="text-6xl font-black block mb-1" :class="gradeColor" x-text="grade"></span>
                    <span class="text-3xl font-extrabold text-white" x-text="`${rate.toFixed(2)}%`"></span>
                    <span class="block text-xs text-slate-400 mt-1">Engagement Rate</span>
                </div>

                <div class="bg-slate-950 p-4 rounded-xl border border-slate-800 text-xs text-slate-300 text-left">
                    <strong class="text-white block mb-1">Benchmark Guide:</strong>
                    <ul class="space-y-1 text-slate-400">
                        <li>• <strong>&gt; 3.5%</strong>: Exceptional (A+)</li>
                        <li>• <strong>1.5% - 3.5%</strong>: Good / Above Average (B)</li>
                        <li>• <strong>&lt; 1.0%</strong>: Low engagement (Needs hook optimization)</li>
                    </ul>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-800">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl shadow-lg transition-colors">
                    <span>Boost Your Engagement Rate with PostPilot</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function engagementCalc() {
    return {
        followers: 2500,
        likes: 85,
        comments: 18,
        shares: 7,

        get totalInteractions() { return (this.likes || 0) + (this.comments || 0) + (this.shares || 0); },
        get rate() {
            if (!this.followers || this.followers <= 0) return 0;
            return (this.totalInteractions / this.followers) * 100;
        },
        get grade() {
            const r = this.rate;
            if (r >= 4.0) return 'A+';
            if (r >= 2.5) return 'A';
            if (r >= 1.5) return 'B';
            if (r >= 0.8) return 'C';
            return 'D';
        },
        get gradeColor() {
            const r = this.rate;
            if (r >= 2.5) return 'text-emerald-400';
            if (r >= 1.5) return 'text-blue-400';
            if (r >= 0.8) return 'text-amber-400';
            return 'text-rose-400';
        }
    }
}
</script>
@endsection
