<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AppointmentController extends Controller
{
    public function index(Request $request){
        return view('appointment_add');
    }

    public function appointment_add_process(Request $request){

    }
}
