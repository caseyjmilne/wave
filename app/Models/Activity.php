<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ActivitySchedule;
use App\Models\ActivityLog;

class Activity extends Model
{

    protected $fillable = ['user_id', 'name', 'description', 'date'];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->hasOne(ActivitySchedule::class);
    }

    public function logs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function currentStreak(): int
    {
        $schedule = $this->schedule;
        $streak = 0;
        $period = now();

        while (true) {
            [$start, $end] = $this->periodBounds($period, $schedule->frequency);
            $count = $this->logs()->whereBetween('completed_at', [$start, $end])->count();

            if ($count < $schedule->times_per_period) break;

            $streak++;
            $period = $start->subSecond(); // move to previous period
        }

        return $streak;
    }

    private function periodBounds($date, $frequency): array
    {
        return match ($frequency) {
            'daily' => [$date->copy()->startOfDay(), $date->copy()->endOfDay()],
            'weekly' => [$date->copy()->startOfWeek(), $date->copy()->endOfWeek()],
            'monthly' => [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()],
            'quarterly' => [$date->copy()->startOfQuarter(), $date->copy()->endOfQuarter()],
            'yearly' => [$date->copy()->startOfYear(), $date->copy()->endOfYear()],
        };
    }

}
