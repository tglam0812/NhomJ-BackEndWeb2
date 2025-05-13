<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuGiamGia extends Model
{
    use HasFactory;

    protected $table = 'phieu_giam_gia';

   protected $fillable = [
    'ma_phieu', 'ten_phieu', 'phan_tram_giam',
    'ngay_bat_dau', 'ngay_ket_thuc', 'mo_ta', 'so_luong'
];
    public $timestamps = false;

    // Quan hệ 1-n: Một phiếu giảm giá có thể thuộc nhiều hóa đơn
    public function bills()
    {
        return $this->hasMany(Bill::class, 'phieu_giam_id', 'id');
    }
}
