<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'admin',
            'email'=> 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);
    }
}