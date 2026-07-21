<?php

namespace App\Livewire\Activities;

use App\Models\Activity;
use Livewire\Component;

class ActionsMenu extends Component
{
    public Activity $activity;
    public bool $open = false;
    public bool $confirmingDelete = false;

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function delete(): void
    {
        $this->activity->delete();
        $this->redirect(route('activities.index'));
    }

    public function render()
    {
        return view('livewire.activities.actions-menu');
    }
}
