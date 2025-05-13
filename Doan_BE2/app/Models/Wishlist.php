<?php

namespace App\Models;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'product_id'];

    public function product() {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
