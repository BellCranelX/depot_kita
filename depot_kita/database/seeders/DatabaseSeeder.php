<?php

namespace Database\Seeders;

use App\Models\customers;
use App\Models\products;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(CreateNotificationsSeeder::class);
        $this->call(customersSeeder::class);    
        $this->call(ProductsSeeder::class);
        $this->call(OrdersSeeder::class);
        $this->call(OrderProductsSeeder::class);
       
        $this->call(StocksSeeder::class);
        $this->call(TransactionsSeeder::class);
        $this->call(UserSeeder::class);
    }
}
