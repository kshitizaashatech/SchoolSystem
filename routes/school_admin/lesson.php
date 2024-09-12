<?php

use App\Http\Controllers\SchoolAdmin\LessonController;

Route::resource('lessons', LessonController::class);
Route::post('lessons/get', [LessonController::class, 'getAllLessons'])->name('lessons.get');