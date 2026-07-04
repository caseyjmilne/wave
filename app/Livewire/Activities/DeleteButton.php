<?php 

namespace App\Livewire\Activities;
use App\Models\Activity;

use Livewire\Component;

class DeleteButton extends Component
{
    public Activity $activity;
    public bool $confirming = false;

    public function delete()
    {
        $this->activity->delete();
        $this->redirect(route('activities.index'));
    }

    public function render()
    {
        return view('livewire.activities.delete-button');
    }
}