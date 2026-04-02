<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
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
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'img_url' => 'items/Armani-Mens-Clock.jpg',
                'user_id' => 1,
                'condition' => '良好',
                'categories' => [5,12],
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'img_url' => 'items/HDD-Hard-Disk.jpg',
                'user_id' => 1,
                'condition' => '目立った傷や汚れなし',
                'categories' => [2],
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'img_url' => 'items/iLoveIMG-d.jpg',
                'user_id' => 1,
                'condition' => 'やや傷や汚れあり',
                'categories' => [10],
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'brand' => null,
                'description' => 'クラシックなデザインの革靴',
                'img_url' => 'items/Leather-Shoes-Product-Photo.jpg',
                'user_id' => 1,
                'condition' => '状態が悪い',
                'categories' => [1,5],
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'img_url' => 'items/Living-Room-Laptop.jpg',
                'user_id' => 1,
                'condition' => '良好',
                'categories' => [2],
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'brand' => null,
                'description' => '高音質のレコーディング用マイク',
                'img_url' => 'items/Music-Mic-4632231.jpg',
                'user_id' => 2,
                'condition' => '目立った傷や汚れなし',
                'categories' => [13],
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'img_url' => 'items/Purse-fashion-pocket.jpg',
                'user_id' => 2,
                'condition' => 'やや傷や汚れあり',
                'categories' => [1,4,11],
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => null,
                'description' => '使いやすいタンブラー',
                'img_url' => 'items/Tumbler-souvenir.jpg',
                'user_id' => 2,
                'condition' => '状態が悪い',
                'categories' => [3,10],
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'img_url' => 'items/Waitress-with-Coffee-Grinder.jpg',
                'user_id' => 2,
                'condition' => '良好',
                'categories' => [3,10],
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'img_url' => 'items/makeup.jpg',
                'user_id' => 2,
                'condition' => '目立った傷や汚れなし',
                'categories' => [1,4,5,6],
            ],
        ];
        foreach ($params as $data) {
            $categoryIds = $data['categories'];
            unset($data['categories']);

            $item = Item::create($data);

            $item->categories()->attach($categoryIds);
        }
    }
}
