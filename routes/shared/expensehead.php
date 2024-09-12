<?php

use App\Http\Controllers\Shared\ExpenseheadController;

Route::resource('expenses-head', ExpenseheadController::class);
Route::post('expenseshead/get', [ExpenseheadController::class, 'getAllExpenseshead'])->name('expenses-head.get');