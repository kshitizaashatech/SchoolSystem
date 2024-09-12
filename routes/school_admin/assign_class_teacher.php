<?php

use App\Http\Controllers\SchoolAdmin\AssignClassTeacherController;

Route::resource('assign-classteachers', AssignClassTeacherController::class);
Route::post('assign-classteachers/get', [AssignClassTeacherController::class, 'getAllAssignClassTeacher'])->name('assign-classteachers.get');