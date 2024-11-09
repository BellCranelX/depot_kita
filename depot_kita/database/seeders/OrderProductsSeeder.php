<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('order_product')->insert([
            [
                'id' => 1,
                'order_id' => 1,
                'product_id' => 3,
                'quantity' => 2,
                'price' => 25.00,
                'subtotal' => 50.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 3,
                'price' => 20.00,
                'subtotal' => 60.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
