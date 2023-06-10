<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ValidationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/check/token', [AuthController::class, 'check_token']);
    Route::get('/logout', [AuthController::class, 'log_out']);
    Route::post('/send/message', [ChatController::class, 'sendMessageController']);
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/validation', [ValidationController::class, 'validation']);

Route::get('/temp/image', [ValidationController::class, 'temp_image']);
