<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products'; // Tên 
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name',
        'product_price',
        'product_qty',
        'category_id',
        'brand_id',
        'product_description',
        'product_status',
        'product_images_1',
        'product_images_2',
        'product_images_3'
    ];

    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function brand()
{
    return $this->belongsTo(Brand::class, 'brand_id');
}
}
