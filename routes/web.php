<?php

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
Route::post('/login',[\App\Http\Controllers\AuthController::class,'login'])->name('login');;


Route::middleware(['auth'])->group(function() {
    Route::put('/changePassword',[\App\Http\Controllers\AuthController::class,'changePassword']);
    

});Route::post('/forgetPassword',[\App\Http\Controllers\AuthController::class,'forgetPassword'])->name('forgetPassword');






