<?php

use App\Http\Controllers\AdvancedUserController;
use App\Http\Controllers\AssignedRoleController;
use App\Http\Controllers\AssignedServiceController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NormalUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceManagerController;
use App\Http\Controllers\ServiceYearAndSpecializationController;
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


Route::post('/createToken/{user}',[\App\Http\Controllers\Controller::class,'createToken']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/advancedUserRegister', [AuthController::class, 'advancedUserRegister']);

Route::post('/createToken/{user}',[\App\Http\Controllers\Controller::class,'createToken']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgetPassword', [AuthController::class, 'forgetPassword']);

Route::delete('/verification', [AuthController::class, 'verification']);

Route::post('/setEmail', [AuthController::class, 'setEmail']);

Route::middleware(['auth:api',
    //'check.role:advancedUser||normalUser'
])->group(function() {

    Route::put('/changePassword',[AuthController::class,'changePassword']);

    Route::put('/updateEmail',[AuthController::class,'updateEmail']);

    Route::post('/setNewPassword',[AuthController::class,'setNewPassword'])->name('setNewPassword');;

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
        Route::get('/showAllRelated/{user}', [SessionController::class, 'showAllRelatedToAdvancedUser']);

        Route::get('/search', [SessionController::class, 'search']);
    });

    Route::prefix("publicSession")->group(function () {
        Route::get('/show/{service}', [PublicSessionController::class, 'show']);
//        Route::get('/showActivities', [PublicSessionController::class, 'showActivities']);
//        Route::get('/showExams', [PublicSessionController::class, 'showExams']);
    });

    Route::prefix("privateSession")->group(function () {
        Route::get('/showProjectInterviews/{service}', [PrivateSessionController::class, 'showProjectInterviews']);
        Route::get('/showAdvancedUsersInterviews/{service}/{user}', [PrivateSessionController::class, 'showAdvancedUsersInterviews']);
    });

    Route::get('privateReservation/showAll/{privateSession}', [PrivateReservationController::class, 'showAll']);

    Route::get('/showFakeReservations/{privateSession}', [FakeReservationController::class, 'showALl']);

});


///////////////////////////////////////////////// Route In Web /////////////////////////////////////////////////


//////////////////////////////////////// Common Methods ////////////////////////////////////////


Route::post('/login',[AuthController::class,'login'])->name('login');

Route::post('/forgetPassword',[AuthController::class,'forgetPassword'])->name('forgetPassword');

Route::delete('/verification',[AuthController::class,'verification'])->name('verification');

Route::post('/setEmail',[AuthController::class,'setEmail'])->name('setEmail');

Route::middleware(['auth:api', 'check.role:1||serviceManager'])->group(function() {

    Route::put('/changePassword',[AuthController::class,'changePassword'])->name('changePassword');

    Route::put('/setNewPassword',[AuthController::class,'setNewPassword'])->name('setNewPassword');

    Route::put('/updateEmail',[AuthController::class,'updateEmail'])->name('updateEmail');

    Route::delete('/deleteAccount/{user}',[AuthController::class,'deleteAccount'])->name('deleteAccount');

});


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


//////////////////////////////////// System Manager Methods ////////////////////////////////////


Route::middleware(['auth:api', 'check.role:1'])->group(function() {

    Route::prefix ("systemManager")->group( function () {
        Route::get('/showProfile',[ServiceManagerController::class,'showSystemManagerProfile'])->name('showSystemManagerProfile');
        Route::post('/createServiceManagerAccount',[ServiceManagerController::class,'createAccount'])->name('createServiceManagerAccount');
        Route::get('/showAll',[ServiceManagerController::class,'showAll'])->name('showAllServicesManagers');
    });

});


/////////////////////////////////// Services Managers Methods //////////////////////////////////


