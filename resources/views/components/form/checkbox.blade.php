{{-- <x-form.checkbox name="remember" label="Ingat saya" /> --}}
@props(['name', 'label'])
<label class="mb-3 flex items-center gap-2 text-sm text-muted">
    <input type="checkbox" name="{{ $name }}" value="1" class="accent-accent" @checked(old($name))>
    <span>{{ $label }}</span>
</label>
