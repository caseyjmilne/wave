<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class DashboardController extends Controller
{

    public function index() {

        $activities = auth()->user()->activities()->with('logs', 'schedule')->latest()->get();

        $activities->each(function ($activity) {
            $activity->streak = $activity->schedule ? $activity->currentStreak() : null;
        });

        return view('dashboard', compact('activities'));

    }


}