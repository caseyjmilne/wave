<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('email', 'test1@test.com')->exists()) {
            return;
        }

        User::create([
            'name' => 'Test User',
            'email' => 'test1@test.com',
            'password' => Hash::make('1234'),
        ]);
    }
}
