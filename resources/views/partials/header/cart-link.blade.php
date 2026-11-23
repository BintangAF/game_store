<a href="{{ route('cart') }}" class="inline-flex items-center gap-2 rounded-full border border-line-teal bg-accent-2/10 px-3.5 py-2 text-sm font-semibold transition hover:bg-accent-2/20">
    Keranjang
    <span class="rounded-full bg-accent px-1.5 text-[0.68rem] font-extrabold">{{ $cartCount ?? 0 }}</span>
</a>
