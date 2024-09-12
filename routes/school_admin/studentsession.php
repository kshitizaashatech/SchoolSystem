<?php

use App\Http\Controllers\SchoolAdmin\StudentSessionController;

Route::resource('students-session', StudentSessionController::class);
Route::post('studentsession/get', [StudentSessionController::class, 'getAllStudentsession'])->name('studentsession.get');