<?php

use App\Http\Controllers\MunicipalityAdmin\AttendenceReportController;

Route::get('/attendance-reports', [AttendenceReportController::class, 'index'])->name('attendance_reports.index');
Route::get('/attendance-reports/report', [AttendenceReportController::class, 'report'])->name('attendance_reports.report');
Route::get('admin/attendance-reports/data', [AttendenceReportController::class, 'getData'])->name('attendance_reports.data');


