<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['images', 'sizes'])->latest()->get();
        return view('admin.products', compact('products'));
    }

    public function create()
    {
        $sizes = Size::all();
        return view('admin.add_product', compact('sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|string',
            'sizes'    => 'nullable|array',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'weight' => 'nullable|string',
            'fit' => 'nullable|string',
            'colour' => 'nullable|string',
            'image'    => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_2'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_3'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::create([
            'name'     => $request->name,
            'price'    => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'content' => $request->content,
            'weight' => $request->weight,
            'fit' => $request->fit,
            'colour' => $request->colour,
        ]);

        // Sync sizes & stock ke pivot kalau ada
        if ($request->has('sizes')) {
            $syncData = [];
            foreach ($request->sizes as $sizeId => $stock) {
                $syncData[$sizeId] = ['stock' => (int) $stock];
            }
            $product->sizes()->sync($syncData);
        }

        // Simpan gambar ke product_images (kompatibel form lama)
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
        $product = Product::with(['images', 'sizes'])->findOrFail($id);
        $sizes   = Size::all();
        return view('admin.edit_product', compact('product', 'sizes'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::with(['images', 'sizes'])->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|string',
            'sizes'    => 'required|array',
            'images.0' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product->update([
            'name'     => $request->name,
            'price'    => $request->price,
            'category' => $request->category,
        ]);

        // Sync sizes & stock ke pivot
        $syncData = [];
        foreach ($request->sizes as $sizeId => $stock) {
            $syncData[$sizeId] = ['stock' => (int) $stock];
        }
        $product->sizes()->sync($syncData);

        // Update gambar — kalau ada file baru, replace yang lama
        $existingImages = $product->images->values();
        foreach ($request->file('images', []) as $index => $file) {
            if ($file) {
                if (isset($existingImages[$index])) {
                    Storage::disk('public')->delete($existingImages[$index]->image_path);
                    $existingImages[$index]->update([
                        'image_path' => $file->store('products', 'public')
                    ]);
                } else {
                    $product->images()->create([
                        'image_path' => $file->store('products', 'public')
                    ]);
                }
            }
        }

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