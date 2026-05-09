<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    // protected $fillable = ['user_id', 'total_price', 'status'];

    // public function items(): HasMany
    // {
    //     return $this->hasMany(OrderItem::class);
    // }

    protected $fillable = [
        'user_id',
        'order_code',
        'address_id',
        'payment_method',
        'bank',
        'total_price',
        'status',
    ];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
