<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $table = 'billdetail'; 

    protected $primaryKey = 'bill_detail_id'; 

    public $timestamps = true; 
    protected $fillable = [
        'bill_id',
        'cart_id',
        'product_id',
        'quantity',
        'price',
    ];
}
