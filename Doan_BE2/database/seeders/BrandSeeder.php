<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'brand_name' => 'Apple',
                'brand_description' => 'Thương hiệu Apple',
                'brand_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'brand_name' => 'Samsung',
                'brand_description' => 'Thương hiệu Samsung',
                'brand_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'brand_name' => 'Xiaomi',
                'brand_description' => 'Thương hiệu Xiaomi',
                'brand_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'brand_name' => 'Asus',
                'brand_description' => 'Thương hiệu Asus',
                'brand_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'brand_name' => 'HP',
                'brand_description' => 'Thương hiệu HP',
                'brand_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        

        for ($i = 1; $i <= 10; $i++) {
            $brands[] = [
                'brand_name' => 'HP',
                'brand_description' => 'Thương hiệu HP'. $i,
                'brand_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('brand')->insert($brands);
    }
}
