<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier'; // Tên bảng
    protected $primaryKey = 'supplier_id';
    protected $fillable = [
        'supplier_name',
        'supplier_email',
        'supplier_description',
        'supplier_status'
    ];
}
