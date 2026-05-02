<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Sizes
        $sizes = ['S', 'M', 'L', 'XL', 'OS'];
        foreach ($sizes as $s) {
            Size::create(['name' => $s]);
        }

        // Products
        $products = [
            ['name' => "BRUTAL TEE", 'price' => 675000, 'category' => "T-SHIRT"],
            ['name' => "VOID CAPSULE", 'price' => 1800000, 'category' => "ACCESSORIES"],
            ['name' => "LOOT BAG", 'price' => 1275000, 'category' => "ACCESSORIES"],
            ['name' => "RAW DENIM", 'price' => 2850000, 'category' => "PANTS"],
            ['name' => "VOID HOODIE", 'price' => 1425000, 'category' => "T-SHIRT"],
            ['name' => "TECH JACKET", 'price' => 3150000, 'category' => "OUTERWEAR"],
        ];

        foreach ($products as $p) {
            $product = Product::create($p);

            // Seed 3 images for each product
            $imgChoices = [
                "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&q=80",
                "https://images.unsplash.com/photo-1549463778-3098f41d24ba?w=400&q=80",
                "https://images.unsplash.com/photo-1544816153-12ad5d714b21?w=400&q=80",
                "https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&q=80",
                "https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&q=80",
                "https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400&q=80"
            ];
            
            for ($i = 0; $i < 3; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imgChoices[array_rand($imgChoices)]
                ]);
            }

            // Seed stock
            $sizesInDb = Size::all();
            foreach ($sizesInDb as $size) {
                DB::table('product_size_stock')->insert([
                    'product_id' => $product->id,
                    'size_id' => $size->id,
                    'stock' => rand(5, 25),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
