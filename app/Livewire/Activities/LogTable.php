<?php

namespace App\Livewire\Activities;

use App\Enums\ActivityLogStatus;
use App\Models\Activity;
use Livewire\Component;

class LogTable extends Component
{
    public Activity $activity;
    public ?int $confirmingLogId = null;
    public ?string $confirmingTargetStatus = null;

    public function complete(int $logId): void
    {
        $log = $this->activity->logs()->find($logId);

        if (! $log) {
            return;
        }

        if ($log->isCompleted()) {
            $this->confirm($logId, ActivityLogStatus::Pending);

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

        // Undoing a completion (either back to pending, or over to skipped)
        // always needs confirmation. Skipping straight to completed doesn't.
        if ($log->isCompleted()) {
            $this->confirm($logId, ActivityLogStatus::Skipped);

            return;
        }

        if ($log->isSkipped()) {
            $this->confirm($logId, ActivityLogStatus::Pending);

            return;
        }

        $log->update([
            'status' => ActivityLogStatus::Skipped,
            'completed_at' => null,
        ]);
    }

    public function confirmChange(): void
    {
        $status = ActivityLogStatus::from($this->confirmingTargetStatus);

        $this->activity->logs()->find($this->confirmingLogId)?->update([
            'status' => $status,
            'completed_at' => $status === ActivityLogStatus::Completed ? now() : null,
        ]);

        $this->cancelChange();
    }

    public function cancelChange(): void
    {
        $this->confirmingLogId = null;
        $this->confirmingTargetStatus = null;
    }

    private function confirm(int $logId, ActivityLogStatus $targetStatus): void
    {
        $this->confirmingLogId = $logId;
        $this->confirmingTargetStatus = $targetStatus->value;
    }

    public function render()
    {
        return view('livewire.activities.log-table', [
            'logs' => $this->activity->logs()->get(),
        ]);
    }
}
