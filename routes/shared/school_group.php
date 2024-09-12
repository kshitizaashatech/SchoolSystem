<?php

use App\Http\Controllers\Shared\SchoolGroupController;

Route::resource('school-groups', SchoolGroupController::class);
Route::post('school-groups/get', [SchoolGroupController::class, 'getAllSchoolGroups'])->name('school-groups.get');
// Route::post('school-groups/assign-head-school', [SchoolGroupController::class, 'assignHeadSchool'])
//     ->name('school-groups.assignHeadSchool');

// Route::get('school-groups/{id}/schools', [SchoolGroupController::class, 'getSchoolsByGroup'])
//     ->name('school-groups.schools');
