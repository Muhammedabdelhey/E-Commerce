<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','phone', 'address', 'payment', 'status', 'user_id',
        'created_at', 'updated_at'
    ];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'order_items',
            'order_id',
            'product_id'
        )->withPivot('color_id', 'size_id', 'quantity');
    }
}
