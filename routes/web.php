<?php

use App\Http\Controllers\Backend\HighlightController;
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

    Route::post('/highlight/save', [HighlightController::class, 'save'])->name('highlight.save');

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
    Route::get('pump-summary', [App\Http\Controllers\Backend\Pump\PumpNameController::class, 'filter'])->name('pumpsum.filter');
    Route::get('pump-summary/result', [App\Http\Controllers\Backend\Pump\PumpNameController::class, 'filterResult'])->name('pumpsum.filter.result');

    Route::resource('pump', App\Http\Controllers\Backend\Pump\PumpController::class)->names('pump');
    Route::get('pump-filter', [App\Http\Controllers\Backend\Pump\PumpController::class, 'filter'])->name('pump.filter');
    Route::get('pump-filter/show', [App\Http\Controllers\Backend\Pump\PumpController::class, 'showFilter'])->name('pump.showFilter');
    Route::get('load-filter', [App\Http\Controllers\Backend\Load\LoadEntryController::class, 'filter'])->name('load.filter');
    Route::get('load-filter/show', [App\Http\Controllers\Backend\Load\LoadEntryController::class, 'showFilter'])->name('load.showFilter');

    Route::group(['prefix' => 'cashbook'], function () {
        Route::resource('calculations', CalculationController::class)->names('calculations');
        Route::get('calculations/export/{calculation}', [CalculationController::class, 'export'])->name('export');
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::get('filter', [CalculationController::class, 'filter'])->name('calculations.filter');
        Route::get('filter-export', [App\Http\Controllers\Cashbook\CalculationController::class, 'filterExport'])->name('calculations.filterExport');

        // Category filter and date range filter for income/expense entries
        Route::get('categories-filter', [App\Http\Controllers\Cashbook\CategoryController::class, 'filter'])->name('categories.filter');
        Route::get('categories-filter-show', [App\Http\Controllers\Cashbook\CategoryController::class, 'filterShow'])->name('categories.filtershow');
        Route::get('categories-filter-export', [App\Http\Controllers\Cashbook\CategoryController::class, 'filterExport'])->name('categories.filterExport');
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

        Route::get('factory-summary', [App\Http\Controllers\Backend\Factory\FactoryController::class, 'filter'])->name('factorysum.filter');
        Route::get('factory-summary/result', [App\Http\Controllers\Backend\Factory\FactoryController::class, 'filterResult'])->name('factorysum.filter.result');

        Route::resource('invoice', App\Http\Controllers\Backend\Invoice\InvoiceController::class)->names('invoice');

        Route::get('invoice/export/{invoice}', App\Http\Controllers\Backend\Invoice\InvoiceController::class.'@export')->name('invoice.export');
    });

    Route::resource('vehicleincome', App\Http\Controllers\Backend\VehicleIncomeController::class)->names('vehicleIncome');
    Route::get('vehicleincome-filter', [App\Http\Controllers\Backend\VehicleIncomeController::class, 'filter'])->name('vehicleIncome.filter');
    Route::get('vehicleincome-filter/show', [App\Http\Controllers\Backend\VehicleIncomeController::class, 'showFilter'])->name('vehicleIncome.showFilter');
    Route::get('vehicleincome-filter/show/print', [App\Http\Controllers\Backend\VehicleIncomeController::class, 'showFilterPrint'])->name('vehicleIncome.showFilterPrint');

    Route::group(['prefix' => 'assets', 'as' => 'asset.'], function () {

        Route::resource('asset', App\Http\Controllers\Backend\Asset\AssetController::class)->names('asset');
        Route::resource('asset-document', App\Http\Controllers\Backend\Asset\AssetDocumentController::class)->names('assetdocument');
    });

    Route::group(['prefix' => 'vehicle', 'as' => 'vehicle.'], function () {
        // Vehicle related routes
        Route::resource('vehicle', App\Http\Controllers\Backend\Asset\VehicleController::class)->names('vehicle');
        Route::resource('vehicle-document', App\Http\Controllers\Backend\Asset\VehicleDocumentController::class)->names('vehicledocument');

        Route::resource('vehicle-maintenance', App\Http\Controllers\Backend\Asset\VehicleMaintenanceController::class)->names('vehiclemaintenance');
    });

    Route::resource('transport', App\Http\Controllers\Backend\Transport\TransportController::class)->names('transport');
    Route::get('transport/{transport}/export', [App\Http\Controllers\Backend\Transport\TransportController::class, 'export'])->name('transport.export');
    Route::get('transport-filter', [App\Http\Controllers\Backend\Transport\TransportController::class, 'filter'])->name('transport.filter');
    Route::get('transport-filter/show', [App\Http\Controllers\Backend\Transport\TransportController::class, 'showFilter'])->name('transport.showFilter');

    Route::get('transport-summary', [App\Http\Controllers\Backend\Transport\TransportController::class, 'summary'])->name('transport.summary');
    Route::get('transport-summary/show', [App\Http\Controllers\Backend\Transport\TransportController::class, 'showSummary'])->name('transport.showSummary');

    Route::resource('diesel', App\Http\Controllers\Backend\Diesel\DieselController::class)->names('diesel');
    Route::get('diesel-filter', [App\Http\Controllers\Backend\Diesel\DieselController::class, 'filter'])->name('diesel.filter');
    Route::get('diesel-summary', [App\Http\Controllers\Backend\Diesel\DieselController::class, 'summary'])->name('diesel.summary');

});

Route::get('factory/invoice/verify/{hash}', [App\Http\Controllers\Backend\Invoice\InvoiceController::class, 'verify'])->name('factory.invoice.verify');

Route::get('test', App\Http\Controllers\Test::class.'@index')->name('test.index');

Route::get('/migration', function () {
    $exitCode = Artisan::call('migrate --force');
    // return what you want
});

Route::get('/appkey', function () {
    $exitCode = Artisan::call('key:generate');
    // return what you want
});
