<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Kerangka checkout (view-nya milik Maul). Sudah memakai data asli;
 * integrasi payment gateway belum ada: order dibuat berstatus "pending".
 */
class CheckoutController extends Controller
{
    private const METHODS = [
        'qris' => 'QRIS', 'dana' => 'Dana', 'ovo' => 'OVO', 'gopay' => 'GoPay',
        'bank_transfer' => 'Transfer Bank (Virtual Account)', 'card' => 'Visa / MasterCard',
    ];

    public function payment()
    {
        $user = auth()->user();

        return view('checkout.payment', [
            'paymentMethods' => self::METHODS,
            'buyer' => (object) ['name' => $user->username, 'email' => $user->email],
        ]);
    }

    public function review(Request $request)
    {
        $code = array_key_exists($request->query('payment_method'), self::METHODS) ? $request->query('payment_method') : 'qris';
        $items = auth()->user()->cart()->with('game')->get();

        return view('checkout.review', [
            'items' => $items,
            'total' => CartController::total($items),
            'paymentMethod' => (object) ['code' => $code, 'label' => self::METHODS[$code]],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'payment_method' => ['required', 'in:'.implode(',', array_keys(self::METHODS))],
            'agree' => ['accepted'],
        ]);
        $user = auth()->user();
        $items = $user->cart()->with('game')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart')->with('status', 'Keranjang kosong.');
        }

        $order = DB::transaction(function () use ($user, $items, $data) {
            $order = Order::create([
                'user_id' => $user->user_id,
                'total_amount' => CartController::total($items),
                'status' => 'pending',
                'payment_method' => $data['payment_method'],
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'game_id' => $item->game_id,
                    'price_at_purchase' => $item->game->game_price,
                ]);
            }

            Cart::where('user_id', $user->user_id)->delete();

            return $order;
        });

        // TODO (Maul): minta transaksi ke payment gateway di sini
        return redirect()->route('checkout.status', ['order' => $order->order_id]);
    }

    public function status(Request $request)
    {
        $order = Order::where('user_id', auth()->user()->user_id)->findOrFail($request->query('order'));

        return view('checkout.status', ['order' => $order]);
    }
}
