<?php

use App\Http\Controllers\SchoolAdmin\TopicController;

Route::resource('topics', TopicController::class);
Route::post('topics/get', [TopicController::class, 'getAllTopics'])->name('topics.get');