<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LaravelSanctumLearningController;
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
Route::post('/store/multi/image', [ValidationController::class, 'store_multi_image']);
Route::get('/create/delete-table-factory', [LaravelSanctumLearningController::class, 'createFactories']);

Route::group(["middleware" => 'auth:sanctum', 'prefix' => 'laravel-sanctum'], function () {
    Route::get('/route/success', [LaravelSanctumLearningController::class, 'returnSuccess']);
    Route::get('/route/error', [LaravelSanctumLearningController::class, 'returnError']);
});

Route::get('/route/get/resources-deleted-table', [LaravelSanctumLearningController::class, 'get_delete_models_resources']);

Route::get('/checker', [LaravelSanctumLearningController::class, 'laravel_collections']);
