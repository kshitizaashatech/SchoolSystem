<?php

use App\Http\Controllers\SchoolAdmin\ExamStudentController;

Route::resource('exam-students', ExamStudentController::class);
Route::post('exam-students/get', [ExamStudentController::class, 'getAllExamStudent'])->name('exam-students.get');
