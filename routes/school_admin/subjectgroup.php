<?php

use App\Http\Controllers\SchoolAdmin\SubjectGroupController;

Route::resource('subject-groups', SubjectGroupController::class);
Route::post('subject-groups/get', [SubjectGroupController::class, 'getAllSubjectsGroup'])->name('subject-groups.get');