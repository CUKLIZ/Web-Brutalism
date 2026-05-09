<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::latest()->get();
        // return view('admin.products', compact('products'));
        $products = Product::with('images')->latest()->get();
        return view('admin.products', compact('products'));
    }

    public function create()
    {
        return view('admin.add_product');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|string',
            'stock'    => 'required|array',
            'image'    => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_2'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_3'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::create([
            'name'     => $request->name,
            'price'    => $request->price,
            'category' => $request->category,
            'stock'    => $request->stock,
        ]);

        // Semua 3 gambar masuk product_images
        foreach (['image', 'image_2', 'image_3'] as $key) {
            if ($request->hasFile($key)) {
                $product->images()->create([
                    'image_path' => $request->file($key)->store('products', 'public')
                ]);
            }
        }

        return redirect('/admin/products')->with('success', 'PRODUCT_ADDED_TO_VAULT');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.edit_product', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|string',
            'stock'    => 'required|array',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_2'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_3'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);
            $product->image = $request->file('image')->store('products', 'public');
            $product->save();
        }

        // Update extra images
        foreach (['image_2', 'image_3'] as $key) {
            if ($request->hasFile($key)) {
                $product->images()->create([
                    'image_path' => $request->file($key)->store('products', 'public')
                ]);
            }
        }

        $product->update([
            'name'     => $request->name,
            'price'    => $request->price,
            'category' => $request->category,
            'stock'    => $request->stock,
        ]);

        return redirect('/admin/products')->with('success', 'PRODUCT_UPDATED');
    }

   public function destroy($id)
    {
        $product = Product::findOrFail($id);

        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $product->delete();

        return response()->json(['success' => true]);
    }
}