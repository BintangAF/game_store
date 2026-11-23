{{-- Pilih bintang 1 sampai 5 (tanpa JS). <x-review.star-input name="star" :selected="old('star')" /> --}}
@props(['name' => 'star', 'selected' => null])
{{-- Urutan DOM 5 ke 1 + flex-row-reverse: tampil 1 ke 5, dan bintang di kirinya ikut menyala. --}}
<div class="mb-3 flex flex-row-reverse justify-end gap-1" role="radiogroup" aria-label="Nilai bintang">
    @foreach ([5, 4, 3, 2, 1] as $value)
        <input type="radio" id="{{ $name }}-{{ $value }}" name="{{ $name }}" value="{{ $value }}" class="peer sr-only" @checked((string) $selected === (string) $value) required>
        <label for="{{ $name }}-{{ $value }}" title="{{ $value }} bintang"
               class="cursor-pointer text-3xl leading-none text-fg/25 transition-colors hover:text-star peer-checked:text-star peer-focus-visible:text-star [&:hover~label]:text-star">&#9733;<span class="sr-only"> {{ $value }} bintang</span></label>
    @endforeach
</div>
