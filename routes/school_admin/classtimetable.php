<?php

use App\Http\Controllers\SchoolAdmin\ClassTimetableController;

Route::resource('class-timetables', ClassTimetableController::class);
Route::post('class-timetables/get', [ClassTimetableController::class, 'getAllClassesTimeTable'])->name('class-timetables.get');