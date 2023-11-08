<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    public function index(Request $request){
        $data = array();
        $data['errors'] = array(
            1 => ['Error: Username/Email and password combination OR Account does not exist.', 'danger'],
            2 => ['You are now logged out', 'primary'],
            3 => ['A new expenses has been saved.', 'primary'],
            4 => ['Error: Your Session has been expired, please log in again.', 'danger'],
            5 => ['Error: Access Denied.', 'danger'],
        );
        if(!empty($request->input('err'))) {$data['err'] = $request->input('err');}

        return view('login', $data);
    }


    public function login(Request $request){
        $data = array();

        $data['inputs'] = $request->input();
        $data['search'] = $userdata = DB::table('main_users')
            ->join('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('email', $request->input('email'))
            ->where('password', md5($request->input('password')))
            ->where('status', 'active')
            ->first();

        if (empty($data['search'])){
            return redirect()->route('loginScreen', ['err'=>1]); die();
        }

        $profile_pic = $userdata->photo;
        $userkey = [$userdata->id,$userdata->firstname,$userdata->middlename,$userdata->lastname,$userdata->email,$userdata->accounttype,$userdata->photo,date('ymdHis')];
        $user_id = encrypt(implode($userkey, ','));
        $request->session()->put('sessionkey', $user_id);
        session(['sessionkey' => $user_id]);

        $goto = 'null';
        if($userdata->accounttype == 'admin') $goto = 'admin';
        if($userdata->accounttype == 'registrar') $goto = 'admin';
        if($userdata->accounttype == 'cashier') $goto = 'admin';
        if($userdata->accounttype == 'student') $goto = 'portal';
        if($userdata->accounttype == 'teacher') $goto = 'teacher';
        if($userdata->accounttype == 'alumni') $goto = 'alumni';
        return redirect()->to($goto);
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect()->route('loginScreen', ['err' => 2]);
    }
}
