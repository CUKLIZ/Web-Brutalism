<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)
            ->with('items.product', 'items.size')
            ->first();

        $cartItems = $cart ? $cart->items : collect();
        $subtotal  = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
        $freeShip  = $subtotal >= 5000000;
        $shipping  = $freeShip ? 0 : 15000;
        $total     = $subtotal + $shipping;

        try {
            $addresses = $user->addresses()->orderByDesc('is_default')->get();
        } catch (\Exception $e) {
            $addresses = collect();
        }

        return view('pages.checkout', compact('cartItems', 'subtotal', 'shipping', 'total', 'addresses'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address_id'     => ['required', 'exists:addresses,id'],
            'payment_method' => ['required', 'in:bank_transfer,qris,dana,ovo,gopay'],
        ]);

        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'CART_IS_EMPTY');
        }

        $cartItems = $cart->items;
        $subtotal  = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
        $freeShip  = $subtotal >= 5000000;
        $shipping  = $freeShip ? 0 : 15000;
        $total     = $subtotal + $shipping;

        // Buat order
        $order = Order::create([
            'user_id'        => $user->id,
            'address_id'     => $request->address_id,
            'payment_method' => $request->payment_method,
            'bank'           => $request->bank,
            'total_price'    => $total,
            'status'         => 'pending',
        ]);

        // Simpan order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'size_id'    => $item->size_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        // Kosongkan cart
        $cart->items()->delete();

        return redirect()->route('order.success', $order->id);
    }
}