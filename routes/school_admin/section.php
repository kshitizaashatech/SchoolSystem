<?php

use App\Http\Controllers\SchoolAdmin\SectionController;

Route::resource('sections', SectionController::class);
Route::post('sections/get', [SectionController::class, 'getAllSections'])->name('sections.get');
