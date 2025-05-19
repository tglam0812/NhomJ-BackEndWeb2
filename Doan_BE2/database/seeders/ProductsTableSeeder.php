<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalCategories = DB::table('category')->count();
        $images = ['tainghe1.jpg', 'dongho1.jpg', 'laptop1.jpg', 'iPhone16.jpg'];

        for ($i = 1; $i <= 100; $i++) {
            DB::table('products')->insert([
                'product_name' => 'Sản phẩm số ' . $i,
                'product_price' => rand(1000000, 50000000),
                'product_qty' => rand(1, 20),
                'category_id' => rand(1, $totalCategories),
                'brand_id' => rand(1, 5),
                'product_description' => 'Mô tả sản phẩm mẫu số ' . $i . '. Đây là sản phẩm dùng để test hệ thống.',
                'product_status' => 'active',
                'product_images_1' => $images[array_rand($images)],
                'product_images_2' => $images[array_rand($images)],
                'product_images_3' => $images[array_rand($images)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
