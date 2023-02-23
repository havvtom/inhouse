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
                    'name' => 'DevManager',
                    'email' => 'devmanager@email.com',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'SeniorDev',
                    'email' => 'seniordev@email.com',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Tom',
                    'email' => 'tom@email.com',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Kya',
                    'email' => 'kya@email.com',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Sharon',
                    'email' => 'sharon@email.com',
                    'password' => Hash::make('password'),
                ],
            ]
        );
    }
}
