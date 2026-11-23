{{-- Halaman Home. Hanya menyusun section. Isi ada di home/sections/. --}}
@extends('layouts.app')
@section('title', 'Home')
@section('content')
    @include('home.sections.featured-carousel')
    @include('home.sections.browse-category')
    @include('home.sections.recommended-library')
    @include('home.sections.because-you-played')
    @include('home.sections.tag-duo')
    @include('home.sections.top-new-releases')
    @include('home.sections.tabbed-list')
    @include('home.sections.under-price')
@endsection