Route::middleware(['auth:api', //'check.role:serviceManager'
])->group(function() {

    Route::prefix("serviceManager")->group(function () {
        Route::get('/showProfile', [ServiceManagerController::class, 'showProfile'])->name('showServiceManagerProfile');
        Route::post('/addAdvancedUsersFile', [ServiceManagerController::class, 'addAdvancedUsersFile'])->name('addAdvancedUsersFile');
        Route::post('/addNormalUsersFile', [ServiceManagerController::class, 'addNormalUsersFile'])->name('addNormalUsersFile');
    });

    Route::prefix("advancedUser")->group(function () {
        Route::get('/showAll', [AdvancedUserController::class, 'showAll'])->name('showAllAdvancedUsers');
        Route::post('/createAccount', [AdvancedUserController::class, 'createAccount'])->name('createAdvancedUserAccount');
        Route::delete('/deleteAllAccounts', [AdvancedUserController::class, 'deleteAllAccounts'])->name('deleteAllAdvancedUsersAccounts');
    });

    Route::prefix("normalUser")->group(function () {
        Route::get('/showAll', [NormalUserController::class, 'showAll'])->name('showAllNormalUsers');
        Route::delete('/deleteAllAccounts', [NormalUserController::class, 'deleteAllAccounts'])->name('deleteAllNormalUsersAccounts');
    });

    Route::prefix("serviceYearAndSpecialization")->group(function () {
        Route::get('/showAll', [ServiceYearAndSpecializationController::class, 'showAll'])->name('showAllServicesYearsAndSpecializations');
        Route::post('/add', [ServiceYearAndSpecializationController::class, 'add'])->name('addServiceYearAndSpecialization');
        Route::delete('/delete/{serviceYearAndSpecialization}', [ServiceYearAndSpecializationController::class, 'delete'])->name('deleteServiceYearAndSpecialization');
        Route::delete('/deleteAll', [ServiceYearAndSpecializationController::class, 'deleteAll'])->name('deleteAllServicesYearsAndSpecializations');
    });

    Route::prefix("role")->group(function () {
        Route::get('/showAll', [RoleController::class, 'showAll'])->name('showAllRoles');
        Route::post('/add', [RoleController::class, 'add'])->name('addRole');
        Route::delete('/delete/{role}', [RoleController::class, 'delete'])->name('deleteRole');
        Route::delete('/deleteAll', [RoleController::class, 'deleteAll'])->name('deleteAllRoles');
    });

    Route::prefix("assignedRole")->group(function () {
        Route::get('/showAll/{assignedService}', [AssignedRoleController::class, 'showAll'])->name('showAllAssignedRoles');
        Route::post('/assign/{assignedService}', [AssignedRoleController::class, 'assign'])->name('assignRole');
        Route::delete('/delete/{assignedRole}', [AssignedRoleController::class, 'delete'])->name('deleteAssignedRole');
        Route::delete('/deleteAll/{assignedService}', [AssignedRoleController::class, 'deleteAll'])->name('deleteAllAssignedRoles');
    });

    Route::prefix("assignedService")->group(function () {
        Route::get('/showAll/{user}', [AssignedServiceController::class, 'showAll'])->name('showAllAssignedServices');
        Route::post('/assign/{user}', [AssignedServiceController::class, 'assign'])->name('assignService');
        Route::delete('/delete/{assignedService}', [AssignedServiceController::class, 'delete'])->name('deleteAssignedService');
        Route::delete('/deleteAll/{user}', [AssignedServiceController::class, 'deleteAll'])->name('deleteAllAssignedServices');
    });

    Route::prefix("service")->group(function () {
        Route::get('/showServiceNameForDynamicDropDown', [ServiceController::class, 'showServiceNameForDynamicDropDown'])->name('showServiceNameForDynamicDropDown');
        Route::get('/showServiceYearAndSpecForDynamicDropDown', [ServiceController::class, 'showServiceYearAndSpecForDynamicDropDown'])->name('showServiceYearAndSpecForDynamicDropDown');
        Route::get('/showAllParent', [ServiceController::class, 'showAllParent'])->name('showAllParentServices');
        Route::get('/showChild/{service}', [ServiceController::class, 'showChild'])->name('showChildServices');
        Route::get('/showMyAllParentFromServiceManager', [ServiceController::class, 'showMyAllParentFromServiceManager'])->name('showMyAllParentServices');
        Route::get('/showMyChildFromServiceManager/{service}', [ServiceController::class, 'showMyChildFromServiceManager'])->name('showMyChildServices');
        Route::post('/add/{parentService?}', [ServiceController::class, 'add'])->name('addService');
        Route::put('/update/{service}', [ServiceController::class, 'update'])->name('updateService');
        Route::delete('/delete/{service}', [ServiceController::class, 'delete'])->name('deleteService');
        Route::delete('/deleteAll', [ServiceController::class, 'deleteAll'])->name('deleteAllServices');
        Route::get('/searchForServiceManager', [ServiceController::class, 'searchForServiceManager'])->name('searchForServiceByServiceName');
        Route::get('/filterByType', [ServiceController::class, 'filterByType'])->name('filterServicesByType');
    });

    Route::prefix("interestedService")->group(function () {
        Route::get('/showAllParent', [InterestedServiceController::class, 'showAllParent'])->name('showAllParentInterestedServices');
        Route::get('/showChild/{service}', [InterestedServiceController::class, 'showChild'])->name('showChildInterestedServices');
        Route::post('/interestInService/{service}', [InterestedServiceController::class, 'interestIn'])->name('interestInService');
        Route::delete('/unInterestInService/{interestedService}', [InterestedServiceController::class, 'unInterestIn'])->name('unInterestInService');
    });

    Route::prefix("announcement")->group(function () {
        Route::get('/showAll', [AnnouncementController::class, 'showAll'])->name('showAnnouncements');
        Route::get('/showAllFromService/{service}', [AnnouncementController::class, 'showAllFromService'])->name('showAllAnnouncementsFromService');
        Route::get('/showMy', [AnnouncementController::class, 'showMy'])->name('showMyAnnouncements');
        Route::post('/add', [AnnouncementController::class, 'add'])->name('addAnnouncement');
        Route::post('/addFromService/{service}', [AnnouncementController::class, 'addFromService'])->name('addAnnouncementFromService');
        Route::put('/update/{announcement}', [AnnouncementController::class, 'update'])->name('updateAnnouncement');
        Route::get('/filterByType', [AnnouncementController::class, 'filterByType'])->name('filterServicesByType');
    });

    Route::prefix("savedAnnouncement")->group(function () {
        Route::get('/showAll', [SavedAnnouncementController::class, 'showAll'])->name('showAllAnnouncements');
        Route::post('/save/{announcement}', [SavedAnnouncementController::class, 'save'])->name('saveAnnouncement');
        Route::delete('/unSave/{savedAnnouncement}', [SavedAnnouncementController::class, 'unSave'])->name('unSaveAnnouncement');
    });

    Route::post('/file/download/{file}', [FileController::class, 'download'])->name('downloadFile');

});

