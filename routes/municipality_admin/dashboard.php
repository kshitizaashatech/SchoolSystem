<?php

use App\Http\Controllers\MunicipalityAdmin\DashboardController;

Route::get('/municipality/dashboard', 'DashboardController@index')->name('municipality.dashboard');
Route::get('/dashboard/major-incidents', [DashboardController::class, 'fetchMajorIncidents']);
