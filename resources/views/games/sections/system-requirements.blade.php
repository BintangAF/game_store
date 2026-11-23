{{-- Data: $game->system_requirements, $game->operatingSystems. --}}
<x-ui.panel>
    <h2 class="mb-3 text-lg font-black">Spesifikasi sistem</h2>
    <div class="mb-3 flex flex-wrap gap-2">
        @forelse (($game->operatingSystems ?? collect()) as $os)
            <x-ui.chip tone="os">{{ $os->os_name }}</x-ui.chip>
        @empty
            <span class="text-sm text-soft">-</span>
        @endforelse
    </div>
    <pre class="whitespace-pre-line rounded-sm border border-line bg-deep p-4 font-mono text-[0.82rem] text-muted">{{ $game->system_requirements }}</pre>
</x-ui.panel>
