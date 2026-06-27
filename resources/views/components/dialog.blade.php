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
