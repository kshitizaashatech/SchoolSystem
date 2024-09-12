<?php
use App\Http\Controllers\Shared\StaffController;

Route::resource('staffs', StaffController::class);
Route::post('staffs/get', [StaffController::class, 'getAllStaff'])->name('staffs.get');

Route::get('/get-district-by-state/{state_id}', [StaffController::class, 'getDistrict'])->name('get-districts');

Route::get('staffs-import/index', [StaffController::class, 'importStaffs'])->name('staffs_import.import');
Route::post('staffs-import/import', [StaffController::class, 'import'])->name('staffs_import.bulkimport');

Route::get('admin/staffs/leavedetails', [StaffController::class, 'addLeaveDetails'])->name('staffs.leavedetails');
Route::post('admin/staffs/leavedetails/store', [StaffController::class, 'storeLeaveDetails'])->name('staffs.leavedetails.store');

Route::get('admin/staffs/resignationdetails', [StaffController::class, 'addResignationDetails'])->name('staffs.resignationdetails');
Route::post('admin/staffs/resignationdetails/store', [StaffController::class, 'storeResignationDetails'])->name('staffs.resignationdetails.store');