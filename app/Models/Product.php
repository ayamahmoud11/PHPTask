<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Tenantable;

    protected $fillable = [
        'name',
        'price',
        'quantity',
    ];

    protected static function booted()
    {
        static::updated(function ($product) {
            cache()->forget('products.user.' . $product->user_id);
        });

        static::deleted(function ($product) {
            cache()->forget('products.user.' . $product->user_id);
        });
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}