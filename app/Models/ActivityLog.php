<?php

namespace App\Models;

use App\Enums\ActivityLogStatus;
use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;

class ActivityLog extends Model
{
    protected $fillable = ['activity_id', 'completed_at', 'status'];
    protected $casts = [
        'completed_at' => 'datetime',
        'status' => ActivityLogStatus::class,
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function isPending(): bool
    {
        return $this->status === ActivityLogStatus::Pending;
    }

    public function isCompleted(): bool
    {
        return $this->status === ActivityLogStatus::Completed;
    }

    public function isSkipped(): bool
    {
        return $this->status === ActivityLogStatus::Skipped;
    }
}