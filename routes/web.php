<?php

use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('user-data', [UserController::class, 'getUserData'])->name('user-data');
    Route::get('user-detail/{id?}', [UserController::class, 'getUserSingleData'])->name('user-detail');
    Route::post('save-user', [UserController::class, 'saveUserData'])->name('save-user');;
    Route::get('delete-user/{id}', [UserController::class, 'deleteUserData'])->name('delete-user');
    Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
});

require __DIR__ . '/auth.php';
