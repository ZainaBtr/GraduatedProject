<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NormalUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PublicReservationController;
use App\Http\Controllers\PrivateReservationController;
use App\Http\Controllers\FakeReservationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\JoiningRequestController;

Route::post('normalUser/completeAccount1',[NormalUserController::class,'completeAccount1'])->middleware(['check.role:normalUser']);

Route::middleware(['auth:api', 'check.role:normalUser||advancedUser'])->group(function() {

    Route::prefix("normalUser")->group( function () {
        Route::get('/showProfile', [NormalUserController::class, 'showProfile']);
        Route::put('/completeAccount2', [NormalUserController::class, 'completeAccount2']);
        Route::put('/completeAccount4', [NormalUserController::class, 'completeAccount4']);
    });

    Route::prefix("session")->group( function () {
        Route::get('/showActiveTheoretical',[SessionController::class,'showActiveTheoretical']);
        Route::get('/showActivePractical',[SessionController::class,'showActivePractical']);
    });

    Route::prefix("publicReservation")->group( function () {
        Route::get('/showMyActivities',[PublicReservationController::class,'showMyActivities']);
        Route::get('/showMyExams',[PublicReservationController::class,'showMyExams']);
        Route::post('/book/{publicSession}',[PublicReservationController::class,'book']);
        Route::delete('/cancel/{publicReservation}',[PublicReservationController::class,'cancel']);
    });

    Route::prefix("privateReservation")->group( function () {
        Route::get('/showMy',[PrivateReservationController::class,'showMy']);
        Route::get('/showMyExam',[PrivateReservationController::class,'showMyExams']);
        Route::get('/showAskedSwitch',[PrivateReservationController::class,'showAskedSwitch']);
        Route::get('/showSentSwitch',[PrivateReservationController::class,'showSentSwitch']);
        Route::post('/book/{id}',[PrivateReservationController::class,'book']);
        Route::delete('/delete/{privateReservation}',[PrivateReservationController::class,'delete']);
        Route::post('/switch/{receiverReservationID}',[PrivateReservationController::class,'switch']);
        Route::put('/acceptSwapRequest/{swapRequestID}',[PrivateReservationController::class,'accept']);
        Route::put('/declineSwapRequest/{swapRequestID}',[PrivateReservationController::class,'decline']);
        Route::delete('/cancelSwapRequest/{swapRequestID}',[PrivateReservationController::class,'cancelSwapReservation']);
    });

    Route::post('/storeFakeReservation',[FakeReservationController::class,'store']);

    Route::prefix("attendance")->group( function () {
        Route::post('/scanQr',[AttendanceController::class,'scanQr']);
        Route::get('/showMyAttendance/{service}',[AttendanceController::class,'showMyAttendanceOfOneService']);
    });

    Route::prefix("group")->group( function () {
        Route::post('/create',[GroupController::class,'create']);
        Route::get('/showALl',[GroupController::class,'showAll']);
        Route::get('/showMy',[GroupController::class,'showMy']);
    });

    Route::prefix("teamMember")->group( function () {
        Route::post('/add',[TeamMemberController::class,'add']);
        Route::get('/search',[TeamMemberController::class,'search']);
        Route::put('/updateSkills/{teamMember}',[TeamMemberController::class,'updateSkills']);
        Route::delete('/delete/{TeamMember}',[TeamMemberController::class,'delete']);
    });

    Route::prefix("joiningRequest")->group( function () {
        Route::get('/showAsked',[JoiningRequestController::class,'showAsked']);
        Route::get('/showSent',[JoiningRequestController::class,'showSent']);
        Route::get('/showMy',[JoiningRequestController::class,'showMy']);
        Route::post('/create/{group}',[JoiningRequestController::class,'create']);
        Route::post('/ask/{group}',[JoiningRequestController::class,'ask']);
        Route::delete('/cancel/{joiningRequest}',[JoiningRequestController::class,'cancel']);
        Route::delete('/accept/{joiningRequest}',[JoiningRequestController::class,'accept']);
        Route::delete('/decline/{joiningRequest}',[JoiningRequestController::class,'decline']);
    });


});

