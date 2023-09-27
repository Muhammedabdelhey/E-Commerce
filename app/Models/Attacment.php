<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attacment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=['path'];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}
