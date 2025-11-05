<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            ['name' => '山田太郎', 'email' => 'yamada@example.com', 'password' => Hash::make('password')],
            ['name' => '佐藤花子', 'email' => 'sato@example.com', 'password' => Hash::make('password')],
            ['name' => '鈴木一郎', 'email' => 'suzuki@example.com', 'password' => Hash::make('password')],
            ['name' => '高橋美咲', 'email' => 'takahashi@example.com', 'password' => Hash::make('password')],
            ['name' => '伊藤健', 'email' => 'ito@example.com', 'password' => Hash::make('password')],
            ['name' => '中村彩', 'email' => 'nakamura@example.com', 'password' => Hash::make('password')],
        ];
        DB::table('users')->insert($params);
    }
}
