<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bill'; 
    protected $primaryKey = 'bill_id'; 
    public $timestamps = true; 

    protected $fillable = [
        'user_id',
        'total_qty',
        'total_amount',
        'date_invoice',
        'status',
        'note',
        'phieu_giam_id',
    ];
}
