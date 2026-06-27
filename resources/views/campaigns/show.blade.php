<x-app-layout>
    @php 
        $groupedPosts = $posts->groupBy('day_number'); 
    @endphp
    
    <style>
        .maestro-calendar-wrapper {
            font-family: 'Inter', sans-serif;
            animation: m-fadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            padding-bottom: 4rem;
        }

        /* The Command Center (Redesigned from the dark pill) */
        .m-command-dock {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            padding: 2.5rem 3rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05), inset 0 0 0 1px rgba(255,255,255,1);
            margin-bottom: 4rem;
            margin-top: 1rem;
            color: #0A0A0A;
            border: 1px solid rgba(0,0,0,0.06);
        }
        .m-command-dock-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .m-command-info { display: flex; align-items: flex-start; gap: 1.5rem; }
        .m-status-icon {
            width: 48px; height: 48px; border-radius: 16px; background: #F8FAFC; border: 1px solid #F1F5F9; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
            flex-shrink: 0;
        }
        .m-status-icon.is-active { background: #ECFDF5; border-color: #D1FAE5; color: #10B981; }
        
        .m-command-title { font-size: 1.8rem; font-weight: 900; letter-spacing: -0.03em; display: flex; align-items: center; gap: 1rem; line-height: 1.1; margin-bottom: 0.5rem; }
        .m-command-subtitle { font-size: 1rem; color: #71717A; font-weight: 500; max-width: 500px; line-height: 1.5; }
        .m-command-badge { padding: 0.3rem 0.8rem; border-radius: 100px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; transform: translateY(-2px); }
        .m-badge-draft { background: #FFFBEB; color: #D97706; border: 1px solid #FEF3C7; }
        .m-badge-active { background: #ECFDF5; color: #059669; border: 1px solid #D1FAE5; }

        .m-command-actions { display: flex; align-items: center; gap: 1rem; }
        .m-btn-back {
            background: #fff; color: #0A0A0A; padding: 1rem 2.5rem; border-radius: 100px; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid rgba(0,0,0,0.1); cursor: pointer; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none; display: inline-block;
        }
        .m-btn-back:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-color: rgba(0,0,0,0.2); }

        /* Sleek Progress Bar for Active Mode */
        .m-progress-container { width: 100%; padding-top: 1.5rem; border-top: 1px solid rgba(0,0,0,0.06); }
        .m-progress-stats { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 0.8rem; }
        .m-progress-label { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #A1A1AA; }
        .m-progress-value { font-size: 1.25rem; font-weight: 900; font-family: 'Inter', monospace; color: #0A0A0A; }
        .m-progress-track { width: 100%; height: 6px; background: rgba(0,0,0,0.04); border-radius: 100px; overflow: hidden; }
        .m-progress-fill { height: 100%; background: #10B981; border-radius: 100px; transition: width 1s cubic-bezier(0.16, 1, 0.3, 1); }

        /* Infinity Grid Calendar */
        .m-cal-container {
            display: flex;
            flex-direction: column;
            background: transparent;
        }
        
        .m-cal-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            margin-bottom: 2rem;
        }
        .m-cal-day-label {
            text-align: right;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #A1A1AA;
            padding-right: 1.5rem;
        }

        .m-cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.04);
            border-radius: 32px;
            overflow: hidden;
        }
        
        .m-cal-cell {
            background: #fff;
            min-height: 160px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
            position: relative;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .m-cal-cell:hover {
            background: #050505;
            transform: scale(1.05);
            z-index: 10;
            border-radius: 24px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
        }
        .m-cal-cell.is-empty { background: #F8F9FA; pointer-events: none; }
        
        .m-cal-date {
            font-size: 1.5rem;
            font-weight: 900;
            color: #0A0A0A;
            transition: color 0.5s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .m-cal-cell:hover .m-cal-date { color: #fff; }

        .m-cal-posts-badge {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.6);
            background: rgba(255,255,255,0.1);
            padding: 0.3rem 0.8rem;
            border-radius: 100px;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s;
        }
        .m-cal-cell:hover .m-cal-posts-badge { opacity: 1; transform: translateY(0); }

        .m-cal-platforms {
            display: flex;
            gap: 0.5rem;
            align-items: flex-end;
        }
        .m-platform-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #D4D4D8;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .m-cal-cell:hover .m-platform-dot { width: 14px; height: 14px; }
        .m-cal-cell:hover .m-dot-linkedin { background: #0a66c2; box-shadow: 0 0 15px rgba(10,102,194,0.6); }
        .m-cal-cell:hover .m-dot-twitter, .m-cal-cell:hover .m-dot-x { background: #fff; box-shadow: 0 0 15px rgba(255,255,255,0.6); }
        .m-cal-cell:hover .m-dot-facebook { background: #1877F2; box-shadow: 0 0 15px rgba(24,119,242,0.6); }
        
        .m-cal-check {
            width: 24px; height: 24px; border-radius: 50%; background: #10B981; display: flex; align-items: center; justify-content: center; color: #fff;
            opacity: 0; transform: scale(0); transition: all 0.4s;
        }
        .m-cal-cell:hover .m-cal-check.is-published { opacity: 1; transform: scale(1); }

        @keyframes m-fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 768px) {
            .m-command-dock { flex-direction: column; gap: 2rem; padding: 2rem; border-radius: 24px; align-items: flex-start; }
            .m-command-actions { width: 100%; justify-content: flex-start; }
            .m-cal-header { display: none; }
            .m-cal-grid { grid-template-columns: 1fr; gap: 1rem; background: transparent; border: none; }
            .m-cal-cell { border: 1px solid rgba(0,0,0,0.1); border-radius: 24px; min-height: 120px; }
            .m-cal-cell:hover { transform: translateY(-5px); }
        }
    </style>

    <div class="maestro-calendar-wrapper max-w-7xl mx-auto relative z-0 pt-8">
        <!-- Decorative Ambient Glow -->
        <div style="position:absolute; top:-100px; left:50%; transform:translateX(-50%); width:600px; height:600px; background:radial-gradient(circle, rgba(79,70,229,0.05) 0%, transparent 70%); pointer-events:none; z-index:-1;"></div>

        <!-- Dynamic Command Center -->
        <div class="m-command-dock">
            <div class="m-command-dock-top">
                <div class="m-command-info">
                    <div class="m-status-icon {{ $campaign->status === 'active' ? 'is-active' : '' }}">
                        @if($campaign->status === 'active')
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        @else
                            ✨
                        @endif
                    </div>
                    <div>
                        <h2 class="m-command-title">
                            {{ $project->name }}
                            @if($campaign->status === 'active')
                                <span class="m-command-badge m-badge-active">Active</span>
                            @else
                                <span class="m-command-badge m-badge-draft">{{ ucfirst($campaign->status) }}</span>
                            @endif
                        </h2>
                        @php
                            $publishedDaysCount = $groupedPosts->filter(function($dayPosts) {
                                return $dayPosts->contains('status', 'published');
                            })->count();
                        @endphp
                        <p class="m-command-subtitle">
                            @if($campaign->status === 'active')
                                Autopilot is running. Your audience is being engaged automatically.
                            @else
                                Reviewing past campaign generation.
                            @endif
                        </p>
                    </div>
                </div>
                <div class="m-command-actions">
                    <a href="{{ route('campaigns.index') }}" class="m-btn-back">
                        Back to Library
                    </a>
                </div>
            </div>
            
            <div class="m-progress-container">
                <div class="m-progress-stats">
                    <span class="m-progress-label">Campaign Progress</span>
                    <span class="m-progress-value">{{ $publishedDaysCount }} / 30 <span style="font-size: 0.75rem; color: #A1A1AA; font-weight: 700; margin-left: 0.2rem;">DAYS</span></span>
                </div>
                <div class="m-progress-track">
                    <div class="m-progress-fill" style="width: {{ ($publishedDaysCount / 30) * 100 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Infinity Grid Calendar -->
        <div class="m-cal-container">
            <div class="m-cal-header">
                <div class="m-cal-day-label">Mon</div>
                <div class="m-cal-day-label">Tue</div>
                <div class="m-cal-day-label">Wed</div>
                <div class="m-cal-day-label">Thu</div>
                <div class="m-cal-day-label">Fri</div>
                <div class="m-cal-day-label">Sat</div>
                <div class="m-cal-day-label">Sun</div>
            </div>

            <div class="m-cal-grid">
                @for ($i = 1; $i <= 35; $i++)
                    @if ($i <= 30)
                        @php 
                            $dayPosts = $groupedPosts->get($i, collect()); 
                            $hasPublished = !$dayPosts->isEmpty() && $dayPosts->contains('status', 'published');
                        @endphp
                        <div class="m-cal-cell" onclick="openDayDrawer({{ $i }})">
                            <div class="m-cal-date">
                                {{ $i }}
                                @if (!$dayPosts->isEmpty())
                                    <span class="m-cal-posts-badge">{{ $dayPosts->count() }} Posts</span>
                                @endif
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                                <div class="m-cal-platforms">
                                    @if (!$dayPosts->isEmpty())
                                        @foreach ($dayPosts->pluck('platform')->map(function($p) { return strtolower($p); })->unique()->take(4) as $platform)
                                            <div class="m-platform-dot m-dot-{{ $platform }}" title="{{ ucfirst($platform) }}"></div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="m-cal-check {{ $hasPublished ? 'is-published' : '' }}">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="m-cal-cell is-empty"></div>
                    @endif
                @endfor
            </div>
        </div>
    </div>

    <!-- The Editorial Brutalist Side-Drawer -->
    <style>
        @keyframes slideUpFadeManifest {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <div id="day-drawer-overlay" class="fixed inset-0 bg-black/45 backdrop-blur-md z-[60] hidden opacity-0 transition-opacity duration-300" onclick="closeDayDrawer()"></div>
    
    <div id="day-drawer" class="fixed top-0 right-0 h-full w-full max-w-lg bg-white/75 backdrop-blur-xl shadow-[-20px_0_50px_rgba(0,0,0,0.15)] z-[70] transform translate-x-full transition-transform duration-500 ease-out flex flex-col border-l-2 border-black">
        <!-- Drawer Header (Brutalist) -->
        <div class="px-8 py-8 border-b-2 border-black bg-transparent flex flex-col relative z-10">
            <!-- Top Row: Meta & Close -->
            <div class="flex justify-between items-start mb-8">
                <div class="inline-flex items-center gap-2">
                    <div class="w-3 h-3 bg-black"></div>
                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest font-mono">Flight Manifest</span>
                </div>
                <button onclick="closeDayDrawer()" class="text-gray-400 hover:text-black transition-colors focus:outline-none">
                    <span class="text-[12px] font-bold font-mono tracking-widest uppercase border-b border-transparent hover:border-black transition-all">[ CLOSE ]</span>
                </button>
            </div>
            
            <!-- Title Row -->
            <div class="flex items-end gap-6">
                <div class="flex items-baseline gap-2">
                    <span class="text-[24px] font-bold text-gray-300 uppercase tracking-tighter">Day</span>
                    <div id="drawer-day-badge" class="text-[72px] font-extrabold text-black leading-[0.8] tracking-tighter font-mono">1</div>
                </div>
                <div class="mb-2">
                    <h3 class="text-[20px] font-extrabold text-black tracking-tight">Scheduled Output</h3>
                    <p id="drawer-post-count" class="text-[13px] font-mono text-gray-500 uppercase tracking-widest mt-1">0 payloads ready</p>
                </div>
            </div>
        </div>

        <!-- Drawer Content (Scrollable) -->
        <div class="flex-1 overflow-y-auto bg-transparent relative">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIC41aDQwTTAgMjAuNWg0ME0yMC41IDB2NDBNLjUgMHY0MCIgc3Ryb2tlPSJyZ2JhKDAsIDAsIDAsIDAuMDMpIi8+PC9zdmc+')] pointer-events-none z-0"></div>

            <div id="drawer-content-container" class="relative z-10 flex flex-col">
                <!-- Dynamic content will be injected here via JS -->
            </div>
        </div>
        
        <!-- Brutalist Footer -->
        <div class="border-t-2 border-black bg-white/40 backdrop-blur-md p-5 flex justify-between items-center z-10">
            <span class="text-[11px] font-bold text-gray-400 font-mono uppercase tracking-widest">Engine // Active</span>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-black animate-pulse"></div>
                <span class="text-[11px] font-bold text-black font-mono uppercase tracking-widest">System Ready</span>
            </div>
        </div>
    </div>

    <!-- Hidden JSON Data for JS -->
    @php
        $campaignDataArray = $groupedPosts->map(function($posts) {
            return $posts->map(function($post) {
                return [
                    'id' => $post->id,
                    'platform' => $post->platform,
                    'content' => $post->content,
                    'time' => $post->scheduled_at ? \Carbon\Carbon::parse($post->scheduled_at)->format('h:i A') : 'TBD',
                ];
            });
        });
    @endphp
    <script>
        const campaignData = @json($campaignDataArray);

        function getPlatformIcon(platform) {
            const p = platform.toLowerCase();
            if (p === 'facebook') {
                return `<svg class="w-3.5 h-3.5 fill-[#1877F2] shrink-0" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>`;
            }
            if (p === 'linkedin') {
                return `<svg class="w-3.5 h-3.5 fill-[#0A66C2] shrink-0" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>`;
            }

            if (p === 'twitter' || p === 'x') {
                return `<svg class="w-3.5 h-3.5 fill-black shrink-0" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>`;
            }
            return '';
        }

        function openDayDrawer(day) {
            const drawer = document.getElementById('day-drawer');
            const overlay = document.getElementById('day-drawer-overlay');
            const container = document.getElementById('drawer-content-container');
            const badge = document.getElementById('drawer-day-badge');
            const count = document.getElementById('drawer-post-count');

            badge.textContent = day.toString().padStart(2, '0');
            const posts = campaignData[day] || [];
            count.textContent = `${posts.length} payload${posts.length !== 1 ? 's' : ''} ready`;

            let html = '';
            if (posts.length === 0) {
                html = `
                    <div class="p-12 flex flex-col items-center justify-center text-center border-b border-gray-200">
                        <div class="w-16 h-16 border-2 border-black flex items-center justify-center mb-6 bg-white/80">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h4 class="text-[18px] font-extrabold text-black uppercase tracking-widest mb-2">Rest Day</h4>
                        <p class="text-gray-500 text-[14px] font-medium max-w-xs">Zero payloads scheduled. System resting to avoid audience fatigue.</p>
                    </div>
                `;
            } else {
                posts.forEach((post, index) => {
                    const platformName = post.platform.toUpperCase();
                    const platformIcon = getPlatformIcon(post.platform);
                    const delay = index * 50; 
                    
                    html += `
                        <div 
                            class="group relative border-b border-black/10 bg-white/50 hover:bg-white/75 backdrop-blur-sm p-8 transition-colors duration-200"
                            style="animation: slideUpFadeManifest 0.4s ease-out ${delay}ms forwards; opacity: 0; transform: translateY(10px);"
                            data-content="${escapeHtml(post.content)}"
                        >
                            <div class="flex items-center justify-between mb-6">
                                <div class="inline-flex items-center gap-3">
                                    <div class="border-2 border-black px-2.5 py-1 bg-white/90 rounded-md flex items-center gap-2 shadow-sm">
                                        ${platformIcon}
                                        <span class="text-[10px] font-bold text-black uppercase tracking-wider font-mono">${platformName}</span>
                                    </div>
                                    <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded font-mono uppercase tracking-widest flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        ${post.time}
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <button onclick="navigator.clipboard.writeText(this.closest('.group').dataset.content); const s=this; s.textContent='[ COPIED ]'; setTimeout(()=>s.textContent='[ COPY ]', 2000);" class="text-[11px] font-bold text-gray-400 hover:text-black font-mono uppercase tracking-widest transition-colors">
                                        [ COPY ]
                                    </button>
                                </div>
                            </div>
                            <div class="relative">
                                <p class="text-black text-[15px] font-medium leading-relaxed whitespace-pre-wrap selection:bg-black selection:text-white">${escapeHtml(post.content)}</p>
                            </div>
                        </div>
                    `;
                });
            }
            container.innerHTML = html;

            overlay.classList.remove('hidden');
            void overlay.offsetWidth;
            overlay.classList.remove('opacity-0');
            drawer.classList.remove('translate-x-full');
        }

        function closeDayDrawer() {
            const drawer = document.getElementById('day-drawer');
            const overlay = document.getElementById('day-drawer-overlay');
            
            drawer.classList.add('translate-x-full');
            overlay.classList.add('opacity-0');
            
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }

        function escapeHtml(unsafe) {
            return unsafe
                 .replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
        }
    </script>
</x-app-layout>
