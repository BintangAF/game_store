<form action="{{ route('search') }}" method="GET" class="relative w-full md:max-w-72">
    <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-soft" aria-hidden="true">&#8981;</span>
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari game, studio, publisher..." aria-label="Cari game"
           class="w-full rounded-full border border-line bg-fg/6 py-2 pl-9 pr-4 text-sm text-fg outline-none transition placeholder:text-soft focus:border-accent-2 focus:bg-deep focus:ring-4 focus:ring-accent-2/20">
</form>
