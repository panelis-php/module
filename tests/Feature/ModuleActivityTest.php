<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Panelis\Module\Models\Module;
use Spatie\Activitylog\Models\Activity;

uses(RefreshDatabase::class);

it('logs module lifecycle activity', function (): void {
    $module = Module::query()->create([
        'name' => 'Panelis Module',
        'description' => 'Module description',
    ]);

    $activity = Activity::query()->where('subject_id', $module->getKey())->firstOrFail();

    expect($activity->log_name)->toBe('module')
        ->and($activity->event)->toBe('created')
        ->and($activity->description)->toBe('module::activity.created');
});

it('does not log module activity when activity logging is disabled', function (): void {
    config()->set('activitylog.enabled', false);

    Module::query()->create([
        'name' => 'Panelis Module',
        'description' => 'Module description',
    ]);

    expect(Activity::query()->count())->toBe(0);
});
