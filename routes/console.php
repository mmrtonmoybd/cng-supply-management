<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('vehicle:check-documents')->dailyAt('09:00')
    ->appendOutputTo(storage_path('logs/vehicle-documents-check.log'));

Schedule::command('loads:check-inactive')
    ->hourly()
    ->appendOutputTo(storage_path('logs/inactive-loads-check.log'));

Schedule::command('auth:clear-resets')
    ->hourly()
    ->appendOutputTo(storage_path('logs/reset-password-clean.log'));
