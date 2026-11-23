{{--
  HALAMAN : Checkout: Status Pembayaran
  PEMILIK : Maul (pembayaran)
  ROUTE   : checkout.status (GET /checkout/status?status=pending|paid|failed)
  DATA    : $order (order_id, status, total_amount, payment_method)
  PAKAI   : <x-checkout.stepper>, <x-ui.panel>, <x-ui.button>
  ACUAN   : views/cart/index.blade.php (panel + ringkasan) dan docs/06-PANDUAN-STYLE.md
  CATATAN : Tiga tampilan: menunggu, berhasil, gagal. Coba lewat ?status=paid di preview. Halaman tujuan setelah kembali dari gateway.
--}}
@extends('layouts.checkout')
@section('title', 'Checkout: Status Pembayaran')
@section('content')
    <x-ui.todo name="checkout.status" />
@endsection
