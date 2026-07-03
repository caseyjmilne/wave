<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Activity extends Model
{

    protected $fillable = ['user_id', 'name', 'description', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
