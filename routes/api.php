<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;

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


Route::post('/register', [UserApiController::class, 'register']);
Route::post('/login',  [UserApiController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/get-user-data', [UserApiController::class, 'getUserData']);
    Route::get('/get-user-details/{id}', [UserApiController::class, 'getUserSingleData']);
    Route::post('/save-user', [UserApiController::class, 'saveUserData']);
    Route::delete('/delet-user/{id}', [UserApiController::class, 'deleteUserData']);
    Route::post('/user-bulk-delete', [UserApiController::class, 'deleteBulkUserData']);
});