<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;

Route::get('/products', function () {
    $query = Product::with(['images', 'sizes']);
    
    $activeCategory = request('category', 'ALL');
    $searchQuery = request('q', '');

    if ($searchQuery) {
        $query->where('name', 'like', '%' . $searchQuery . '%');
    }

    if ($activeCategory && $activeCategory !== 'ALL') {
        $query->where('category', $activeCategory);
    }

    $products = $query->get();
    $categories = ["ALL", ...Product::distinct()->pluck('category')];

    return view('pages.products', compact('products', 'categories', 'activeCategory', 'searchQuery'));
})->name('products');

Route::get('/product/{category}/{slug}', function ($category, $slug) {
    $product = Product::with(['images', 'sizes', 'reviews.user'])
        ->where('slug', $slug)
        ->where('category', strtoupper($category))
        ->firstOrFail();
    return view('pages.product-detail', compact('product'));
})->name('product.detail');

Route::get('/', function () {
    $products = Product::with('images')->where('is_featured', true)->take(6)->get();
    return view('pages.home', compact('products'));
});

Route::get('/cart/summary', function () {
    $cart = \App\Models\Cart::where('user_id', auth()->id())
        ->with('items.product')
        ->first();
    $cartItems = $cart ? $cart->items : collect();
    $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
    $freeShip = $subtotal >= 5000000;
    return response()->json([
        'subtotal'  => $subtotal,
        'total'     => $subtotal + ($freeShip ? 0 : 15000),
        'count'     => $cartItems->count(),
        'progress'  => min(100, ($subtotal / 5000000) * 100),
        'remaining' => max(0, 5000000 - $subtotal),
        'free_ship' => $freeShip,
    ]);
})->middleware('auth');

Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Address
    Route::post('/profile/address', [AddressController::class, 'store'])->name('profile.address.store');
    Route::patch('/profile/address/{id}/default', [AddressController::class, 'setDefault'])->name('profile.address.default');
    Route::get('/profile/address/{id}/edit', [AddressController::class, 'edit'])->name('profile.address.edit');
    Route::delete('/profile/address/{id}', [AddressController::class, 'destroy'])->name('profile.address.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Order
    Route::get('/order/{order_code}/success', [CheckoutController::class, 'success'])->name('order.success');
    Route::patch('/order/{order_code}/simulate', [CheckoutController::class, 'simulate'])->name('order.simulate');
    Route::patch('/order/{order_code}/expire', [CheckoutController::class, 'expire'])->name('order.expire');
    Route::get('/order/{order_code}/detail', [CheckoutController::class, 'showDetail'])->name('order.detail');
    Route::patch('/order/{order_code}/cancel', [CheckoutController::class, 'cancel'])->name('order.cancel');

    // Review
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('review.store');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
});

Route::get('/banned', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    if (!Auth::user()->is_banned) {
        return redirect('/');
    }
    return view('pages.banned', ['user' => Auth::user()]);
})->name('banned');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index']);

    Route::prefix('admin')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        Route::get('/orders', [DashboardController::class, 'orders'])->name('admin.orders');
        Route::patch('/orders/{id}/complete', [DashboardController::class, 'complete'])->name('admin.orders.complete');
        Route::get('/orders/{id}', [DashboardController::class, 'showOrder'])->name('admin.orders.show');

        Route::get('/users', [DashboardController::class, 'users'])->name('admin.users');
        Route::patch('/users/{id}/role', [DashboardController::class, 'updateRole'])->name('admin.users.role');
        Route::patch('/users/{id}/ban', [DashboardController::class, 'toggleBan'])->name('admin.users.ban');
    });
});