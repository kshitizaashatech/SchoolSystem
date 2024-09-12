<?php

use App\Http\Controllers\Shared\IncomeHeadController;

Route::resource('income-head', IncomeHeadController::class);
Route::post('incomehead/get', [IncomeHeadController::class, 'getAllIncomehead'])->name('income-head.get');