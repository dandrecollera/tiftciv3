<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function adminsetting_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['did']) || empty($input['firstname']) || empty($input['lastname'])){
            return redirect('adminsettings?e=1');
            die();
        }

        $logindata = DB::table('main_users')->where('id', $input['did'])->where('accounttype', 'admin')->first();
        if(empty($logindata)){
            return redirect('adminsettings?e=5');
            die();
        }

        DB::table('main_users_details')
            ->where('userid', $input['did'])
            ->update([
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : '',
                'mobilenumber' => !empty($input['mobilenumber']) ? $input['mobilenumber'] : '',
                'address' => !empty($input['address']) ? $input['address'] : '',
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);


        $newuser = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('main_users.id', $userinfo[0])
            ->first();

        $userkey = [
            $newuser->id,
            $newuser->firstname,
            $newuser->middlename,
            $newuser->lastname,
            $newuser->email,
            $newuser->accounttype,
            $newuser->photo,
            date('ymdHis')
        ];

        $user_id = encrypt(implode($userkey, ','));
        $request->session()->put('sessionkey', $user_id);
        session(['sessionkey' => $user_id]);

        return redirect('adminsettings?n=2');
    }

    public function adminsetting_pass_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();


        if(empty($input['did']) || empty($input['password']) || empty($input['password2'])){
            return redirect('adminsettings?e=1');
            die();
        }

        if(strlen($input['password']) < 8){
            return redirect('adminsettings?e=2');
            die();
        }

        if($input['password'] != $input['password2']){
            return redirect('adminsettings?e=3');
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->where('accounttype', 'admin')
            ->first();

        if(empty($logindata)){
            return redirect('adminsettings?e=5');
            die();
        }

        DB::table('main_users')
            ->where('id', $input['did'])
            ->update([
                'password' => md5($input['password']),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);


        $newuser = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('main_users.id', $userinfo[0])
            ->first();

        $userkey = [
            $newuser->id,
            $newuser->firstname,
            $newuser->middlename,
            $newuser->lastname,
            $newuser->email,
            $newuser->accounttype,
            $newuser->photo,
            date('ymdHis')
        ];

        $user_id = encrypt(implode($userkey, ','));
        $request->session()->put('sessionkey', $user_id);
        session(['sessionkey' => $user_id]);

        return redirect('adminsettings?n=3');
    }

    public function adminsetting_image_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $input = $request->input();

        // Get the current photo to delete later
        $photo = DB::table('main_users_details')
            ->select('main_users_details.photo')
            ->where('userid', $input['did'])
            ->first();

        if($request->hasFile('image')){
            $destinationPath = 'public/images';
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = $input['did'] . '.' . $extension;

            if(Storage::exists($destinationPath.'/'.$imageName)){
                Storage::delete($destinationPath.'/'.$imageName);
            }

            $path = $request->file('image')->storeAs($destinationPath, $imageName);
            $photo = $imageName;
        } else {
            return redirect('adminsettings?e=7');
            die();
        }


        DB::table('main_users_details')
            ->where('userid', $input['did'])
            ->update([
                'photo' => $photo,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        $newuser = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('main_users.id', $userinfo[0])
            ->first();

        $userkey = [
            $newuser->id,
            $newuser->firstname,
            $newuser->middlename,
            $newuser->lastname,
            $newuser->email,
            $newuser->accounttype,
            $newuser->photo,
            date('ymdHis')
        ];

        $user_id = encrypt(implode($userkey, ','));
        $request->session()->put('sessionkey', $user_id);
        session(['sessionkey' => $user_id]);

        return redirect('adminsettings?n=5');
    }
}
