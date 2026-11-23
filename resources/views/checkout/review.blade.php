{{--
  HALAMAN : Checkout: Tinjau + Beli
  PEMILIK : Maul (pembayaran)
  ROUTE   : checkout.review (GET /checkout/tinjau); kirim ke checkout.store (POST)
  DATA    : $items, $total, $paymentMethod (code, label)
  PAKAI   : <x-checkout.stepper>, <x-checkout.order-summary>, <x-form.checkbox>, <x-ui.panel>, <x-ui.button>
  ACUAN   : views/cart/index.blade.php (panel + ringkasan) dan docs/06-PANDUAN-STYLE.md
  CATATAN : Field: payment_method (hidden), agree. Tambahkan @csrf. POST ini membuat order pending dan memulai pembayaran gateway.
--}}
@extends('layouts.checkout')
@section('title', 'Checkout: Tinjau + Beli')
@section('content')
    <x-ui.todo name="checkout.review" />
@endsection
