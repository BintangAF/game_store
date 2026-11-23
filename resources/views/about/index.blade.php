{{-- Tentang. Teks statis dan daftar tim. --}}
@extends('layouts.app')
@section('title', 'Tentang')
@section('content')
    <x-ui.panel>
        <h1 class="mb-2 text-2xl font-black">Tentang LINTAR.STORE</h1>
        <p class="text-sm leading-relaxed">LINTAR.STORE adalah toko game digital buatan kelompok kami untuk proyek akhir mata kuliah Pemrograman Berbasis Platform. Isi teks ini masih placeholder.</p>
    </x-ui.panel>

    <x-ui.section-title title="Tim pengembang" />
    <div class="grid gap-3 sm:grid-cols-3">
        @foreach (['Frontend', 'Backend', 'Database'] as $i => $role)
            <x-ui.panel>
                <p class="font-semibold">Nama anggota {{ $i + 1 }}</p>
                <p class="text-sm text-muted">{{ $role }}</p>
            </x-ui.panel>
        @endforeach
    </div>
@endsection
