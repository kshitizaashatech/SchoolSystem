<?php
use App\Http\Controllers\SchoolAdmin\GenerateMarkSheetController;
use App\Http\Controllers\SchoolAdmin\MarksheetController;

Route::resource('generate-marksheets', GenerateMarkSheetController::class);

Route::get('generate-marksheets/examination-id/{examination_id}', [GenerateMarkSheetController::class, 'getAllMarksheets'])->name('generate.marksheets.create');

Route::get('generate-marksheets/get-sections/{classId}', [GenerateMarkSheetController::class, 'getSections'])->name('generate.marksheet.get-sections');

Route::post('generate-marksheets/student/get', [GenerateMarkSheetController::class, 'getAllStudent'])->name('generate-student-marksheet.get');

Route::get('generate-marksheets/download-marksheet/{student_id}/{class_id}/{section_id}/{marksheetdesign_id}/{examination_id}', [GenerateMarkSheetController::class, 'downloadStudentMarkSheet'])->name('downloadstudentmarksheet.get');
Route::get('generate-marksheets/show-marksheet-design/{student_id}/{class_id}/{section_id}/{marksheetdesign_id}/{examination_id}', [GenerateMarkSheetController::class, 'showMarkSheetDesign'])->name('show.marksheet.design');
Route::post('bulk-download-marksheets', [GenerateMarkSheetController::class, 'bulkDownloadMarksheets'])->name('bulk.download.marksheets');