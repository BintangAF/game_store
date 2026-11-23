{{-- Form tulis ulasan: bintang 1-5 wajib, teks boleh kosong. Hanya untuk pembeli (backend yang memeriksa). --}}
@props(['game'])
<form method="POST" action="{{ route('reviews.store') }}">
    @csrf
    <input type="hidden" name="game_id" value="{{ $game->game_id }}">

    <p class="mb-1 text-xs font-bold text-accent-2">Nilai kamu</p>
    <x-review.star-input name="star" :selected="old('star')" />
    <x-form.field-error name="star" />

    <div class="mb-3">
        <label for="body" class="mb-1 block text-xs font-bold text-accent-2">Ulasan (opsional)</label>
        <textarea id="body" name="body" rows="4" placeholder="Ceritakan pengalamanmu memainkan game ini"
                  class='w-full rounded-sm border border-line bg-deep px-3 py-2.5 text-sm text-fg outline-none placeholder:text-soft focus:border-accent-2 min-h-24 resize-y'>{{ old('body') }}</textarea>
        <x-form.field-error name="body" />
    </div>
    <x-ui.button type="submit">Kirim ulasan</x-ui.button>
</form>
