# 4. UI Design System

## 1. DaisyUI Theme Configuration (`tailwind.config.js`)

We utilize a custom DaisyUI theme named "auto30" extending Tailwind v3.4+. The aesthetic is "Utmost Clarity"—a timeless, high-contrast SaaS standard relying on generous whitespace and deep indigo actions.

```javascript
import daisyui from 'daisyui';

export default {
  content: ['./resources/**/*.blade.php'],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [daisyui],
  daisyui: {
    themes: [
      {
        auto30: {
          "primary": "#4f46e5", // Indigo-600 (Actions)
          "primary-content": "#ffffff",
          "secondary": "#f8fafc", // Slate-50 (Backgrounds)
          "secondary-content": "#1e293b", // Slate-800
          "accent": "#0ea5e9", // Sky-500 (Hover/Highlights)
          "accent-content": "#ffffff",
          "neutral": "#1e293b", // Slate-800 (Text)
          "neutral-content": "#f8fafc",
          "base-100": "#ffffff", // Pure White (Cards)
          "base-200": "#f1f5f9", // Slate-100 (Page BG)
          "base-300": "#e2e8f0", // Slate-200 (Borders)
          "info": "#3b82f6", // Blue-500
          "success": "#22c55e", // Green-500
          "warning": "#f59e0b", // Amber-500
          "error": "#ef4444", // Red-500
        },
      },
    ],
  },
};
```

## 2. Typography

We strictly override browser defaults to Inter. Headings use tight tracking for a modern, dense SaaS feel. Body text maintains high legibility. We use responsive typography (`text-sm md:text-base`) to prevent microscopic text on ultra-wide monitors.

*   **H1:** `text-3xl font-extrabold tracking-tight text-neutral`
*   **H2:** `text-xl font-bold tracking-tight text-neutral`
*   **Body:** `text-sm md:text-base font-normal text-neutral/80`
*   **Muted/Captions:** `text-xs md:text-sm font-medium text-neutral/50`

## 3. Component Glossary & Blade Components

To enforce DRY principles (Code Golf), we define strict Blade components. No inline class spaghetti in views.

### 3.1 `<x-button>` (Double-Submit Trap Guarded)
**File:** `resources/views/components/button.blade.php`
```blade
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
```

### 3.2 `<x-input>` & `<x-textarea>`
Handles pure Blade validation states natively using First Principles.

**File:** `resources/views/components/input.blade.php`
```blade
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
```

**File:** `resources/views/components/textarea.blade.php`
```blade
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
```

### 3.3 `<x-dialog>` (The FOUC-Proof Modal)
Implements the Security/A11y mandates and fixes the FOUC auto-reopen flaw.
**File:** `resources/views/components/dialog.blade.php`
```blade
@props(['id' => 'shared-modal', 'isOpen' => false])

<dialog 
  id="{{ $id }}" 
  class="modal"
  @if($isOpen) open @endif
>
  <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close">✕</button>
    </form>
    {{ $slot }}
  </div>
  <form method="dialog" class="modal-backdrop">
    <button aria-label="Close backdrop">close</button>
  </form>
</dialog>
```

### 3.4 `<x-toast>` (Auto-Dismissing Flash Messages)
**File:** `resources/views/components/toast.blade.php`
```blade
@props(['type' => 'success'])

@php
    $message = session($type);
    if (!$message) return;

    $alertClass = match($type) {
        'error' => 'alert-error',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
        default => 'alert-success',
    };
@endphp

<div id="global-toast-{{ $type }}" class="toast toast-top toast-end z-50 mt-16">
    <div class="alert {{ $alertClass }} shadow-lg">
        <span>{{ $message }}</span>
    </div>
</div>

<script>
    setTimeout(() => {
        const toast = document.getElementById('global-toast-{{ $type }}');
        if (toast) {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }
    }, 4000);
</script>
```

### 3.5 `<x-confirm-modal>` (Destructive Action Standard)
**File:** `resources/views/components/confirm-modal.blade.php`
```blade
@props([
    'id',
    'action',
    'method' => 'DELETE',
    'title' => 'Are you sure?',
    'message' => 'This action cannot be undone.',
    'confirmText' => 'Delete',
    'triggerClass' => 'btn btn-error btn-sm'
])

<button type="button" class="{{ $triggerClass }}" onclick="document.getElementById('dialog-confirm-{{ $id }}').showModal()">
    {{ $slot->isEmpty() ? $confirmText : $slot }}
</button>

<dialog id="dialog-confirm-{{ $id }}" class="modal">
    <div class="modal-box border-l-4 border-error">
        <h3 class="font-bold text-lg flex items-center gap-2 text-error">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ $title }}
        </h3>
        <p class="py-4 text-base-content/70">{{ $message }}</p>
        
        <form action="{{ $action }}" method="POST" class="modal-action">
            @csrf
            @method($method)
            
            <button type="button" class="btn btn-ghost" onclick="this.closest('dialog').close()">Cancel</button>
            <button type="submit" class="btn btn-error">
                Confirm {{ $confirmText }}
            </button>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
```

