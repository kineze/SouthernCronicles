<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenaralController;
use App\Http\Controllers\DashboardController;

Route::controller(GenaralController::class)->group( function (){

    Route::get('/', 'index')->name('index');

    Route::get('/home', 'home')->name('home');
    Route::get('/setdashboard', 'setDashboard')->name('setDashboard');
    Route::get('/dashboard', 'setDashboard')->name('dashboard');
    Route::get('/user-login','userLogin')->name('userLogin');
    
    Route::get('/register', 'userRegister')->name('userRegister');
    Route::post('/register', 'registerUser')->name('registerUser');
    // Route::get('/login', 'userLogin')->name('login');
    // Route::post('/login', 'loginUser')->name('loginUser');

});

Route::prefix('admin')->middleware(['auth:sanctum','permission:Access Admin Dashboard', config('jetstream.auth_session'),'verified'])->group(function (){

    Route::controller(DashboardController::class)->group(function (){

        Route::get('/dashboard', 'getAdminDashboard')->name('getAdminDashboard');

    });

});

Route::middleware(['permission:Manage Users', config('jetstream.auth_session'), 'verified',])->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('/new-user', 'getNewUser')->name('newUser');
        Route::get('/system-users', 'sysUsers')->name('sysUsers');
        Route::get('/show-password/{id}/{tempPass}', 'showPass')->name('showPass');
        Route::get('/get-user-update/{id}', 'getUpdateUser')->name('getUpdateUser');
        Route::post('update-user{id}', 'updateUser')->name('updateUser');
        Route::post('updateUserPassword/{id}', 'updateUserPassword')->name('updateUserPassword');
        Route::post('/delete-user/{id}', 'deleteUser')->name('deleteUser');
        Route::post('/store-new-user', 'storeUser')->name('storeUser');
        Route::post('/delete-user/{id}', 'deleteUser')->name('deleteUser');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/role-management', 'roleManagement')->name('roleManagement');
        Route::post('/store-role', 'storeRole')->name('storeRole');
        Route::post('/delete-role/{id}', 'deleteRole')->name('deleteRole');
        Route::get('/view-role/{id}', 'viewRole')->name('viewRole');
    });

});

