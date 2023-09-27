<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'price', 'subcategory_id'];
    public $timestamps = false;

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function carts()
    {
        return $this->belongsToMany(
            Cart::class,
            'cart_items',
            'product_id',
            'cart_id'
        )->withPivot('quanitiy');
    }
    public function orders()
    {
        return $this->belongsToMany(
            Order::class,
            'order_items',
            'product_id',
            'order_id'
        );
    }

    public function productColorSize()
    {
        return $this->hasMany(ProductColorSize::class, 'product_id');
    }


    public function images()
    {
        return $this->morphMany(Attacment::class, 'attachmentable');
    }
    public function scopeFilterByColors($query, array $colorIds)
    {
        return $query->whereHas('productColorSize', function ($query) use ($colorIds) {
            $query->whereIn('color_id', $colorIds);
        });
    }

    public function scopeFilterBySizes($query, array $sizeIds)
    {
        return $query->whereHas('productColorSize', function ($query) use ($sizeIds) {
            $query->whereIn('size_id', $sizeIds);
        });
    }
}
