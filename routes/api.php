<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\SpeakersController;

Route::apiResource('festivals', FestivalController::class);
Route::apiResource('speakers', SpeakersController::class);
