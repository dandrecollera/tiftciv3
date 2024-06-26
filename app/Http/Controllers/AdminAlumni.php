<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminAlumni extends Controller
{
    public function __construct(Request $request){
        $this->middleware('axuadmin');
    }

    public $default_url = "adminalumni";
    public $default_lpp = 25;
    public $default_start_page = 1;


    public $default_accounttype = 'alumni';

    public function adminalumni(Request $request){
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
            1 => 'New Alumni has been saved.',
            2 => 'Changes has been saved.',
            3 => 'Password has been changed.',
            4 => 'Alumni has been updated.',
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
            ->where('accounttype', 'alumni')
            ->count();
        $dbdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('accounttype', 'alumni')
            ->select(
                'main_users.*',
                'main_users_details.firstname',
                'main_users_details.middlename',
                'main_users_details.lastname',
                'main_users_details.mobilenumber',
                'main_users_details.address',
                'main_users_details.lrn',
                'main_users_details.photo',
            );

        if(!empty($keyword)){
            $countdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->leftjoin('students', 'students.userid', '=', 'main_users.id')
            ->leftjoin('curriculums', 'curriculums.id', '=', 'students.sectionid')
            ->where('accounttype', 'alumni')
            ->where('main_users.email', 'like', "%$keyword%")
            ->orwhere('main_users_details.firstname', 'like', "%$keyword%")
            ->orwhere('main_users_details.middlename', 'like', "%$keyword%")
            ->orwhere('main_users_details.lastname', 'like', "%$keyword%")
            ->orwhere('main_users_details.mobilenumber', 'like', "%$keyword%")
            ->orwhere('main_users_details.address', 'like', "%$keyword%")
            ->count();

            $dbdata->where('main_users.email', 'like', "%$keyword%")->where('accounttype', 'alumni');
            $dbdata->orwhere('main_users_details.firstname', 'like', "%$keyword%")->where('accounttype', 'alumni');
            $dbdata->orwhere('main_users_details.middlename', 'like', "%$keyword%")->where('accounttype', 'alumni');
            $dbdata->orwhere('main_users_details.lastname', 'like', "%$keyword%")->where('accounttype', 'alumni');
            $dbdata->orwhere('main_users_details.mobilenumber', 'like', "%$keyword%")->where('accounttype', 'alumni');
            $dbdata->orwhere('main_users_details.address', 'like', "%$keyword%")->where('accounttype', 'alumni');
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

        return view('admin.adminalumni', $data);
    }

    public function adminalumni_add(Request $request){
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
            1 => 'New Student has been saved.',
            2 => 'Changes has been saved.',
            3 => 'Password has been changed.',
            4 => 'Student has been updated.',
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
            ->where('accounttype', 'student')
            ->count();
        $dbdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('accounttype', 'student')
            ->select(
                'main_users.*',
                'main_users_details.firstname',
                'main_users_details.middlename',
                'main_users_details.lastname',
                'main_users_details.mobilenumber',
                'main_users_details.address',
                'main_users_details.lrn',
                'main_users_details.photo',
            );

        if(!empty($keyword)){
            $countdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->leftjoin('students', 'students.userid', '=', 'main_users.id')
            ->leftjoin('curriculums', 'curriculums.id', '=', 'students.sectionid')
            ->where('accounttype', 'student')
            ->where('main_users.email', 'like', "%$keyword%")
            ->orwhere('main_users_details.firstname', 'like', "%$keyword%")
            ->orwhere('main_users_details.middlename', 'like', "%$keyword%")
            ->orwhere('main_users_details.lastname', 'like', "%$keyword%")
            ->orwhere('main_users_details.mobilenumber', 'like', "%$keyword%")
            ->orwhere('main_users_details.address', 'like', "%$keyword%")
            ->count();

            $dbdata->where('main_users.email', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('main_users_details.firstname', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('main_users_details.middlename', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('main_users_details.lastname', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('main_users_details.mobilenumber', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('main_users_details.address', 'like', "%$keyword%")->where('accounttype', 'student');
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

        return view('admin.adminalumni_add', $data);
    }

    public function adminalumni_add_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();


        DB::table('main_users')
            ->where('id', $query['did'])
            ->update([
                'accounttype' => 'alumni',
            ]);

        return redirect('adminalumni?n=1');
    }

    public function adminalumni_batchadd(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('admin.adminalumni_batchadd');
    }

    public function adminalumni_batchadd_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        if($request->hasFile('csvupload')){
            $file = $request->file('csvupload');
            $handle = fopen($file, 'r');

            $header = fgetcsv($handle);

            while(($data = fgetcsv($handle)) !== false){
                $userdetails = DB::table('main_users_details')
                    ->where('lrn', $data[0])
                    ->first();

                DB::table('main_users')
                    ->where('id', $userdetails->userid)
                    ->update([
                        'accounttype' => 'alumni',
                        'password' => md5('password123')
                    ]);
            }
        }

        return redirect('adminalumni?n=1');
    }

    public function adminalumni_edit(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        if(empty($query['id'])){
            die('Error: Requirements are not complete');
        }

        $data['dbdata'] = $dbdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('accounttype', 'alumni')
            ->where('main_users.id', $query['id'])
            ->select(
                'main_users.*',
                'main_users_details.firstname',
                'main_users_details.middlename',
                'main_users_details.lastname',
                'main_users_details.mobilenumber',
                'main_users_details.address',
                'main_users_details.photo',
                'main_users_details.lrn',
            )
            ->first();

        return view('admin.adminalumni_edit', $data);
    }

    public function adminalumni_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['did']) || empty($input['lrn']) || empty($input['email']) || empty($input['firstname']) || empty($input['lastname']) ){
            return redirect($this->default_url.'?e=1');
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->where('accounttype', $this->default_accounttype)
            ->first();


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
                'lrn' => $input['lrn'],
                'firstname' => $input['firstname'],
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : '',
                'lastname' => $input['lastname'],
                'mobilenumber' => !empty($input['mobilenumber']) ? $input['mobilenumber'] : '',
                'address' => !empty($input['address']) ? $input['address'] : '',
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=2');
    }

    public function adminalumni_pass_process(Request $request){
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
            ->where('accounttype', $this->default_accounttype)
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

    public function adminalumni_image_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');


        $input = $request->input();
        $photo = DB::table('main_users_details')
            ->select('main_users_details.photo')
            ->where('userid', $input['did'])
            ->first();

        $maxSize = 2 * 1024 * 1024;
        if($request->hasFile('image')){
            $size = $request->file('image')->getSize();
            if($size > $maxSize){
                return redirect($this->default_url.'?e=9');
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

    public function adminalumni_archive_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : $this->default_lpp,
            'page' => !empty($input['page']) ? $input['page'] : $this->default_start_page,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : '',
        ]);

        if(empty($input['did'])){
            return redirect('/adminalumni?e=1%'.$qstring);
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->where('accounttype', 'alumni')
            ->first();

        if(empty($logindata)){
            return redirect('/adminalumni?e=5&'.$qstring);
            die();
        }

        if($logindata->status == 'active'){
            DB::table('main_users')
                ->where('id', $input['did'])
                ->update([
                    'status' => 'inactive',
                ]);
        } else {
            DB::table('main_users')
                ->where('id', $input['did'])
                ->update([
                    'status' => 'active',
                ]);
        }

        return redirect('/adminalumni?n=4&'.$qstring);
    }

}
