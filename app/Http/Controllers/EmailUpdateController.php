<?php

namespace App\Http\Controllers;

use App\Mail\UpdateUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class EmailUpdateController extends Controller
{
    public function index(Request $request){
        $user = "dandre";
        $status = "active";
        Mail::to('dandrecollera@gmail.com')->send(new UpdateUser($user, $status));
    }
}
