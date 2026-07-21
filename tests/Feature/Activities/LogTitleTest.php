<?php

use App\Models\Activity;
use App\Models\User;

test('a one-off activity with no schedule gets a dated title', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read', 'date' => '2026-07-21']);

    $title = $activity->nextLogTitle(now()->setDate(2026, 7, 21));

    expect($title)->toBe('Log for Jul 21, 2026');
});

test('a schedule with one log per period gets a period label instead of a count', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $activity->schedule()->create(['frequency' => 'weekly', 'times_per_period' => 1]);

    $title = $activity->nextLogTitle(now(), 1);

    expect($title)->toStartWith('Week of ');
});

test('a schedule with multiple logs per period numbers them', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $activity->schedule()->create(['frequency' => 'weekly', 'times_per_period' => 3]);

    expect($activity->nextLogTitle(now(), 1))->toBe('Log 1 of 3 this week');
    expect($activity->nextLogTitle(now(), 2))->toBe('Log 2 of 3 this week');
});

test('backfilling logs assigns sequential titles within a period', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $activity->schedule()->create(['frequency' => 'daily', 'times_per_period' => 2]);

    $activity->backfillLogs();

    $titles = $activity->logs()->orderBy('id')->pluck('title');

    expect($titles->take(2)->all())->toBe(['Log 1 of 2 today', 'Log 2 of 2 today']);
});
