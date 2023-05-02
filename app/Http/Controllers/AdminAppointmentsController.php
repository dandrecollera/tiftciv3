<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class AdminAppointmentsController extends Controller
{
    public function __construct(Request $request) {
        $this->middleware('axuadmin');
    }

    public $default_url = '/adminappointments';
    public $default_lpp = 25;
    public $default_start_page = 1;

    public function adminappointments(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        return view('admin.appointments', $data);
    }
}
