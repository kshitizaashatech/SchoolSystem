<?php

use App\Http\Controllers\SchoolAdmin\PrimaryExaminationController;
use App\Http\Controllers\SchoolAdmin\PrimaryExaminationRoutineController;
use App\Http\Controllers\SchoolAdmin\PrimaryLessonMarksController;
use App\Http\Controllers\SchoolAdmin\PrimaryExaminationStudentsController;


// Routes for primary lesson marks 
Route::resource('primary-lessonmarks', PrimaryLessonMarksController::class);
Route::post('primary-lessonmarks/get', [PrimaryLessonMarksController::class, 'getAllMarks'])->name('primary-lessonmarks.get');

// ROUTES FOR PRIMARY-EXAMINATIONS
Route::resource('primary-examinations', PrimaryExaminationController::class);
Route::post('primary-examinations/get', [PrimaryExaminationController::class, 'getAllPrimaryExaminations'])->name('primaryexaminations.get');

// ROUTES FOR PRIMARY-EXAMINATIONS-ROUTINE/SCHEDULE
Route::get('primaryexam-routines/{exam_id}/create', [PrimaryExaminationRoutineController::class, 'createPrimaryExamRoutine'])->name('primaryexam-routines.create');
Route::post('primaryexam-routines/storeexamroutine', [PrimaryExaminationRoutineController::class, 'storePrimaryExamRoutine'])->name('primaryexam-routines.storeexamroutine');
Route::post('primaryexaminationroutines/get/{id}', [PrimaryExaminationRoutineController::class, 'getAllRoutines'])->name('primaryexaminationroutines.get');
Route::get('primaryexam-routines/{routine_id}/edit', [PrimaryExaminationRoutineController::class, 'editPrimaryExamRoutine'])->name('primaryexam-routines.edit');
Route::put('primaryexam-routines/{routine_id}/update', [PrimaryExaminationRoutineController::class, 'updatePrimaryExamRoutine'])->name('primaryexam-routines.update');
Route::delete('primaryexam-routines/{routine_id}/destroy', [PrimaryExaminationRoutineController::class, 'destroyPrimaryExamRoutine'])->name('primaryexam-routines.destroy');


// ASSIGN PRIMARY STUDENTS TO PRIMARY EXAMINATION
Route::get('assign-primarystudents/{exam_id}/create', [PrimaryExaminationStudentsController::class, 'assignPrimaryStudents'])->name('assign-primarystudents.create');

Route::get('assign-primarystudents/by-class-section/{exam_id}/{classId}/{sectionId}', [PrimaryExaminationStudentsController::class, 'getExamAssignPrimaryStudents'])->name('getExamAssignPrimaryStudentsByClassSection');

Route::post('assign-primarystudents/save-assign-exam', [PrimaryExaminationStudentsController::class, 'saveAssignPrimaryStudentsToExam'])->name('assign-primarystudents.save');
