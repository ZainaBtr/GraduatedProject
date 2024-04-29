<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::prefix("announcement")->group( function () {
    Route::get('/showALl',[AnnouncementController::class,'showAll']);
    Route::get('/showAllFromService/{service}',[AnnouncementController::class,'showAllFromService']);
    Route::get('/showServiceNameForFilter',[AnnouncementController::class,'showServiceNameForFilter']);
    Route::get('/showServiceYearForFilter',[AnnouncementController::class,'showServiceYearForFilter']);
    Route::get('/showServiceTypeForFilter',[AnnouncementController::class,'showServiceTypeForFilter']);
    Route::get('/showServiceSpecForFilter',[AnnouncementController::class,'showServiceSpecializationForFilter']);
    Route::get('/filterByServiceName',[AnnouncementController::class,'filterByServiceName']);
    Route::get('/filterByServiceYear',[AnnouncementController::class,'filterByServiceYear']);
    Route::get('/filterByServiceSpec',[AnnouncementController::class,'filterByServiceSpecialization']);
    Route::get('/filterByServiceType',[AnnouncementController::class,'filterByServiceType']);
});

Route::prefix("savedAnnouncement")->group( function () {
    Route::get('/showALl',[SavedAnnouncementController::class,'showAll']);
    Route::post('/save/{announcement}',[SavedAnnouncementController::class,'save']);
    Route::delete('/unSave/{savedAnnouncement}',[SavedAnnouncementController::class,'unSave']);

});

Route::prefix("service")->group( function () {
    Route::get('/showALl',[ServiceController::class,'showAll']);
    Route::get('/showByYearAndSpecialization',[ServiceController::class,'showByYearAndSpecializationInGeneral']);
    Route::get('/showActivityInGeneral',[ServiceController::class,'showActivityInGeneral']);
    Route::get('/showProjectInterviewInGeneral',[ServiceController::class,'showProjectInterviewInGeneral']);
    Route::get('/showDoctorInterviewInGeneral',[ServiceController::class,'showDoctorInterviewInGeneral']);
    Route::get('/showExamInGeneral',[ServiceController::class,'showExamInGeneral']);
    Route::get('/showAdvancedUsers/{service}',[ServiceController::class,'showAdvancedUsersOfService']);
    Route::get('/search',[ServiceController::class,'search']);
    Route::get('/filterByYear',[ServiceController::class,'filterByServiceYear']);
    Route::get('/filterBySpecialization',[ServiceController::class,'filterByServiceSpecialization']);
    Route::get('/filterByType',[ServiceController::class,'filterByServiceType']);
});

Route::prefix("interestedServices")->group( function () {
    Route::get('/showALl',[InterestedServiceController::class,'showAll']);
    Route::post('/interestInService/{service}',[InterestedServiceController::class,'interestIn']);
    Route::delete('/unInterestInService/{interestedService}',[InterestedServiceController::class,'unInterestIn']);
});

Route::prefix("session")->group( function () {
    Route::get('/showALl/{service}',[SessionController::class,'showAll']);
    Route::get('/showALlRelated/{advancedUser}',[SessionController::class,'showAllRelatedToAdvancedUser']);
    Route::get('/search',[SessionController::class,'search']);
});

Route::prefix("publicSession")->group( function () {
    Route::get('/showActivities',[PublicSessionController::class,'showActivities']);
    Route::get('/showExams',[PublicSessionController::class,'showExams']);
});

Route::prefix("privateSession")->group( function () {
    Route::get('/showProjectInterviews',[PrivateSessionController::class,'showProjectsInterviews']);
    Route::get('/showAdvancedUsersInterviews',[PrivateSessionController::class,'showAdvancedUsersInterviews']);
});

Route::get('/showAll',[PrivateReservationController::class,'showAll']);

Route::get('/showFakeReservation',[FakeReservationController::class,'showALl']);


