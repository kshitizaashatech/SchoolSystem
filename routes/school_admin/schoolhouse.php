<?php

use App\Http\Controllers\SchoolAdmin\SchoolHouseController;

Route::resource('school-houses', SchoolHouseController::class);
Route::post('school-houses/get', [SchoolHouseController::class, 'getAllHouses'])->name('school-houses.get');