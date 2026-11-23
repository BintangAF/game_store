{{-- Form daftar. POST ke route register.store. --}}
@extends('layouts.auth')
@section('title', 'Daftar')
@section('content')
    <x-ui.panel>
        <h1 class="mb-4 text-xl font-black">Daftar akun</h1>
        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <x-form.input name="username" label="Username" autocomplete="username" />
            <x-form.input name="email" label="Email" type="email" autocomplete="email" />
            <x-form.input name="password" label="Password" type="password" autocomplete="new-password" />
            <x-form.input name="password_confirmation" label="Konfirmasi password" type="password" autocomplete="new-password" />
            <x-ui.button type="submit" block>Buat akun</x-ui.button>
        </form>
        <p class="mt-4 text-center text-sm text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-accent-2 hover:underline">Masuk</a></p>
    </x-ui.panel>
@endsection
