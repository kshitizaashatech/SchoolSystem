<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\InclusiveQuotasController;
use App\Http\Controllers\Auth\ChangePasswordController;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

// routes/web.php




Route::get('change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');
Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');



// Route::prefix('/admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
//     Route::get('/', [AdminController::class, 'index'])->name('index');

//     // Route::as('users.')->prefix('/users')->name('users.')->group(function () {
//     //     Route::get('/',             [ UserController::class, 'index'] )->name('index');
//     //     Route::get('create',        [ UserController::class, 'create'] )->name('create');
//     //     Route::post('store',        [ UserController::class, 'store'] )->name('store');
//     //     Route::get('edit/{id}',     [ UserController::class, 'edit'] )->name('edit');
//     //     Route::post('update',       [ UserController::class, 'update'] )->name('update');
//     //     Route::get('destroy/{id}',  [ UserController::class, 'destroy'] )->name('destroy');

//     //     Route::put('{user}/update-roles', [UserController::class, 'updateRoles'])->name('updateRoles');
//     // });

//     // Route::as('roles.')->prefix('/roles')->name('roles.')->group(function () {
//     //     Route::get('/',             [ RoleController::class, 'index'] )->name('index');
//     //     Route::get('create',        [ RoleController::class, 'create'] )->name('create');
//     //     Route::post('store',        [ RoleController::class, 'store'] )->name('store');
//     //     Route::get('edit/{id}',     [ RoleController::class, 'edit'] )->name('edit');
//     //     Route::post('update',       [ RoleController::class, 'update'] )->name('update');
//     //     Route::get('destroy/{id}',  [ RoleController::class, 'destroy'] )->name('destroy');

//     //     Route::put('permissions/{role}', [ RoleController::class, 'updatePermissions'] )->name('permissions');
//     // });

//     // Route::as('permissions.')->prefix('/permissions')->name('permissions.')->group(function () {
//     //     Route::get('/',             [ PermissionController::class, 'index'] )->name('index');
//     //     Route::get('create',        [ PermissionController::class, 'create'] )->name('create');
//     //     Route::post('store',        [ PermissionController::class, 'store'] )->name('store');
//     //     Route::get('edit/{id}',     [ PermissionController::class, 'edit'] )->name('edit');
//     //     Route::post('update',       [ PermissionController::class, 'update'] )->name('update');
//     //     Route::get('destroy/{id}',  [ PermissionController::class, 'destroy'] )->name('destroy');
//     // });

//     //For Inclusive Quotas.
//     // Route:: as('inclusivequotas.')->prefix('inclusivequotas')->group(function () {
//     //     Route::get('index', [InclusiveQuotasController::class, 'index'])->name('index');
//     //     Route::get('create', [InclusiveQuotasController::class, 'create'])->name('create');
//     //     Route::post('store', [InclusiveQuotasController::class, 'store'])->name('store');
//     //     Route::get('edit/{id}', [InclusiveQuotasController::class, 'edit'])->name('edit');
//     //     Route::post('update/{id}', [InclusiveQuotasController::class, 'update'])->name('update');
//     //     Route::delete('delete/{id}', [InclusiveQuotasController::class, 'destroy'])->name('delete');
//     // });



// });