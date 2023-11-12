<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;

class RegistrarController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('axuadmin');
    }

    public $default_url = "adminregistrar";
    public $default_lpp = 25;
    public $default_start_page = 1;


    public function adminregistrar(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['errorlist'] = [
            1 => 'All forms are required please try again.',
            2 => 'Your password is too short, it should be at least 8 characters long.',
            3 => 'Both password and retype password are not the same.',
            4 => 'The email already existed, please try to check the user on the list.',
            5 => 'This user does not exist',
            6 => 'Status should only be Active or Inactive',
            7 => 'No Image has been Uploaded',
            8 => 'Enter right amount.',
            9 => 'Image is over 2MB.'
        ];
        $data['error'] = 0;
        if (!empty($_GET['e'])) {
            $data['error'] = $_GET['e'];
        }

        $data['notiflist'] = [
            1 => 'New Registrar has been saved.',
            2 => 'Changes has been saved.',
            3 => 'Password has been changed.',
            4 => 'Registrar has been updated.',
            5 => 'Image has been updated',
            6 => 'Tuition has been updated.',
            7 => 'Section has been changed',
        ];
        $data['notif'] = 0;
        if (!empty($_GET['n'])) {
            $data['notif'] = $_GET['n'];
        }

        $query = $request->query();
        $qstring = array();

        $lpp = $this->default_lpp;

        $lineperpage = [3, 25, 50, 100, 200];
        if(!empty($query['lpp'])){
            if(in_array($query['lpp'], $lineperpage)){
                $lpp = $query['lpp'];
            }
        }
        $data['lpp'] = $qstring['lpp'] = $lpp;

        $keyword = '';
        if(!empty($query['keyword'])){
            $qstring['keyword'] = $keyword = $query['keyword'];
            $data['keyword'] = $keyword;
        }

        $data['sort'] = 0;
        $data['orderbylist'] = [
            ['display'=>'Default', 'field'=>'main_users.id' ],
            ['display'=>'Username/Email', 'field'=>'main_users.email'],
            ['display'=>'Last Name', 'field'=>'main_users_details.lastname' ],
            ['display'=>'First Name', 'field'=>'main_users_details.firstname' ],
            ['display'=>'Middle Name', 'field'=>'main_users_details.middlename' ],
        ];
        if (!empty($query['sort'])) {
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }

        $page = $this->default_start_page;
        if (!empty($query['page'])) {
            $page = $query['page'];
        }

        $qstring['page'] = $page;
        $countdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('accounttype', 'registrar')
            ->count();
        $dbdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('accounttype', 'registrar')
            ->select(
                'main_users.*',
                'main_users_details.firstname',
                'main_users_details.middlename',
                'main_users_details.lastname',
                'main_users_details.mobilenumber',
                'main_users_details.address',
                'main_users_details.photo',
            );

        if(!empty($keyword)){
            $countdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->leftjoin('curriculums', 'curriculums.id', '=', 'students.sectionid')
            ->where('accounttype', 'registrar')
            ->where('main_users.email', 'like', "%$keyword%")
            ->orwhere('main_users_details.firstname', 'like', "%$keyword%")
            ->orwhere('main_users_details.middlename', 'like', "%$keyword%")
            ->orwhere('main_users_details.lastname', 'like', "%$keyword%")
            ->orwhere('main_users_details.mobilenumber', 'like', "%$keyword%")
            ->orwhere('main_users_details.address', 'like', "%$keyword%")
            ->count();

            $dbdata->where('main_users.email', 'like', "%$keyword%")->where('accounttype', 'registrar');
            $dbdata->orwhere('main_users_details.firstname', 'like', "%$keyword%")->where('accounttype', 'registrar');
            $dbdata->orwhere('main_users_details.middlename', 'like', "%$keyword%")->where('accounttype', 'registrar');
            $dbdata->orwhere('main_users_details.lastname', 'like', "%$keyword%")->where('accounttype', 'registrar');
            $dbdata->orwhere('main_users_details.mobilenumber', 'like', "%$keyword%")->where('accounttype', 'registrar');
            $dbdata->orwhere('main_users_details.address', 'like', "%$keyword%")->where('accounttype', 'registrar');
        }

        $dbdata->orderBy($data['orderbylist'][$data['sort']]['field']);

        $data['totalpages'] = ceil($countdata / $lpp);
        $data['page'] = $page;
        $data['totalitems'] = $countdata;
        $dataoffset = ($page*$lpp)-$lpp;

        $dbdata->offset($dataoffset)->limit($lpp);
        $data['qstring'] = http_build_query($qstring);
        $data['qstring2'] = $qstring;

        if ($page < 2) {
            //disabled URLS of first and previous button
            $data['page_first_url'] = '<a class="btn btn-dark disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-left fa-xs"></i> </a>';
            $data['page_prev_url'] = '<a class="btn btn-dark disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-left fa-xs"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = 1; //firstpage
            $data['page_first_url'] = '<a class="btn btn-dark" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-left fa-xs"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] - 1; // current page minus 1 for prev
            $data['page_prev_url'] = '<a class="btn btn-dark" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-left fa-xs"></i> </a>';
        }
        if ($page >= $data['totalpages']) {
            //disabled URLS on next and last button
            $data['page_last_url'] = '<a class="btn btn-dark disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-right fa-xs"></i> </a>';
            $data['page_next_url'] = '<a class="btn btn-dark disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-right fa-xs"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = $data['totalpages']; //lastpage
            $data['page_last_url'] = '<a class="btn btn-dark" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-right fa-xs"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] + 1; //nest page
            $data['page_next_url'] = '<a class="btn btn-dark" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-right fa-xs"></i> </a>';
        }

        $data['dbresult'] = $dbresult = $dbdata->get()->toArray();

        return view('admin.adminregistrar', $data);
    }

    public function adminregistrar_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        return view('admin.adminregistrar_add', $data);
    }

    public function adminregistrar_add_process(Request $request) {
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input(); print_r($input);
        //error: required forms
        if (empty($input['email']) || empty($input['password']) || empty($input['password2']) || empty($input['firstname']) || empty($input['lastname']) || empty($input['status'])) { return redirect($this->default_url.'?e=1'); die(); }
        //error: at least 8 chars long on password
        if (strlen($input['password']) < 8) { return redirect($this->default_url.'?e=2'); die(); }
        //error: both password should be the same
        if ($input['password'] != $input['password2']) { return redirect($this->default_url.'?e=3'); die(); }
        //check if email is existing
        $chkemail = DB::table('main_users')->where('email', $input['email'])->first();
        if (!empty($chkemail->email)) {
            return redirect($this->default_url.'?e=4');
            die();
        }

        $maxSize = 2 * 1024 * 1024;
        if($request->hasFile('image')){
            $size = $request->file('image')->getSize();
            if($size > $maxSize){
                return redirect($this->default_url.'?e=8');
                die();
            }
        }

        $muserid = DB::table('main_users')->insertGetId([
            'email' => $input['email'] . '@tiftci.org',
            'password' => md5($input['password']),
            'accounttype' => 'registrar',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        $photo = 'blank.jpg';
        if($request->hasFile('image')){
            $destinationPath = 'public/images';
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = $muserid . '.' . $extension;
            $path = $request->file('image')->storeAs($destinationPath, $filename);
            $photo = $filename;
        }

        DB::table('main_users_details')->insert([
            'userid' => $muserid,
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'middlename' => !empty($input['middlename']) ? $input['middlename'] : '',
            'mobilenumber' => !empty($input['mobilenumber']) ? $input['mobilenumber'] : '',
            'address' => !empty($input['address']) ? $input['address'] : '',
            'photo' => $photo,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        return redirect($this->default_url.'?n=1'); die();
    }

    public function adminregistrar_edit(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        if(empty($query['id'])){
            die('Error: Requirements are not complete');
        }

        $data['dbdata'] = $dbdata = DB::table('main_users')
            ->select('main_users.*', 'main_users_details.firstname', 'main_users_details.middlename', 'main_users_details.lastname', 'main_users_details.mobilenumber', 'main_users_details.address', 'main_users_details.photo')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('main_users.accounttype', 'registrar')
            ->where('main_users.id', $query['id'])
            ->first();

        return view('admin.adminregistrar_edit', $data);
    }

    public function adminregistrar_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['did']) || empty($input['email']) || empty($input['firstname']) || empty($input['lastname'])){
            return redirect($this->default_url.'?e=1');
            die();
        }

        $logindata = DB::table('main_users')->where('id', $input['did'])->where('accounttype', 'registrar')->first();
        if(empty($logindata)){
            return redirect($this->default_url.'?e=5');
            die();
        }

        DB::table('main_users')
            ->where('id', $input['did'])
            ->update([
                'email' => $input['email'] . '@tiftci.org',
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

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

        return redirect($this->default_url.'?n=2');
    }

    public function adminregistrar_pass_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();


        if(empty($input['did']) || empty($input['password']) || empty($input['password2'])){
            return redirect($this->default_url.'?e=1');
            die();
        }

        if(strlen($input['password']) < 8){
            return redirect($this->default_url.'?e=2');
            die();
        }

        if($input['password'] != $input['password2']){
            return redirect($this->default_url.'?e=3');
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->where('accounttype', 'registrar')
            ->first();

        if(empty($logindata)){
            return redirect($this->default_url.'?e=5');
            die();
        }

        DB::table('main_users')
            ->where('id', $input['did'])
            ->update([
                'password' => md5($input['password']),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=3');
    }

    public function adminregistrar_image_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $input = $request->input();

        // Get the current photo to delete later
        $photo = DB::table('main_users_details')
            ->select('main_users_details.photo')
            ->where('userid', $input['did'])
            ->first();

        $maxSize = 2 * 1024 * 1024;
        if($request->hasFile('image')){
            $size = $request->file('image')->getSize();
            if($size > $maxSize){
                return redirect($this->default_url.'?e=8');
                die();
            }
        }


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
            return redirect($this->default_url.'?e=7');
            die();
        }


        DB::table('main_users_details')
            ->where('userid', $input['did'])
            ->update([
                'photo' => $photo,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=5');
    }

    public function  adminregistrar_archive_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : $this->default_lpp,
            'page' => !empty($input['page']) ? $input['page'] : $this->default_start_page,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : '',
        ]);

        if (empty($input['did'])) {
            return redirect($this->default_url . '?e=1&' . $qstring);
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->where('accounttype', 'registrar')
            ->first();

        if (empty($logindata)) {
            return redirect($this->default_url . '?e=5&' . $qstring);
            die();
        }

        if($logindata->status == 'active'){
            DB::table('main_users')
                ->where('id', $input['did'])
                ->update([
                    'status' => "inactive",
                ]);
        } else {
            DB::table('main_users')
                ->where('id', $input['did'])
                ->update([
                    'status' => "active",
                ]);
        }

        return redirect($this->default_url . '?n=4&' . $qstring);
    }

    public function regreport(Request $request){
        $query = $request->query();
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['selected'] = $selected = DB::table('appointments')
            ->where('active', 'Completed')
            ->whereBetween('appointeddate', [$query['start'] . ' 00:00:00', $query['end'] . ' 23:59:59'])
            ->get()
            ->toArray();

        $data['goodmoral'] = $goodmoral = DB::table('appointments')
            ->where('goodmoral', '1')
            ->where('active', 'Completed')
            ->whereBetween('appointeddate', [$query['start'] . ' 00:00:00', $query['end'] . ' 23:59:59'])
            ->count();

        $data['registration'] = $registration = DB::table('appointments')
            ->where('registration', '1')
            ->where('active', 'Completed')
            ->whereBetween('appointeddate', [$query['start'] . ' 00:00:00', $query['end'] . ' 23:59:59'])
            ->get()
            ->count();
        $data['f138'] = $f138 = DB::table('appointments')
            ->where('f138', '1')
            ->where('active', 'Completed')
            ->whereBetween('appointeddate', [$query['start'] . ' 00:00:00', $query['end'] . ' 23:59:59'])
            ->get()
            ->count();
        $data['others'] = $others = DB::table('appointments')
            ->where('others', '1')
            ->where('active', 'Completed')
            ->whereBetween('appointeddate', [$query['start'] . ' 00:00:00', $query['end'] . ' 23:59:59'])
            ->get()
            ->count();
        $data['start'] = $query['start'];
        $data['end'] = $query['end'];

        $pdf = PDF::loadview('admin.appointmentreportpdf', $data);
        return $pdf->stream('appointmentreport.pdf');
        dd($selected);
    }
}
