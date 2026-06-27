@props(['label' => '', 'name' => null, 'type' => 'text', 'max' => null])

@php
  $errorClass = $errors->has($name) ? 'input-error' : '';
  $ariaInvalid = $errors->has($name) ? 'true' : 'false';
  $errorId = $name . '-error';
@endphp

<div class="form-control w-full">
  @if($label)
    <label class="label" for="{{ $name }}">
      <span class="label-text font-medium text-neutral">{{ $label }}</span>
    </label>
  @endif
  <input 
    type="{{ $type }}" 
    name="{{ $name }}" 
    id="{{ $name }}"
    value="{{ old($name, $attributes->get('value')) }}"
    maxlength="{{ $max }}"
    autocomplete="off"
    aria-invalid="{{ $ariaInvalid }}"
    aria-describedby="{{ $errors->has($name) ? $errorId : null }}"
    {{ $attributes->merge(['class' => "input input-bordered w-full {$errorClass}"]) }} 
  />
  @error($name)
    <p id="{{ $errorId }}" class="text-error text-xs mt-1 font-medium">{{ $message }}</p>
  @enderror
</div>
