<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $genders = ['Male', 'Female', 'Other'];
        $avatars = ['avatar1.jpg', 'avatar2.jpg', 'avatar3.jpg'];
        $levelCount = DB::table('level_user')->count(); // số lượng quyền

        for ($i = 1; $i <= 50; $i++) {
            DB::table('users')->insert([
                'full_name' => 'User ' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => Hash::make('password' . $i),
                'phone' => '09' . rand(10000000, 99999999),
                'gender' => $genders[array_rand($genders)],
                'date' => now()->subYears(rand(18, 40))->subDays(rand(1, 365))->format('Y-m-d'),
                'address' => 'Địa chỉ ' . $i,
                'avatar' => $avatars[array_rand($avatars)],
                'level_id' => rand(1, $levelCount),
                'status' => '1',
                'about' => 'Giới thiệu người dùng số ' . $i,
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
