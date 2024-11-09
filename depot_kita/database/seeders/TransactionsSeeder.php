<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('transaction')->insert([
            [
                'id' => 1,
                'order_id' => 1,
                'transaction_date' => Carbon::now(),
                'amount' => 150.50,
                'payment_method' => 'Credit Card',
                'status' => 'Completed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'order_id' => 2,
                'transaction_date' => Carbon::now()->subDay(),
                'amount' => 200.75,
                'payment_method' => 'PayPal',
                'status' => 'Pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more transactions as needed
        ]);
    }
}
