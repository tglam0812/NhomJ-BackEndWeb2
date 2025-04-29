<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category'; // Tên bảng
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_name',
        'category_description',
        'category_status'
    ];
    /**
     * Một danh mục có nhiều sản phẩm
     */
    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
