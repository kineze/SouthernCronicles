<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\SpeakersController;
use App\Http\Controllers\TeamTypeController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\UsefulLinkController;
use App\Http\Controllers\VolunteersController;
use App\Http\Controllers\PartnerTypeController;
use App\Http\Controllers\SpeakerTypeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\BookingManageController;
use App\Http\Controllers\MemorySubmissionController;


// for admin view

Route::get('/config/google-maps-key', function () {
    return response()->json([
        'key' => config('services.google_maps.key')
    ]);
});

Route::apiResource('festivals', FestivalController::class);

Route::post('/speaker-types/reorder', [SpeakerTypeController::class, 'reorder'])->name('speaker-types.reorder');
Route::apiResource('speaker-types', SpeakerTypeController::class);

Route::post('/speakers/reorder', [SpeakersController::class, 'reorder']);
Route::apiResource('speakers', SpeakersController::class);

Route::get('/registrations', [RegistrationController::class, 'index']);

Route::post('/partners/reorder', [PartnerController::class, 'reorder'])->name('partners.reorder');
Route::apiResource('partners', PartnerController::class);

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

Route::delete('/time-slots/by-date', [TimeSlotController::class, 'destroyByDate']);
Route::apiResource('time-slots', TimeSlotController::class);
Route::post('/time-slots/{timeSlot}/toggle', [TimeSlotController::class, 'toggleStatus']);



Route::get('/launchpad/bookings', [BookingManageController::class, 'allBookings']);
Route::put('/launchpad/bookings/{booking}/status', [BookingManageController::class, 'updateStatus']);


Route::get('/memory-submissions', [MemorySubmissionController::class, 'index']);

Route::apiResource('useful-links', UsefulLinkController::class);

Route::post('volunteers/{volunteer}/status', [VolunteersController::class, 'setStatus']); 
Route::apiResource('volunteers', VolunteersController::class)->only(['index','store','update','destroy']);

Route::apiResource('news', NewsController::class);

Route::put('news/{news}/toggle-status', [NewsController::class, 'toggleStatus']);
Route::get('/news/{news}', [NewsController::class, 'show']);

Route::apiResource('partner-types', PartnerTypeController::class);
Route::post('partner-types/reorder', [PartnerTypeController::class, 'reorder']);

Route::apiResource('team-types', TeamTypeController::class);
Route::post('team-types/reorder', [TeamTypeController::class, 'reorder']);


// for web view
Route::get('/speakers/home', [SpeakersController::class, 'homeSpeakers']);
Route::get('/custom-speaker-types', [SpeakersController::class, 'types']);

Route::get('/speakers/by-type/{typeId}', [SpeakersController::class, 'byType']);


Route::get('/our-partners', [PartnerController::class, 'partnersList']);

Route::post('/contact', [ContactController::class, 'sendContactEmail']);

Route::post('/register', [RegistrationController::class, 'store']);

Route::get('/get-events', [EventsController::class, 'getEvents']);
Route::get('/events/dates', [EventsController::class, 'uniqueDates']);

Route::get('/get-teams', [TeamsController::class, 'getTeams']);

Route::get('/launchpad/time-slots', [BookingController::class, 'getTimeSlots']);
Route::post('/launchpad/book', [BookingController::class, 'store']);

Route::post('/memory-submissions', [MemorySubmissionController::class, 'store']);

