<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelFileController;

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

Route::post('/login',[App\Http\Controllers\AuthController::class,'login'])->name('login');
Route::post('/changePassword',[\App\Http\Controllers\AuthController::class,'changePassword'])->name('changePassword');
Route::post('/forgetPassword',[\App\Http\Controllers\AuthController::class,'forgetPassword'])->name('forgetPassword');

Route::namespace ("excelFile")->group( function () {
    Route::post('/advancedUserImport', [ExcelFileController::class, 'advancedUserImport'])->name('addAdvancedUserFile');
    Route::post('/normalUserImport', [ExcelFileController::class, 'normalUserImport'])->name('addNormalUserFile');
});







