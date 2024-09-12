<?php

use App\Http\Controllers\SchoolAdmin\ClassController;

Route::resource('classes', ClassController::class);
Route::post('classes/get', [ClassController::class, 'getAllClasses'])->name('classes.get');