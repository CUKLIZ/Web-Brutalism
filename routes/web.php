<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;

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
