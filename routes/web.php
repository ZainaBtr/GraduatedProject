<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceManagerController;
use App\Http\Controllers\AdvancedUserController;

Route::post('/login',[AuthController::class,'login'])->name('login');

Route::post('/forgetPassword',[AuthController::class,'forgetPassword'])->name('forgetPassword');

Route::delete('/verification',[AuthController::class,'verification'])->name('verification');

Route::post('/setEmail',[AuthController::class,'setEmail'])->name('setEmail');

Route::middleware(['auth'])->group(function() {

    Route::put('/changePassword',[AuthController::class,'changePassword'])->name('changePassword');

    Route::put('/setNewPassword',[AuthController::class,'setNewPassword'])->name('setNewPassword');

    Route::put('/updateEmail',[AuthController::class,'updateEmail'])->name('updateEmail');

    Route::delete('/deleteAccount/{user}',[AuthController::class,'deleteAccount'])->name('deleteAccount');

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
