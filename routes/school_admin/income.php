<?php

use App\Http\Controllers\SchoolAdmin\IncomeController;

Route::resource('incomes', IncomeController::class);
Route::post('incomes/get', [IncomeController::class, 'getAllIncomes'])->name('incomes.get');