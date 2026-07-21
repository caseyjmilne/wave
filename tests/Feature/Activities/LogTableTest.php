<?php

use App\Enums\ActivityLogStatus;
use App\Livewire\Activities\LogTable;
use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\User;
use Livewire\Livewire;

test('completing a log sets status and completed_at', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['completed_at' => null]);

    Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('complete', $log->id);

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Completed);
    expect($log->completed_at)->not->toBeNull();
});

test('skipping a log sets status to skipped', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['completed_at' => null]);

    Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('skip', $log->id);

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Skipped);
    expect($log->completed_at)->toBeNull();
});

test('clicking complete on an already-completed log opens a confirm prompt instead of reverting immediately', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['status' => ActivityLogStatus::Completed, 'completed_at' => now()]);

    $component = Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('complete', $log->id);

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Completed);
    $component->assertSet('confirmingRevertId', $log->id);
});

test('confirming the revert sets the log back to pending', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['status' => ActivityLogStatus::Completed, 'completed_at' => now()]);

    Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('complete', $log->id)
        ->call('confirmRevert');

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Pending);
    expect($log->completed_at)->toBeNull();
});

test('cancelling the revert leaves the log unchanged', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['status' => ActivityLogStatus::Completed, 'completed_at' => now()]);

    $component = Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('complete', $log->id)
        ->call('cancelRevert');

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Completed);
    $component->assertSet('confirmingRevertId', null);
});

test('skipping an already-completed log switches it directly with no confirm', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['status' => ActivityLogStatus::Completed, 'completed_at' => now()]);

    $component = Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('skip', $log->id);

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Skipped);
    expect($log->completed_at)->toBeNull();
    $component->assertSet('confirmingRevertId', null);
});
