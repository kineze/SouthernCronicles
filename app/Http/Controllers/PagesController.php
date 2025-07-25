<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function speakersList(){

        return view('web.speakersList');
    }

    public function ourPartners(){

        return view('web.ourPartners');
    }
}
