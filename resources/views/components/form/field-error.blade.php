@props(['name'])
@error($name)
    <p class="mt-1 text-xs text-accent-soft">{{ $message }}</p>
@enderror
