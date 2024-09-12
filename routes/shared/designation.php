<?php

use App\Http\Controllers\Shared\DesignationController;

Route::resource('designations', DesignationController::class);
Route::post('designations/get', [DesignationController::class, 'getAllDesignation'])->name('designations.get');