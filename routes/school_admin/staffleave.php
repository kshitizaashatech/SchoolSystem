<?php

use App\Http\Controllers\SchoolAdmin\StaffLeaveController;

Route::resource('staff-leaverequests', StaffLeaveController::class);
Route::post('staff-leaverequests/get', [StaffLeaveController::class, 'getAllStaffLeave'])->name('staff-leaverequests.get');