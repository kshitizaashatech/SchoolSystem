<?php

use App\Http\Controllers\Shared\InclusiveQuotasController;

Route::resource('inclusive-quotas', InclusiveQuotasController::class);
Route::post('inclusive-quotas/get', [InclusiveQuotasController::class, 'getAllInclusivequotas'])->name('inclusive-quotas.get');

