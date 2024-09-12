<?php

use App\Http\Controllers\SchoolAdmin\ExpenseController;

Route::resource('expenses', ExpenseController::class);
Route::post('expenses/get', [ExpenseController::class, 'getAllexpenses'])->name('expenses.get');