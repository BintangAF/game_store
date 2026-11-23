{{-- Kerangka utama toko: head, header (2 baris), menu samping mobile, konten, footer. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body data-js="game-tip" class="flex min-h-screen flex-col bg-base font-sans text-fg antialiased">
    {{-- Checkbox ini membuka menu samping di mobile. Harus berada sebelum partial drawer. --}}
    <input id="drawer-toggle" type="checkbox" class="peer sr-only">
    @include('partials.header.mobile-drawer')

    <header class="sticky top-0 z-30 border-b border-line bg-deep/85 backdrop-blur-lg">
        @include('partials.header.top')
        @include('partials.header.store-nav')
    </header>

    <main class="mx-auto w-full max-w-[1240px] flex-1 px-5 pb-16 pt-7">
        @include('partials.flash')
        @yield('content')
    </main>

    @include('partials.footer')
    @stack('scripts')
</body>
</html>
