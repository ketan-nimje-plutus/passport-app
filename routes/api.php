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

    Route::get('/user', function (Request $request) {
        return response()->json(['status' => true, 'user' => $request->user()]);
    });
    Route::get('/get-user-data', [UserApiController::class, 'getUserData']);
    Route::get('/get-user-details', [UserApiController::class, 'getUserSingleData']);
    Route::post('/save-user', [UserApiController::class, 'saveUserData']);
    Route::post('/delet-user', [UserApiController::class, 'deleteUserData']);
    
});
