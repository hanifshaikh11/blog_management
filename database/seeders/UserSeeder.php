<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class UserSeeder extends Seeder
{
    public function run(): void
    {

        // \DB::table('users')->truncate();

        \App\Models\User::insert([
            // [
            //     'name' => 'Demo User',
            //     'email' => 'demo@test.com',
            //     'password' => Hash::make('123456'),
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'name' => 'Another User',
            //     'email' => 'abc@test.com',
            //     'password' => Hash::make('123456'),
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'name' => 'Hanif Shaikh',
            //     'email' => 'hanif_blog@gmail.com',
            //     'password' => Hash::make('123456'),
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],

            [
                'name' => 'Tengo Charli',
                'email' => 'charli@test.com',
                'password' => Hash::make('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'Morgan',
                'email' => 'morgan@test.com',
                'password' => Hash::make('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'MS Patel',
                'email' => 'patel@test.com',
                'password' => Hash::make('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],


            [
                'name' => 'Maria Go',
                'email' => 'maria@test.com',
                'password' => Hash::make('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
