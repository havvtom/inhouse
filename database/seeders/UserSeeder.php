<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
                [
                    'name' => 'Leon',
                    'email' => 'leon@payfast.com',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'SeniorDev',
                    'email' => 'seniordev@payfast.com',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Tom',
                    'email' => 'tom@payfast.com',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Kya',
                    'email' => 'kya@payfast.com',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Sharon',
                    'email' => 'sharon@payfast.com',
                    'password' => Hash::make('password'),
                ],
            ]
        );
    }
}
