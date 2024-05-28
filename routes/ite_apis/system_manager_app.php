<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceManagerController;

Route::middleware(['auth:api'])->group(function() {

    Route::prefix ("systemManager")->group( function () {
        Route::get('/showProfile',[ServiceManagerController::class,'showSystemManagerProfile'])->name('showSystemManagerProfile');
        Route::post('/createServiceManagerAccount',[ServiceManagerController::class,'createAccount'])->name('createServiceManagerAccount');
        Route::get('/showAll',[ServiceManagerController::class,'showAll'])->name('showAllServicesManagers');
    });

});
