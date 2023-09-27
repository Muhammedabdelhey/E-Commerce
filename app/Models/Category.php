<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable  = ['name'];
    public $timestamps = false;

    public function products()
    {
        return $this->hasManyThrough(Product::class,SubCategory::class,'category_id','subcategory_id');
    }

    public function subcategories(){
        return $this->hasMany(SubCategory::class);
    }
}
