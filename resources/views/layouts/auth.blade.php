{{-- Kerangka halaman masuk dan daftar: kotak form di tengah, tanpa navbar. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body class="flex min-h-screen flex-col items-center justify-center bg-base px-4 py-10 font-sans text-fg antialiased">
    <x-ui.brand class="mb-7 [&>img]:h-20"  />

    
    <main class="w-full max-w-sm">
        @include('partials.flash')
        @yield('content')
    </main>
</body>
</html>
