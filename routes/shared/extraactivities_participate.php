<?php
use App\Http\Controllers\Shared\EcaParticipationController;

Route::get('eca-participations', [EcaParticipationController::class, 'index'])->name('eca_participations.index');
Route::get('eca-participations/get', [EcaParticipationController::class, 'getEcaParticipations'])->name('eca_participations.get');
