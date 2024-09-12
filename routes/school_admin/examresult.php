<?php

use App\Http\Controllers\SchoolAdmin\ExamResultController;

Route::resource('exam-results', ExamResultController::class);
Route::get('exam-results/show/{studentId}', [ExamResultController::class, 'show'])->name('exam-results.show');
Route::post('exams-results/get', [ExamResultController::class, 'getAllExamResult'])->name('exam-results.get');

//Schedule or examination Routine
Route::get('exam-results/{exam_id}/create', [ExamResultController::class, 'assignStudents'])->name('exam-results.assignmarks');
Route::get('exam-results/get-routine-wise-subject/class-section-and-examination', [ExamResultController::class, 'getRoutineDetails'])->name('exam-routines.details');
Route::post('exam-results/get-students-by-class-section-subject-and-examination', [ExamResultController::class, 'getStudentsDetails'])->name('exam-students.details');
Route::get('exam-results/by-class-section/{exam_id}/{classId}/{sectionId}', [ExamResultController::class, 'getExamAssignStudents'])->name('getExamAssignStudentsByClassSection');
Route::post('exam-results/save-students-marks', [ExamResultController::class, 'saveStudentsMarks'])->name('students-mark.save');
Route::post('exam-results/import', [ExamResultController::class, 'import'])->name('exam-results.bulkimport');
Route::post('/school/exam-results/save-students-marks', [ExamResultController::class, 'saveStudentMarks'])->name('school.exam-results.save-students-marks');
Route::get('exam-results/export-sample', [ExamResultController::class, 'exportAll'])->name('exam-results.export-sample');