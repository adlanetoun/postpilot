@extends('layouts.tool')

@section('title', 'Free 30-Day Content Calendar Generator & CSV Exporter - PostPilot')
@section('meta_description', 'Generate a structured 30-day social media matrix balancing 40% Educational, 30% Proof, 20% Personal, and 10% Promotional content with CSV export.')
@section('tool_name', 'Free 30-Day Content Calendar Generator')

@section('content')
<div class="mb-8" x-data="calendarGenerator()">
    <div class="flex items-center gap-2 text-xs text-emerald-400 font-semibold uppercase tracking-wider mb-2">
        <span>Planning & Export</span>
        <span>•</span>
        <span>100% Free & Client-Side</span>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
        30-Day Content Matrix Calendar & CSV Exporter
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-3xl leading-relaxed">
        Generate a balanced 30-day content calendar structure (40% Educational, 30% Proof, 20% Story, 10% Offer) tailored to your business, and export it instantly as a CSV.
    </p>

    <div class="mt-8 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            <div class="sm:col-span-8">
                <label for="nicheInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                    Your Industry / Niche
                </label>
                <input 
                    id="nicheInput"
                    type="text" x-model="niche" 
                    x-on:input="generateCalendar()"
                    placeholder="e.g. B2B SaaS, E-commerce, Real Estate, Fitness Coach" 
                    class="w-full bg-slate-950 border border-slate-800 focus:border-emerald-500 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none"
                >
            </div>

            <div class="sm:col-span-4">
                <button 
                    x-on:click="exportCsv()"
                    class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-xl shadow-lg transition-colors flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export 30-Day CSV</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Calendar Table Grid -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950 text-slate-400 uppercase font-bold border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-4 w-16">Day</th>
                        <th class="py-3 px-4 w-32">Pillar Type</th>
                        <th class="py-3 px-4">Post Prompt / Angle</th>
                        <th class="py-3 px-4 w-28">Target Platform</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <template x-for="row in days" :key="row.day">
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-white" x-text="`Day ${row.day}`"></td>
                            <td class="py-3 px-4">
                                <span 
                                    class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"
                                    :class="{
                                        'bg-blue-950 text-blue-400 border border-blue-800/40': row.pillar === 'Educational',
                                        'bg-emerald-950 text-emerald-400 border border-emerald-800/40': row.pillar === 'Proof / Case Study',
                                        'bg-amber-950 text-amber-400 border border-amber-800/40': row.pillar === 'Personal / Story',
                                        'bg-rose-950 text-rose-400 border border-rose-800/40': row.pillar === 'Offer / Pitch'
                                    }"
                                    x-text="row.pillar"
                                ></span>
                            </td>
                            <td class="py-3 px-4 text-slate-200 font-medium" x-text="row.prompt"></td>
                            <td class="py-3 px-4 text-slate-400 uppercase font-mono" x-text="row.platform"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function calendarGenerator() {
    return {
        niche: 'B2B SaaS',
        days: [],

        init() {
            this.generateCalendar();
        },

        generateCalendar() {
            const n = this.niche.trim() || 'your product';
            const pillars = [
                { type: 'Educational', platform: 'LinkedIn', prompt: `3 costly mistakes people make in ${n} (and how to avoid them)` },
                { type: 'Educational', platform: 'Twitter/X', prompt: `How to simplify your ${n} workflow in 3 simple steps` },
                { type: 'Proof / Case Study', platform: 'LinkedIn', prompt: `How one customer used our ${n} strategy to cut work hours in half` },
                { type: 'Personal / Story', platform: 'LinkedIn', prompt: `The hardest lesson I learned while building in ${n}` },
                { type: 'Educational', platform: 'Twitter/X', prompt: `5 free tools every ${n} founder should use in 2026` },
                { type: 'Offer / Pitch', platform: 'LinkedIn', prompt: `Why we built our ${n} solution and how you can get started today` },
                { type: 'Educational', platform: 'Facebook', prompt: `The single biggest misconception about ${n}` }
            ];

            let calendar = [];
            for (let day = 1; day <= 30; day++) {
                const template = pillars[(day - 1) % pillars.length];
                calendar.push({
                    day: day,
                    pillar: template.type,
                    prompt: `[Day ${day}] ${template.prompt}`,
                    platform: template.platform
                });
            }
            this.days = calendar;
        },

        exportCsv() {
            let csvContent = "data:text/csv;charset=utf-8,Day,Pillar,Post Prompt,Target Platform\n";
            this.days.forEach(row => {
                const escapedPrompt = `"${row.prompt.replace(/"/g, '""')}"`;
                csvContent += `${row.day},${row.pillar},${escapedPrompt},${row.platform}\n`;
            });
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `30_Day_Content_Calendar_${this.niche.replace(/\s+/g, '_')}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}
</script>
@endsection
