<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'price', 'category', 'description', 'content', 'weight', 'fit', 'colour', 'is_featured'];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'product_size_stock')
                    ->withPivot('stock')
                    ->withTimestamps();
    }

    public function getTotalStockAttribute()
    {
        return $this->sizes->sum('pivot.stock');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
