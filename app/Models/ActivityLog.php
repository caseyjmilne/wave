<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;

class ActivityLog extends Model
{
    protected $fillable = ['activity_id', 'completed_at', 'status'];
    protected $casts = ['completed_at' => 'datetime'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}