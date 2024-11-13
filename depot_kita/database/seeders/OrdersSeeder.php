<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('orders')->insert([
            [
                'id' => 1,
                'customer_id' => 1,
                'order_date' => Carbon::now(),
                'status' => 'Pending',
                'waiting_list_number' => 5,
                'total_amount' => 150.50,
                'special_requests' => 'Please deliver after 5 PM.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'customer_id' => 2,
                'order_date' => Carbon::now()->subDay(),
                'status' => 'Pending',
                'waiting_list_number' => 3,
                'total_amount' => 200.75,
                'special_requests' => 'Gift wrap the items.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'customer_id' => 3,
                'order_date' => Carbon::now()->subDays(2),
                'status' => 'Pending',
                'waiting_list_number' => 1,
                'total_amount' => 100.25,
                'special_requests' => 'Please call before delivery.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more orders here

            
        ]);
    }
}
