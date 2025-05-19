<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('category')->insert([
            [
                'category_name' => 'Điện thoại',
                'category_description' => 'Các sản phẩm điện thoại',
                'category_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_name' => 'Laptop',
                'category_description' => 'Các sản phẩm laptop',
                'category_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_name' => 'Đồng hồ',
                'category_description' => 'Các sản phẩm đồng hồ',
                'category_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_name' => 'Phụ kiện khác',
                'category_description' => 'Các sản phẩm khác',
                'category_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
