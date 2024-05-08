<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceManagerController;


Route::prefix ("systemManager")->group( function () {
Route::get('/showProfile',[ServiceManagerController::class,'showSystemManagerProfile'])->name('showSystemManagerProfile');
Route::post('/createServiceManagerAccount',[ServiceManagerController::class,'createAccount'])->name('createServiceManagerAccount');
Route::delete('/deleteServiceManagerAccount/{serviceManager}',[ServiceManagerController::class,'deleteAccount'])->name('deleteServiceManagerAccount');
});



