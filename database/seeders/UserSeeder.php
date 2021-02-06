<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Chu Cẩm Phong',
            'email' => 'chucamphong@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'Trương Thái Ngọc',
            'email' => 'truongthaingoc@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'Nguyễn Trường An',
            'email' => 'nguyentruongan@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'Trần Duy Anh',
            'email' => 'tranduyanh@gmail.com',
        ]);
    }
}
