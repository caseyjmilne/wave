<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test1@test.com')->first();

        for ($i = 0; $i < 5; $i++) {
            Activity::create([
                'user_id' => $user->id,
                'name' => fake()->sentence(3),
                'description' => fake()->paragraph(),
                'date' => fake()->dateTimeBetween('-1 month', '+1 month'),
            ]);
        }
    }
}
