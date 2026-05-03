<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

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
}