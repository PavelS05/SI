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
            'username' => 'ops',
            'password' => Hash::make('ops'),
            'role' => 'ops'
        ]);
    }
}