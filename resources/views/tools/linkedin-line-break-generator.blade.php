@extends('layouts.tool')

@section('title', 'Free LinkedIn Paragraph Spacing & Line Break Generator - PostPilot')
@section('meta_description', 'Format clean LinkedIn posts with zero-width invisible line breaks so LinkedIn never collapses your blank lines upon pasting.')
@section('tool_name', 'Free LinkedIn Line Break Generator')

@section('content')
<div class="mb-8" x-data="lineBreakFormatter()">
    <div class="flex items-center gap-2 text-xs text-amber-400 font-semibold uppercase tracking-wider mb-2">
        <span>Formatting Tools</span>
        <span>•</span>
        <span>100% Free & Client-Side</span>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
        LinkedIn Paragraph Spacing & Line Break Formatter
    </h1>
    <p class="text-slate-400 text-sm sm:text-base max-w-3xl leading-relaxed">
        Stop LinkedIn from stripping your paragraph spaces. Paste your post below to automatically inject zero-width invisible spaces (`\u200B`) into empty lines.
    </p>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input area -->
        <div class="lg:col-span-6 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
            <div>
                <label for="rawInputText" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Raw Post Text
                </label>
                <textarea 
                    id="rawInputText"
                    x-model="rawText"
                    @input="formatText()"
                    rows="10"
                    placeholder="Paste text with paragraph breaks..."
                    class="w-full bg-slate-950 border border-slate-800 focus:border-amber-500 rounded-xl p-4 text-sm text-slate-100 placeholder-slate-600 focus:outline-none focus:ring-1 focus:ring-amber-500 font-sans leading-relaxed resize-y"
                ></textarea>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-800 flex items-center justify-between text-xs">
                <span class="text-slate-400">Preserved Paragraphs: <strong class="text-white" x-text="paragraphCount"></strong></span>
                <button @click="rawText = sampleText; formatText()" class="text-amber-400 hover:underline">Load Sample</button>
            </div>
        </div>

        <!-- Formatted Output area -->
        <div class="lg:col-span-6 bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-400">
                        Formatted LinkedIn Post (Safe Spacing)
                    </span>
                    <span class="text-xs text-slate-500 font-mono">Zero-Width Injected</span>
                </div>

                <div class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-sm text-slate-100 font-sans leading-relaxed min-h-[220px] whitespace-pre-line">
                    <span x-text="formattedText || 'Formatted preview will appear here...' "></span>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-500">Ready to paste directly into LinkedIn</span>
                <button 
                    @click="copyFormatted()"
                    class="px-5 py-2.5 bg-amber-600 hover:bg-amber-500 text-white text-xs font-bold rounded-xl shadow-lg transition-colors"
                >
                    <span x-text="copied ? 'Copied with Safe Spacing!' : 'Copy Formatted Text'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function lineBreakFormatter() {
    return {
        rawText: '',
        formattedText: '',
        copied: false,
        sampleText: "Most LinkedIn posts look cramped because LinkedIn strips empty lines.\n\nHere is line 1.\n\nHere is line 2.\n\nBy using invisible zero-width spaces, your spacing remains crisp on mobile.",
        
        get paragraphCount() { return this.rawText ? this.rawText.split(/\n\s*\n/).length : 0; },

        formatText() {
            if (!this.rawText) {
                this.formattedText = '';
                return;
            }
            // Replace empty line returns with a zero-width space
            this.formattedText = this.rawText.replace(/\n\s*\n/g, '\n\u200B\n');
        },

        copyFormatted() {
            if (!this.formattedText) return;
            navigator.clipboard.writeText(this.formattedText);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
    }
}
</script>
@endsection
