@extends(request()->routeIs('embed.*') ? 'layouts.embed' : 'layouts.tool')

@section('title', $seo['title'] ?? 'Free Social Media ROI Calculator [No Sign-Up] – Measure Your Results Instantly | PostPilot')
@section('meta_description', $seo['meta_description'] ?? 'Calculate the exact ROI of your social media campaigns in seconds. Enter your spend and revenue to get your true return on investment. Free, no sign-up ➔')
@section('tool_name', 'Free Social Media Time Saved & ROI Calculator')
@section('tool_route', 'tools.social-roi-calculator')

@section('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #ffffff; }
    .font-mono { font-family: 'JetBrains Mono', monospace; }
    .font-mono-numbers { font-family: 'JetBrains Mono', monospace; font-variant-numeric: tabular-nums; }
    
    input[type=range] {
        -webkit-appearance: none;
        appearance: none;
        width: 100%;
        background: transparent;
    }

    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        height: 22px;
        width: 22px;
        border-radius: 50%;
        background: #000000;
        cursor: pointer;
        margin-top: -8px;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        transition: transform 0.15s ease, background-color 0.15s ease;
    }

    input[type=range]::-webkit-slider-thumb:hover {
        transform: scale(1.15);
        background: #006c49;
    }

    input[type=range]::-moz-range-thumb {
        height: 22px;
        width: 22px;
        border-radius: 50%;
        background: #000000;
        cursor: pointer;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        transition: transform 0.15s ease, background-color 0.15s ease;
    }

    input[type=range]::-moz-range-thumb:hover {
        transform: scale(1.15);
        background: #006c49;
    }

    input[type=range]::-webkit-slider-runnable-track {
        width: 100%;
        height: 6px;
        cursor: pointer;
        background: #e2e8f0;
        border-radius: 3px;
    }

    input[type=range]::-moz-range-track {
        width: 100%;
        height: 6px;
        cursor: pointer;
        background: #e2e8f0;
        border-radius: 3px;
    }

    .metric-card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    
    .metric-card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection

@section('schema_json')
    <x-seo.faq-schema :faqs="[
        [
            'question' => 'How do you calculate social media ROI?',
            'answer' => 'Social media ROI is calculated by measuring total financial gains or labor value saved from social activities, subtracting total investment costs (labor hours, design, tools, ad spend), and dividing by total investment costs. Multiply by 100 to get your ROI percentage, or express it as a multiplier to determine net efficiency gains.'
        ],
        [
            'question' => 'What is the average time spent on manual social media posting?',
            'answer' => 'Most businesses and solo creators spend between 5 to 15 hours per week manually researching ideas, drafting text, creating graphics, and publishing posts across multiple platforms. That totals over 300 to 700 hours per year per creator spent on repetitive social media management tasks.'
        ],
        [
            'question' => 'How much money can automation save my business?',
            'answer' => 'By automating content creation and multi-platform scheduling, businesses typically reduce manual social media labor by up to 80%. For a team member earning $50/hour publishing 10 posts a week, automated social media workflows save over $15,000 annually in reclaimed payroll.'
        ],
        [
            'question' => 'What metrics should I track for social media ROI?',
            'answer' => 'Key metrics include labor cost per post, total hours saved, engagement rate (likes, comments, shares), referral traffic from UTM links, lead conversions, and customer acquisition cost (CAC). Combining qualitative engagement metrics with quantitative labor efficiency provides a complete view of social media ROI.'
        ],
        [
            'question' => 'Is this calculator accurate for small businesses?',
            'answer' => 'Yes, the calculator is tailored for solopreneurs, small business owners, agencies, and enterprise teams. You can customize weekly posting volume, content creation time per post, hourly wage rates, and automation efficiency ratios to match your exact team dynamics.'
        ],
        [
            'question' => 'How does PostPilot compare to manual content creation costs?',
            'answer' => 'Manual content creation requires hundreds of hours in writing, image creation, formatting, and manual scheduling, which can cost thousands of dollars per month in team labor. PostPilot\'s 30-day autopilot engine generates and schedules multi-platform content in under 5 minutes for a fraction of traditional payroll costs.'
        ]
    ]" />
@endsection

