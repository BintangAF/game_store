{{-- Form masuk. POST ke route login.store. --}}
@extends('layouts.auth')
@section('title', 'Masuk')
@section('content')
    <x-ui.panel>
        <h1 class="mb-4 text-xl font-black">Masuk</h1>
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <x-form.input name="login" label="Email atau username" autocomplete="username" />
            <x-form.input name="password" label="Password" type="password" autocomplete="current-password" />
            <x-form.checkbox name="remember" label="Ingat saya" />
            <x-ui.button type="submit" block>Masuk</x-ui.button>
        </form>
        <p class="mt-4 text-center text-sm text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-accent-2 hover:underline">Daftar</a></p>
    </x-ui.panel>
@endsection
