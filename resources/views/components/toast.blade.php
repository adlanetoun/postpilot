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
