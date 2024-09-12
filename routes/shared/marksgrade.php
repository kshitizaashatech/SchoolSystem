<?php

use App\Http\Controllers\Shared\MarksGradeController;

Route::resource('marks-grades', MarksGradeController::class);
Route::post('marks-grade/get', [MarksGradeController::class, 'getAllMarksGrade'])->name('marks-grades.get');
