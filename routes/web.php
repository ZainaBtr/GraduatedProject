<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceManagerController;
use App\Http\Controllers\AdvancedUserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login',[\App\Http\Controllers\AuthController::class,'login'])->name('login');
Route::post('/forgetPassword',[\App\Http\Controllers\AuthController::class,'forgetPassword'])->name('forgetPassword');

Route::middleware(['auth'])->group(function() {
    Route::put('/changePassword',[AuthController::class,'changePassword'])->name('changePassword');
    Route::delete('/verification',[AuthController::class,'verification'])->name('verification');
});






