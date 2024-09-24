<?php

// use App\Models\GenerateMarkSheet;

use App\Http\Controllers\SchoolAdmin\GenerateAdmitCardController;

Route::resource('generate-admitcards', GenerateAdmitCardController::class);

Route::get('generate-admitcards/get-sections/{classId}', [GenerateAdmitCardController::class, 'getSections'])->name('generate.admitcards.get-sections');


Route::get('generate-admitcards/download-admit-card/{studentId}/{admitCardId}/{examinationId}', [GenerateAdmitCardController::class, 'downloadAdmitCard'])->name('download.admit.card');

Route::get('generate-admitcards/admit-card-designprint/get', [GenerateAdmitCardController::class, 'printAdmitCard'])->name('admit-carddesignsprint.get');


Route::post('generate-admitcards/admit-card-design/get', [GenerateAdmitCardController::class, 'getAllAdmitCardDesign'])->name('admit-carddesigns.get');

Route::get('generate-admitcards/show-admitcard-design/{student_id}/{admit_card_id}/{examination_id}', [GenerateAdmitCardController::class, 'showAdmitCardDesign'])->name('showadmitcarddesign');

Route::post('generate-admitcards/student/get', [GenerateAdmitCardController::class, 'getAllStudents'])->name('generatestudentsadmitcards.get');

Route::post('generate-admitcards/bulk-download', [GenerateAdmitCardController::class, 'bulkDownloadAdmitCards'])->name('generate-admitcards.bulk-download');