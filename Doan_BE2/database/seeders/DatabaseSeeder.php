<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gọi lần lượt các seeder cần thiết
        $this->call([
            LevelUserSeeder::class,   
            UsersTableSeeder::class,  
            CategorySeeder::class, 
            BrandSeeder::class,
            ProductsTableSeeder::class
        ]);
    }
}
