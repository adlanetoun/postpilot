<x-app-layout>
    <style>
        /* Maestro's Second Opus: The Gallery of Strategy */
        .maestro-wrapper {
            padding: 6rem 2rem 10rem 2rem;
            max-width: 1600px;
            margin: 0 auto;
            font-family: 'Inter', sans-serif;
        }

        .maestro-hero {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 6rem;
            opacity: 0;
            transform: translateY(30px);
            animation: m-fadeUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            padding-bottom: 2rem;
            border-bottom: 2px solid rgba(0,0,0,0.05);
        }

        .maestro-hero h1 {
            font-size: 4.5rem;
            font-weight: 900;
            letter-spacing: -0.05em;
            color: #0A0A0A;
            line-height: 0.9;
            margin: 0;
            text-transform: lowercase;
        }

        .maestro-hero-btn {
            display: inline-flex;
            align-items: center;
            padding: 1.2rem 2.5rem;
            background: #0A0A0A;
            color: #fff;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .maestro-hero-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
            background: #000;
        }

        /* The Grid */
        .maestro-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
            gap: 3rem;
        }

        /* The Card (Canvas) */
        .maestro-card {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 3.5rem 3rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 50px -10px rgba(0,0,0,0.05), 0 0 1px rgba(0,0,0,0.1);
            transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            opacity: 0;
            transform: translateY(50px);
            display: flex;
            flex-direction: column;
            cursor: pointer;
            text-decoration: none;
        }

        .maestro-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 40px 80px -15px rgba(0,0,0,0.1), 0 0 2px rgba(0,0,0,0.1);
        }

        /* Ambient Glow inside the card */
        .maestro-glow {
            position: absolute;
            top: -50%;
            right: -50%;
            width: 150%;
            height: 150%;
            background: radial-gradient(circle, rgba(79,70,229,0.06) 0%, rgba(255,255,255,0) 60%);
            opacity: 0;
            transition: opacity 1s ease;
            pointer-events: none;
            z-index: 0;
        }

        .maestro-card:hover .maestro-glow {
            opacity: 1;
        }

        .m-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Meta Top */
        .m-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
        }

        .m-date {
            font-size: 0.75rem;
            font-weight: 700;
            color: #A1A1AA;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }

        /* Status Badge */
        .m-status {
            padding: 0.5rem 1.2rem;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .s-generating { background: #EFF6FF; color: #1D4ED8; }
        .s-generating .dot { background: #1D4ED8; animation: pulse 1.5s infinite; }
        
        .s-failed { background: #FEF2F2; color: #B91C1C; }
        .s-failed .dot { background: #B91C1C; }
        
        .s-completed { background: #FFFBEB; color: #B45309; }
        .s-completed .dot { background: #B45309; }
        
        .s-active { background: #ECFDF5; color: #047857; }
        .s-active .dot { background: #047857; }

        .s-default { background: #F4F4F5; color: #52525B; }
        .s-default .dot { background: #52525B; }

        /* Typography */
        .m-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #0A0A0A;
            line-height: 1.1;
            letter-spacing: -0.03em;
            margin-bottom: 1.5rem;
            transition: color 0.4s ease;
        }

        .m-desc {
            font-size: 1.05rem;
            color: #71717A;
            line-height: 1.6;
            flex-grow: 1;
            margin-bottom: 3rem;
        }

        /* Action Footer */
        .m-action {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 2rem;
            border-top: 1px solid rgba(0,0,0,0.06);
            font-weight: 800;
            font-size: 0.8rem;
            color: #0A0A0A;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: color 0.4s ease;
        }

        .m-action svg {
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .maestro-card:hover .m-action {
            color: #4F46E5;
        }

        .maestro-card:hover .m-action svg {
            transform: translateX(12px);
            color: #4F46E5;
        }

        /* Empty State */
        .m-empty {
            text-align: center;
            padding: 10rem 0;
            opacity: 0;
            animation: m-fadeUp 1s forwards;
            animation-delay: 0.3s;
        }
        .m-empty-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 2rem;
            color: #E4E4E7;
        }
        .m-empty-title {
            font-size: 2rem;
            font-weight: 800;
            color: #0A0A0A;
            margin-bottom: 1rem;
            letter-spacing: -0.03em;
        }
        .m-empty-desc {
            font-size: 1.1rem;
            color: #71717A;
            max-width: 500px;
            margin: 0 auto 3rem;
            line-height: 1.6;
        }

        @keyframes m-fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            50% { opacity: 0.3; }
        }

        .js-animate {
            animation: m-fadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @media (max-width: 768px) {
            .maestro-hero {
                flex-direction: column;
                align-items: flex-start;
                gap: 2rem;
            }
            .maestro-hero h1 { font-size: 3.5rem; }
            .maestro-grid { grid-template-columns: 1fr; }
            .maestro-card { padding: 2.5rem 2rem; }
        }
    </style>

    <div class="maestro-wrapper">
        <div class="maestro-hero">
            <h1>{{ __('Campaign Library') }}</h1>
            <a href="{{ route('dashboard', ['new' => 1]) }}" class="maestro-hero-btn">
                Create Campaign
            </a>
        </div>

        @if($campaigns->isEmpty())
            <div class="m-empty">
                <svg class="m-empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="m-empty-title">No Campaigns Found</h3>
                <p class="m-empty-desc">You haven't generated any content campaigns yet. Head over to the dashboard to start your first 30-day strategy.</p>
                <a href="{{ route('dashboard', ['new' => 1]) }}" class="maestro-hero-btn" style="background: transparent; color: #000; border: 2px solid #000; box-shadow: none;">
                    Create Campaign
                </a>
            </div>
        @else
            <div class="maestro-grid">
                @foreach($campaigns as $index => $campaign)
                    <a href="{{ route('campaigns.show', $campaign->id) }}" class="maestro-card js-animate" style="animation-delay: {{ 0.2 + ($index * 0.1) }}s;">
                        <div class="maestro-glow"></div>
                        
                        <div class="m-content">
                            <div class="m-meta">
                                <span class="m-date">{{ $campaign->created_at->format('M j, Y') }}</span>
                                
                                @if($campaign->status === 'generating')
                                    <span class="m-status s-generating"><span class="dot"></span>Generating</span>
                                @elseif($campaign->status === 'failed_generation')
                                    <span class="m-status s-failed"><span class="dot"></span>Failed</span>
                                @elseif($campaign->status === 'completed')
                                    <span class="m-status s-completed"><span class="dot"></span>Draft</span>
                                @elseif($campaign->status === 'active')
                                    <span class="m-status s-active"><span class="dot"></span>Active</span>
                                @else
                                    <span class="m-status s-default"><span class="dot"></span>{{ ucfirst($campaign->status) }}</span>
                                @endif
                            </div>

                            <h2 class="m-title">{{ $campaign->project->name }}</h2>
                            <p class="m-desc">{{ $campaign->project->description }}</p>

                            <div class="m-action">
                                <span>View Details</span>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
