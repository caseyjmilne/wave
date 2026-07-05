<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;

class ActivitySchedule extends Model
{
    protected $fillable = ['activity_id', 'frequency', 'times_per_period'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}