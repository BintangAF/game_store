{{-- Daftar bertab. Data: $tabs = ['kunci' => ['label' => '...', 'games' => koleksi]]. JS: tabs. --}}
<div data-js="tabs" class="mt-10">
    <div class="flex gap-2 overflow-x-auto pb-1" role="tablist">
        @foreach ($tabs as $key => $tab)
            <button type="button" role="tab" data-tab="{{ $key }}"
                    class="whitespace-nowrap rounded-full border px-4 py-1.5 text-sm font-bold transition">{{ $tab['label'] }}</button>
        @endforeach
    </div>
    @foreach ($tabs as $key => $tab)
        <div data-panel="{{ $key }}" class="mt-4 space-y-3 {{ $loop->first ? '' : 'hidden' }}">
            @foreach ($tab['games'] as $game)
                <x-game.list-row :game="$game" />
            @endforeach
        </div>
    @endforeach
</div>