@section('content')
<div class="mb-12 font-sans" x-data="roiCalculator()">
    <!-- Hero Section -->
    <section class="flex flex-col items-center text-center gap-4 max-w-3xl mx-auto mb-10 font-sans">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-[#006c49]/10 border border-[#006c49]/30 rounded-full shadow-md">
            <span class="material-symbols-outlined text-[16px] text-[#006c49]">verified</span>
            <span class="font-mono text-xs text-[#006c49] uppercase tracking-wider font-extrabold">ANALYTICS &amp; ROI TOOLS • 100% FREE &amp; CLIENT-SIDE</span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-black tracking-tight leading-tight font-sans text-center">
            {{ $seo['h1'] ?? 'Social Media Time Saved & ROI Calculator' }}
        </h1>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl font-medium leading-relaxed text-center font-sans">
            Calculate your annual financial waste on manual content creation &amp; scheduling, and see how much time and money PostPilot saves your team.
        </p>
    </section>

    @if(!request()->routeIs('embed.*'))
    {{-- GEO / Answer-First Content --}}
    <div class="max-w-3xl mx-auto mb-8 px-4 sm:px-0">
        <p class="text-[15px] leading-relaxed text-gray-700 font-medium bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <strong>What is this tool?</strong> {{ $seo['answer_first'] ?? 'The Social Media ROI Calculator is a free utility that measures annual labor costs, hours lost, and net financial returns from automating social media workflows. By inputting your team size, posting volume, hourly wage, and creation time, it quantifies financial waste and demonstrates how automation reclaims hundreds of productive work hours annually.' }}
        </p>
    </div>
    @endif

    <!-- Top Overview Financial Stats Bar -->
    <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 flex flex-col shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-gray-700">inventory_2</span>
                Annual Posts
            </span>
            <span class="font-mono text-xl sm:text-2xl font-black text-black mt-1" x-text="yearlyPosts.toLocaleString()">520</span>
            <span class="text-[10px] text-gray-400 font-sans mt-0.5" x-text="safePostsPerWeek * safeTeamSize + ' posts/wk total'">10 posts/wk total</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 flex flex-col shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-amber-600">schedule</span>
                Weekly Effort
            </span>
            <span class="font-mono text-xl sm:text-2xl font-black text-black mt-1"><span x-text="weeklyHoursLost">7.5</span> <span class="text-xs font-normal">hrs</span></span>
            <span class="text-[10px] text-gray-400 font-sans mt-0.5">Across team</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 flex flex-col shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-red-600">timer</span>
                Hours Wasted / Yr
            </span>
            <span class="font-mono text-xl sm:text-2xl font-black text-red-600 mt-1"><span x-text="annualHoursLost.toLocaleString()">390</span> <span class="text-xs font-normal">hrs</span></span>
            <span class="text-[10px] text-gray-400 font-sans mt-0.5">Manual content ops</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 flex flex-col shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-red-600">money_off</span>
                Annual Payroll Cost
            </span>
            <span class="font-mono text-xl sm:text-2xl font-black text-black mt-1">$<span x-text="annualDollarsLost.toLocaleString()">19,500</span></span>
            <span class="text-[10px] text-gray-400 font-sans mt-0.5" x-text="'$' + monthlyDollarsLost.toLocaleString() + ' / month'">$1,625 / month</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 flex flex-col shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-[#006c49]">bolt</span>
                Autopilot Hours Saved
            </span>
            <span class="font-mono text-xl sm:text-2xl font-black text-[#006c49] mt-1"><span x-text="autopilotHoursSaved.toLocaleString()">312</span> <span class="text-xs font-normal">hrs</span></span>
            <span class="text-[10px] text-[#006c49] font-sans font-medium mt-0.5" x-text="daysSavedPerYear + ' workdays saved'">39.0 workdays saved</span>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded-xl p-4 flex flex-col shadow-md hover:border-gray-400 transition-all">
            <span class="font-mono text-xs text-gray-500 uppercase tracking-wider font-extrabold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-[#006c49]">trending_up</span>
                Net Return / Yr
            </span>
            <span class="font-mono text-xl sm:text-2xl font-black text-[#006c49] mt-1">+$<span x-text="netRoiGain.toLocaleString()">15,252</span></span>
            <span class="text-[10px] text-[#006c49] font-sans font-extrabold mt-0.5" x-text="roiMultiplier + 'x ROI Multiplier'">43.8x ROI Multiplier</span>
        </div>
    </section>

    <!-- Main Calculator Workspace Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-12">
        <!-- Left Column: Inputs & Workflow Controls (7 cols) -->
        <div class="lg:col-span-7 bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md space-y-6 flex flex-col justify-between">
            <div class="space-y-6">
                <!-- Section Title & Reset -->
                <div class="flex items-center justify-between border-b border-gray-200/80 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-black text-white text-[11px] font-mono flex items-center justify-center font-bold">1</span>
                        <h2 class="text-xs font-extrabold text-black uppercase tracking-wider font-mono flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-[#006c49]">tune</span>
                            Input Workflow Parameters
                        </h2>
                    </div>
                    <button 
                        type="button" 
                        x-on:click="resetDefaults()" 
                        class="px-3 py-1.5 rounded-lg border border-gray-300 hover:border-black bg-white text-gray-700 hover:text-black font-mono text-xs font-bold transition-all flex items-center gap-1 cursor-pointer shadow-md active:scale-95"
                    >
                        <span class="material-symbols-outlined text-sm">restart_alt</span>
                        <span>Reset</span>
                    </button>
                </div>

                <!-- Scenario Presets -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-gray-700 font-mono flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px] text-[#006c49]">groups</span>
                            Scenario Presets:
                        </span>
                        <span class="text-[10px] text-gray-500 font-mono">Select a team profile</span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                        <button 
                            type="button"
                            x-on:click="setPreset(3, 30, 35, 1, 80)"
                            :class="isPreset(3, 30, 35, 1, 80) ? 'border-black ring-2 ring-black bg-white shadow-md font-bold' : 'border-gray-300 hover:border-black bg-white'"
                            class="flex flex-col items-center justify-center p-3 rounded-xl border-2 transition-all text-center cursor-pointer active:scale-[0.98]"
                        >
                            <span class="font-sans text-xs font-bold text-black mb-0.5">Solopreneur</span>
                            <span class="font-mono text-[10px] font-semibold text-gray-500">3 posts / $35hr</span>
                        </button>

                        <button 
                            type="button"
                            x-on:click="setPreset(10, 45, 50, 3, 80)"
                            :class="isPreset(10, 45, 50, 3, 80) ? 'border-black ring-2 ring-black bg-white shadow-md font-bold' : 'border-gray-300 hover:border-black bg-white'"
                            class="flex flex-col items-center justify-center p-3 rounded-xl border-2 transition-all text-center cursor-pointer active:scale-[0.98]"
                        >
                            <span class="font-sans text-xs font-bold text-black mb-0.5">Growth Team</span>
                            <span class="font-mono text-[10px] font-semibold text-gray-500">10 posts / 3 members</span>
                        </button>

                        <button 
                            type="button"
                            x-on:click="setPreset(25, 60, 75, 5, 80)"
                            :class="isPreset(25, 60, 75, 5, 80) ? 'border-black ring-2 ring-black bg-white shadow-md font-bold' : 'border-gray-300 hover:border-black bg-white'"
                            class="flex flex-col items-center justify-center p-3 rounded-xl border-2 transition-all text-center cursor-pointer active:scale-[0.98]"
                        >
                            <span class="font-sans text-xs font-bold text-black mb-0.5">Agency</span>
                            <span class="font-mono text-[10px] font-semibold text-gray-500">25 posts / 5 members</span>
                        </button>

                        <button 
                            type="button"
                            x-on:click="setPreset(60, 90, 110, 10, 80)"
                            :class="isPreset(60, 90, 110, 10, 80) ? 'border-black ring-2 ring-black bg-white shadow-md font-bold' : 'border-gray-300 hover:border-black bg-white'"
                            class="flex flex-col items-center justify-center p-3 rounded-xl border-2 transition-all text-center cursor-pointer active:scale-[0.98]"
                        >
                            <span class="font-sans text-xs font-bold text-black mb-0.5">Enterprise Hub</span>
                            <span class="font-mono text-[10px] font-semibold text-gray-500">60 posts / 10 members</span>
                        </button>
                    </div>
                </div>

                <!-- Input Range Sliders & Number Input Card -->
                <div class="bg-white border-2 border-gray-300 rounded-xl p-5 sm:p-6 shadow-md space-y-6">
                    <!-- Slider 1: Posts per week per member -->
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-end">
                            <div>
                                <label for="postsPerWeek" class="font-mono text-xs font-extrabold uppercase tracking-wider text-gray-700 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm text-[#006c49]">send</span>
                                    Posts Published Per Week (Per Member)
                                </label>
                                <p class="text-[11px] text-gray-500 font-sans font-medium mt-0.5">Number of original posts published across social networks weekly</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <input 
                                    type="number" 
                                    min="1" 
                                    max="200" 
                                    x-model.number="postsPerWeek" 
                                    class="w-16 text-right font-mono-numbers font-extrabold text-xl text-black border-2 border-gray-300 focus:border-black rounded-lg px-2 py-0.5 outline-none"
                                />
                                <span class="text-xs font-bold text-gray-500 font-sans">posts/wk</span>
                            </div>
                        </div>
                        <input 
                            id="postsPerWeek"
                            class="w-full" 
                            max="100" 
                            min="1" 
                            step="1"
                            type="range" 
                            x-model.number="postsPerWeek"
                        />
                        <div class="flex justify-between font-mono text-[10px] font-bold text-gray-400">
                            <span>1 post/wk</span>
                            <span>50 posts/wk</span>
                            <span>100 posts/wk</span>
                        </div>
                    </div>

                    <!-- Slider 2: Creation effort per post (minutes) -->
                    <div class="space-y-2.5 border-t border-gray-100 pt-5">
                        <div class="flex justify-between items-end">
                            <div>
                                <label for="minutesPerPost" class="font-mono text-xs font-extrabold uppercase tracking-wider text-gray-700 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm text-[#006c49]">schedule</span>
                                    Minutes Spent Per Post Cycle
                                </label>
                                <p class="text-[11px] text-gray-500 font-sans font-medium mt-0.5">Includes research, copywriting, design formatting &amp; scheduling (<span x-text="hoursPerPostDisplay + ' hrs'">0.8 hrs</span>/post)</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <input 
                                    type="number" 
                                    min="5" 
                                    max="480" 
                                    step="5" 
                                    x-model.number="minutesPerPost" 
                                    class="w-16 text-right font-mono-numbers font-extrabold text-xl text-black border-2 border-gray-300 focus:border-black rounded-lg px-2 py-0.5 outline-none"
                                />
                                <span class="text-xs font-bold text-gray-500 font-sans">mins</span>
                            </div>
                        </div>
                        <input 
                            id="minutesPerPost"
                            class="w-full" 
                            max="240" 
                            min="10" 
                            step="5"
                            type="range" 
                            x-model.number="minutesPerPost"
                        />
                        <div class="flex justify-between font-mono text-[10px] font-bold text-gray-400">
                            <span>10m (Quick)</span>
                            <span>60m (1 hr/post)</span>
                            <span>240m (4 hrs/post)</span>
                        </div>
                    </div>

                    <!-- Slider 3: Team Size -->
                    <div class="space-y-2.5 border-t border-gray-100 pt-5">
                        <div class="flex justify-between items-end">
                            <div>
                                <label for="teamSize" class="font-mono text-xs font-extrabold uppercase tracking-wider text-gray-700 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm text-[#006c49]">badge</span>
                                    Team Size / Content Creators
                                </label>
                                <p class="text-[11px] text-gray-500 font-sans font-medium mt-0.5">Number of marketers, freelancers, or founders managing social content</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <input 
                                    type="number" 
                                    min="1" 
                                    max="50" 
                                    x-model.number="teamSize" 
                                    class="w-16 text-right font-mono-numbers font-extrabold text-xl text-black border-2 border-gray-300 focus:border-black rounded-lg px-2 py-0.5 outline-none"
                                />
                                <span class="text-xs font-bold text-gray-500 font-sans">people</span>
                            </div>
                        </div>
                        <input 
                            id="teamSize"
                            class="w-full" 
                            max="25" 
                            min="1" 
                            step="1"
                            type="range" 
                            x-model.number="teamSize"
                        />
                        <div class="flex justify-between font-mono text-[10px] font-bold text-gray-400">
                            <span>1 Solo</span>
                            <span>5 Team</span>
                            <span>25 Agency</span>
                        </div>
                    </div>

                    <!-- Slider 4: Hourly wage / rate -->
                    <div class="space-y-2.5 border-t border-gray-100 pt-5">
                        <div class="flex justify-between items-end">
                            <div>
                                <label for="hourlyRate" class="font-mono text-xs font-extrabold uppercase tracking-wider text-gray-700 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm text-[#006c49]">payments</span>
                                    Team Wage / Hourly Rate
                                </label>
                                <p class="text-[11px] text-gray-500 font-sans font-medium mt-0.5">Blended hourly labor cost of content creators &amp; social managers</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <span class="text-xl font-extrabold text-black font-mono">$</span>
                                <input 
                                    type="number" 
                                    min="10" 
                                    max="500" 
                                    step="5" 
                                    x-model.number="hourlyRate" 
                                    class="w-20 text-right font-mono-numbers font-extrabold text-xl text-black border-2 border-gray-300 focus:border-black rounded-lg px-2 py-0.5 outline-none"
                                />
                                <span class="text-xs font-bold text-gray-500 font-sans">/ hr</span>
                            </div>
                        </div>
                        <input 
                            id="hourlyRate"
                            class="w-full" 
                            max="300" 
                            min="15" 
                            step="5"
                            type="range" 
                            x-model.number="hourlyRate"
                        />
                        <div class="flex justify-between font-mono text-[10px] font-bold text-gray-400">
                            <span>$15/hr</span>
                            <span>$150/hr</span>
                            <span>$300/hr</span>
                        </div>
                    </div>

                    <!-- Slider 5: Autopilot Efficiency Factor -->
                    <div class="space-y-2.5 border-t border-gray-100 pt-5">
                        <div class="flex justify-between items-end">
                            <div>
                                <label for="savingsPercent" class="font-mono text-xs font-extrabold uppercase tracking-wider text-gray-700 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm text-[#006c49]">auto_awesome</span>
                                    PostPilot Efficiency Saved Ratio
                                </label>
                                <p class="text-[11px] text-gray-500 font-sans font-medium mt-0.5">Average time saved by PostPilot automated campaign generation</p>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="font-mono-numbers font-extrabold text-2xl text-[#006c49]" x-text="safeSavingsPercent + '%'">80%</span>
                            </div>
                        </div>
                        <input 
                            id="savingsPercent"
                            class="w-full" 
                            max="95" 
                            min="50" 
                            step="5"
                            type="range" 
                            x-model.number="savingsPercent"
                        />
                        <div class="flex justify-between font-mono text-[10px] font-bold text-gray-400">
                            <span>50% (Conservative)</span>
                            <span>80% (Benchmark)</span>
                            <span>95% (Full Autopilot)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Volume Summary Footnote -->
            <div class="mt-6 pt-5 border-t-2 border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <span class="font-mono text-xs font-extrabold text-gray-700 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[#006c49] text-base">inventory_2</span>
                    Annual Content Output Volume:
                </span>
                <div class="flex items-center gap-3">
                    <span class="font-mono-numbers text-lg font-extrabold text-black">
                        <span x-text="yearlyPosts.toLocaleString()">520</span> <span class="text-xs font-normal text-gray-500 font-sans">posts / yr</span>
                    </span>
                    <span class="text-gray-300">•</span>
                    <span class="font-mono-numbers text-xs font-bold text-gray-600">
                        <span x-text="weeklyHoursLost">7.5</span> hrs/wk effort
                    </span>
                </div>
            </div>
        </div>

        <!-- Right Column: ROI & Financial Audit (5 cols) -->
        <div class="lg:col-span-5 h-full">
            <div class="bg-[#f8f9fa] border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md h-full flex flex-col justify-between space-y-6">
                <div class="space-y-6">
                    <!-- Section Title -->
                    <div class="flex items-center justify-between border-b border-gray-200/80 pb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#006c49] text-white text-[11px] font-mono flex items-center justify-center font-bold">2</span>
                            <h2 class="text-xs font-extrabold text-black uppercase tracking-wider font-mono flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px] text-[#006c49]">insights</span>
                                Financial &amp; Time Saved Audit
                            </h2>
                        </div>
                        <span class="bg-emerald-100 text-[#006c49] text-[10px] font-mono font-extrabold px-2 py-0.5 rounded border border-emerald-200">
                            LIVE METRICS
                        </span>
                    </div>

                    <!-- Financial Metric Cards Stack -->
                    <div class="space-y-4 font-mono">
                        <!-- Metric 1: Hours Wasted / Yr -->
                        <div class="bg-white border-2 border-gray-300 rounded-xl p-5 metric-card-hover">
                            <div class="text-xs text-gray-600 font-extrabold uppercase tracking-wider mb-1.5 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-base text-red-600">timer</span>
                                    Hours Wasted / Yr
                                </span>
                                <span class="text-[10px] text-gray-400 font-normal">Manual labor</span>
                            </div>
                            <div class="font-mono-numbers text-3xl font-extrabold text-black leading-tight">
                                <span x-text="annualHoursLost.toLocaleString()">390</span> <span class="text-sm font-normal text-gray-500 font-sans">hrs / yr</span>
                            </div>
                            <div class="mt-2 pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500">
                                <span>Weekly effort lost:</span>
                                <span class="font-bold text-black" x-text="weeklyHoursLost + ' hrs / week'">7.5 hrs / week</span>
                            </div>
                        </div>

                        <!-- Metric 2: Wasted Labor Cost / Yr -->
                        <div class="bg-white border-2 border-gray-300 rounded-xl p-5 metric-card-hover">
                            <div class="text-xs text-gray-600 font-extrabold uppercase tracking-wider mb-1.5 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-base text-red-600">money_off</span>
                                    Wasted Labor Cost / Yr
                                </span>
                                <span class="text-[10px] text-gray-400 font-normal">Payroll burn</span>
                            </div>
                            <div class="font-mono-numbers text-3xl font-extrabold text-black leading-tight">
                                $<span x-text="annualDollarsLost.toLocaleString()">19,500</span>
                            </div>
                            <div class="mt-2 pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500">
                                <span>Monthly labor burn:</span>
                                <span class="font-bold text-black" x-text="'$' + monthlyDollarsLost.toLocaleString() + ' / month'">$1,625 / month</span>
                            </div>
                        </div>

                        <!-- Metric 3: Autopilot Hours Recovered -->
                        <div class="bg-emerald-50/90 border-2 border-emerald-300 rounded-xl p-5 metric-card-hover">
                            <div class="text-xs text-[#006c49] font-extrabold uppercase tracking-wider mb-1.5 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-base">bolt</span>
                                    Autopilot Time Recovered
                                </span>
                                <span class="bg-[#006c49] text-white px-2 py-0.5 rounded text-[10px] font-extrabold font-mono" x-text="safeSavingsPercent + '% SAVED'">
                                    80% SAVED
                                </span>
                            </div>
                            <div class="font-mono-numbers text-3xl font-extrabold text-[#006c49] leading-tight">
                                <span x-text="autopilotHoursSaved.toLocaleString()">312</span> <span class="text-sm font-normal text-gray-700 font-sans">hrs / yr recovered</span>
                            </div>
                            <div class="mt-2 pt-2 border-t border-emerald-200/80 flex items-center justify-between text-[11px] text-[#006c49] font-semibold">
                                <span>Workday equivalent:</span>
                                <span class="font-bold font-mono" x-text="daysSavedPerYear + ' full 8-hr workdays'">39.0 full 8-hr workdays</span>
                            </div>
                        </div>

                        <!-- Metric 4: Net Dollar Return / Yr -->
                        <div class="bg-emerald-50/90 border-2 border-emerald-300 rounded-xl p-5 metric-card-hover">
                            <div class="text-xs text-[#006c49] font-extrabold uppercase tracking-wider mb-1 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-base">account_balance_wallet</span>
                                    Net Dollar Return / Yr
                                </span>
                                <span class="text-[10px] text-[#006c49] font-bold">After PostPilot Plan</span>
                            </div>
                            <div class="font-mono-numbers text-4xl font-extrabold text-[#006c49] leading-tight">
                                +$<span x-text="netRoiGain.toLocaleString()">15,252</span>
                            </div>
                            <div class="mt-2 pt-2 border-t border-emerald-200/80 flex items-center justify-between text-[11px] text-[#006c49] font-semibold">
                                <span>Estimated ROI Multiplier:</span>
                                <span class="font-bold font-mono" x-text="roiMultiplier + 'x (' + roiPercentage + '% Return)'">43.8x (4,383% Return)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button Group -->
                <div class="space-y-2.5 pt-4">
                    <button 
                        type="button"
                        x-on:click="copyAuditSummary()"
                        class="w-full bg-black hover:bg-gray-800 text-white rounded-xl border-2 border-black py-4 px-6 font-mono text-xs font-extrabold uppercase tracking-wider transition-all flex items-center justify-center gap-2 cursor-pointer shadow-md active:scale-[0.99]"
                    >
                        <span class="material-symbols-outlined text-lg" x-text="copied ? 'check_circle' : 'content_copy'">content_copy</span>
                        <span x-text="copied ? 'Copied Audit Summary!' : 'Copy Audit Summary'">Copy Audit Summary</span>
                    </button>

                    <button 
                        type="button"
                        x-on:click="window.print()"
                        class="w-full bg-white hover:bg-gray-100 text-black rounded-xl border-2 border-black py-3 px-6 font-mono text-xs font-extrabold uppercase tracking-wider transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-[0.99]"
                    >
                        <span class="material-symbols-outlined text-base">print</span>
                        <span>Print / Save ROI Report</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Educational & Methodology Breakdown Card -->
    <div class="bg-white border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md mb-12">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-xl font-extrabold text-black tracking-tight font-sans flex items-center gap-2">
                <span class="material-symbols-outlined text-[#006c49]">analytics</span>
                ROI Calculation Methodology &amp; Benchmark Logic
            </h2>
            <span class="text-xs font-mono text-gray-500 font-medium">Standard Marketing Audit Protocol</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-[#f8f9fa] border-2 border-gray-200 p-5 rounded-xl space-y-2.5">
                <div class="font-mono text-xs font-extrabold text-black uppercase flex items-center justify-between">
                    <span class="text-[#006c49]">1. Labor Cost Formula</span>
                    <span class="material-symbols-outlined text-base text-gray-400">calculate</span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-sans font-medium">
                    Calculated by multiplying annual output volume (<code class="bg-white border border-gray-200 px-1 py-0.5 rounded font-mono text-[11px] text-black">posts/wk × team size × 52</code>) by the average minutes per creation cycle, converted to hours and multiplied by your team's hourly rate.
                </p>
            </div>

            <div class="bg-[#f8f9fa] border-2 border-gray-200 p-5 rounded-xl space-y-2.5">
                <div class="font-mono text-xs font-extrabold text-black uppercase flex items-center justify-between">
                    <span class="text-[#006c49]">2. 80% Autopilot Savings</span>
                    <span class="material-symbols-outlined text-base text-gray-400">speed</span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-sans font-medium">
                    Manual workflows suffer from context switching, multi-platform formatting, design drafting, and individual post scheduling. PostPilot's 30-day autopilot engine batch-generates and schedules posts automatically.
                </p>
            </div>

            <div class="bg-[#f8f9fa] border-2 border-gray-200 p-5 rounded-xl space-y-2.5">
                <div class="font-mono text-xs font-extrabold text-black uppercase flex items-center justify-between">
                    <span class="text-[#006c49]">3. Net Dollar Return</span>
                    <span class="material-symbols-outlined text-base text-gray-400">savings</span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-sans font-medium">
                    Net dollar return equals recovered labor value minus PostPilot's modest annual subscription cost ($348/yr on Starter). This reflects raw payroll bandwidth freed up for high-impact revenue activities.
                </p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6 text-xs font-sans text-gray-600">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[#006c49] text-lg shrink-0 mt-0.5">verified</span>
                <div>
                    <h4 class="font-bold text-black text-xs uppercase tracking-wider font-mono mb-1">Agency Pitch Ready</h4>
                    <p class="leading-relaxed font-medium">Use the "Copy Audit Summary" or "Print / Save ROI Report" button to attach formatted time-saving audits directly to client proposals and pitch decks.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[#006c49] text-lg shrink-0 mt-0.5">trending_up</span>
                <div>
                    <h4 class="font-bold text-black text-xs uppercase tracking-wider font-mono mb-1">Opportunity Cost Recovery</h4>
                    <p class="leading-relaxed font-medium">Reclaiming 300+ hours per year allows founders and growth marketers to focus on direct sales, customer acquisition, and strategic product development.</p>
                </div>
            </div>
        </div>
    </div>



    <!-- Related Free Satellite Tools Section -->
    <div class="bg-white border-2 border-gray-300 rounded-[1rem] p-6 sm:p-8 shadow-md mb-12">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <div>
                <h2 class="text-xl font-extrabold text-black tracking-tight font-sans flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#006c49]">build_circle</span>
                    Explore More Free PostPilot Tools
                </h2>
                <p class="text-xs text-gray-500 font-sans font-medium mt-1">Supercharge your social media workflow with our suite of free marketing utilities</p>
            </div>
            <a href="{{ route('tools.index') }}" class="text-xs font-mono font-bold text-[#006c49] hover:underline flex items-center gap-1">
                <span>View All Tools</span>
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Tool Card 1 -->
            <a href="{{ route('tools.content-calendar-template') }}" class="bg-[#f8f9fa] border-2 border-gray-200 hover:border-black rounded-xl p-4 transition-all duration-200 flex flex-col justify-between group cursor-pointer">
                <div>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#006c49] border border-emerald-200 flex items-center justify-center mb-3 group-hover:bg-black group-hover:text-white group-hover:border-black transition-colors">
                        <span class="material-symbols-outlined text-lg">calendar_month</span>
                    </div>
                    <h3 class="font-bold text-sm text-black mb-1 font-sans group-hover:text-[#006c49] transition-colors">30-Day Calendar Generator</h3>
                    <p class="text-xs text-gray-500 leading-relaxed font-sans font-medium">Generate a complete 30-day content calendar tailored for your niche.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-200/80 flex items-center justify-between text-[11px] font-mono text-gray-500">
                    <span>Calendar Tool</span>
                    <span class="text-[#006c49] font-bold group-hover:translate-x-1 transition-transform inline-block">→</span>
                </div>
            </a>

            <!-- Tool Card 2 -->
            <a href="{{ route('tools.engagement-calculator') }}" class="bg-[#f8f9fa] border-2 border-gray-200 hover:border-black rounded-xl p-4 transition-all duration-200 flex flex-col justify-between group cursor-pointer">
                <div>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#006c49] border border-emerald-200 flex items-center justify-center mb-3 group-hover:bg-black group-hover:text-white group-hover:border-black transition-colors">
                        <span class="material-symbols-outlined text-lg">monitoring</span>
                    </div>
                    <h3 class="font-bold text-sm text-black mb-1 font-sans group-hover:text-[#006c49] transition-colors">Engagement Rate Calculator</h3>
                    <p class="text-xs text-gray-500 leading-relaxed font-sans font-medium">Audit account engagement rate, letter grades, and platform benchmarks.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-200/80 flex items-center justify-between text-[11px] font-mono text-gray-500">
                    <span>Audit Tool</span>
                    <span class="text-[#006c49] font-bold group-hover:translate-x-1 transition-transform inline-block">→</span>
                </div>
            </a>

            <!-- Tool Card 3 -->
            <a href="{{ route('tools.linkedin-hooks') }}" class="bg-[#f8f9fa] border-2 border-gray-200 hover:border-black rounded-xl p-4 transition-all duration-200 flex flex-col justify-between group cursor-pointer">
                <div>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#006c49] border border-emerald-200 flex items-center justify-center mb-3 group-hover:bg-black group-hover:text-white group-hover:border-black transition-colors">
                        <span class="material-symbols-outlined text-lg">auto_awesome</span>
                    </div>
                    <h3 class="font-bold text-sm text-black mb-1 font-sans group-hover:text-[#006c49] transition-colors">LinkedIn Hook Generator</h3>
                    <p class="text-xs text-gray-500 leading-relaxed font-sans font-medium">Create high-converting opening hooks to boost LinkedIn impressions.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-200/80 flex items-center justify-between text-[11px] font-mono text-gray-500">
                    <span>Copywriting</span>
                    <span class="text-[#006c49] font-bold group-hover:translate-x-1 transition-transform inline-block">→</span>
                </div>
            </a>

            <!-- Tool Card 4 -->
            <a href="{{ route('tools.utm-builder') }}" class="bg-[#f8f9fa] border-2 border-gray-200 hover:border-black rounded-xl p-4 transition-all duration-200 flex flex-col justify-between group cursor-pointer">
                <div>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#006c49] border border-emerald-200 flex items-center justify-center mb-3 group-hover:bg-black group-hover:text-white group-hover:border-black transition-colors">
                        <span class="material-symbols-outlined text-lg">link</span>
                    </div>
                    <h3 class="font-bold text-sm text-black mb-1 font-sans group-hover:text-[#006c49] transition-colors">GA4 UTM Link Builder</h3>
                    <p class="text-xs text-gray-500 leading-relaxed font-sans font-medium">Build standardized campaign tracking URLs for Google Analytics 4.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-200/80 flex items-center justify-between text-[11px] font-mono text-gray-500">
                    <span>Tracking Tool</span>
                    <span class="text-[#006c49] font-bold group-hover:translate-x-1 transition-transform inline-block">→</span>
                </div>
            </a>
        </div>
    </div>

    <!-- High-Converting PostPilot Promotional CTA Banner -->
    <div class="bg-black rounded-[1rem] p-8 sm:p-12 text-white relative overflow-hidden border-2 border-black shadow-xl">
        <!-- Background Radial Accent -->
        <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-[#006c49]/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -top-16 w-60 h-60 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-950/90 border border-emerald-700/60 text-emerald-300 font-mono text-[11px] font-bold uppercase tracking-wider">
                    <span class="material-symbols-outlined text-xs text-emerald-400">rocket_launch</span>
                    <span>PostPilot Autopilot Engine</span>
                </div>
                <h3 class="text-2xl sm:text-4xl font-extrabold tracking-tight font-sans text-white leading-tight">
                    Stop Losing 300+ Hours Per Year to Manual Content Ops
                </h3>
                <p class="text-gray-300 text-sm sm:text-base leading-relaxed max-w-2xl font-sans font-normal">
                    Launch your 30-day automated social campaign in under 5 minutes. Reclaim thousands in wasted payroll and multiply your reach across LinkedIn, X, Facebook, and Instagram automatically.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 font-mono text-xs text-gray-300">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
                        <span>30-Day Autopilot Generation</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
                        <span>Multi-Platform Publishing</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
                        <span>Zero Risk Free Trial</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3 justify-center">
                <a 
                    href="{{ route('register') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-[#006c49] hover:bg-emerald-600 text-white font-extrabold px-6 py-4 rounded-xl shadow-lg hover:shadow-emerald-900/40 transition-all font-mono text-xs uppercase tracking-wider text-center cursor-pointer active:scale-95 border border-emerald-500/30"
                >
                    <span>Start Free 30-Day Trial</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
                <p class="text-[10px] text-gray-400 font-mono text-center uppercase tracking-widest">No Credit Card Required</p>
            </div>
        </div>
    </div>

    @if(!request()->routeIs('embed.*'))
    <x-tools.embed-widget toolSlug="social-roi-calculator" />

    {{-- FAQ Section (SSR Content for SEO) --}}
    <section class="mt-16 max-w-4xl mx-auto" x-data="{ openFaq: null }">
        <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-[#006c49] text-xl">help</span>
            <h2 class="text-xl font-extrabold text-black tracking-tight font-sans">Frequently Asked Questions</h2>
        </div>

        @php
            $faqs = [
                [
                    'question' => 'How do you calculate social media ROI?',
                    'answer' => 'Social media ROI is calculated by measuring total financial gains or labor value saved from social activities, subtracting total investment costs (labor hours, design, tools, ad spend), and dividing by total investment costs. Multiply by 100 to get your ROI percentage, or express it as a multiplier to determine net efficiency gains.'
                ],
                [
                    'question' => 'What is the average time spent on manual social media posting?',
                    'answer' => 'Most businesses and solo creators spend between 5 to 15 hours per week manually researching ideas, drafting text, creating graphics, and publishing posts across multiple platforms. That totals over 300 to 700 hours per year per creator spent on repetitive social media management tasks.'
                ],
                [
                    'question' => 'How much money can automation save my business?',
                    'answer' => 'By automating content creation and multi-platform scheduling, businesses typically reduce manual social media labor by up to 80%. For a team member earning $50/hour publishing 10 posts a week, automated social media workflows save over $15,000 annually in reclaimed payroll.'
                ],
                [
                    'question' => 'What metrics should I track for social media ROI?',
                    'answer' => 'Key metrics include labor cost per post, total hours saved, engagement rate (likes, comments, shares), referral traffic from UTM links, lead conversions, and customer acquisition cost (CAC). Combining qualitative engagement metrics with quantitative labor efficiency provides a complete view of social media ROI.'
                ],
                [
                    'question' => 'Is this calculator accurate for small businesses?',
                    'answer' => 'Yes, the calculator is tailored for solopreneurs, small business owners, agencies, and enterprise teams. You can customize weekly posting volume, content creation time per post, hourly wage rates, and automation efficiency ratios to match your exact team dynamics.'
                ],
                [
                    'question' => 'How does PostPilot compare to manual content creation costs?',
                    'answer' => 'Manual content creation requires hundreds of hours in writing, image creation, formatting, and manual scheduling, which can cost thousands of dollars per month in team labor. PostPilot\'s 30-day autopilot engine generates and schedules multi-platform content in under 5 minutes for a fraction of traditional payroll costs.'
                ]
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
    @endif
</div>

<!-- Alpine.js Controller -->
<script>
function roiCalculator() {
    return {
        postsPerWeek: 10,
        minutesPerPost: 45,
        hourlyRate: 50,
        teamSize: 1,
        savingsPercent: 80,
        copied: false,
        openFaq: null,

        get safePostsPerWeek() {
            return Math.max(1, Math.min(200, Number(this.postsPerWeek) || 1));
        },

        get safeMinutesPerPost() {
            return Math.max(5, Math.min(480, Number(this.minutesPerPost) || 5));
        },

        get safeHourlyRate() {
            return Math.max(10, Math.min(500, Number(this.hourlyRate) || 10));
        },

        get safeTeamSize() {
            return Math.max(1, Math.min(50, Number(this.teamSize) || 1));
        },

        get safeSavingsPercent() {
            return Math.max(50, Math.min(95, Number(this.savingsPercent) || 80));
        },

        get hoursPerPostDisplay() {
            return (this.safeMinutesPerPost / 60).toFixed(1);
        },

        get yearlyPosts() {
            return this.safePostsPerWeek * 52 * this.safeTeamSize;
        },

        get annualHoursLost() {
            return Math.round((this.yearlyPosts * this.safeMinutesPerPost) / 60);
        },

        get weeklyHoursLost() {
            return (this.annualHoursLost / 52).toFixed(1);
        },

        get annualDollarsLost() {
            return Math.round(this.annualHoursLost * this.safeHourlyRate);
        },

        get monthlyDollarsLost() {
            return Math.round(this.annualDollarsLost / 12);
        },

        get autopilotHoursSaved() {
            return Math.round(this.annualHoursLost * (this.safeSavingsPercent / 100));
        },

        get daysSavedPerYear() {
            return (this.autopilotHoursSaved / 8).toFixed(1);
        },

        get postPilotAnnualCost() {
            return 348;
        },

        get grossDollarSavings() {
            return Math.round(this.annualDollarsLost * (this.safeSavingsPercent / 100));
        },

        get netRoiGain() {
            return Math.max(0, Math.round(this.grossDollarSavings - this.postPilotAnnualCost));
        },

        get roiMultiplier() {
            if (this.postPilotAnnualCost === 0) return '0.0';
            return (this.netRoiGain / this.postPilotAnnualCost).toFixed(1);
        },

        get roiPercentage() {
            if (this.postPilotAnnualCost === 0) return 0;
            return Math.round((this.netRoiGain / this.postPilotAnnualCost) * 100);
        },

        setPreset(posts, mins, rate, team = 1, savings = 80) {
            this.postsPerWeek = posts;
            this.minutesPerPost = mins;
            this.hourlyRate = rate;
            this.teamSize = team;
            this.savingsPercent = savings;
        },

        isPreset(posts, mins, rate, team = 1, savings = 80) {
            return Number(this.postsPerWeek) === posts && 
                   Number(this.minutesPerPost) === mins && 
                   Number(this.hourlyRate) === rate &&
                   Number(this.teamSize) === team &&
                   Number(this.savingsPercent) === savings;
        },

        resetDefaults() {
            this.postsPerWeek = 10;
            this.minutesPerPost = 45;
            this.hourlyRate = 50;
            this.teamSize = 1;
            this.savingsPercent = 80;
        },

        toggleFaq(index) {
            this.openFaq = this.openFaq === index ? null : index;
        },

        copyAuditSummary() {
            const text = `PostPilot Social Media Time Saved & ROI Audit:
--------------------------------------------------
- Team Size: ${this.safeTeamSize} member(s)
- Posts Published / Week: ${this.safePostsPerWeek} posts/member (${this.safePostsPerWeek * this.safeTeamSize} total/wk)
- Creation Time / Post Cycle: ${this.safeMinutesPerPost} mins (${this.hoursPerPostDisplay} hrs)
- Blended Hourly Team Wage: $${this.safeHourlyRate}/hr
- Annual Content Output: ${this.yearlyPosts.toLocaleString()} posts/yr
--------------------------------------------------
FINANCIAL & TIME AUDIT RESULTS:
- Annual Hours Spent: ${this.annualHoursLost.toLocaleString()} hrs (${this.weeklyHoursLost} hrs/wk)
- Wasted Annual Labor Cost: $${this.annualDollarsLost.toLocaleString()} / year ($${this.monthlyDollarsLost.toLocaleString()}/mo)
- PostPilot Hours Saved (${this.safeSavingsPercent}%): ${this.autopilotHoursSaved.toLocaleString()} hrs/yr (${this.daysSavedPerYear} full 8-hr workdays)
- Gross Annual Labor Savings: $${this.grossDollarSavings.toLocaleString()} / year
- PostPilot Annual Plan: $${this.postPilotAnnualCost} / year
- Net Annual Financial Return: +$${this.netRoiGain.toLocaleString()} / year
- PostPilot ROI Multiplier: ${this.roiMultiplier}x (${this.roiPercentage}% Return)
--------------------------------------------------
Generated via PostPilot Social Media Time Saved & ROI Calculator`;

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2500);
                });
            } else {
                let textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2500);
                } catch (err) {}
                textArea.remove();
            }
        }
    };
}
</script>
@endsection
