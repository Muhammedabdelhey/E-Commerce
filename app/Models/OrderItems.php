<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['order_id','product_id','color_id','size_id','quantity'];
}
