{{--
  HALAMAN : Checkout: Info Pembayaran
  PEMILIK : Maul (pembayaran)
  ROUTE   : checkout.payment (GET /checkout/pembayaran)
  DATA    : $paymentMethods (kode => nama), $buyer
  PAKAI   : <x-checkout.stepper>, <x-checkout.payment-option>, <x-form.input>, <x-ui.panel>, <x-ui.button>
  ACUAN   : views/cart/index.blade.php (panel + ringkasan) dan docs/06-PANDUAN-STYLE.md
  CATATAN : Form GET ke route(checkout.review). Field: payment_method, buyer_name, buyer_email.
--}}
@extends('layouts.checkout')
@section('title', 'Checkout: Info Pembayaran')
@section('content')
    <x-ui.todo name="checkout.payment" />
@endsection
