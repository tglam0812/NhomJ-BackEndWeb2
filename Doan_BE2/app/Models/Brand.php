<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brand'; // Tên bảng
    protected $primaryKey = 'brand_id';
    protected $fillable = [
        'brand_id',
        'brand_name',
        'brand_description',
        'brand_status'
        
    ];
    
    /**
     * Một danh mục có nhiều sản phẩm
     */
    public function products() {
        return $this->hasMany(Products::class);
    }public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
