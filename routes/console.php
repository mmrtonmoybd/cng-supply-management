<?php

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schedule;

Schedule::command('vehicle:check-documents')->dailyAt('09:00')
    ->appendOutputTo(storage_path('logs/vehicle-documents-check.log'));

Schedule::command('loads:check-inactive')
    ->hourly()
    ->appendOutputTo(storage_path('logs/inactive-loads-check.log'));

Schedule::command('auth:clear-resets')
    ->hourly()
    ->appendOutputTo(storage_path('logs/reset-password-clean.log'));

Schedule::command('activitylog:clean --days=61')
    ->daily()
    ->appendOutputTo(storage_path('logs/activity-clean.log'));

Schedule::call(function () {
     DatabaseNotification::whereNotNull('read_at')
        ->where('created_at', '<', Carbon::now()->subDays(60))
        ->delete();

    //logger("Deleted $deleted old read notifications.");
})->daily()->appendOutputTo(storage_path('logs/notification-clean.log'));
