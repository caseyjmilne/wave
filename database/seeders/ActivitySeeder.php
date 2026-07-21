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

        // No schedule: title is just the dated log.
        Activity::create([
            'user_id' => $user->id,
            'name' => 'Dentist appointment',
            'description' => fake()->sentence(),
            'date' => now()->addWeek(),
        ]);

        // 1x per period: title is a period label, no count needed.
        $this->withSchedule($user, 'Meditate', 'daily', 1);
        $this->withSchedule($user, 'Budget review', 'monthly', 1);

        // Several per period: title is numbered.
        $this->withSchedule($user, 'Gym', 'weekly', 3);
        $this->withSchedule($user, 'Water plants', 'weekly', 2);
    }

    private function withSchedule(User $user, string $name, string $frequency, int $timesPerPeriod): void
    {
        $activity = Activity::create([
            'user_id' => $user->id,
            'name' => $name,
            'description' => fake()->sentence(),
        ]);

        $activity->schedule()->create([
            'frequency' => $frequency,
            'times_per_period' => $timesPerPeriod,
        ]);

        $activity->backfillLogs();
    }
}
