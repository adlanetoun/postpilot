@props(['toolSlug'])

<div x-data="{ copied: false }" class="mt-12 rounded-2xl bg-gray-50 p-6 border border-gray-200">
    <div class="flex items-center gap-2 mb-3">
        <span class="material-symbols-outlined text-[#006c49]">code</span>
        <h3 class="text-lg font-bold text-gray-900">Embed this tool on your website</h3>
    </div>
    <p class="mb-4 text-sm text-gray-600">Copy this code to add this free tool to your blog or website. It works perfectly on WordPress, Webflow, and any HTML site.</p>
    
    <div class="relative">
        <textarea readonly class="w-full rounded-xl border border-gray-300 p-4 pr-32 font-mono text-xs text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-[#006c49]/50 focus:border-[#006c49] resize-none" rows="3"
            x-text="`<iframe src='{{ url('/embed/' . $toolSlug) }}' width='100%' height='400' frameborder='0' style='border:1px solid #e5e7eb; border-radius:12px;'></iframe>`">
        </textarea>
        
        <button @click="navigator.clipboard.writeText($el.previousElementSibling.textContent); copied = true; setTimeout(() => copied = false, 2000)"
            class="absolute right-3 top-3 inline-flex items-center gap-1.5 rounded-lg bg-black px-4 py-2 text-xs font-bold text-white hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined text-[16px]" x-show="!copied">content_copy</span>
            <span class="material-symbols-outlined text-[16px]" x-show="copied" x-cloak>check</span>
            <span x-show="!copied">Copy Code</span>
            <span x-show="copied" x-cloak>Copied!</span>
        </button>
    </div>
</div>
