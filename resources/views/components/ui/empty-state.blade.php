{{-- <x-ui.empty-state title="Keranjang kosong" message="..." :href="route('home')" action="Cari game" /> --}}
@props(['title', 'message' => null, 'href' => null, 'action' => 'Kembali ke toko'])
<x-ui.panel class="py-10 text-center">
    <h2 class="text-lg font-black">{{ $title }}</h2>
    @if ($message)
        <p class="mt-1 text-sm text-muted">{{ $message }}</p>
    @endif
    @if ($href)
        <x-ui.button :href="$href" class="mt-4">{{ $action }}</x-ui.button>
    @endif
</x-ui.panel>
