<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Warren Miltaico',
                'email' => 'warrenmiltaico6@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt(value: '12345'),
                'role' => 'admin',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'James Wann',
                'email' => 'jameswann@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345'),
                'role' => 'employee',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kevin Gunawan',
                'email' => 'kevingunawan@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345'),
                'role' => 'employee',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
