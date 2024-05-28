<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\ServiceYearAndSpecializationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SavedAnnouncementController;
use App\Http\Controllers\InterestedServiceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PublicSessionController;
use App\Http\Controllers\PrivateSessionController;
use App\Http\Controllers\PrivateReservationController;
use App\Http\Controllers\FakeReservationController;

require  __DIR__ . '/ite_apis/advanced_user_app.php';
require  __DIR__ . '/ite_apis/normal_user_app.php';
require  __DIR__ . '/ite_apis/service_manager_app.php';
require  __DIR__ . '/ite_apis/system_manager_app.php';

Route::post('/register',[AuthController::class,'register']);

Route::post('/advancedUserRegister',[AuthController::class,'advancedUserRegister']);

Route::post('/login',[AuthController::class,'login']);

Route::post('/forgetPassword',[AuthController::class,'forgetPassword']);

Route::delete('/verification',[AuthController::class,'verification']);

Route::post('/setEmail',[AuthController::class,'setEmail']);

Route::middleware(['auth:api'])->group(function() {

    Route::put('/changePassword',[AuthController::class,'changePassword']);

    Route::put('/updateEmail',[AuthController::class,'updateEmail']);

    Route::put('/setNewPassword',[AuthController::class,'setNewPassword']);

    Route::delete('/verification',[AuthController::class,'verification']);

    Route::get('/serviceYearAndSpecialization/showAll', [ServiceYearAndSpecializationController::class, 'showAll']);

    Route::prefix("service")->group(function () {
        Route::get('/showByYearAndSpecialization/{serviceYearAndSpecialization}', [ServiceController::class, 'showByYearAndSpecialization']);
        Route::get('/showByType/{type}', [ServiceController::class, 'showByType']);
        Route::get('/showAdvancedUsersOfService/{service}', [ServiceController::class, 'showAdvancedUsersOfService']);
    });

    Route::prefix("interestedService")->group(function () {
        Route::get('/showAll', [InterestedServiceController::class, 'showAll']);
        Route::post('/interestInService/{service}', [InterestedServiceController::class, 'interestIn']);
        Route::delete('/unInterestInService/{interestedService}', [InterestedServiceController::class, 'unInterestIn']);
    });

    Route::prefix("announcement")->group(function () {
        Route::get('/showAll', [AnnouncementController::class, 'showAll']);
        Route::get('/showAllFromService/{service}', [AnnouncementController::class, 'showAllFromService']);
        Route::get('/filterByType', [AnnouncementController::class, 'filterByType']);
    });

    Route::prefix("savedAnnouncement")->group(function () {
        Route::get('/showAll', [SavedAnnouncementController::class, 'showAll']);
        Route::post('/save/{announcement}', [SavedAnnouncementController::class, 'save']);
        Route::delete('/unSave/{savedAnnouncement}', [SavedAnnouncementController::class, 'unSave']);
    });

    Route::post('/file/download/{file}', [FileController::class, 'download'])->name('downloadFile');

    Route::prefix("session")->group(function () {
        Route::get('/showAll/{service}', [SessionController::class, 'showAll']);
        Route::get('/showALlRelated/{advancedUser}', [SessionController::class, 'showAllRelatedToAdvancedUser']);
        Route::get('/search', [SessionController::class, 'search']);
    });

    Route::prefix("publicSession")->group(function () {
        Route::get('/showActivities', [PublicSessionController::class, 'showActivities']);
        Route::get('/showExams', [PublicSessionController::class, 'showExams']);
    });

    Route::prefix("privateSession")->group(function () {
        Route::get('/showProjectInterviews', [PrivateSessionController::class, 'showProjectsInterviews']);
        Route::get('/showAdvancedUsersInterviews', [PrivateSessionController::class, 'showAdvancedUsersInterviews']);
    });

    Route::get('/showAll', [PrivateReservationController::class, 'showAll']);

    Route::get('/showFakeReservation', [FakeReservationController::class, 'showALl']);

});
