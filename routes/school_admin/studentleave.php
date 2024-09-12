<?php

use App\Http\Controllers\SchoolAdmin\StudentLeaveController;

Route::resource('student-leaverequests', StudentLeaveController::class);
Route::post('student-leaverequests/get', [StudentLeaveController::class, 'getAllStudentLeave'])->name('student-leaverequests.get');