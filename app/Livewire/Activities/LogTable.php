<?php

namespace App\Livewire\Activities;

use App\Enums\ActivityLogStatus;
use App\Models\Activity;
use Livewire\Component;

class LogTable extends Component
{
    public Activity $activity;
    public ?int $confirmingRevertId = null;

    public function complete(int $logId): void
    {
        $log = $this->activity->logs()->find($logId);

        if (! $log) {
            return;
        }

        if ($log->isCompleted()) {
            $this->confirmingRevertId = $logId;

            return;
        }

        $log->update([
            'status' => ActivityLogStatus::Completed,
            'completed_at' => now(),
        ]);
    }

    public function skip(int $logId): void
    {
        $log = $this->activity->logs()->find($logId);

        if (! $log) {
            return;
        }

        if ($log->isSkipped()) {
            $this->confirmingRevertId = $logId;

            return;
        }

        $log->update([
            'status' => ActivityLogStatus::Skipped,
            'completed_at' => null,
        ]);
    }

    public function confirmRevert(): void
    {
        $this->activity->logs()->find($this->confirmingRevertId)?->update([
            'status' => ActivityLogStatus::Pending,
            'completed_at' => null,
        ]);

        $this->confirmingRevertId = null;
    }

    public function cancelRevert(): void
    {
        $this->confirmingRevertId = null;
    }

    public function render()
    {
        return view('livewire.activities.log-table', [
            'logs' => $this->activity->logs()->get(),
        ]);
    }
}
