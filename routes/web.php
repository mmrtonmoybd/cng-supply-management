<?php

use Illuminate\Support\Facades\Route;

$default = [
    'prefix' => config('boilerplate.app.prefix', ''),
    'domain' => config('boilerplate.app.domain', ''),
    'middleware' => [
        'web',
        'boilerplatelocale',
        'boilerplateauth',
        'ability:admin,backend_access', 'boilerplate.emailverified',
    ],
    'as' => 'backend.',
];

Route::group($default, function () {

    Route::get('/clear', function () {
        $exitCode = Artisan::call('optimize:clear');
        // return what you want
    });

    Route::get('/cache', function () {
        $exitCode = Artisan::call('optimize');
        // return what you want
    });

    Route::get('/storagelink', function () {
        $exitCode = Artisan::call('storage:link');
        // return what you want
    });

    Route::group([], function () {
        Route::get('/notifications', [App\Http\Controllers\Backend\Notification\NotificationController::class, 'fetch']);
        Route::post('/notifications/mark-read', [App\Http\Controllers\Backend\Notification\NotificationController::class, 'markRead']);
        Route::post('/notifications/mark-read/{id}', [App\Http\Controllers\Backend\Notification\NotificationController::class, 'markSingleRead']);
        Route::get('/notifications/all', [App\Http\Controllers\Backend\Notification\NotificationController::class, 'all'])->name('notifications.all');
    });

    Route::resource('load/load-entry', App\Http\Controllers\Backend\Load\LoadEntryController::class)->names('load');

    Route::get('activity', App\Http\Controllers\Backend\Activity\ActivityController::class.'@index')->name('activity.index');
    Route::get('activity/{activity}', App\Http\Controllers\Backend\Activity\ActivityController::class.'@show')->name('activity.show');

    Route::resource('pump', App\Http\Controllers\Backend\Pump\PumpController::class)->names('pump');

});

Route::get('test', App\Http\Controllers\Test::class.'@index')->name('test.index');

Route::get('/migration', function () {
        $exitCode = Artisan::call('migrate');
        // return what you want
    });

Route::get('/appkey', function () {
        $exitCode = Artisan::call('key:generate');
        // return what you want
    });
