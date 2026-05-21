<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'body'   => 'required|string|min:10|max:1000',
        ]);

        $user = Auth::user();

        // Cek apakah user sudah beli produk ini dengan status paid/completed
        $hasBought = Order::where('user_id', $user->id)
            ->whereIn('status', ['paid', 'completed'])
            ->whereHas('items', fn($q) => $q->where('product_id', $productId))
            ->exists();

        if (!$hasBought) {
            return back()->with('error', 'YOU_MUST_PURCHASE_THIS_PRODUCT_FIRST');
        }

        // Cek apakah sudah pernah review produk ini
        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'YOU_HAVE_ALREADY_REVIEWED_THIS_PRODUCT');
        }

        // Ambil order_id
        $order = Order::where('user_id', $user->id)
            ->whereIn('status', ['paid', 'completed'])
            ->whereHas('items', fn($q) => $q->where('product_id', $productId))
            ->latest()
            ->first();

        Review::create([
            'user_id'    => $user->id,
            'product_id' => $productId,
            'order_id'   => $order->id,
            'rating'     => $request->rating,
            'body'       => $request->body,
        ]);

        return back()->with('success', 'REVIEW_SUBMITTED_SUCCESSFULLY');
    }
}