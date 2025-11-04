<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentMethod;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['payment_method' => 'コンビニ払い'],
            ['payment_method' => 'カード支払い'],
        ];
        DB::table('payment_methods')->insert($param);
    }
}
