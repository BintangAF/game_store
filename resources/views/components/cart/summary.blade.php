{{-- Ringkasan keranjang. $total berupa angka (rupiah). --}}
@props(['items', 'total'])
<x-ui.panel>
    <h2 class="mb-3 text-lg font-black">Ringkasan</h2>
    <dl class="space-y-2 text-sm">
        <div class="flex justify-between"><dt class="text-soft">Jumlah game</dt><dd>{{ count($items) }}</dd></div>
        <div class="flex justify-between border-t border-line pt-3 text-base font-black">
            <dt>Total</dt><dd>Rp {{ number_format($total, 0, ',', '.') }}</dd>
        </div>
    </dl>
    <x-ui.button :href="route('checkout.payment')" block class="mt-4">Lanjut ke checkout</x-ui.button>
</x-ui.panel>
