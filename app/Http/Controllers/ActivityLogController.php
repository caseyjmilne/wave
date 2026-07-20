<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function create(Activity $activity)
    {
        return view('activities.log', compact('activity'));
    }

    public function store(Request $request, Activity $activity)
    {
        $activity->logs()->create($request->validate([
            'completed_at' => 'required|date',
            'notes' => 'nullable|string',
        ]));

        return redirect()->route('activities.index');
    }
}