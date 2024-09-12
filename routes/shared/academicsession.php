<?php

use App\Http\Controllers\Shared\AcademicSessionController;

Route::resource('academic-sessions', AcademicSessionController::class);
Route::post('academic-sessions/get', [AcademicSessionController::class, 'getAllAcademicsession'])->name('academic-sessions.get');