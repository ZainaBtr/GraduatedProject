<?php

use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvancedUserController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PublicSessionController;
use App\Http\Controllers\PrivateSessionController;
use App\Http\Controllers\PublicReservationController;
use App\Http\Controllers\PrivateReservationController;
use App\Http\Controllers\AttendanceController;

Route::middleware(['auth:api'])->group(function() {

    Route::prefix("advancedUser")->group( function () {
        Route::get('/showProfile',[AdvancedUserController::class,'showProfile']);
    });

    Route::prefix("service")->group(function () {
        Route::get('/showMyFromAdvancedUser', [ServiceController::class, 'showMyFromAdvancedUser']);
        Route::get('/searchForAdvancedUser', [ServiceController::class, 'searchForAdvancedUser']);
    });

    Route::prefix("announcement")->group(function () {
        Route::get('/showMy', [AnnouncementController::class, 'showMy'])->name('showMyAnnouncements');
        Route::post('/add', [AnnouncementController::class, 'add'])->name('addAnnouncement');
        Route::post('/addFromService/{service}', [AnnouncementController::class, 'addFromService']);
        Route::put('/update/{announcement}', [AnnouncementController::class, 'update']);
    });

    Route::prefix("session")->group( function () {
        Route::get('/showMy/{service}',[SessionController::class,'showMy']);
        Route::post('/create/{service}',[SessionController::class,'create']);
        Route::put('/start/{session}',[SessionController::class,'start']);
        Route::put('/close/{session}',[SessionController::class,'close']);
        Route::delete('/cancel/{session}',[SessionController::class,'cancel']);
        Route::put('/update/{session}',[SessionController::class,'update']);
    });

    Route::prefix("publicSession")->group( function () {
        Route::get('/showMyActivity',[PublicSessionController::class,'showMyActivities']);
        Route::get('/showMyExams',[PublicSessionController::class,'showMyExams']);
        Route::post('/create/{session}',[PublicSessionController::class,'create']);
        Route::put('/update/{publicSession}',[PublicSessionController::class,'update']);
    });

    Route::prefix("privateSession")->group( function () {
        Route::get('/showMyProjectInterviews',[PrivateSessionController::class,'showMyProjectsInterviews']);
        Route::get('/showMyAdvancedUserInterviews',[PrivateSessionController::class,'showMyAdvancedUsersInterviews']);
        Route::post('/create/{session}',[PrivateSessionController::class,'create']);
        Route::put('/update/{privateSession}',[PrivateSessionController::class,'update']);
    });

    Route::get('/showAll/{publicSession}',[PublicReservationController::class,'showALl']);

    Route::prefix("privateReservation")->group( function () {
        Route::get('/showAttendance/{privateSession}',[PrivateReservationController::class,'showAttendance']);
        Route::put('/delay/{privateReservation}',[PrivateReservationController::class,'delay']);
    });

    Route::prefix("attendance")->group( function () {
        Route::get('/showSessionQr/{session}',[AttendanceController::class,'showSessionQr']);
        Route::get('/showAttendanceOfOneSession/{session}',[AttendanceController::class,'showOfOneSession']);
        Route::get('/showAttendanceOfOneService/{service}',[AttendanceController::class,'showOfOneService']);
    });

});
