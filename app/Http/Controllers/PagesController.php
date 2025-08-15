<?php

namespace App\Http\Controllers;

use PDO;
use Carbon\Carbon;
use App\Models\News;
use App\Models\Career;
use App\Models\Festival;
use Illuminate\Http\Request;

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

    public function teamList(){

        return view('web.teamList');
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

    public function livingMemoryVault(){

        return view('web.livingMemoryVault');
    }

    public function theKipenzi(){

        return view('web.theKipenzi');
    }

    public function volunteerWithUs(){

        return view('web.volunteerWithUs');
    }

    public function newsList(){

        return view('web.newsList');
    }

    public function viewNews($id){

        $news = News::findOrFail($id);

        return view('web.viewNews', compact('news'));
    }

    public function careers(){

        return view('web.careers');
    }

    public function viewCareer($id){

        $career = Career::findOrFail($id);

        return view('web.viewCareer', compact('career'));
    }
}
