<?php

use App\Http\Controllers\Shared\SchoolWiseReportController;

Route::post('school-wise-reports', [SchoolWiseReportController::class, 'getSchoolWiseReportCollection'])->name('school-wise-reports');