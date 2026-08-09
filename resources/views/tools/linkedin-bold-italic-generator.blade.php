@extends('layouts.tool')

@section('title', 'Free LinkedIn Bold & Italic Unicode Text Generator - PostPilot')
@section('meta_description', 'Format LinkedIn and X/Twitter posts with mathematical Unicode bold, italic, and monospace text formatting. 100% free with instant copy.')
@section('tool_name', 'Free LinkedIn Bold & Italic Unicode Text Generator')

@section('content')
<div class="mb-8" x-data="unicodeFormatter()">
    <div class="flex items-center gap-2 text-xs text-indigo-400 font-semibold uppercase tracking-wider mb-2">
        <span>Formatting Tools</span>
        <span>•</span>
        <span>100% Free & Client-Side</span>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
        LinkedIn Bold & Italic Unicode Text Formatter
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-3xl leading-relaxed">
        LinkedIn doesn't have rich text controls. Type your headline or key points below to instantly generate mathematical Unicode 𝗕𝗼𝗹𝗱, 𝘐𝘵𝘢𝘭𝘪𝘤, and 𝙼𝚘𝚗𝚘𝚜𝚙𝚊𝚌𝚎 styles ready to paste.
    </p>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Column -->
        <div class="lg:col-span-5 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
            <div>
                <label for="inputText" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Enter Text to Format
                </label>
                <textarea 
                    id="inputText"
                    x-model="text"
                    rows="8"
                    placeholder="Type words or a headline here..."
                    class="w-full bg-slate-950 border border-slate-800 focus:border-indigo-500 rounded-xl p-4 text-base text-slate-100 placeholder-slate-600 focus:outline-none focus:ring-1 focus:ring-indigo-500 font-sans leading-relaxed resize-y"
                ></textarea>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-800 text-xs text-slate-500">
                Tip: Use bold text sparingly on LinkedIn (1-2 lines per post) to highlight key takeaways without triggering accessibility spam filters.
            </div>
        </div>

        <!-- Output Styles Column -->
        <div class="lg:col-span-7 space-y-4">
            <!-- Style 1: Bold Serif -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 flex items-center justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <span class="block text-xs font-bold text-indigo-400 uppercase tracking-wider mb-1">Bold Serif (𝗕𝗼𝗹𝗱)</span>
                    <p class="text-sm font-medium text-slate-100 truncate" x-text="convert(text, 'boldSerif') || 'Your formatted text will appear here...'"></p>
                </div>
                <button 
                    @click="copyStyle(convert(text, 'boldSerif'), 'boldSerif')"
                    class="px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shrink-0 transition-colors"
                >
                    <span x-text="copiedStyle === 'boldSerif' ? 'Copied!' : 'Copy'"></span>
                </button>
            </div>

            <!-- Style 2: Italic Serif -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 flex items-center justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <span class="block text-xs font-bold text-indigo-400 uppercase tracking-wider mb-1">Italic Serif (𝘐𝘵𝘢𝘭𝘪𝘤)</span>
                    <p class="text-sm font-medium text-slate-100 truncate" x-text="convert(text, 'italicSerif') || 'Your formatted text will appear here...'"></p>
                </div>
                <button 
                    @click="copyStyle(convert(text, 'italicSerif'), 'italicSerif')"
                    class="px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shrink-0 transition-colors"
                >
                    <span x-text="copiedStyle === 'italicSerif' ? 'Copied!' : 'Copy'"></span>
                </button>
            </div>

            <!-- Style 3: Bold Sans -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 flex items-center justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <span class="block text-xs font-bold text-indigo-400 uppercase tracking-wider mb-1">Bold Sans-Serif (𝗦𝗮𝗻𝘀)</span>
                    <p class="text-sm font-medium text-slate-100 truncate" x-text="convert(text, 'boldSans') || 'Your formatted text will appear here...'"></p>
                </div>
                <button 
                    @click="copyStyle(convert(text, 'boldSans'), 'boldSans')"
                    class="px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shrink-0 transition-colors"
                >
                    <span x-text="copiedStyle === 'boldSans' ? 'Copied!' : 'Copy'"></span>
                </button>
            </div>

            <!-- Style 4: Monospace -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 flex items-center justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <span class="block text-xs font-bold text-indigo-400 uppercase tracking-wider mb-1">Monospace (𝙼𝚘𝚗𝚘𝚜𝚙𝚊𝚌𝚎)</span>
                    <p class="text-sm font-mono text-slate-100 truncate" x-text="convert(text, 'monospace') || 'Your formatted text will appear here...'"></p>
                </div>
                <button 
                    @click="copyStyle(convert(text, 'monospace'), 'monospace')"
                    class="px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shrink-0 transition-colors"
                >
                    <span x-text="copiedStyle === 'monospace' ? 'Copied!' : 'Copy'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function unicodeFormatter() {
    return {
        text: '3-step SaaS Marketing Strategy',
        copiedStyle: null,

        maps: {
            boldSerif: { A:0x1D400, a:0x1D41A, 0:0x1D7CE },
            italicSerif: { A:0x1D434, a:0x1D44E, 0:0x1D7CE },
            boldSans: { A:0x1D5D4, a:0x1D5EE, 0:0x1D7EC },
            monospace: { A:0x1D670, a:0x1D68A, 0:0x1D7F6 }
        },

        convert(str, style) {
            if (!str) return '';
            const map = this.maps[style];
            let res = '';
            for (let char of str) {
                const code = char.charCodeAt(0);
                if (code >= 65 && code <= 90) { // A-Z
                    res += String.fromCodePoint(map.A + (code - 65));
                } else if (code >= 97 && code <= 122) { // a-z
                    res += String.fromCodePoint(map.a + (code - 97));
                } else if (code >= 48 && code <= 57) { // 0-9
                    res += String.fromCodePoint(map['0'] + (code - 48));
                } else {
                    res += char;
                }
            }
            return res;
        },

        copyStyle(formattedText, styleKey) {
            if (!formattedText) return;
            navigator.clipboard.writeText(formattedText);
            this.copiedStyle = styleKey;
            setTimeout(() => this.copiedStyle = null, 2000);
        }
    }
}
</script>
@endsection
