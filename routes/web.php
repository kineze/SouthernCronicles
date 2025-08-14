<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GenaralController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\SpeakersController;
use App\Http\Controllers\TeamTypeController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsefulLinkController;
use App\Http\Controllers\VolunteersController;
use App\Http\Controllers\PartnerTypeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\BookingManageController;
use App\Http\Controllers\MemorySubmissionController;

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

Route::controller(PagesController::class)->group( function (){

    Route::get('/the-writing-lab', 'writingLab')->name('writingLab');
    Route::get('/about-us', 'aboutUs')->name('aboutUs');
    Route::get('/speakers-list','speakersList')->name('speakersList');
    Route::get('/our-partners','ourPartners')->name('ourPartners');
    Route::get('/contact-us','contactus')->name('contactus');
    Route::get('/events-schedule','eventsSchedule')->name('eventsSchedule');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacyPolicy');
    Route::get('/terms-&-conditions','temsConditions')->name('temsConditions');

    Route::get('booking-now','bookingNow')->name('bookingNow');
    Route::get('living-memory-vault','livingMemoryVault')->name('livingMemoryVault');
    Route::get('/the-kipenzi','theKipenzi')->name('theKipenzi');
    Route::get('/volunteer-with-us','volunteerWithUs')->name('volunteerWithUs');

    Route::get('/team-list','teamList')->name('teamList');
    Route::get('/news-list','newsList')->name('newsList');

    Route::get('/view-news/{id}', 'viewNews')->name('viewNews');
});



Route::prefix('admin')->middleware(['auth:sanctum','permission:Access Admin Dashboard', config('jetstream.auth_session'),'verified'])->group(function (){

    Route::controller(DashboardController::class)->group(function (){

        Route::get('/dashboard', 'getAdminDashboard')->name('getAdminDashboard');

    });

});


Route::middleware(['permission:Manage Festivals', config('jetstream.auth_session'), 'verified',])->group( function (){

    Route::controller(FestivalController::class)->group(function () {

        Route::get('/all-festivals','allFestivals')->name('allFestivals');
        Route::get('/all-speakers', 'allSpeakers')->name('allSpeakers');

    });

    Route::controller(SpeakersController::class)->group(function () {

        Route::get('/speaker-types','speakerTypes')->name('speakerTypes');
        Route::get('/all-speakers', 'allSpeakers')->name('allSpeakers');

    });

});




Route::middleware(['permission:Manage Partners', config('jetstream.auth_session'), 'verified',])->group( function (){

    Route::controller(PartnerTypeController::class)->group(function () {

        Route::get('/partner-types','partnerTypes')->name('partnerTypes');

    });

    Route::controller(PartnerController::class)->group(function () {

        Route::get('/partners','Partners')->name('Partners');

    });

    Route::controller(UsefulLinkController::class)->group(function () {

        Route::get('/usefull-links','usefullLinks')->name('usefullLinks');

    });

});



Route::middleware(['permission:Manage Events', config('jetstream.auth_session'), 'verified',])->group( function (){

    Route::controller(EventsController::class)->group(function () {

        Route::get('/manage-events','manageEvents')->name('manageEvents');

    });

});



Route::middleware(['permission:Manage Teams', config('jetstream.auth_session'), 'verified',])->group( function (){

    Route::controller(TeamsController::class)->group(function () {

        Route::get('/manage-teams','manageTeams')->name('manageTeams');

    });

    Route::controller(TeamTypeController::class)->group(function () {

        Route::get('/team-types','teamTypes')->name('teamTypes');

    });

});


Route::middleware(['permission:Manage Bookings', config('jetstream.auth_session'), 'verified',])->group( function (){

    Route::controller(TimeSlotController::class)->group(function () {

        Route::get('/manage-time-slots','manageTimeSlots')->name('manageTimeSlots');

    });

    Route::controller(BookingManageController::class)->group( function () {

        Route::get('/manage-bookings','manageBookings')->name('manageBookings');

    });

    Route::controller(MemorySubmissionController::class)->group(function () {

        Route::get('/memory-submission','memorySubmission')->name('memorySubmission');
    });

});



Route::middleware(['permission:Manage News', config('jetstream.auth_session'), 'verified',])->group( function (){

    Route::controller(NewsController::class)->group(function () {

        Route::get('/all-news','allNews')->name('allNews');

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


    Route::controller(RegistrationController::class)->group(function (){

        route::get('/registered-list','registeredList')->name('registeredList');

    });


    Route::controller(VolunteersController::class)->group(function (){

        route::get('/volunteers','volunteers')->name('volunteers');

    });

});

