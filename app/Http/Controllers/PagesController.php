<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Festival;
use Illuminate\Http\Request;
use PDO;

class PagesController extends Controller
{

    public function aboutUs(){

          $nextFestival = Festival::where('start_at', '>=', Carbon::now())
            ->orderBy('end_at', 'asc')
            ->first();

        return view('web.aboutUs', compact('nextFestival'));
    }

    public function writingLab(){



        return view('web.writingLab');
    }

    public function speakersList(){

        return view('web.speakersList');
    }

    public function ourPartners(){

        return view('web.ourPartners');
    }

    public function contactus(){

        return view('web.contactus');
    }

    public function eventsSchedule(){

        return view('web.eventsSchedule');
    }

    public function privacyPolicy(){

        return view('web.privacyPolicy');
    }

    public function temsConditions(){

        return view('web.temsConditions');
    }

    public function bookingNow(){

        return view('web.bookingNow');
    }
}
