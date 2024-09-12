<?php

use App\Http\Controllers\SchoolAdmin\HeadTeacherLogReportController;

Route::get('headteacherlog-reports', [HeadTeacherLogReportController::class, 'index'])->name('headteacherlog-reports.index');
// Route::get('headteacherlogreports_get', [HeadTeacherLogReportController::class, 'getAttendanceReport']);
Route::get('/headteacherlogreports_get', [HeadTeacherLogReportController::class, 'getAttendanceReport'])->name('headteacherlogreports_get');
Route::get('students/get', [HeadTeacherLogReportController::class, 'getTotalStudents'])->name('totalStudents.get');

