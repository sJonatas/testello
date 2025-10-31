<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ImportedFilesController;
use App\Http\Controllers\ShippingRatesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::prefix('/clients')->name('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('.index');
    Route::get('/rates/{id}', [ClientController::class, 'shippingRateList'])->name('.rates');
});

Route::prefix('/shipping-rate')->name('shipping-rate')->group(function () {
    Route::post('/import/{client_id}', [ShippingRatesController::class, 'import'])->name('.import');
});

Route::prefix('/imported-files')->name('imported-files')->group(function () {
    Route::get('/', [ImportedFilesController::class, 'index'])->name('.index');
});
