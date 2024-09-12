<?php

use App\Http\Controllers\SchoolAdmin\SchoolAttendanceReportController;

Route::get('/attendance-reports', [SchoolAttendanceReportController::class, 'index'])->name('attendance_reports.index');
Route::get('/attendance-reports/schoolreport', [SchoolAttendanceReportController::class, 'report'])->name('attendance_reports.schoolreport');
Route::get('admin/attendance-reports/schooldata', [SchoolAttendanceReportController::class, 'getData'])->name('attendance_schoolreports.data');
Route::get('section}', [SchoolAttendanceReportController::class, 'getSections'])->name('student.get-schoolsections');





