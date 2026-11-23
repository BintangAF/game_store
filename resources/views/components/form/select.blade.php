{{-- <x-form.select name="sort" label="Urutkan" :options="['newest' => 'Terbaru']" selected="newest" /> --}}
@props(['name', 'label', 'options' => [], 'selected' => null, 'placeholder' => null])
<div class="mb-3">
    <label for="{{ $name }}" class="mb-1 block text-xs font-bold text-accent-2">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'w-full rounded-sm border border-line bg-deep px-3 py-2.5 text-sm text-fg outline-none placeholder:text-soft focus:border-accent-2']) }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" @selected((string) old($name, $selected) === (string) $value)>{{ $text }}</option>
        @endforeach
    </select>
    <x-form.field-error :name="$name" />
</div>
