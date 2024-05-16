<?php

use App\Http\Controllers\InterestedServiceController;
use App\Http\Controllers\SavedAnnouncementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceManagerController;
use App\Http\Controllers\AdvancedUserController;
use App\Http\Controllers\NormalUserController;
use App\Http\Controllers\ServiceYearAndSpecializationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AssignedRoleController;
use App\Http\Controllers\AssignedServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AnnouncementController;

Route::middleware(['auth:api'])->group(function() {

  Route::prefix("serviceManager")->group(function () {
    Route::put('/completeAccount',[ServiceManagerController::class,'completeAccount'])->name('showAdvancedUserProfile');
    Route::put('/updateEmail',[ServiceManagerController::class,'updateEmail'])->name('updateServiceManagerEmail');
    Route::get('/showProfile',[ServiceManagerController::class,'showProfile'])->name('showServiceManagerProfile');
    Route::get('/showAll',[ServiceManagerController::class,'showAll'])->name('showAllServiceManages');
    Route::post('/addAdvancedUsersFile',[ServiceManagerController::class,'addAdvancedUsersFile'])->name('addAdvancedUsersFile');
    Route::post('/addNormalUsersFile',[ServiceManagerController::class,'addNormalUsersFile'])->name('addNormalUsersFile');
    Route::delete('/deleteAccount',[ServiceManagerController::class,'delete'])->name('deleteServiceManager');
    });

    Route::prefix ("advancedUser")->group( function () {
      Route::get('/showAll',[AdvancedUserController::class,'showAll'])->name('showAllAdvancedUsers');
      Route::post('/createAccount',[AdvancedUserController::class,'createAccount'])->name('createAdvancedUserAccount');
      Route::delete('/deleteAccount/{advancedUser}',[AdvancedUserController::class,'deleteAccount'])->name('deleteAdvancedUserAccount');
      Route::delete('/deleteAllAccounts',[AdvancedUserController::class,'deleteAllAccounts'])->name('deleteAllAdvancedUserAccounts');
    });

    Route::prefix("normalUser")->group(function () {
        Route::get('/showAll', [NormalUserController::class, 'showAll'])->name('showAllNormalUsers');
        Route::delete('/deleteAll', [NormalUserController::class, 'deleteAllAccounts'])->name('deleteAllNormalUsersAccounts');
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
        Route::get('/showAll/{advancedUser}', [AssignedServiceController::class, 'showAll'])->name('showAllAssignedServices');
        Route::post('/assign/{advancedUser}', [AssignedServiceController::class, 'assign'])->name('assignService');
        Route::delete('/delete/{assignedService}', [AssignedServiceController::class, 'delete'])->name('deleteAssignedService');
        Route::delete('/deleteAll/{advancedUser}', [AssignedServiceController::class, 'deleteAll'])->name('deleteAllAssignedServices');
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
        Route::get('/showAll', [AnnouncementController::class, 'showAnnouncements'])->name('showAnnouncements');
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
