{{-- Ubah profil. Data: $user. PUT ke profile.update. --}}
@extends('layouts.app')
@section('title', 'Ubah Profil')
@section('content')
    <x-ui.panel class="mx-auto max-w-md">
        <h1 class="mb-4 text-xl font-black">Ubah profil</h1>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            <x-form.input name="username" label="Username" :value="$user->username ?? $user->name" />
            <x-form.input name="email" label="Email" type="email" :value="$user->email" />
            <x-ui.button type="submit">Simpan</x-ui.button>
        </form>
    </x-ui.panel>
@endsection
