<?php

use App\Http\Controllers\Shared\ExtraCurricularHeadController;

Route::resource('extracurricular-head', ExtraCurricularHeadController::class);
Route::post('extracurricularhead/get', [ExtraCurricularHeadController::class, 'getAllExtraCurricularHead'])->name('extracurricular-head.get');