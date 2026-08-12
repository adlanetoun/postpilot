@props(['toolName' => '', 'toolUrl' => '', 'toolDescription' => ''])

@php
    $shareUrl = $toolUrl ?: url()->current();
    $shareText = $toolName
        ? "Just found this free {$toolName} tool — really useful! 🚀"
        : 'Check out these free social media tools! 🚀';
    $linkedinShareUrl = 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($shareUrl);
    $twitterShareUrl = 'https://twitter.com/intent/tweet?text=' . urlencode($shareText) . '&url=' . urlencode($shareUrl);
@endphp

<div class="mt-12 pt-8 border-t border-gray-200/60 flex flex-col sm:flex-row items-center justify-between gap-4 max-w-5xl mx-auto px-4 sm:px-6">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-gray-400 text-lg">share</span>
        <span class="text-xs font-bold text-gray-500 font-mono uppercase tracking-wider">Share This Tool:</span>
    </div>

    <div class="flex items-center gap-3">
        {{-- LinkedIn Share --}}
        <a href="{{ $linkedinShareUrl }}"
           target="_blank"
           rel="noopener noreferrer"
           onclick="gtag('event', 'share', { method: 'linkedin', content_type: 'tool', item_id: '{{ Str::slug($toolName) }}' })"
           class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-[#0077B5] bg-[#0077B5]/10 hover:bg-[#0077B5] hover:text-white border border-[#0077B5]/20 rounded-xl transition-all duration-200 shadow-xs"
           title="Share on LinkedIn">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            <span>Share on LinkedIn</span>
        </a>

        {{-- X / Twitter Share --}}
        <a href="{{ $twitterShareUrl }}"
           target="_blank"
           rel="noopener noreferrer"
           onclick="gtag('event', 'share', { method: 'twitter', content_type: 'tool', item_id: '{{ Str::slug($toolName) }}' })"
           class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-gray-900 bg-gray-100 hover:bg-black hover:text-white border border-gray-200 rounded-xl transition-all duration-200 shadow-xs"
           title="Share on X / Twitter">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            <span>Post on X</span>
        </a>
    </div>
</div>
