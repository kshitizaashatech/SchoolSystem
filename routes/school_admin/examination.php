<?php

use App\Http\Controllers\SchoolAdmin\ExamResultController;
use App\Http\Controllers\SchoolAdmin\ExaminationController;
use App\Http\Controllers\SchoolAdmin\GenerateResultController;
use App\Http\Controllers\SchoolAdmin\ExaminationRoutineController;
use App\Http\Controllers\SchoolAdmin\ExaminationStudentsController;
use App\Http\Controllers\SchoolAdmin\ExaminationTeachersController;

Route::resource('examinations', ExaminationController::class);
Route::post('examinations/get', [ExaminationController::class, 'getAllExaminations'])->name('examinations.get');
Route::get('get-term-examination', [ExaminationController::class, 'getTermExam'])->name('get.ter-mexaminations');

Route::get('students/marksheet/get-sections/{classId}', [ExaminationController::class, 'getSections'])->name('student.marksheet.get-sections');
// Route::post('marksheets/get', [ExaminationController::class, 'getAllStudents'])->name('marksheets.get');
//generate mark sheet  pdf
// Route::get('generate-mark-sheet-pdf', [ExaminationController::class, 'generateMarkSheetPDF'])->name('generate.mark.sheet.pdf');

// Route::get('mark-sheetesign/show-marksheet-design/{student_id}/{class_id}/{section_id}/{marksheetdesign_id}', [ExaminationController::class, 'showMarkSheetDesign'])->name('showmarksheetdesign.get');

Route::get('mark-sheetesign/download-marksheet-design/{student_id}/{class_id}/{section_id}/{marksheetdesign_id}', [ExaminationController::class, 'downloadMarkSheet'])->name('downloadmarksheetdesign.get');


//Schedule or examination Routine
Route::get('exam-routines/{exam_id}/create', [ExaminationRoutineController::class, 'createExamRoutine'])->name('exam-routines.create');
Route::post('exam-routines/storeexamroutine', [ExaminationRoutineController::class, 'storeExamRoutine'])->name('exam-routines.storeexamroutine');
// Route::post('examinationroutines/get', [ExaminationRoutineController::class, 'getAllRoutines'])->name('examinationroutines.get');
Route::post('examinationroutines/get/{id}', [ExaminationRoutineController::class, 'getAllRoutines'])->name('examinationroutines.get');

Route::get('exam-routines/{routine_id}/edit', [ExaminationRoutineController::class, 'editExamRoutine'])->name('exam-routines.edit');
Route::put('exam-routines/{routine_id}/update', [ExaminationRoutineController::class, 'updateExamRoutine'])->name('exam-routines.update');
Route::delete('exam-routines/{routine_id}/destroy', [ExaminationRoutineController::class, 'destroyExamRoutine'])->name('exam-routines.destroy');


//Schedule or examination Routine
Route::get('assign-students/{exam_id}/create', [ExaminationStudentsController::class, 'assignStudents'])->name('assign-students.create');
Route::get('assign-students/by-class-section/{exam_id}/{classId}/{sectionId}', [ExaminationStudentsController::class, 'getExamAssignStudents'])->name('getExamAssignStudentsByClassSection');
Route::post('assign-students/save-assign-exam', [ExaminationStudentsController::class, 'saveAssignStudentsToExam'])->name('assign-students.save');
Route::get('assign-students/by-class-section/{class_id}/{section_id}', [ExaminationRoutineController::class, 'getStudentsByClassSection'])->name('assign-students.by-class-section');
Route::get('assign-students/form/{class_id}/{section_id}', [ExaminationStudentsController::class, 'showAssignStudentsForm'])->name('assign-students.form');



//Schedule or examination Routine for Teachers
Route::get('assign-teachers/{exam_id}/create', [ExaminationTeachersController::class, 'assignTeachers'])->name('assign-teachers.create');
Route::post('assign-teachers/save-assign-exam', [ExaminationTeachersController::class, 'storeAssignTeachers'])->name('assign-teachers.save');
Route::get('assign-teachers/get', [ExaminationTeachersController::class, 'getAllExaminationsTeachers'])->name('assign-teachers.get');
Route::delete('assign-teachers/delete/{id}', [ExaminationTeachersController::class, 'deleteAssignTeachers'])->name('assign-teachers');
Route::get('assign-teachers/{id}/edit', [ExaminationTeachersController::class, 'edit'])->name('assign-teachers.edit');
Route::put('assign-teachers/{id}', [ExaminationTeachersController::class, 'update'])->name('assign-teachers.update');

// FOR INSIDE EXAM_ROUTINE/SCHEDULES DATA-TABLE's ACTION
Route::get('assign-students/{exam_id}/routine/{routine_id}/create', [ExaminationRoutineController::class, 'assignStudentsForExamRoutine'])->name('assign-students.create.for-examroutine');
Route::get('exam-results/{exam_id}/routine/{routine_id}/create', [ExaminationRoutineController::class, 'assignStudentsForExamResult'])->name('exam-results.create.for-examroutine');


route::get('/admin/get-teachers', [ExaminationTeachersController::class, 'getTeachers'])->name('get.teachers');

//result generate
Route::get('generate-results/{exam_id}/create', [GenerateResultController::class, 'create'])->name('generate-results.create');
Route::get('generate-results/{exam_id}/export', [GenerateResultController::class, 'exportExamResults'])->name('generate-results.export');
Route::get('generate-results/', [GenerateResultController::class, 'index'])->name('generate-results.index');


Route::get('/examinations/create', [ExaminationController::class, 'create'])->middleware('initialize.session');