{{-- Keranjang. Data: $items (tiap item punya ->game), $total. --}}
@extends('layouts.app')
@section('title', 'Keranjang')
@section('content')
    <h1 class="mb-4 text-2xl font-black">Keranjang</h1>

    @if (count($items))
        <div class="grid gap-6 lg:grid-cols-3">
            <x-ui.panel class="lg:col-span-2">
                @foreach ($items as $item)
                    <x-cart.item :item="$item" />
                @endforeach
            </x-ui.panel>
            <x-cart.summary :items="$items" :total="$total" />
        </div>
    @else
        <x-ui.empty-state title="Keranjang kosong" message="Tambahkan game dari halaman detail." :href="route('search')" action="Cari game" />
    @endif
@endsection
