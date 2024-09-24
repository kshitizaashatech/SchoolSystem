<?php
use App\Http\Controllers\Shared\NoticeController;

// Resource route for NoticeController


// Additional custom routes if needed

Route::resource('notices', NoticeController::class);
Route::post('notices/get', [NoticeController::class, 'getNotices'])->name('notices.get');


