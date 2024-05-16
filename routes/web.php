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
Route::post('/login',[AuthController::class,'login'])->name('login');

Route::post('/forgetPassword',[AuthController::class,'forgetPassword'])->name('forgetPassword');

Route::delete('/verification',[AuthController::class,'verification'])->name('verification');

Route::post('/setEmail',[AuthController::class,'setEmail'])->name('setEmail');


Route::middleware(['auth'])->group(function() {

    Route::put('/changePassword',[AuthController::class,'changePassword'])->name('changePassword');

    Route::put('/setNewPassword',[AuthController::class,'setNewPassword'])->name('setNewPassword');

    Route::put('/updateEmail',[AuthController::class,'updateEmail'])->name('updateEmail');

});

Route::get('/', function () {
    return view('pages.FirstPageForServiceManager');
});

Route::get('/n', function () {
    return view('page.FirstPageForSystemManager');
});
Route::get('/m', function () {
    return view('Common.ChangePasswordPageForChangePassword');
});

Route::get('/d', function () {
    return view('Common.LoginPage');
});
