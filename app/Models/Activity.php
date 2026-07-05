<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ActivitySchedule;

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

}
