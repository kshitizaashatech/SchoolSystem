<?php

use App\Http\Controllers\Shared\PermissionController;
use App\Http\Controllers\Shared\RoleController;

//  Permission
Route::resource('permissions', PermissionController::class);
Route::put('permissions/permission-update/{role}', [ RoleController::class, 'updatePermissions'] )->name('roles.permissions');

Route::post('permissions/get', 'PermissionController@getAllPermission')->name('permissions.get');

//  Roles
Route::resource('roles', RoleController::class);
Route::post('roles/get', 'RoleController@getAllRoles')->name('roles.get');
