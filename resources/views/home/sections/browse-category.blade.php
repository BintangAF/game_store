{{-- Telusuri berdasarkan kategori (bisa digeser). Data: $categories. JS: scroller. --}}
<x-ui.section-title eyebrow="Genre" title="Telusuri berdasarkan kategori" />
<x-ui.scroller>
    @foreach ($categories as $category)
        <x-ui.tile :category="$category" />
    @endforeach
</x-ui.scroller>
