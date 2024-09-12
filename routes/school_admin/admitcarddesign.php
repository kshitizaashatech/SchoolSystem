<?php

use App\Http\Controllers\SchoolAdmin\AdmitCardDesignController;


Route::resource('admit-carddesigns', AdmitCardDesignController::class);
Route::post('admit-card-design/get', [AdmitCardDesignController::class, 'getAllAdmitCardDesign'])->name('admit-carddesigns.get');

// Route::get('admit-card-designprint/get', [AdmitCardDesignController::class, 'printAdmitCard'])->name('admit-carddesignsprint.get');
Route::get('admitcard/get-sections/{classId}', [AdmitCardDesignController::class, 'getSections'])->name('admitcard.get-sections');

// Route::get('admit-carddesign/show-admitcard-design/{student_id}/{admit_card_id}/{examination_id}', [AdmitCardDesignController::class, 'showAdmitCardDesign'])->name('showadmitcarddesign');

// Route::get('/download-admit-card/{studentId}/{admitCardId}/{examinationId}', [AdmitCardDesignController::class, 'downloadAdmitCard'])->name('download.admit.card');



// Route::get('/admin/admit-carddesigns/getStudentDetail', [AdmitCardDesignController::class, 'getStudentDetail'])->name('admit-carddesigns.getStudentDetail');