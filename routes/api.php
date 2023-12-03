<?php

use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthContoller;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [AuthContoller::class, 'user']);
    Route::get('/logout', [AuthContoller::class, 'logout']);
    Route::post('/reset-pass', [AuthContoller::class, 'resetPass']);
    Route::post('/user-update', [AuthContoller::class, 'userUpdate']);
    Route::post('/profile-upload', [AuthContoller::class, 'profileUpload']);
    Route::post('/delete-photo/{id}', [AuthContoller::class, 'deletePhoto']);
    Route::post('/select-photo/{id}', [AuthContoller::class, 'selectPhoto']);

    Route::get('/index', [UserController::class, 'index']);
    Route::post('/create', [UserController::class, 'store']);
    Route::post('/update/{id}', [UserController::class, 'update']);

    Route::get('/pages', [PageController::class, 'index']);
    Route::post('/create_page', [PageController::class, 'store']);
    Route::post('/update_page/{id}', [PageController::class, 'update']);

    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/create', [RoleController::class, 'store']);
    Route::put('/update_role/{id}', [RoleController::class, 'update']);

    Route::get('/permissions/{roleId}', [PermissionController::class, 'permissionId']);
    Route::post('/create_permission', [PermissionController::class, 'store']);
    Route::put('/update_permission/{id}', [PermissionController::class, 'update']);
});

Route::post('/reset-password', [AuthContoller::class, 'resetPassword']);
Route::post('/login', [AuthContoller::class, 'login']);
Route::post('/register', [AuthContoller::class, 'register']);
