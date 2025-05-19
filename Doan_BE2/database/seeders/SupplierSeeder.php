<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table('supplier')->insert([
                'supplier_name' => 'Nhà cung cấp ' . $i,
                'supplier_email' => 'supplier' . $i . '@gmail.com',
                'supplier_description' => 'Mô tả cho nhà cung cấp số ' . $i,
                'supplier_status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
