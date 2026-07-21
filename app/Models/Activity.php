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

    public function periodBounds($date, $frequency): array
    {
        return match ($frequency) {
            'daily' => [$date->copy()->startOfDay(), $date->copy()->endOfDay()],
            'weekly' => [$date->copy()->startOfWeek(), $date->copy()->endOfWeek()],
            'monthly' => [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()],
            'quarterly' => [$date->copy()->startOfQuarter(), $date->copy()->endOfQuarter()],
            'yearly' => [$date->copy()->startOfYear(), $date->copy()->endOfYear()],
        };
    }

    /**
     * The user-facing title for a log falling in the period containing $date.
     * Computed once at log-creation time so it stays stable even if sibling
     * logs are later added, completed, or removed.
     */
    public function nextLogTitle($date, ?int $position = null): string
    {
        $schedule = $this->schedule;

        if (! $schedule) {
            return 'Log for '.$date->format('M j, Y');
        }

        [$start, $end] = $this->periodBounds($date, $schedule->frequency);
        $timesPerPeriod = $schedule->times_per_period;

        $position ??= $this->logs()->whereBetween('created_at', [$start, $end])->count() + 1;

        if ($timesPerPeriod <= 1) {
            return match ($schedule->frequency) {
                'daily' => 'Log for '.$start->format('M j, Y'),
                'weekly' => 'Week of '.$start->format('M j'),
                'monthly' => $start->format('F Y').' log',
                'quarterly' => 'Q'.$start->quarter.' '.$start->year.' log',
                'yearly' => $start->year.' log',
            };
        }

        $periodLabel = match ($schedule->frequency) {
            'daily' => 'today',
            'weekly' => 'this week',
            'monthly' => 'this month',
            'quarterly' => 'this quarter',
            'yearly' => 'this year',
        };

        return "Log {$position} of {$timesPerPeriod} {$periodLabel}";
    }

    public function backfillLogs(): bool
    {
        if (!$this->schedule) return false;

        $frequency = $this->schedule->frequency;
        $timesPerPeriod = $this->schedule->times_per_period;

        $lastLog = $this->logs()->latest('created_at')->first();
        $cursor = $lastLog ? $lastLog->created_at->copy() : $this->created_at->copy();

        $refreshed = false;

        while (true) {
            [$start, $end] = $this->periodBounds($cursor, $frequency);

            if ($start->gt(now())) break;

            $existing = $this->logs()->whereBetween('created_at', [$start, $end])->count();
            $needed = $timesPerPeriod - $existing;

            for ($i = 0; $i < $needed; $i++) {
                $this->logs()->create([
                    'completed_at' => null,
                    'title' => $this->nextLogTitle($start, $existing + $i + 1),
                ]);
                $refreshed = true;
            }

            if ($end->gte(now())) break;

            $cursor = $end->copy()->addSecond();
        }

        if ($refreshed) {
            $this->load('logs');
        }

        return $refreshed;
    }

}
