<?php

use App\Http\Controllers\SchoolAdmin\StaffAttendanceController;


Route::resource('staff-attendance', StaffAttendanceController::class);
Route::get('/getStaffName', [StaffAttendanceController::class, 'getStaffName'])->name('get.staff.name');

Route::post('staff-attendances/save-attendance', [StaffAttendanceController::class, 'saveAttendance']);
Route::post('/admin/staff/mark-holiday-range', 'StaffAttendanceController@markHolidayRange')->name('staff.mark-holiday-range');


