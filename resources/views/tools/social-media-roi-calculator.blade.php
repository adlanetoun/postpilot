@extends('layouts.tool')

@section('title', 'Free Social Media Time Saved & ROI Calculator - PostPilot')
@section('meta_description', 'Calculate how many hours and dollars your business loses on manual content creation versus automated autopilot scheduling.')
@section('tool_name', 'Free Social Media Time Saved & ROI Calculator')

@section('content')
<div class="mb-8" x-data="roiCalculator()">
    <div class="flex items-center gap-2 text-xs text-emerald-400 font-semibold uppercase tracking-wider mb-2">
        <span>ROI Calculator</span>
        <span>•</span>
        <span>100% Free & Client-Side</span>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
        Social Media Time Saved & ROI Calculator
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-3xl leading-relaxed">
        See how much money and time you waste creating and scheduling posts manually every month versus using PostPilot's automated 30-day autopilot engine.
    </p>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Form -->
        <div class="lg:col-span-6 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-5">
            <div>
                <label for="postsPerWeek" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                    Posts Published Per Week
                </label>
                <input 
                    id="postsPerWeek"
                    type="range" min="1" max="30" 
                    x-model.number="postsPerWeek" 
                    class="w-full text-indigo-500 accent-indigo-500 cursor-pointer"
                >
                <div class="flex justify-between text-xs text-slate-400 font-bold mt-1">
                    <span>1 post/wk</span>
                    <span class="text-indigo-400 font-mono text-sm" x-text="`${postsPerWeek} posts / week`"></span>
                    <span>30 posts/wk</span>
                </div>
            </div>

            <div>
                <label for="minutesPerPost" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                    Minutes Spent Per Post Cycle (Ideation + Writing + Posting)
                </label>
                <input 
                    id="minutesPerPost"
                    type="range" min="10" max="120" step="5" 
                    x-model.number="minutesPerPost" 
                    class="w-full accent-indigo-500 cursor-pointer"
                >
                <div class="flex justify-between text-xs text-slate-400 font-bold mt-1">
                    <span>10 mins</span>
                    <span class="text-indigo-400 font-mono text-sm" x-text="`${minutesPerPost} mins / post`"></span>
                    <span>120 mins</span>
                </div>
            </div>

            <div>
                <label for="hourlyRate" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                    Hourly Wage / Opportunity Cost ($/hr)
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-slate-500 text-sm font-bold">$</span>
                    <input 
                        id="hourlyRate"
                        type="number" min="10" max="500" 
                        x-model.number="hourlyRate" 
                        class="w-full bg-slate-950 border border-slate-800 focus:border-emerald-500 rounded-xl py-2 pl-8 pr-4 text-sm font-mono text-white focus:outline-none"
                    >
                </div>
            </div>
        </div>

        <!-- Output ROI Card -->
        <div class="lg:col-span-6 bg-slate-900 border border-emerald-500/40 rounded-2xl p-6 shadow-2xl flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block mb-4">
                    Your Monthly Cost Breakdown
                </span>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-slate-950 p-4 rounded-xl border border-slate-800">
                        <span class="block text-xs text-slate-400 mb-1">Manual Hours Wasted</span>
                        <span class="text-2xl font-extrabold text-white" x-text="`${monthlyHours} hrs/mo`"></span>
                    </div>

                    <div class="bg-slate-950 p-4 rounded-xl border border-slate-800">
                        <span class="block text-xs text-slate-400 mb-1">Monthly Cost Value</span>
                        <span class="text-2xl font-extrabold text-rose-400" x-text="`$${monthlyCost.toLocaleString()}`"></span>
                    </div>
                </div>

                <div class="bg-emerald-950/60 border border-emerald-800/60 rounded-xl p-5 text-center">
                    <span class="text-xs text-emerald-300 font-bold uppercase tracking-wider block mb-1">Estimated Savings with PostPilot</span>
                    <span class="text-3xl font-black text-emerald-400 block" x-text="`$${netSavings.toLocaleString()} / month`"></span>
                    <p class="text-xs text-slate-300 mt-2">
                        PostPilot cuts content creation time by 85%, giving you back <strong class="text-white font-mono" x-text="`${savedHours} hours`"></strong> every month.
                    </p>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-800 text-center">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg shadow-emerald-600/30 transition-all">
                    <span>Reclaim {{ round(12) }} Hours Now with PostPilot</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function roiCalculator() {
    return {
        postsPerWeek: 5,
        minutesPerPost: 35,
        hourlyRate: 50,

        get monthlyPosts() { return this.postsPerWeek * 4.33; },
        get monthlyHours() { return Math.round((this.monthlyPosts * this.minutesPerPost) / 60); },
        get monthlyCost() { return Math.round(this.monthlyHours * this.hourlyRate); },
        get savedHours() { return Math.round(this.monthlyHours * 0.85); },
        get netSavings() { return Math.max(0, Math.round(this.savedHours * this.hourlyRate - 29)); }
    }
}
</script>
@endsection
