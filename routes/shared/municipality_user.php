<?php

use App\Http\Controllers\Shared\MunicipalityUserController;

Route::resource('municipality-users', MunicipalityUserController::class);
Route::post('municipality-users/get', [MunicipalityUserController::class, 'getAllMunicipalityUsers'])->name('municipality-users.get');

Route::put('{user}/update-roles', [MunicipalityUserController::class, 'updateRoles'])->name('municipality-users.updateRoles');
Route::get('/get-municipality-by-district/{district_id}', [MunicipalityUserController::class, 'getMunicipality'])->name('get-municipalities');