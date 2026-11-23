@auth
    <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 rounded-full border border-line-teal bg-fg/7 py-1 pl-1.5 pr-3 text-sm font-bold hover:bg-accent-2/20">
        <span class="grid size-6 place-items-center rounded-full bg-linear-to-br from-accent to-[#a82838] text-xs font-black">{{ strtoupper(substr(auth()->user()->username ?? auth()->user()->name, 0, 1)) }}</span>
        {{ auth()->user()->username ?? auth()->user()->name }}
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-ui.button type="submit" variant="ghost" size="sm">Keluar</x-ui.button>
    </form>
@else
    <x-ui.button :href="route('login')" variant="outline" size="sm">Masuk</x-ui.button>
    <x-ui.button :href="route('register')" size="sm">Daftar</x-ui.button>
@endauth
