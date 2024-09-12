<?php


use App\Http\Controllers\SchoolAdmin\MarkSheetDesignController;

Route::resource('mark-sheetdesigns', MarkSheetDesignController::class);
Route::post('mark-sheetdesigns/get', [MarkSheetDesignController::class, 'getAllMarkSheetDesign'])->name('mark-sheetdesigns.get');
