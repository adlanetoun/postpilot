@props(['model' => null, 'bag' => 'default', 'label' => ''])

@php
    $errorBagName = $bag;
    $hasError = $errors->getBag($errorBagName)->has($model);
    $errorId = $model . '-error';
@endphp

<div class="form-control w-full">
  @if($label)
    <label class="label" for="{{ $model }}">
      <span class="label-text font-medium text-neutral">{{ $label }}</span>
    </label>
  @endif
  <textarea 
      name="{{ $model }}"
      id="{{ $model }}"
      {{ $attributes->merge([
          'class' => "textarea textarea-bordered w-full text-sm font-mono " . ($hasError ? "textarea-error focus:ring-error/20" : "focus:ring-primary/20") . " focus:outline-none focus:ring-2"
      ]) }}
      @if($hasError) aria-invalid="true" aria-describedby="{{ $errorId }}" @endif
  >{{ old($model, $slot) }}</textarea>

  @error($model, $errorBagName)
      <p id="{{ $errorId }}" class="text-error text-xs mt-1 font-medium">{{ $message }}</p>
  @enderror
</div>
