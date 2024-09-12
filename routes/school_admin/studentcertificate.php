<?php

use App\Http\Controllers\SchoolAdmin\StudentCertificateController;

Route::resource('student-certificates', StudentCertificateController::class);
// Route::post('student-attendances/get', [StudentCertificateController::class, 'getAllStudentAttendance'])->name('student-attendances.get');