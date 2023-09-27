<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductColorSize extends Pivot
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = ['product_id', 'color_id', 'size_id', 'quantity'];
    protected $table = 'product_colors_sizes';
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
