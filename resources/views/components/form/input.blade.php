{{-- <x-form.input name="email" label="Email" type="email" /> --}}
@props(['name', 'label', 'type' => 'text', 'value' => null])
<div class="mb-3">
    <label for="{{ $name }}" class="mb-1 block text-xs font-bold text-accent-2">{{ $label }}</label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $type === 'password' ? '' : old($name, $value) }}"
           {{ $attributes->merge(['class' => 'w-full rounded-sm border border-line bg-deep px-3 py-2.5 text-sm text-fg outline-none placeholder:text-soft focus:border-accent-2']) }}>
    <x-form.field-error :name="$name" />
</div>
