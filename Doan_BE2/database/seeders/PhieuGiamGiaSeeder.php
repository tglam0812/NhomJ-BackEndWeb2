<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PhieuGiamGiaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('phieu_giam_gia')->insert([
            [
                'ten_phieu' => 'Giảm 10% Tháng 5',
                'phan_tram_giam' => 10,
                'so_luong' => 100,
                'ngay_bat_dau' => '2025-05-01',
                'ngay_ket_thuc' => '2025-05-31',
                'mo_ta' => 'Áp dụng cho tất cả đơn hàng trong tháng 5',
                'created_at' => Carbon::parse('2025-05-13 15:45:56'),
                'updated_at' => Carbon::parse('2025-05-13 15:45:56'),
            ],
            [
                'ten_phieu' => 'Ưu đãi sinh nhật',
                'phan_tram_giam' => 20,
                'so_luong' => 50,
                'ngay_bat_dau' => '2025-05-10',
                'ngay_ket_thuc' => '2025-06-10',
                'mo_ta' => 'Chúc mừng sinh nhật khách hàng',
                'created_at' => Carbon::parse('2025-05-13 15:45:56'),
                'updated_at' => Carbon::parse('2025-05-13 15:45:56'),
            ],
            [
                'ten_phieu' => 'Flash Sale 50%',
                'phan_tram_giam' => 50,
                'so_luong' => 30,
                'ngay_bat_dau' => '2025-05-15',
                'ngay_ket_thuc' => '2025-05-16',
                'mo_ta' => 'Chỉ áp dụng trong 2 ngày Flash Sale',
                'created_at' => Carbon::parse('2025-05-13 15:45:56'),
                'updated_at' => Carbon::parse('2025-05-13 15:45:56'),
            ],
            [
                'ten_phieu' => 'Giảm 5% toàn sàn',
                'phan_tram_giam' => 5,
                'so_luong' => 500,
                'ngay_bat_dau' => '2025-05-01',
                'ngay_ket_thuc' => '2025-12-31',
                'mo_ta' => 'Không giới hạn số lần sử dụng',
                'created_at' => Carbon::parse('2025-05-13 15:45:56'),
                'updated_at' => Carbon::parse('2025-05-13 15:45:56'),
            ],
            [
                'ten_phieu' => 'Black Fridayy',
                'phan_tram_giam' => 40,
                'so_luong' => 200,
                'ngay_bat_dau' => '2025-11-25',
                'ngay_ket_thuc' => '2025-11-30',
                'mo_ta' => 'Khuyến mãi lớn mùa Black Friday',
                'created_at' => Carbon::parse('2025-05-13 15:45:56'),
                'updated_at' => Carbon::parse('2025-05-13 15:45:56'),
            ],
        ]);
    }
}
