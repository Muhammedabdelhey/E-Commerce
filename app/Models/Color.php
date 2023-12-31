<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name'];

    public function productColorSize()
    {
        return $this->hasMany(ProductColorSize::class, 'color_id');
    }
}
