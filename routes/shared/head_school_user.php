<?php

use App\Http\Controllers\Shared\HeadSchoolUserController;

Route::resource('head-schoolusers', HeadSchoolUserController::class);
Route::post('head-schoolusers/get', [ HeadSchoolUserController::class, 'getAllHeadSchoolUsers'])->name('head-schoolusers.get');

Route::get('/head-schoolusers/get-school-details/{id}', [ HeadSchoolUserController::class, 'getSchoolDetails' ]);





