<?php

use App\Http\Controllers\Shared\AttendanceTypeController;

Route::resource('attendance-types', AttendanceTypeController::class);
Route::post('attendance-types/get', [AttendanceTypeController::class, 'getAllattendanceTypes'])->name('attendance-types.get');