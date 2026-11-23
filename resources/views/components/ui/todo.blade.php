{{-- Penanda bagian yang belum diisi. Hapus pemakaiannya saat bagian selesai. <x-ui.todo name="..." /> --}}
@props(['name'])
@if (app()->isLocal())
    <div class="my-3 rounded-sm border border-dashed border-accent/50 p-4 text-sm text-soft">
        {{ $name }} (belum diisi)
    </div>
@endif
