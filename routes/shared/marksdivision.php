<?php

use App\Http\Controllers\Shared\MarksDivisionController;

Route::resource('marks-divisions', MarksDivisionController::class);
Route::post('marks-divisions/get', [MarksDivisionController::class, 'getAllMarksDivision'])->name('marks-divisions.get');
