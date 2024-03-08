<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('users', [UserController::class, 'store']);

Route::middleware('auth:api')->group(function () {

    // Books
    Route::apiResource('books', BookController::class)->only(['index', 'show', 'destroy', 'store']);
    Route::post('books/{book}', [BookController::class, 'update']);

    // Permissions
    Route::apiResource('permissions', PermissionController::class)->only(['index', 'show', 'destroy', 'store']);
    Route::post('permissions/{permission}', [PermissionController::class, 'update']);

    // Reservations
    Route::apiResource('reservations', ReservationController::class)->only(['index', 'show', 'destroy', 'store']);
    Route::post('reservations/{reservation}', [ReservationController::class, 'update']);

    // Roles
    Route::apiResource('roles', RoleController::class)->only(['index', 'show', 'destroy', 'store']);
    // Custom route for updating roles using POST
    Route::post('roles/{role}', [RoleController::class, 'update']);

    // Users
    Route::apiResource('users', UserController::class)->only(['index', 'show', 'destroy']);
    Route::post('users/{user}', [UserController::class, 'update']);
});
