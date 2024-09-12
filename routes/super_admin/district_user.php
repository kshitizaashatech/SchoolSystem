<?php

use App\Http\Controllers\SuperAdmin\DistrictUserController;

Route::resource('district-users', DistrictUserController::class);
Route::post('district-users/get', [DistrictUserController::class, 'getAllDistrictUsers'])->name('district-users.get');

Route::put('{user}/update-roles', [DistrictUserController::class, 'updateRoles'])->name('district-users.updateRoles');
Route::get('/get-district-by-state/{state_id}', [DistrictUserController::class, 'getDistrict'])->name('get-districts');