<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\SpeakersController;
use App\Http\Controllers\SpeakerTypeController;
use App\Http\Controllers\RegistrationController;


// for admin view
Route::apiResource('festivals', FestivalController::class);

Route::apiResource('speaker-types', SpeakerTypeController::class);

Route::apiResource('speakers', SpeakersController::class);
Route::get('/registrations', [RegistrationController::class, 'index']);




// for web view
Route::get('/speakers/home', [SpeakersController::class, 'homeSpeakers']);
Route::get('/custom-speaker-types', [SpeakersController::class, 'types']);

Route::get('/speakers/by-type/{typeId}', [SpeakersController::class, 'byType']);

Route::apiResource('partners', PartnerController::class);
Route::get('/our-partners', [PartnerController::class, 'partnersList']);

Route::post('/contact', [ContactController::class, 'sendContactEmail']);

Route::post('/register', [RegistrationController::class, 'store']);
