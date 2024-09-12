<?php
use App\Http\Controllers\MunicipalityAdmin\InventoryReportController;

    Route::get('inventory-report', [InventoryReportController::class, 'index'])->name('municipalityAdmin.inventoryReport.index');
    Route::get('/inventory-reports/report', [InventoryReportController::class, 'report'])->name('municipalityAdmin.inventoryReport.report');
    Route::get('inventory-report/data', [InventoryReportController::class, 'getData'])->name('municipalityAdmin.inventoryReport.getData');
    Route::get('inventory-report/view/{id}', [InventoryReportController::class, 'view'])->name('municipalityAdmin.inventoryReport.view');




