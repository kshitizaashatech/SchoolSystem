<?php

use App\Http\Controllers\Shared\LeaveTypeController;

Route::resource('leave-types', LeaveTypeController::class);
Route::post('leave-types/get', [LeaveTypeController::class, 'getAllLeaveTypes'])->name('leave-types.get');
