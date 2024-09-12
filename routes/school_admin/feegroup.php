<?php

use App\Http\Controllers\SchoolAdmin\FeeGroupController;


Route::resource('fee-groups', FeeGroupController::class);
Route::post('fee-groups/get', [FeeGroupController::class, 'getAllFeeGroups'])->name('fee-groups.get');
