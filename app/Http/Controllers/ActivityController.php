<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    public function index()
    {
        $activities = auth()->user()->activities()->with('logs', 'schedule')->latest()->get();

        $activities->each(fn ($activity) => $activity->backfillLogs());

        $activities->each(function ($activity) {
            $activity->streak = $activity->schedule ? $activity->currentStreak() : null;
        });

        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly,yearly',
            'times_per_period' => 'nullable|integer|min:1',
        ]);

        $activity = auth()->user()->activities()->create(
            collect($validated)->only(['name', 'description', 'date'])->toArray()
        );

        $activity->schedule()->create(
            collect($validated)->only(['frequency', 'times_per_period'])->toArray()
        );

        return redirect()->route('activities.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        //
    }

    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly,yearly',
            'times_per_period' => 'nullable|integer|min:1',
        ]);

        $activity->update(collect($validated)->only(['name', 'description', 'date'])->toArray());

        $activity->schedule()->updateOrCreate([], collect($validated)->only(['frequency', 'times_per_period'])->toArray());

        return redirect()->route('activities.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        //
    }

}
