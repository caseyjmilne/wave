<?php

use App\Enums\ActivityLogStatus;
use App\Livewire\Activities\LogTable;
use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\User;
use Livewire\Livewire;

test('completing a pending log sets status and completed_at immediately', function () {
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

test('skipping a pending log sets status to skipped immediately', function () {
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
    $component->assertSet('confirmingLogId', $log->id);
    $component->assertSet('confirmingTargetStatus', 'pending');
});

test('confirming complete->complete reverts the log back to pending', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['status' => ActivityLogStatus::Completed, 'completed_at' => now()]);

    Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('complete', $log->id)
        ->call('confirmChange');

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Pending);
    expect($log->completed_at)->toBeNull();
});

test('cancelling the confirm leaves the log unchanged', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['status' => ActivityLogStatus::Completed, 'completed_at' => now()]);

    $component = Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('complete', $log->id)
        ->call('cancelChange');

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Completed);
    $component->assertSet('confirmingLogId', null);
    $component->assertSet('confirmingTargetStatus', null);
});

test('clicking skip on an already-completed log opens a confirm prompt since it undoes the completion', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['status' => ActivityLogStatus::Completed, 'completed_at' => now()]);

    $component = Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('skip', $log->id);

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Completed);
    $component->assertSet('confirmingLogId', $log->id);
    $component->assertSet('confirmingTargetStatus', 'skipped');
});

test('confirming completed->skip marks the log skipped', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['status' => ActivityLogStatus::Completed, 'completed_at' => now()]);

    Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('skip', $log->id)
        ->call('confirmChange');

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Skipped);
    expect($log->completed_at)->toBeNull();
});

test('completing an already-skipped log switches it directly with no confirm', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['status' => ActivityLogStatus::Skipped, 'completed_at' => null]);

    $component = Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('complete', $log->id);

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Completed);
    expect($log->completed_at)->not->toBeNull();
    $component->assertSet('confirmingLogId', null);
});

test('clicking skip on an already-skipped log opens a confirm prompt to revert to pending', function () {
    $user = User::factory()->create();
    $activity = Activity::create(['user_id' => $user->id, 'name' => 'Read']);
    $log = $activity->logs()->create(['status' => ActivityLogStatus::Skipped, 'completed_at' => null]);

    $component = Livewire::actingAs($user)
        ->test(LogTable::class, ['activity' => $activity])
        ->call('skip', $log->id);

    $log->refresh();

    expect($log->status)->toBe(ActivityLogStatus::Skipped);
    $component->assertSet('confirmingLogId', $log->id);
    $component->assertSet('confirmingTargetStatus', 'pending');
});
