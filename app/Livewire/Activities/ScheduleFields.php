<?php

namespace App\Livewire\Activities;

use Livewire\Component;
use App\Models\Activity;

class ScheduleFields extends Component
{
    public string $type = 'singular';
    public ?string $date = null;
    public string $frequency = 'daily';
    public int $times_per_period = 1;

    public function render()
    {
        return view('livewire.activities.schedule-fields');
    }

    public function mount(?Activity $activity = null)
    {
        if ($activity?->schedule) {
            $this->type = 'recurring';
            $this->frequency = $activity->schedule->frequency;
            $this->times_per_period = $activity->schedule->times_per_period;
        } elseif ($activity?->date) {
            $this->type = 'singular';
            $this->date = $activity->date->format('Y-m-d');
        }
    }

}