<?php

use App\Http\Controllers\SchoolAdmin\TeacherLogController;

Route::resource('teacher-logs', TeacherLogController::class);
Route::post('teacher-logs/get', [TeacherLogController::class, 'getAllTeacherLogs'])->name('teacher-logs.get');