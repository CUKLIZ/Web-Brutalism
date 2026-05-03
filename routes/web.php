<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    $products = Product::with('images')->take(6)->get();
    return view('pages.home', compact('products'));
});

Route::get('/products', function () {
    $products = Product::all();
    $categories = ["ALL", ...Product::distinct()->pluck('category')];
    $activeCategory = request('category', 'ALL');
    $searchQuery = request('q', '');
    return view('pages.products', compact('products', 'categories', 'activeCategory', 'searchQuery'));
});

Route::get('/product/{id}', function ($id) {
    $product = Product::with(['images', 'sizes'])->findOrFail($id);
    return view('pages.product-detail', compact('product'));
});

Route::get('/admin', function () {
    $products = Product::all();
    return view('admin.dashboard', compact('products'));
});

Route::get('/admin/products', function () {
    $products = Product::all();
    return view('admin.products', compact('products'));
});

// Route::get('/cart', function () {
//     return view('pages.cart');
// })->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
});

Route::get('/cart/summary', function () {
    $cart = \App\Models\Cart::where('user_id', auth()->id())
        ->with('items.product')
        ->first();
    $cartItems = $cart ? $cart->items : collect();
    $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
    $freeShip = $subtotal >= 5000000;
    return response()->json([
        'subtotal' => $subtotal,
        'total' => $subtotal + ($freeShip ? 0 : 15000),
        'count' => $cartItems->count(),
        'progress' => min(100, ($subtotal / 5000000) * 100),
        'remaining' => max(0, 5000000 - $subtotal),
        'free_ship' => $freeShip,
    ]);
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    Route::post('/profile/address', [AddressController::class, 'store'])->name('profile.address.store');
    Route::patch('/profile/address/{id}/default', [AddressController::class, 'setDefault'])->name('profile.address.default');
    Route::get('/profile/address/{id}/edit', [AddressController::class, 'edit'])->name('profile.address.edit');
    Route::delete('/profile/address/{id}', [AddressController::class, 'destroy'])->name('profile.address.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');