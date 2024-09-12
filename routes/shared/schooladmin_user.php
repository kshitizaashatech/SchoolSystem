<?php

use App\Http\Controllers\Shared\SchoolAdminUserController;

Route::resource('school-adminusers', SchoolAdminUserController::class);
Route::post('school-adminusers/get', [SchoolAdminUserController::class, 'getAllSchoolAdminUsers'])->name('school-adminusers.get');

Route::put('{user}/update-roles', [SchoolAdminUserController::class, 'updateRoles'])->name('school-adminusers.updateRoles');
Route::get('/get-schooladmin-by-school/{school_id}', [SchoolAdminUserController::class, 'getSchooladmin'])->name('get-adminusers');