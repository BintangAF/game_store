{{-- Data: $user (username, email, created_at). --}}
<x-ui.panel class="flex flex-wrap items-center gap-5">
    <div class="grid size-20 shrink-0 place-items-center rounded-full bg-linear-to-br from-accent to-[#a82838] text-3xl font-black shadow-glow-red">{{ strtoupper(substr($user->username ?? $user->name, 0, 1)) }}</div>
    <div class="min-w-0 flex-1">
        <h1 class="text-xl font-black">{{ $user->username ?? $user->name }}</h1>
        <p class="text-sm text-soft">{{ $user->email }} &middot; Bergabung {{ $user->created_at?->format('d/m/Y') }}</p>
    </div>
    <x-ui.button :href="route('profile.edit')" variant="outline">Ubah profil</x-ui.button>
</x-ui.panel>
