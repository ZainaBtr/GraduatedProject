<?php

use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NormalUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PublicReservationController;
use App\Http\Controllers\PrivateReservationController;
use App\Http\Controllers\FakeReservationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\JoinRequestController;

Route::post('normalUser/completeAccount1',[NormalUserController::class,'completeAccount1'])->middleware(['check.role:normalUser']);

Route::middleware(['auth:api', 'check.role:normalUser'])->group(function() {

    Route::prefix("normalUser")->group( function () {
        Route::get('/showProfile', [NormalUserController::class, 'showProfile']);
        Route::put('/completeAccount2', [NormalUserController::class, 'completeAccount2']);
        Route::put('/completeAccount4', [NormalUserController::class, 'completeAccount4']);
    });

    Route::prefix("session")->group( function () {
        Route::get('/showActiveTheoretical',[SessionController::class,'showActiveTheoretical']);
        Route::get('/showActivePractical',[SessionController::class,'showActivePractical']);
        Route::get('/getSessionDetails/{sessionID}',[SessionController::class,'getSessionDetails']);
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
        Route::post('/create/{service}',[GroupController::class,'create']);
        Route::get('/showAll/{service}',[GroupController::class,'showAll']);
        Route::get('/showMy',[GroupController::class,'showMy']);
        Route::get('/searchNormalUser',[GroupController::class,'searchNormalUser']);
        Route::get('/getNormalUserDetails/{normalUser}',[GroupController::class,'getNormalUserDetails']);
    });

    Route::prefix("teamMember")->group( function () {
        Route::post('/add',[TeamMemberController::class,'add']);
        Route::get('/search',[TeamMemberController::class,'search']);
        Route::put('/updateSkills/{teamMember}',[TeamMemberController::class,'updateSkills']);
        Route::delete('/delete/{teamMember}',[TeamMemberController::class,'delete']);
    });

    Route::prefix("joinRequest")->group( function () {
        Route::get('/showSentJoinRequests',[JoinRequestController::class,'showSentJoinRequests']);
        Route::get('/showReceivedJoinRequests',[JoinRequestController::class,'showReceivedJoinRequests']);
        Route::post('/sendJoinRequest/{group}',[JoinRequestController::class,'sendJoinRequest']);
        Route::put('/acceptJoinRequest/{joinRequest}',[JoinRequestController::class,'acceptJoinRequest']);
        Route::put('/declineJoinRequest/{joinRequest}',[JoinRequestController::class,'declineJoinRequest']);
        Route::delete('/cancelJoinRequest/{joinRequest}',[JoinRequestController::class,'cancelJoinRequest']);
    });
     Route::prefix("invitation")->group( function () {
        Route::get('/showSentInvitations',[InvitationController::class,'showSentInvitations']);
        Route::get('/showReceivedInvitations',[InvitationController::class,'showReceivedInvitations']);
        Route::post('/sendInvitation/{service}/{normalUser}',[InvitationController::class,'sendInvitation']);
        Route::put('/acceptInvitation/{invitation}',[InvitationController::class,'acceptInvitation']);
        Route::put('/declineInvitation/{invitation}',[InvitationController::class,'declineInvitation']);
        Route::delete('/cancelInvitation/{invitation}',[InvitationController::class,'cancelInvitation']);
        });

});

