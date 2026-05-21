<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with('product.images')
            ->latest()
            ->get();

        return view('pages.wishlist', compact('wishlists'));
    }

    public function toggle($productId)
    {
        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            $saved = false;
        } else {
            Wishlist::create([
                'user_id'    => auth()->id(),
                'product_id' => $productId,
            ]);
            $saved = true;
        }

        if (request()->expectsJson()) {
            return response()->json(['saved' => $saved]);
        }

        return back();
    }

    public function clear()
    {
        Wishlist::where('user_id', auth()->id())->delete();
        return back()->with('success', 'VAULT_PURGED');
    }
}