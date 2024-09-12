<?php

use App\Http\Controllers\Shared\DepartmentController;

Route::resource('departments', DepartmentController::class);
Route::post('departments/get', [DepartmentController::class, 'getAllDepartment'])->name('departments.get');