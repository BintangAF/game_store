{{--
  KOMPONEN : Satu pilihan metode bayar
  PEMILIK : Maul (pembayaran)
  PAKAI DI: <x-checkout.payment-option ... />
  MEMAKAI : -
  CATATAN : Input radio name="payment_method". Logo metode boleh ditaruh di public/images/payment/.
--}}
@props(['value', 'label', 'checked' => false])