/////////////////////////////////////////////////// Route In Web /////////////////////////////////////////////////
//
//
////////////////////////////////////////// Common Methods ////////////////////////////////////////
//
//
//Route::post('/login',[AuthController::class,'login'])->name('login');
//
//Route::post('/forgetPassword',[AuthController::class,'forgetPassword'])->name('forgetPassword');
//
//Route::delete('/verification',[AuthController::class,'verification'])->name('verification');
//
//Route::post('/setEmail',[AuthController::class,'setEmail'])->name('setEmail');
//
//Route::middleware(['auth:api', 'check.role:1||serviceManager'])->group(function() {
//
//    Route::put('/changePassword',[AuthController::class,'changePassword'])->name('changePassword');
//
//    Route::put('/setNewPassword',[AuthController::class,'setNewPassword'])->name('setNewPassword');
//
//    Route::put('/updateEmail',[AuthController::class,'updateEmail'])->name('updateEmail');
//
//    Route::delete('/deleteAccount/{user}',[AuthController::class,'deleteAccount'])->name('deleteAccount');
//
//});
//
//
//Route::get('/', function () {
//    return view('pages.FirstPageForServiceManager');
//});
//
//Route::get('/n', function () {
//    return view('page.FirstPageForSystemManager');
//});
//Route::get('/m', function () {
//    return view('Common.ChangePasswordPageForChangePassword');
//});
//
//Route::get('/d', function () {
//    return view('Common.LoginPage');
//});
//
//
////////////////////////////////////// System Manager Methods ////////////////////////////////////
//
//
//Route::middleware(['auth:api', 'check.role:1'])->group(function() {
//
//    Route::prefix ("systemManager")->group( function () {
//        Route::get('/showProfile',[ServiceManagerController::class,'showSystemManagerProfile'])->name('showSystemManagerProfile');
//        Route::post('/createServiceManagerAccount',[ServiceManagerController::class,'createAccount'])->name('createServiceManagerAccount');
//        Route::get('/showAll',[ServiceManagerController::class,'showAll'])->name('showAllServicesManagers');
//    });
//
//});
//
//
///////////////////////////////////// Services Managers Methods //////////////////////////////////
//
//
//Route::middleware(['auth:api', 'check.role:serviceManager'])->group(function() {
//
//    Route::prefix("serviceManager")->group(function () {
//        Route::get('/showProfile', [ServiceManagerController::class, 'showProfile'])->name('showServiceManagerProfile');
//        Route::post('/addAdvancedUsersFile', [ServiceManagerController::class, 'addAdvancedUsersFile'])->name('addAdvancedUsersFile');
//        Route::post('/addNormalUsersFile', [ServiceManagerController::class, 'addNormalUsersFile'])->name('addNormalUsersFile');
//    });
//
//    Route::prefix("advancedUser")->group(function () {
//        Route::get('/showAll', [AdvancedUserController::class, 'showAll'])->name('showAllAdvancedUsers');
//        Route::post('/createAccount', [AdvancedUserController::class, 'createAccount'])->name('createAdvancedUserAccount');
//        Route::delete('/deleteAllAccounts', [AdvancedUserController::class, 'deleteAllAccounts'])->name('deleteAllAdvancedUsersAccounts');
//    });
//
//    Route::prefix("normalUser")->group(function () {
//        Route::get('/showAll', [NormalUserController::class, 'showAll'])->name('showAllNormalUsers');
//        Route::delete('/deleteAllAccounts', [NormalUserController::class, 'deleteAllAccounts'])->name('deleteAllNormalUsersAccounts');
//    });
//
//    Route::prefix("serviceYearAndSpecialization")->group(function () {
//        Route::get('/showAll', [ServiceYearAndSpecializationController::class, 'showAll'])->name('showAllServicesYearsAndSpecializations');
//        Route::post('/add', [ServiceYearAndSpecializationController::class, 'add'])->name('addServiceYearAndSpecialization');
//        Route::delete('/delete/{serviceYearAndSpecialization}', [ServiceYearAndSpecializationController::class, 'delete'])->name('deleteServiceYearAndSpecialization');
//        Route::delete('/deleteAll', [ServiceYearAndSpecializationController::class, 'deleteAll'])->name('deleteAllServicesYearsAndSpecializations');
//    });
//
//    Route::prefix("role")->group(function () {
//        Route::get('/showAll', [RoleController::class, 'showAll'])->name('showAllRoles');
//        Route::post('/add', [RoleController::class, 'add'])->name('addRole');
//        Route::delete('/delete/{role}', [RoleController::class, 'delete'])->name('deleteRole');
//        Route::delete('/deleteAll', [RoleController::class, 'deleteAll'])->name('deleteAllRoles');
//    });
//
//    Route::prefix("assignedRole")->group(function () {
//        Route::get('/showAll/{assignedService}', [AssignedRoleController::class, 'showAll'])->name('showAllAssignedRoles');
//        Route::post('/assign/{assignedService}', [AssignedRoleController::class, 'assign'])->name('assignRole');
//        Route::delete('/delete/{assignedRole}', [AssignedRoleController::class, 'delete'])->name('deleteAssignedRole');
//        Route::delete('/deleteAll/{assignedService}', [AssignedRoleController::class, 'deleteAll'])->name('deleteAllAssignedRoles');
//    });
//
//    Route::prefix("assignedService")->group(function () {
//        Route::get('/showAll/{user}', [AssignedServiceController::class, 'showAll'])->name('showAllAssignedServices');
//        Route::post('/assign/{user}', [AssignedServiceController::class, 'assign'])->name('assignService');
//        Route::delete('/delete/{assignedService}', [AssignedServiceController::class, 'delete'])->name('deleteAssignedService');
//        Route::delete('/deleteAll/{user}', [AssignedServiceController::class, 'deleteAll'])->name('deleteAllAssignedServices');
//    });
//
//    Route::prefix("service")->group(function () {
//        Route::get('/showServiceNameForDynamicDropDown', [ServiceController::class, 'showServiceNameForDynamicDropDown'])->name('showServiceNameForDynamicDropDown');
//        Route::get('/showServiceYearAndSpecForDynamicDropDown', [ServiceController::class, 'showServiceYearAndSpecForDynamicDropDown'])->name('showServiceYearAndSpecForDynamicDropDown');
//        Route::get('/showAllParent', [ServiceController::class, 'showAllParent'])->name('showAllParentServices');
//        Route::get('/showChild/{service}', [ServiceController::class, 'showChild'])->name('showChildServices');
//        Route::get('/showMyAllParentFromServiceManager', [ServiceController::class, 'showMyAllParentFromServiceManager'])->name('showMyAllParentServices');
//        Route::get('/showMyChildFromServiceManager/{service}', [ServiceController::class, 'showMyChildFromServiceManager'])->name('showMyChildServices');
//        Route::post('/add/{parentService?}', [ServiceController::class, 'add'])->name('addService');
//        Route::put('/update/{service}', [ServiceController::class, 'update'])->name('updateService');
//        Route::delete('/delete/{service}', [ServiceController::class, 'delete'])->name('deleteService');
//        Route::delete('/deleteAll', [ServiceController::class, 'deleteAll'])->name('deleteAllServices');
//        Route::get('/searchForServiceManager', [ServiceController::class, 'searchForServiceManager'])->name('searchForServiceByServiceName');
//        Route::get('/filterByType', [ServiceController::class, 'filterByType'])->name('filterServicesByType');
//    });
//
//    Route::prefix("interestedService")->group(function () {
//        Route::get('/showAllParent', [InterestedServiceController::class, 'showAllParent'])->name('showAllParentInterestedServices');
//        Route::get('/showChild/{service}', [InterestedServiceController::class, 'showChild'])->name('showChildInterestedServices');
//        Route::post('/interestInService/{service}', [InterestedServiceController::class, 'interestIn'])->name('interestInService');
//        Route::delete('/unInterestInService/{interestedService}', [InterestedServiceController::class, 'unInterestIn'])->name('unInterestInService');
//    });
//
//    Route::prefix("announcement")->group(function () {
//        Route::get('/showAll', [AnnouncementController::class, 'showAll'])->name('showAnnouncements');
//        Route::get('/showAllFromService/{service}', [AnnouncementController::class, 'showAllFromService'])->name('showAllAnnouncementsFromService');
//        Route::get('/showMy', [AnnouncementController::class, 'showMy'])->name('showMyAnnouncements');
//        Route::post('/add', [AnnouncementController::class, 'add'])->name('addAnnouncement');
//        Route::post('/addFromService/{service}', [AnnouncementController::class, 'addFromService'])->name('addAnnouncementFromService');
//        Route::put('/update/{announcement}', [AnnouncementController::class, 'update'])->name('updateAnnouncement');
//        Route::get('/filterByType', [AnnouncementController::class, 'filterByType'])->name('filterServicesByType');
//    });
//
//    Route::prefix("savedAnnouncement")->group(function () {
//        Route::get('/showAll', [SavedAnnouncementController::class, 'showAll'])->name('showAllAnnouncements');
//        Route::post('/save/{announcement}', [SavedAnnouncementController::class, 'save'])->name('saveAnnouncement');
//        Route::delete('/unSave/{savedAnnouncement}', [SavedAnnouncementController::class, 'unSave'])->name('unSaveAnnouncement');
//    });
//
//    Route::post('/file/download/{file}', [FileController::class, 'download'])->name('downloadFile');
//
//});
