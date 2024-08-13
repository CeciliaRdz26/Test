<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Alan Torres',
            'email' => 'alan@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // contraseña encriptada
            'remember_token' => Str::random(10),
        ]);
    }
}
