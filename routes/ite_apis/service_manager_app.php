<?php

use App\Http\Controllers\ExcelFileController;
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

Route::prefix ("serviceManager")->group( function () {
    Route::put('/completeAccount',[ServiceManagerController::class,'completeAccount'])->name('showAdvancedUserProfile');
    Route::put('/updateEmail',[ServiceManagerController::class,'updateEmail'])->name('updateServiceManagerEmail');
    Route::get('/showProfile',[ServiceManagerController::class,'showProfile'])->name('showServiceManagerProfile');
    Route::get('/showAll',[ServiceManagerController::class,'showAll'])->name('showAllServiceManages');
    Route::post('/addAdvancedUsersFile',[ServiceManagerController::class,'addAdvancedUsersFile'])->name('addAdvancedUsersFile');
    Route::post('/addNormalUsersFile',[ServiceManagerController::class,'addNormalUsersFile'])->name('addNormalUsersFile');
});

Route::prefix ("announcement")->group( function () {
    Route::get('/showALl',[AnnouncementController::class,'showAnnouncements'])->name('showAnnouncements');
    Route::get('/showAllFromService/{service}',[AnnouncementController::class,'showAllFromService'])->name('showAllAnnouncementsFromService');
    Route::get('/showServiceNameForFilter',[AnnouncementController::class,'showServiceNameForFilter'])->name('showServiceNameForFilter');
    Route::get('/showServiceYearForFilter',[AnnouncementController::class,'showServiceYearForFilter'])->name('showServiceYearForFilter');
    Route::get('/showServiceTypeForFilter',[AnnouncementController::class,'showServiceTypeForFilter'])->name('showServiceTypeForFilter');
    Route::get('/showServiceSpecForFilter',[AnnouncementController::class,'showServiceSpecializationForFilter'])->name('showServiceSpecializationForFilter');
    Route::get('/filterByServiceName',[AnnouncementController::class,'filterByServiceName'])->name('announcementFilterByServiceName');
    Route::get('/filterByServiceYear',[AnnouncementController::class,'filterByServiceYear'])->name('announcementFilterByServiceYear');
    Route::get('/filterByServiceSpec',[AnnouncementController::class,'filterByServiceSpecialization'])->name('announcementFilterByServiceSpecialization');
    Route::get('/filterByServiceType',[AnnouncementController::class,'filterByServiceType'])->name('announcementFilterByServiceType');
    Route::get('/showMy',[AnnouncementController::class,'showMy'])->name('showMyAnnouncements');
    Route::post('/add/{service}',[AnnouncementController::class,'add'])->name('addAnnouncement');
    Route::put('/update/{announcement}',[AnnouncementController::class,'update'])->name('updateAnnouncement');
});

Route::prefix ("advancedUser")->group( function () {
    Route::get('/showAll',[AdvancedUserController::class,'showAll'])->name('showAllAdvancedUsers');
    Route::post('/createAccount',[AdvancedUserController::class,'createAccount'])->name('createAdvancedUserAccount');
    Route::delete('/deleteAccount/{advancedUser}',[AdvancedUserController::class,'deleteAccount'])->name('deleteAdvancedUserAccount');
    Route::delete('/deleteAllAccount',[AdvancedUserController::class,'deleteAllAccounts'])->name('deleteAllAdvancedUserAccounts');
});

Route::prefix ("normalUser")->group( function () {
    Route::get('/showAll',[NormalUserController::class,'showAll'])->name('showAllNormalUsers');
    Route::delete('/deleteAll',[NormalUserController::class,'deleteAllAccounts'])->name('deleteAllNormalUsersAccounts');
});

Route::prefix ("serviceYearAndSpecialization")->group( function () {
    Route::post('/add',[ServiceYearAndSpecializationController::class,'add'])->name('addServiceYearAndSpecialization');
    Route::delete('/delete/{serviceYearAndSpecialization}',[ServiceYearAndSpecializationController::class,'delete'])->name('deleteServiceYearAndSpecialization');
    Route::delete('/deleteAll',[ServiceYearAndSpecializationController::class,'deleteAll'])->name('deleteAllServiceYearAndSpecialization');
});

Route::prefix ("role")->group( function () {
    Route::get('/show',[RoleController::class,'showAll'])->name('showRoles');
    Route::post('/add',[RoleController::class,'add'])->name('addRole');
    Route::delete('/delete/{role}',[RoleController::class,'delete'])->name('deleteRole');
    Route::delete('/deleteAll',[RoleController::class,'deleteAll'])->name('deleteALlRole');
});

Route::prefix ("assignedRole")->group( function () {
    Route::get('/show',[AssignedRoleController::class,'showAll'])->name('showAssignedRoles');
    Route::post('/assign',[AssignedRoleController::class,'assign'])->name('assignRoles');
    Route::delete('/delete/{assignRole}',[AssignedRoleController::class,'delete'])->name('deleteAssignRoles');
    Route::delete('/deleteAll/{assignedService}',[AssignedRoleController::class,'deleteAll'])->name('deleteAllAssignRoles');
});

Route::prefix ("assignedService")->group( function () {
    Route::get('/show',[AssignedServiceController::class,'showAll'])->name('showAssignedServices');
    Route::post('/assign',[AssignedServiceController::class,'assign'])->name('assignService');
    Route::delete('/delete/{assignService}',[AssignedServiceController::class,'delete'])->name('deleteAssignedService');
    Route::delete('/deleteAll/{advancedUser}',[AssignedServiceController::class,'deleteAll'])->name('deleteAllAssignedServices');
});

Route::prefix ("service")->group( function () {
    Route::get('/showMy',[ServiceController::class,'showMy'])->name('showMyServices');
    Route::post('/add/{parentService}',[ServiceController::class,'add'])->name('addService');
    Route::put('/update/{service}',[ServiceController::class,'update'])->name('updateService');
    Route::delete('/delete/{service}',[ServiceController::class,'delete'])->name('deleteService');
    Route::delete('/deleteAll',[ServiceController::class,'deleteAll'])->name('deleteAllServices');
});

Route::prefix ("file")->group( function () {
    Route::get('/download',[FileController::class,'download'])->name('download');
    Route::post('/add/{announcement}',[FileController::class,'add'])->name('addFile');
    Route::delete('/delete/{file}',[FileController::class,'delete'])->name('deleteFile');
});

