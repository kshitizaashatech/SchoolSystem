<?php

use App\Http\Controllers\Shared\EcaActivityController;


Route::resource('eca_activities', EcaActivityController::class);
Route::post('eca_activities/get', [EcaActivityController::class, 'getEcaActivities'])->name('eca_activities.get');