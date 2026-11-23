{{-- Kotak kategori: gambar (placeholder), label putih di tengah. <x-ui.tile :category="$category" /> --}}
@props(['category'])
<a href="{{ route('search', ['category' => $category->category_id]) }}"
   class="ph group flex h-32 items-center justify-center overflow-hidden rounded-md border border-line shadow-elev transition duration-300 hover:-translate-y-1 hover:border-line-teal"
   style="--ph-h: {{ ($category->category_id * 47) % 360 }}">
    <span class="rounded-sm bg-fg px-4 py-2 text-center text-sm font-extrabold uppercase tracking-wider text-deep">{{ $category->category_name }}</span>
</a>