## 4. 30-Day Grid Layout (With Hidden Error Trap Prevention)
Responsive layout avoiding mobile collapse (`xl:grid-cols-5 text-sm md:text-base`). Checkbox accordions strictly auto-open on validation errors.
**File:** Applied in `campaigns/show.blade.php`

```blade
<!-- Grid Container -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4 text-sm md:text-base">
  
  @foreach($posts as $post)
    @php
        $errorFields = [
            "posts.{$post->id}.title",
            "posts.{$post->id}.content",
            "posts.{$post->id}.platform",
            "posts.{$post->id}.scheduled_at"
        ];
        $hasError = $errors->hasAny($errorFields);
    @endphp

    <!-- DaisyUI Collapse with dynamic @checked binding -->
    <div class="bg-base-100 border border-base-300 rounded-lg shadow-sm mb-2">
        <input 
            type="checkbox" 
            name="day-{{ $post->id }}-accordion" 
            class="collapse-toggle peer" 
            @checked($hasError) 
        />

        <div class="collapse collapse-arrow">
            <label for="day-{{ $post->id }}-accordion" class="collapse-title text-xl font-medium cursor-pointer flex justify-between items-center">
                <span>Day {{ $post->id }}</span>
                @if($hasError)
                    <span class="badge badge-error badge-sm">Fix Error</span>
                @endif
            </label>
            
            <div class="collapse-content"> 
                <form action="{{ route('posts.update', $post->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <x-input 
                        name="posts[{{ $post->id }}][title]" 
                        label="Title" 
                        :value="old('posts.' . $post->id . '.title', $post->title)"
                    />

                    <x-textarea 
                        model="posts[{{ $post->id }}][content]" 
                        label="Content" 
                        class="h-32"
                    >{{ old('posts.' . $post->id . '.content', $post->content) }}</x-textarea>

                    <x-button text="Save Day {{ $post->id }}" />
                </form>
            </div>
        </div>
    </div>
  @endforeach
</div>
```

## 5. Empty States & AI Generation Skeletons

**Generation Polling State:**
```html
<div class="flex flex-col items-center justify-center py-20 space-y-6">
  <span class="loading loading-spinner loading-lg text-primary"></span>
  <div class="text-center">
    <h2 class="text-lg font-bold text-neutral">Generating 30-Day Campaign...</h2>
    <p class="text-sm text-neutral/50 mt-1">AI is crafting platform-optimized content. This takes ~30s.</p>
  </div>
  
  <!-- Staggered Skeleton Grid Preview -->
  <div class="grid grid-cols-5 gap-2 w-full max-w-2xl mt-4 opacity-50">
    <div class="col-span-2 h-12 bg-base-300 rounded animate-pulse" style="animation-delay: 0.1s"></div>
    <div class="h-12 bg-base-300 rounded animate-pulse" style="animation-delay: 0.2s"></div>
    <div class="h-12 bg-base-300 rounded animate-pulse" style="animation-delay: 0.3s"></div>
    <div class="h-12 bg-base-300 rounded animate-pulse" style="animation-delay: 0.4s"></div>
  </div>
</div>
```

**Empty State (No Projects - SPA Immersive):**
```blade
<div class="flex flex-col items-center justify-center p-12 text-center hero min-h-[50vh] bg-base-200">
    <svg class="w-16 h-16 text-base-content/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    <h3 class="text-2xl font-bold">Start Your First Campaign</h3>
    <p class="text-base-content/60 mb-6 max-w-md py-6">Input your product idea and let our AI engine generate 120 unique, platform-optimized posts for the next 30 days.</p>
    
    <button type="button" class="btn btn-primary" onclick="document.getElementById('dialog-create-project').showModal()">
        Create Project
    </button>
</div>

<x-dialog id="dialog-create-project" :isOpen="false">
    <h3 class="font-bold text-lg mb-4">Create New Project</h3>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <x-input name="name" label="Project Name" class="mb-4" />
        <div class="modal-action">
            <button type="button" class="btn btn-ghost" onclick="this.closest('dialog').close()">Cancel</button>
            <x-button text="Create Project" />
        </div>
    </form>
</x-dialog>
```
