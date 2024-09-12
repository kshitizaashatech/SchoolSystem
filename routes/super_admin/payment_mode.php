<?php

use App\Http\Controllers\SuperAdmin\PaymentModeController;


Route::resource('payment-mode', PaymentModeController::class);
Route::post('payment-mode/get', [PaymentModeController::class, 'getAllPaymentMode'])->name('payment-mode.get');
