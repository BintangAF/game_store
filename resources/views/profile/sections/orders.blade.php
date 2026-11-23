{{-- Data: $orders (order_id, created_at, items, total_amount, status). --}}
@php
    $statuses = [
        'pending' => ['Menunggu', 'bg-star/20 text-star'],
        'paid' => ['Lunas', 'bg-accent-2/22 text-accent-2'],
        'failed' => ['Gagal', 'bg-accent/20 text-accent-soft'],
        'refunded' => ['Dikembalikan', 'bg-accent/20 text-accent-soft'],
    ];
@endphp
<x-ui.section-title eyebrow="Transaksi" title="Riwayat transaksi" />
<x-ui.panel class="overflow-x-auto p-0">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="bg-deep text-[0.74rem] uppercase tracking-wider text-accent-2">
                <th class="px-3 py-3 font-bold">No. order</th>
                <th class="px-3 py-3 font-bold">Tanggal</th>
                <th class="px-3 py-3 font-bold">Item</th>
                <th class="px-3 py-3 font-bold">Total</th>
                <th class="px-3 py-3 font-bold">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                @php [$label, $tone] = $statuses[$order->status] ?? [$order->status, 'bg-fg/10 text-muted']; @endphp
                <tr class="border-b border-line last:border-b-0">
                    <td class="px-3 py-3">#{{ $order->order_id }}</td>
                    <td class="px-3 py-3">{{ $order->created_at?->format('d/m/Y') }}</td>
                    <td class="px-3 py-3">{{ collect($order->items)->pluck('game.game_title')->join(', ') }}</td>
                    <td class="px-3 py-3">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-3 py-3"><span class="inline-block rounded-full px-2.5 py-0.5 text-[0.7rem] font-extrabold uppercase {{ $tone }}">{{ $label }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-3 py-6 text-center text-soft">Belum ada transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
</x-ui.panel>
