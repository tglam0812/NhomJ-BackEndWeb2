<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy danh sách [category_id => category_name]
        $categories = DB::table('category')->pluck('category_name', 'category_id');
        $images = ['macbookpro13m2_1.jpg', 'samsum22_2.jpg', 'laptopasusf15_1.jpg', 'samsum23_1.jpg', 'samsungfit3_3.jpg', 'macbookpro13m2_2.jpg', 'gallery-04.jpg'];

        for ($i = 1; $i <= 100; $i++) {
            $categoryId = $categories->keys()->random(); // random category_id
            $categoryName = $categories[$categoryId];     // lấy tên danh mục

            DB::table('products')->insert([
                'product_name' => $categoryName . ' số ' . $i,
                'product_price' => rand(1000000, 50000000),
                'product_qty' => rand(1, 20),
                'category_id' => $categoryId,
                'brand_id' => rand(1, 5),
                'product_description' => 'Mô tả sản phẩm mẫu số ' . $i . '. Đây là sản phẩm dùng để test hệ thống.',
                'product_status' => '1',
                'product_images_1' => $images[array_rand($images)],
                'product_images_2' => $images[array_rand($images)],
                'product_images_3' => $images[array_rand($images)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
