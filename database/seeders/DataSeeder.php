<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@collective.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fajar Wisnu Mukti',
                'email' => 'fajar@collective.com',
                'password' => Hash::make('password'),
                'role' => 'Guest',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('wallets')->insert([
            [
                'user_id' => 2, // Assuming user_id 1 exists
                'balance' => 10000000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $transactions = [];

        foreach (range(1, 10) as $index) {
            $transactions[] = [
                'user_id' => 2, // Assuming user_id 2 exists
                'order_id' => Str::uuid()->toString(),
                'amount' => mt_rand(10000, 100000) / 100, // Random amount between 100.00 and 1000.00
                'type' =>  rand(1, 2) == 1 ? 'Deposit' : 'Withdraw',
                'timestamp' => Carbon::now(),
                'status' => rand(1, 2), // Random status between 1 and 2
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('transactions')->insert($transactions);
    }
}
