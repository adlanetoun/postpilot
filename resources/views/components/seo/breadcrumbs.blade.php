@props(['toolName' => '', 'toolUrl' => ''])

{{-- Visual Breadcrumbs --}}
<nav aria-label="Breadcrumb" class="mb-6">
    <ol class="flex items-center gap-1.5 text-xs font-medium text-gray-500 font-mono">
        <li>
            <a href="{{ route('home') }}" class="hover:text-black transition-colors">Home</a>
        </li>
        <li class="text-gray-300">/</li>
        <li>
            <a href="{{ route('tools.index') }}" class="hover:text-black transition-colors">Free Tools</a>
        </li>
        @if($toolName)
        <li class="text-gray-300">/</li>
        <li class="text-black font-semibold truncate max-w-[200px]" aria-current="page">{{ $toolName }}</li>
        @endif
    </ol>
</nav>

{{-- BreadcrumbList JSON-LD --}}
@php
    $breadcrumbItems = [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Free Tools', 'item' => route('tools.index')],
    ];

    if ($toolName) {
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $toolName,
            'item' => $toolUrl ?: url()->current(),
        ];
    }
@endphp

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $breadcrumbItems,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
