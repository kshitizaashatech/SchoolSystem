<?php

use App\Http\Controllers\Shared\UtilityFunctionController;

//state->district->municipality->wadas
Route::get('/get-district-by-state/{state_id}', [UtilityFunctionController::class, 'getDistrict'])->name('get-districts');
Route::get('/get-municipality-by-district/{district_id}', [UtilityFunctionController::class, 'getMunicipality'])->name('get-municipalities');
Route::get('/get-ward-by-municipality/{municipality_id}', [UtilityFunctionController::class, 'getWard'])->name('get-wards');

//class->section

Route::get('/get-section-by-class/{class_id}', [UtilityFunctionController::class, 'getSection'])->name('get-sections');

// SECTION ==> STUDENTS
Route::get('/get-students-by-section/{classId}/{sectionId}/{date}', [UtilityFunctionController::class, 'getStudentsBySection'])->name('getstudentsBySection');
Route::get('/get-students-by-class-section/{classId}/{sectionId}', [UtilityFunctionController::class, 'getStudentsByClassSection'])->name('getstudentsByClassSection');
// Route::get('get-attendance-by-date/{classId}/{sectionId}/{date}', [UtilityFunctionController::class, 'getAttendanceByDate']);


//subjectgroup->subject->topic->lesson
Route::get('get-subject-group-by-class-and-section', [UtilityFunctionController::class, 'getSubjectGroupByClassAndSection'])->name('get.subjectgroups');
Route::get('get-subjects-by-subject-group/{subject_group_id}', [UtilityFunctionController::class, 'getSubjects'])->name('get.subjects');
Route::get('get-lessons-by-class-section-subjectgroup-and-subject', [UtilityFunctionController::class, 'getLessonsGroupByClassSectionSubjectgroupAndSubject'])->name('get.lessongroups');
Route::get('get-lessons-by-class-section-subjectgroup-and-subjectprimary', [UtilityFunctionController::class, 'getLessonsGroupByClassSectionSubjectgroupAndSubjectPrimary'])->name('get.lessongroupsprimary');
Route::get('/get-lesson-by-subject/{subject_id}', [UtilityFunctionController::class, 'getLesson'])->name('get-lesson');
Route::get('/get-topics--by-class-section-subjectgroup-subject-and-lessons', [UtilityFunctionController::class, 'getTopicsByClassSectionSubjectgroupSubjectAndLesson'])->name('get-topic');

Route::get('get-subjects-by-subject-group', [UtilityFunctionController::class, 'getSubjectsBySubjectGroup'])->name('get.subjects.by.subject_group'); // for Exam Routine