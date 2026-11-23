{{-- Logo: kotak merah + nama. <x-ui.brand /> --}}
<a href="{{ route('home') }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-3']) }}>
    <span class="grid size-9 shrink-0 place-items-center rounded-[11px] bg-linear-to-br from-accent to-[#b82d3a] text-lg font-black shadow-glow-red" aria-hidden="true">L</span>
    <span class="flex flex-col leading-none">
        <span class="text-[1.32rem] font-black tracking-[2.4px]">LINTAR<span class="text-accent-2">.STORE</span></span>
        <span class="mt-1 text-[0.62rem] font-bold uppercase tracking-[1.8px] text-soft">Game Store</span>
    </span>
</a>
