{{-- Profil. Hanya menyusun section di profile/sections/. --}}
@extends('layouts.app')
@section('title', 'Profil')
@section('content')
    @include('profile.sections.header')
    @include('profile.sections.library')
    @include('profile.sections.orders')
@endsection
