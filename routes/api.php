<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\SpeakersController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\SpeakerTypeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\BookingManageController;
use App\Http\Controllers\MemorySubmissionController;


// for admin view
Route::apiResource('festivals', FestivalController::class);

Route::apiResource('speaker-types', SpeakerTypeController::class);

Route::apiResource('speakers', SpeakersController::class);
Route::get('/registrations', [RegistrationController::class, 'index']);

Route::get('/events', [EventsController::class, 'index']);
Route::post('/events', [EventsController::class, 'store']);
Route::put('/events/{event}', [EventsController::class, 'update']);
Route::delete('/events/{event}', [EventsController::class, 'destroy']);
Route::get('/get-speakers', [EventsController::class, 'getSpeakers']);

Route::get('/teams', [TeamsController::class, 'index']);
Route::post('/teams', [TeamsController::class, 'store']);
Route::put('/teams/{team}', [TeamsController::class, 'update']);
Route::delete('/teams/{team}', [TeamsController::class, 'destroy']);
Route::put('/teams/{team}/toggle-status', [TeamsController::class, 'toggleStatus']);

Route::apiResource('time-slots', TimeSlotController::class);
Route::get('/launchpad/bookings', [BookingManageController::class, 'allBookings']);
Route::put('/launchpad/bookings/{booking}/status', [BookingManageController::class, 'updateStatus']);




// for web view
Route::get('/speakers/home', [SpeakersController::class, 'homeSpeakers']);
Route::get('/custom-speaker-types', [SpeakersController::class, 'types']);

Route::get('/speakers/by-type/{typeId}', [SpeakersController::class, 'byType']);

Route::apiResource('partners', PartnerController::class);
Route::get('/our-partners', [PartnerController::class, 'partnersList']);

Route::post('/contact', [ContactController::class, 'sendContactEmail']);

Route::post('/register', [RegistrationController::class, 'store']);

Route::get('/get-events', [EventsController::class, 'getEvents']);
Route::get('/events/dates', [EventsController::class, 'uniqueDates']);

Route::get('/get-teams', [TeamsController::class, 'getTeams']);

Route::get('/launchpad/time-slots', [BookingController::class, 'getTimeSlots']);
Route::post('/launchpad/book', [BookingController::class, 'store']);

Route::post('/memory-submissions', [MemorySubmissionController::class, 'store']);

