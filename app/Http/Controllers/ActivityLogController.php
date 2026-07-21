<?php

namespace App\Http\Controllers;

use App\Enums\ActivityLogStatus;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ActivityLogController extends Controller
{
    public function create(Activity $activity)
    {
        return view('activities.log', compact('activity'));
    }

    public function store(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'completed_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $completedAt = Carbon::parse($validated['completed_at']);

        $activity->logs()->create([
            'completed_at' => $completedAt,
            'status' => ActivityLogStatus::Completed,
            'title' => $activity->nextLogTitle($completedAt),
        ]);

        return redirect()->route('activities.index');
    }
}