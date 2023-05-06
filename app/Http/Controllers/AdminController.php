<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    //------------------------
    // Constructs
    //------------------------
    public function __construct(Request $request) {
        $this->middleware('axuadmin'); //only admin can enter here
    }

    //-----------------------
    // Default variables
    //-----------------------
    public $default_url_adminuser = "/adminuser";   //default return URL
    public $default_lpp = 25;                       //default line per page
    public $default_start_page = 1;                 //default starting page

    //------------------------
    // Admin Dashboard
    //------------------------
    public function index(Request $request) {
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['studentcount'] = $studentcount = DB::table('main_users')
            ->where('accounttype', 'student')
            ->count();
        $data['teachercount'] = $teachercount = DB::table('main_users')
            ->where('accounttype', 'teacher')
            ->count();
        $data['admincount'] = $admincount = DB::table('main_users')
            ->where('accounttype', 'admin')
            ->count();



        return view('admin.home', $data);
    }

    //------------------------
    // Admin User Main Page
    //------------------------
    public function adminuser(Request $request) {
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo'); //print_r($userinfo);
        //Array ( [0] => 1 [1] => Dhon [2] => Collera [3] => Cunanan [4] => me@dhonc.com [5] => admin [6] => blank.jpg [7] => 230315183724 )

        //error lists
        $data['errorlist'] = [
            1 => 'All forms are required please try again.',
            2 => 'Your password is too short, it should be at least 8 characters long.',
            3 => 'Both password and retype password are not the same.',
            4 => 'The email already existed, please try to check the user on the list.',
            5 => 'This user doed not exist',
            6 => 'Status should only be Active or Inactive',
            7 => 'No Image has been Uploaded',
        ];
        $data['error'] = 0;
        if (!empty($_GET['e'])) {
            $data['error'] = $_GET['e'];
        }

        //notification lists
        $data['notiflist'] = [
            1 => 'New User has been saved.',
            2 => 'Changes has been saved.',
            3 => 'Password has been changed.',
            4 => 'User has been deleted.',
            5 => 'Image has been updated'
        ];
        $data['notif'] = 0;
        if (!empty($_GET['n'])) {
            $data['notif'] = $_GET['n'];
        }

        $query = $request->query(); //print_r($query);
        $qstring = array(); //querystrings

        //lines per page section
        $lpp = $this->default_lpp;
        //urlperline
        $lineperpage = [ 3, 25, 50, 100, 200 ];
        if (!empty($query['lpp'])) {
            if (in_array($query['lpp'], $lineperpage)) {
                $lpp = $query['lpp'];
            }
        }
        $data['lpp'] = $qstring['lpp'] = $lpp;

        //keyword section
        $keyword = '';
        if (!empty($query['keyword'])) {
            $qstring['keyword'] = $keyword = $query['keyword'];
            $data['keyword'] = $keyword;
        }

        //orderby
        $data['sort'] = 0;
        $data['orderbylist'] = [
            ['display'=>'ID', 'field'=>'main_users.id' ],
            ['display'=>'Username/Email', 'field'=>'main_users.email'],
            ['display'=>'Last Name', 'field'=>'main_users_details.lastname' ],
            ['display'=>'First Name', 'field'=>'main_users_details.firstname' ],
            ['display'=>'Middle Name', 'field'=>'main_users_details.middlename' ],
        ];
        if (!empty($query['sort'])) {
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }


        //paging section
        $page = $this->default_start_page;
        if (!empty($query['page'])) {
            $page = $query['page'];
        }
        $qstring['page'] = $page;
        $countdata = DB::table('main_users')->leftJoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')->where('accounttype', 'admin')->count();
        $dbdata = DB::table('main_users')->select('main_users.*', 'main_users_details.firstname', 'main_users_details.lastname', 'main_users_details.middlename', 'main_users_details.mobilenumber', 'main_users_details.address',)
            ->leftJoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('accounttype', 'admin');
        if (!empty($keyword)) {

            $countdata = DB::table('main_users')->leftJoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')->where('accounttype', 'admin')
                ->Where('main_users.email', 'like', "%$keyword%")
                ->orWhere('main_users_details.firstname', 'like', "%$keyword%")
                ->orWhere('main_users_details.lastname', 'like', "%$keyword%")
                ->orWhere('main_users_details.middlename', 'like', "%$keyword%")
                ->orWhere('main_users_details.mobilenumber', 'like', "%$keyword%")
                ->orWhere('main_users_details.address', 'like', "%$keyword%")
                ->count();

            $dbdata->Where('main_users.email', 'like', "%$keyword%");
            $dbdata->orWhere('main_users_details.firstname', 'like', "%$keyword%");
            $dbdata->orWhere('main_users_details.lastname', 'like', "%$keyword%");
            $dbdata->orWhere('main_users_details.middlename', 'like', "%$keyword%");
            $dbdata->orWhere('main_users_details.mobilenumber', 'like', "%$keyword%");
            $dbdata->orWhere('main_users_details.address', 'like', "%$keyword%");

        }
        //orderby
        $dbdata->orderBy($data['orderbylist'][$data['sort']]['field']);

        //compute pages
        $data['totalpages'] = ceil($countdata / $lpp);
        $data['page'] = $page;
        $data['totalitems'] = $countdata;
        $dataoffset = ($page*$lpp)-$lpp; //echo $dataoffset;
        //add paging on data
        $dbdata->offset($dataoffset)->limit($lpp);
        $data['qstring'] = http_build_query($qstring);
        $data['qstring2'] = $qstring;

        //paging URL settings
        if ($page < 2) {
            //disabled URLS of first and previous button
            $data['page_first_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-left fa-xs"></i> </a>';
            $data['page_prev_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-left fa-xs"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = 1; //firstpage
            $data['page_first_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-left fa-xs"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] - 1; // current page minus 1 for prev
            $data['page_prev_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-left fa-xs"></i> </a>';
        }
        if ($page >= $data['totalpages']) {
            //disabled URLS on next and last button
            $data['page_last_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-right fa-xs"></i> </a>';
            $data['page_next_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-right fa-xs"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = $data['totalpages']; //lastpage
            $data['page_last_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-right fa-xs"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] + 1; //nest page
            $data['page_next_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-right fa-xs"></i> </a>';
        }

        $data['dbresult'] = $dbresult = $dbdata->get()->toArray();

        return view('admin.adminusers', $data);
    }


    public function adminuser_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        return view('admin.adminusers_add', $data);
    }

    public function adminuser_add_process(Request $request) {
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input(); print_r($input);
        //error: required forms
        if (empty($input['email']) || empty($input['password']) || empty($input['password2']) || empty($input['firstname']) || empty($input['lastname']) || empty($input['status'])) { return redirect($this->default_url_adminuser.'?e=1'); die(); }
        //error: at least 8 chars long on password
        if (strlen($input['password']) < 8) { return redirect($this->default_url_adminuser.'?e=2'); die(); }
        //error: both password should be the same
        if ($input['password'] != $input['password2']) { return redirect($this->default_url_adminuser.'?e=3'); die(); }
        //check if email is existing
        $chkemail = DB::table('main_users')->Where('email', $input['email'])->first();
        if (!empty($chkemail->email)) { return redirect($this->default_url_adminuser.'?e=4'); die(); }

        $muserid = DB::table('main_users')->insertGetId([
            'email' => $input['email'],
            'password' => md5($input['password']),
            'accounttype' => 'admin',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        $photo = 'blank.jpg';
        if($request->hasFile('image')){
            $destinationPath = 'public/images';
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destinationPath,$imageName);

            $photo = $imageName;
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

        return redirect($this->default_url_adminuser.'?n=1'); die();
    }

    public function adminuser_edit(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        if(empty($query['id'])){
            die('Error: Requirements are not complete');
        }

        $data['dbdata'] = $dbdata = DB::table('main_users')
            ->select('main_users.*', 'main_users_details.firstname', 'main_users_details.middlename', 'main_users_details.lastname', 'main_users_details.mobilenumber', 'main_users_details.address', 'main_users_details.photo')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('main_users.accounttype', 'admin')
            ->where('main_users.id', $query['id'])
            ->first();

        return view('admin.adminusers_edit', $data);
    }

    public function adminuser_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['did']) || empty($input['firstname']) || empty($input['lastname']) || empty($input['status'])){
            return redirect($this->default_url_adminuser.'?e=1');
            die();
        }

        if($input['status'] != 'active' && $input['status'] != 'inactive'){
            return redirect($this->default_url_adminuser.'?e=6');
            die();
        }

        $logindata = DB::table('main_users')->where('id', $input['did'])->where('accounttype', 'admin')->first();
        if(empty($logindata)){
            return redirect($this->default_url_adminuser.'?e=5');
            die();
        }

        DB::table('main_users')
            ->where('id', $input['did'])
            ->update([
                'status' => $input['status'],
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

        return redirect($this->default_url_adminuser.'?n=2');
    }

    public function adminuser_pass_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();


        if(empty($input['did']) || empty($input['password']) || empty($input['password2'])){
            return redirect($this->default_url_adminuser.'?e=1');
            die();
        }

        if(strlen($input['password']) < 8){
            return redirect($this->default_url_adminuser.'?e=2');
            die();
        }

        if($input['password'] != $input['password2']){
            return redirect($this->default_url_adminuser.'?e=3');
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->where('accounttype', 'admin')
            ->first();

        if(empty($logindata)){
            return redirect($this->default_url_adminuser.'?e=5');
            die();
        }

        DB::table('main_users')
            ->where('id', $input['did'])
            ->update([
                'password' => md5($input['password']),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url_adminuser.'?n=3');
    }

    public function adminuser_image_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $input = $request->input();
        $photo = DB::table('main_users_details')
            ->select('main_users_details.photo')
            ->where('userid', $input['did'])
            ->first();


        if($request->hasFile('image')){
            $destinationPath = 'public/images';
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destinationPath,$imageName);

            $photo = $imageName;
        } else {
            return redirect($this->default_url_adminuser.'?e=7');
            die();
        }

        DB::table('main_users_details')
            ->where('userid', $input['did'])
            ->update([
                'photo' => $photo,
                'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        return redirect($this->default_url_adminuser.'?n=5');
    }

    public function adminuser_delete_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : $this->default_lpp,
            'page' => !empty($input['page']) ? $input['page'] : $this-> default_start_page,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : '',
        ]);

        if(empty($input['did'])){
            return redirect($this->default_url_adminuser.'?e=1&'.$qstring);
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->where('accounttype', 'admin')
            ->first();

        if(empty($logindata)){
            return redirect($this->default_url_adminuser.'?e=5&'.$qstring);
            die();
        }

        DB::table('main_users')
            ->where('id', $input['did'])
            ->delete();

        return redirect($this->default_url_adminuser.'?n=4&'.$qstring);
    }
}

