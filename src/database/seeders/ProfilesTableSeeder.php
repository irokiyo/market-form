<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            [
                'user_id' => 1,
                'img_url' => null,
                'name' => '太郎',
                'postcode' => '100-0011',
                'address' => '東京都千代田区内幸町1-2-3',
                'building' => 'サンシャイン内幸町ビル 5F',
            ],
            [
                'user_id' => 2,
                'img_url' => null,
                'name' => 'はなちゃん',
                'postcode' => '150-0042',
                'address' => '東京都渋谷区宇田川町4-12-8',
                'building' => null,
            ],
            [
                'user_id' => 3,
                'img_url' => null,
                'name' => 'いっくん',
                'postcode' => '530-0005',
                'address' => '大阪府大阪市北区中之島3-15-21',
                'building' => '中之島パークタワー 12F',
            ],
        ];
        DB::table('profiles')->insert($params);
    }
}
