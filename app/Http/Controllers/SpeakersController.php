<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpeakersController extends Controller
{
    public function allSpeakers(){

        return view('dashboards.admin.allSpeakers');
    }
}
