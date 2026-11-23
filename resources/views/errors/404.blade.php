@extends('layouts.app')
@section('title', 'Halaman tidak ditemukan')
@section('content')
    <x-ui.empty-state title="Halaman tidak ditemukan" message="Alamat yang kamu buka tidak ada atau sudah dipindahkan." :href="route('home')" action="Ke beranda" />
@endsection
