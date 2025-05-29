<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 4 danh mục cố định
        $categories = [
            [
                'category_name' => 'Điện thoại',
                'category_description' => 'Các sản phẩm điện thoại',
                'category_status' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Laptop',
                'category_description' => 'Các sản phẩm laptop',
                'category_status' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Đồng hồ',
                'category_description' => 'Các sản phẩm đồng hồ',
                'category_status' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_name' => 'Phụ kiện khác',
                'category_description' => 'Các sản phẩm khác',
                'category_status' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Thêm 10 danh mục tự động
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                'category_name' => 'Danh mục số ' . $i,
                'category_description' => 'Mô tả danh mục số ' . $i,
                'category_status' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('category')->insert($categories);
    }
}
