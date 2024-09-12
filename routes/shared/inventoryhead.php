<?php

use App\Http\Controllers\Shared\InventoryHeadController;

Route::resource('inventory-head', InventoryHeadController::class);
Route::post('inventoryhead/get', [InventoryHeadController::class, 'getAllInventoryhead'])->name('inventory-head.get');