<?php

use App\Http\Controllers\Shared\FeeTypeController;

Route::resource('fee-types', FeeTypeController::class);
Route::post('fee-types/get', [FeeTypeController::class, 'getAllFeeTypes'])->name('fee-types.get');