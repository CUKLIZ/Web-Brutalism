<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->with(['items.product.images', 'items.size'])
            ->first();

        $cartItems = $cart ? $cart->items : collect();
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('pages.cart', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id'    => 'required|exists:sizes,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $existing = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->where('size_id', $request->size_id)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $request->product_id,
                'size_id'    => $request->size_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'ITEM_ADDED_TO_LOOT.');
    }

    public function update(Request $request, $itemId)
{
    $request->validate(['quantity' => 'required|integer|min:1']);
    $cart = Cart::where('user_id', Auth::id())->firstOrFail();
    CartItem::where('id', $itemId)->where('cart_id', $cart->id)
        ->update(['quantity' => $request->quantity]);
    return response()->json(['ok' => true]);
}

public function remove($itemId)
{
    $cart = Cart::where('user_id', Auth::id())->firstOrFail();
    CartItem::where('id', $itemId)->where('cart_id', $cart->id)->delete();
    return response()->json(['ok' => true]);
}
    
}