<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group(['middleware' => 'auth:sanctum'], function ($router) {
    //auth
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/user', [AuthController::class, 'user']);
    Route::post('auth/changePassword', [AuthController::class, 'changePassword']);
    
    //mananger
    Route::apiResource('user', UserController::class);
    Route::get('user/permission/{id}/{guard_name}', [UserController::class, 'getPermission'])->name('user.view-permission');
    Route::put('user/permission/{id}', [UserController::class, 'putPermission'])->name('user.view-permission');
    Route::apiResource('role', RoleController::class);
    Route::get('role/permission/{id}/{guard_name}', [RoleController::class, 'getPermission'])->name('role.permission');
    Route::post('permission/update', [PermissionController::class, 'updatePermission'])->name('permission.load-router');
    Route::apiResource('permission', PermissionController::class);
});
