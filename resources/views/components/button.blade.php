@props([
    'type' => 'submit',
    'text' => 'Submit',
    'variant' => 'primary',
])
@php
  $baseClasses = "btn btn-sm font-semibold tracking-wide transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary";
  $variants = [
    'primary' => 'btn-primary',
    'secondary' => 'btn-ghost text-neutral hover:bg-base-300',
    'danger' => 'btn-error',
  ];
@endphp

<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => "$baseClasses {$variants[$variant]}"]) }}
>
    {{ $slot->isEmpty() ? $text : $slot }}
</button>
