@props(['current' => ''])

@php
    $allTools = [
        [
            'name' => 'LinkedIn Post Preview',
            'route' => 'tools.linkedin-preview',
            'icon' => 'work',
            'category' => 'LinkedIn',
            'description' => 'Preview how your LinkedIn posts render before publishing to avoid broken hooks.',
        ],
        [
            'name' => 'X / Twitter Splitter',
            'route' => 'tools.twitter-thread-splitter',
            'icon' => 'flutter_dash',
            'category' => 'Twitter / X',
            'description' => 'Automatically split long articles into numbered, character-weighted tweets.',
        ],
        [
            'name' => 'Bold & Italic Formatter',
            'route' => 'tools.linkedin-bold-italic',
            'icon' => 'format_bold',
            'category' => 'Unicode',
            'description' => 'Generate eye-catching Unicode bold & italic fonts for social feeds.',
        ],
        [
            'name' => 'Character Limit Counter',
            'route' => 'tools.social-character-counter',
            'icon' => 'pin',
            'category' => 'Analytics',
            'description' => 'Track character, word, and reading time limits across 5 social networks.',
        ],
        [
            'name' => 'Time Saved & ROI Calculator',
            'route' => 'tools.social-roi-calculator',
            'icon' => 'calculate',
            'category' => 'ROI',
            'description' => 'Calculate labor costs and hours saved by automating social posting.',
        ],
        [
            'name' => 'Line Break Formatter',
            'route' => 'tools.linkedin-line-break',
            'icon' => 'format_line_spacing',
            'category' => 'LinkedIn',
            'description' => 'Prevent LinkedIn from collapsing paragraph spacing with zero-width characters.',
        ],
        [
            'name' => 'GA4 UTM Link Builder',
            'route' => 'tools.utm-builder',
            'icon' => 'link',
            'category' => 'Analytics',
            'description' => 'Generate clean campaign tracking links formatted for Google Analytics 4.',
        ],
        [
            'name' => 'Engagement Rate Calculator',
            'route' => 'tools.engagement-calculator',
            'icon' => 'query_stats',
            'category' => 'Analytics',
            'description' => 'Measure exact audience engagement percentages across platforms.',
        ],
        [
            'name' => 'LinkedIn Hook Templates',
            'route' => 'tools.linkedin-hooks',
            'icon' => 'auto_fix_high',
            'category' => 'Templates',
            'description' => 'Browse and fill battle-tested hook formulas to increase dwell time.',
        ],
        [
            'name' => '30-Day Content Matrix',
            'route' => 'tools.content-calendar-template',
            'icon' => 'calendar_month',
            'category' => 'Planning',
            'description' => 'Plan a full month of strategic social content themes and export to CSV.',
        ],
    ];

    // Filter out current tool and select 3 relevant tools
    $filtered = collect($allTools)->filter(fn($t) => $t['route'] !== $current);

    if ($current) {
        $currentTool = collect($allTools)->firstWhere('route', $current);
        $currentCategory = $currentTool['category'] ?? '';

        $sameCategory = $filtered->filter(fn($t) => $t['category'] === $currentCategory)->take(2);
        $otherCategory = $filtered->filter(fn($t) => $t['category'] !== $currentCategory)->shuffle()->take(3 - $sameCategory->count());
        $related = $sameCategory->merge($otherCategory)->take(3);
    } else {
        $related = $filtered->shuffle()->take(3);
    }
@endphp

<section class="mt-20 pt-12 border-t border-gray-200/80 font-sans">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10 pb-4 border-b border-gray-100">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#006c49]/10 text-[#006c49] font-mono text-[11px] font-extrabold uppercase tracking-wider mb-2">
                    <span class="material-symbols-outlined text-xs">grid_view</span>
                    <span>RECOMMENDED TOOLS</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Explore More Free Tools
                </h2>
            </div>
            <a href="{{ route('tools.index') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 hover:bg-black text-white rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow-md shrink-0">
                <span>View All 10 Free Tools</span>
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <!-- Tool Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related as $tool)
            <a href="{{ route($tool['route']) }}"
               class="group relative flex flex-col justify-between p-6 bg-white rounded-2xl border border-gray-200/80 hover:border-[#006c49] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div>
                    <!-- Top Row: Icon + Badge + Arrow -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#006c49] group-hover:bg-[#006c49] group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-xs">
                            <span class="material-symbols-outlined text-xl">{{ $tool['icon'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-600 font-mono text-[10px] font-bold uppercase tracking-wider">
                                {{ $tool['category'] }}
                            </span>
                            <span class="material-symbols-outlined text-gray-300 group-hover:text-[#006c49] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-all text-lg">
                                north_east
                            </span>
                        </div>
                    </div>

                    <!-- Title & Description -->
                    <h3 class="text-base font-extrabold text-gray-900 group-hover:text-[#006c49] transition-colors mb-2 leading-snug">
                        {{ $tool['name'] }}
                    </h3>
                    <p class="text-xs text-gray-600 font-medium leading-relaxed">
                        {{ $tool['description'] }}
                    </p>
                </div>

                <!-- Footer Tag -->
                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center text-[11px] font-bold text-[#006c49] opacity-0 group-hover:opacity-100 transition-opacity">
                    <span>Use Tool Free</span>
                    <span class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
