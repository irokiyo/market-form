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
            [
                'user_id' => 4,
                'img_url' => null,
                'name' => 'みさみさ',
                'postcode' => '460-0012',
                'address' => '愛知県名古屋市中区千代田2-8-16',
                'building' => '千代田セントラルマンション 204号室',
            ],
            [
                'user_id' => 5,
                'img_url' => null,
                'name' => '伊藤健',
                'postcode' => '810-0041',
                'address' => '福岡県福岡市中央区大名1-6-22',
                'building' => '大名サウスコートビル 7階',
            ],
            [
                'user_id' => 6,
                'img_url' => null,
                'name' => '中村',
                'postcode' => '060-0042',
                'address' => '北海道札幌市中央区大通西5丁目9-4',
                'building' => '札幌フロントタワー 18F',
            ],
        ];
        DB::table('profiles')->insert($params);
    }
}
