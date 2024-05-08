<?php

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
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

require  __DIR__ . '/ite_apis/advanced_user_app.php';
require  __DIR__ . '/ite_apis/normal_user_app.php';
require  __DIR__ . '/ite_apis/service_manager_app.php';
require  __DIR__ . '/ite_apis/system_manager_app.php';

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthController::class,'login']);
Route::post('/sendEmail',[AuthController::class,'sendEmail']);

Route::middleware(['auth:api'])->group(function() {
    Route::put('/changePassword',[AuthController::class,'changePassword']);
});

Route::post('/forgetPassword',[AuthController::class,'forgetPassword']);


Route::get('register', [ServiceController::class, 'register']);
Route::get('advancedUserRegister', [ServiceController::class, 'advancedUserRegister']);

Route::middleware(['auth:api'])->group(function() {

    Route::prefix("announcement")->group(function () {
        Route::get('/showAll', [AnnouncementController::class, 'showAll']);
        Route::get('/showAllFromService/{service}', [AnnouncementController::class, 'showAllFromService']);
        Route::get('/showServiceNameForFilter', [AnnouncementController::class, 'showServiceNameForFilter']);
        Route::get('/showServiceYearForFilter', [AnnouncementController::class, 'showServiceYearForFilter']);
        Route::get('/showServiceTypeForFilter', [AnnouncementController::class, 'showServiceTypeForFilter']);
        Route::get('/showServiceSpecForFilter', [AnnouncementController::class, 'showServiceSpecializationForFilter']);
        Route::get('/filterByServiceName', [AnnouncementController::class, 'filterByServiceName']);
        Route::get('/filterByServiceYear', [AnnouncementController::class, 'filterByServiceYear']);
        Route::get('/filterByServiceSpec', [AnnouncementController::class, 'filterByServiceSpecialization']);
        Route::get('/filterByServiceType', [AnnouncementController::class, 'filterByServiceType']);
    });

    Route::prefix("savedAnnouncement")->group(function () {
        Route::get('/showALl', [SavedAnnouncementController::class, 'showAll']);
        Route::post('/save/{announcement}', [SavedAnnouncementController::class, 'save']);
        Route::delete('/unSave/{savedAnnouncement}', [SavedAnnouncementController::class, 'unSave']);
    });

    Route::prefix("service")->group(function () {
        Route::get('/showByYearAndSpecialization/{serviceYearAndSpecialization}', [ServiceController::class, 'showByYearAndSpecialization']);
        Route::get('/showByType/{type}', [ServiceController::class, 'showByType']);
        Route::get('/showAdvancedUsersOfService/{service}', [ServiceController::class, 'showAdvancedUsersOfService']);
    });

    Route::prefix("interestedService")->group(function () {
        Route::get('/showAllParent', [InterestedServiceController::class, 'showAllParent']);
        Route::get('/showChild/{service}', [InterestedServiceController::class, 'showChild']);
        Route::post('/interestInService/{service}', [InterestedServiceController::class, 'interestIn']);
        Route::delete('/unInterestInService/{interestedService}', [InterestedServiceController::class, 'unInterestIn']);
    });

    Route::prefix("session")->group(function () {
        Route::get('/showALl/{service}', [SessionController::class, 'showAll']);
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
