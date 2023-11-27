<?php

use App\Http\Controllers\AuthContoller;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/logout', [AuthContoller::class, 'logout']);
});

Route::post('/reset-password', [AuthContoller::class, 'resetPassword']);
Route::post('/login', [AuthContoller::class, 'login']);
Route::post('/register', [AuthContoller::class, 'register']);