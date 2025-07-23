<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FestivalController;

Route::apiResource('festivals', FestivalController::class);
