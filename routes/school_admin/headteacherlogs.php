<?php

use App\Http\Controllers\SchoolAdmin\HeadTeacherLogController;

Route::resource('headteacher-logs', HeadTeacherLogController::class);
Route::post('headteacher-logs/get', [HeadTeacherLogController::class, 'getAllHeadTeacherLogs'])->name('headteacher-logs.get');
