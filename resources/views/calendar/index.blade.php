<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h1 class="text-[18px] font-bold text-[#111827] tracking-tight">{{ __('Content Calendar') }}</h1>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto my-12 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="bg-white border border-gray-200/80 rounded-[24px] shadow-[0_8px_30px_-4px_rgba(0,0,0,0.04),0_2px_10px_-2px_rgba(0,0,0,0.02)] overflow-hidden p-8">
            
            <div class="mb-8">
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Upcoming Schedule</h2>
                <p class="text-gray-500 mt-1">A timeline of all your scheduled posts across all active campaigns.</p>
            </div>

            @if($posts->isEmpty())
                <div class="p-12 text-center flex flex-col items-center bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="w-16 h-16 bg-white border border-gray-200 rounded-[16px] flex items-center justify-center mb-6 shadow-sm">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Calendar is Empty</h3>
                    <p class="text-gray-500 text-sm max-w-sm">You have no upcoming scheduled posts. Generate and approve a campaign to populate your calendar.</p>
                </div>
            @else
                <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 before:to-transparent">
                    
                    @php
                        // Group posts by date string
                        $groupedPosts = $posts->groupBy(function($post) {
                            return \Carbon\Carbon::parse($post->scheduled_at)->format('Y-m-d');
                        });
                    @endphp

                    @foreach($groupedPosts as $dateString => $dayPosts)
                        @php
                            $date = \Carbon\Carbon::parse($dateString);
                            $isToday = $date->isToday();
                        @endphp
                        
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <!-- Timeline Dot -->
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-{{ $isToday ? 'indigo' : 'gray' }}-100 text-{{ $isToday ? 'indigo' : 'gray' }}-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                @if($isToday)
                                    <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full animate-pulse"></div>
                                @else
                                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                @endif
                            </div>
                            
                            <!-- Card -->
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-2xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="font-bold text-gray-900 text-sm {{ $isToday ? 'text-indigo-600' : '' }}">
                                        {{ $isToday ? 'Today' : $date->format('l, M j') }}
                                    </div>
                                    <div class="text-xs font-semibold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                                        {{ count($dayPosts) }} {{ count($dayPosts) === 1 ? 'Post' : 'Posts' }}
                                    </div>
                                </div>
                                
                                <div class="space-y-3">
                                    @foreach($dayPosts as $post)
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100/50">
                                            <div class="mt-0.5">
                                                @if(strtolower($post->platform) === 'twitter' || strtolower($post->platform) === 'x')
                                                    <div class="w-6 h-6 bg-black rounded-md flex items-center justify-center shrink-0">
                                                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                                                    </div>
                                                @elseif(strtolower($post->platform) === 'linkedin')
                                                    <div class="w-6 h-6 bg-[#0077b5] rounded-md flex items-center justify-center shrink-0">
                                                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-[13px] text-gray-700 font-medium line-clamp-2 leading-relaxed">
                                                    {{ $post->content }}
                                                </div>
                                                <div class="flex items-center gap-2 mt-2">
                                                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                                        {{ \Carbon\Carbon::parse($post->scheduled_at)->format('g:i A') }}
                                                    </span>
                                                    @if($post->status === 'published')
                                                        <span class="text-[10px] bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded font-bold">Published</span>
                                                    @elseif($post->status === 'failed')
                                                        <span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-bold">Failed</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
