<?php

use App\Http\Controllers\Cashbook\CalculationController;
use App\Http\Controllers\Cashbook\CategoryController;
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

    Route::resource('pumpname', App\Http\Controllers\Backend\Pump\PumpNameController::class)->names('pumpname');

    Route::resource('pump', App\Http\Controllers\Backend\Pump\PumpController::class)->names('pump');
    Route::get('pump-filter', [App\Http\Controllers\Backend\Pump\PumpController::class, 'filter'])->name('pump.filter');
    Route::get('pump-filter/show', [App\Http\Controllers\Backend\Pump\PumpController::class, 'showFilter'])->name('pump.showFilter');
    Route::get('load-filter', [App\Http\Controllers\Backend\Load\LoadEntryController::class, 'filter'])->name('load.filter');
    Route::get('load-filter/show', [App\Http\Controllers\Backend\Load\LoadEntryController::class, 'showFilter'])->name('load.showFilter');

    Route::group(['prefix' => 'cashbook'], function () {
        Route::resource('calculations', CalculationController::class)->middleware('ability:admin,cashbook')->names('calculations');
        Route::get('calculations/export/{calculation}', [CalculationController::class, 'export'])->name('export');
        Route::resource('categories', CategoryController::class)->names('categories');
    });

    Route::group(['prefix' => 'factory', 'as' => 'factory.'], function () {
        Route::resource('dispansar', App\Http\Controllers\Backend\Factory\DispansarController::class)->names('dispansar');
        Route::get('dispansar/load-entry-select2', [App\Http\Controllers\Backend\Factory\DispansarController::class, 'loadEntrySelect2'])->name('dispansar.loadEntrySelect2');
        Route::get('dispansar-filter', [App\Http\Controllers\Backend\Factory\DispansarController::class, 'filter'])->name('dispansar.filter');
        Route::get('dispansar-filter/show', [App\Http\Controllers\Backend\Factory\DispansarController::class, 'showFilter'])->name('dispansar.showFilter');

        // Cng Pump & Waight Scale (WeightOne)
        Route::resource('weightone', App\Http\Controllers\Backend\Factory\WeightOneController::class)->names('weightone');
        Route::get('weightone-filter', [App\Http\Controllers\Backend\Factory\WeightOneController::class, 'filter'])->name('weightone.filter');
        Route::get('weightone-filter/show', [App\Http\Controllers\Backend\Factory\WeightOneController::class, 'showFilter'])->name('weightone.showFilter');

        // Waight Scale
        Route::resource('weight', App\Http\Controllers\Backend\Factory\WeightController::class)->names('weight');
        Route::get('weight-filter', [App\Http\Controllers\Backend\Factory\WeightController::class, 'filter'])->name('weight.filter');
        Route::get('weight-filter/show', [App\Http\Controllers\Backend\Factory\WeightController::class, 'showFilter'])->name('weight.showFilter');

        // Cng Pump Slip
        Route::resource('cngPump', App\Http\Controllers\Backend\Factory\CngPumpSlipController::class)->names('cngpump');
        Route::get('cngPump-filter', [App\Http\Controllers\Backend\Factory\CngPumpSlipController::class, 'filter'])->name('cngpump.filter');
        Route::get('cngPump-filter/show', [App\Http\Controllers\Backend\Factory\CngPumpSlipController::class, 'showFilter'])->name('cngpump.showFilter');

        Route::resource('factory', App\Http\Controllers\Backend\Factory\FactoryController::class)->names('factory');

        Route::resource('invoice', App\Http\Controllers\Backend\Invoice\InvoiceController::class)->names('invoice');

        Route::get('invoice/export/{invoice}', App\Http\Controllers\Backend\Invoice\InvoiceController::class.'@export')->name('invoice.export');
    });

});

Route::get('factory/invoice/verify/{hash}', [App\Http\Controllers\Backend\Invoice\InvoiceController::class, 'verify'])->name('factory.invoice.verify');

Route::get('test', App\Http\Controllers\Test::class.'@index')->name('test.index');

Route::get('/migration', function () {
    $exitCode = Artisan::call('migrate');
    // return what you want
});

Route::get('/appkey', function () {
    $exitCode = Artisan::call('key:generate');
    // return what you want
});
