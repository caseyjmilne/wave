<?php

namespace App\Livewire\Activities;

use App\Enums\ActivityLogStatus;
use App\Models\Activity;
use Livewire\Component;

class LogTable extends Component
{
    public Activity $activity;

    public function complete(int $logId): void
    {
        $this->activity->logs()->find($logId)?->update([
            'status' => ActivityLogStatus::Completed,
            'completed_at' => now(),
        ]);
    }

    public function skip(int $logId): void
    {
        $this->activity->logs()->find($logId)?->update([
            'status' => ActivityLogStatus::Skipped,
            'completed_at' => null,
        ]);
    }

    public function render()
    {
        return view('livewire.activities.log-table', [
            'logs' => $this->activity->logs()->get(),
        ]);
    }
}
