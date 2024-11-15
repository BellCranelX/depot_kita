<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product')->insert([
            'id' => 1,
            'name' => "Nasi Ayam Hongkong",
            "price" => 29000,
            'stock' => 100,
            "description"=>"Ayam Tanpa Tulang... Menggunakan Ayam Koloke Disiram Kuah",
            "image_url"=>"nasi_ayam_hongkong.jpg",
            "active" => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('product')->insert([
            'id' => 2,
            'name' => "Nasi Ayam Teriyaki",
            "price" => 29000,
            'stock' => 100,
            "description"=>"Ayam Crispy... Ayam Tanpa Tulang... Saos BBQ Pisah... Tidak Pedas...",
            "image_url"=>"nasi_ayam_teriyaki.png",
            "active" => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('product')->insert([
            'id' => 3,

            'name' => "Nasi Ayam Kungpao",
            "price" => 29000,
            'stock' => 100,
            "description"=>"Ayam Saos Inggris... Tanpa Tulang... Tidak Pedas...",
            "image_url"=>"ayam_kungpao.jpg",
            "active" => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('product')->insert([
            'id' => 4,
            'name' => "Nasi Empal",
            "price" => 34500,
            'stock' => 100,
            "description"=>"Empal Gepuk Empuk Dapat Kremesan Dapat Sambal Bajak Dipisah",
            "image_url"=>"nasi_empal.png",
            "active" => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('product')->insert([
            'id' => 6,
            'name' => "Nasi Ayam Geprek",
            "price" => 29000,
            'stock' => 100,
            "description"=>"Ayam Geprek Tanpa Tulang Sambel Bawang, Sambel Dipisah... LEvel Sambel Tidak Ada... Sambel Mantulll Pake Sambel Bawang... Dapet Tempe 2Pcs...",
            "image_url"=>"nasi_ayam_geprek.png",
            "active" => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
