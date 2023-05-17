<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminStudentController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('axuadmin');
    }

    public $default_url = "adminstudent";
    public $default_lpp = 25;
    public $default_start_page = 1;


    public $default_accounttype = 'student';


    public function adminstudent(Request $request){
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
            4 => 'Student has been deleted.',
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
            ['display'=>'Section', 'field'=>'sections.section_name' ],
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
            ->leftjoin('students', 'students.userid', '=', 'main_users.id')
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->where('accounttype', 'student')
            ->count();
        $dbdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->leftjoin('students', 'students.userid', '=', 'main_users.id')
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
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
                'sections.section_name',
                'sections.strand',
                'sections.yearlevel',
            );

        if(!empty($keyword)){
            $countdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->leftjoin('students', 'students.userid', '=', 'main_users.id')
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->where('accounttype', 'student')
            ->where('main_users.email', 'like', "%$keyword%")
            ->orwhere('main_users_details.firstname', 'like', "%$keyword%")
            ->orwhere('main_users_details.middlename', 'like', "%$keyword%")
            ->orwhere('main_users_details.lastname', 'like', "%$keyword%")
            ->orwhere('main_users_details.mobilenumber', 'like', "%$keyword%")
            ->orwhere('main_users_details.address', 'like', "%$keyword%")
            ->orwhere('sections.section_name', 'like', "%$keyword%")
            ->count();

            $dbdata->where('main_users.email', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('main_users_details.firstname', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('main_users_details.middlename', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('main_users_details.lastname', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('main_users_details.mobilenumber', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('main_users_details.address', 'like', "%$keyword%")->where('accounttype', 'student');
            $dbdata->orwhere('sections.section_name', 'like', "%$keyword%")->where('accounttype', 'student');
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

        return view('admin.adminstudent', $data);
    }

    public function adminstudent_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['sections'] = $sections = DB::table('sections')
            ->get()
            ->toArray();

        return view('admin.adminstudent_add', $data);
    }

    public function adminstudent_add_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['email']) || empty($input['lrn']) || empty($input['password']) || empty($input['password2']) || empty($input['firstname']) || empty($input['lastname']) || empty($input['status']) || empty($input['paymenttype']) || empty($input['paymentmethod'])){
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

        $checkemail = DB::table('main_users')
            ->where('email', $input['email'])
            ->first();
        if(!empty($checkemail->email)){
            return redirect($this->default_url.'?e=4');
            die();
        }

        $maxSize = 2 * 1024 * 1024;
        if($request->hasFile('image')){
            $size = $request->file('image')->getSize();
            if($size > $maxSize){
                return redirect($this->default_url.'?e=9');
                die();
            }
        }

        $muserid = DB::table('main_users')
            ->insertGetID([
                'email' => $input['email'],
                'password' => md5($input['password']),
                'accounttype' => 'student',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        DB::table('students')
            ->insert([
                'userid' => $muserid,
                'sectionid' => $input['section'],
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


        DB::table('main_users_details')
            ->insert([
                'userid' => $muserid,
                'lrn' => $input['lrn'],
                'strand' => $input['strand'],
                'yearlevel' => $input['yearlevel'],
                'firstname' => $input['firstname'],
                'middlename' => !empty($input['middlename']) ? $input['middlename'] : '',
                'lastname' => $input['lastname'],
                'mobilenumber' => !empty($input['mobilenumber']) ? $input['mobilenumber'] : '',
                'address' => !empty($input['address']) ? $input['address'] : '',
                'photo' => $photo,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        $voucher = 0;
        $tuition = 0;
        $registration = 0;
        if($input['paymenttype'] == 'public'){
            $voucher = 17500.00;
            $tuition = 0.00;
            $registration = 1000.00;
        } else if($input['paymenttype'] == 'semi'){
            $voucher = 14000.00;
            $tuition = 3500.00;
            $registration = 1000.00;
        } else {
            $voucher = 0.00;
            $tuition = 17500.00;
            $registration = 1000.00;
        }

        if($input['paymentmethod'] == 'full'){
            $voucher = 0;
            $tuition = 0;
            $registration = 0;
        }

        $latestyear = DB::table('schoolyears')
            ->orderBy('school_year', 'desc')
            ->first();

        DB::table('tuition')
            ->insert([
                'userid' => $muserid,
                'yearid' => $latestyear->id,
                'paymenttype' => $input['paymenttype'],
                'paymentmethod' => $input['paymentmethod'],
                'voucher' => $voucher,
                'tuition' => $tuition,
                'registration' => $registration,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=1');
    }


    public function adminstudent_batchadd(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('admin.adminstudent_batchadd', $data);
    }

    public function adminstudent_batchadd_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $sample = array();
        if($request->hasFile('csvupload')){
            $file = $request->file('csvupload');
            $handle = fopen($file, 'r');

            $header =fgetcsv($handle);

            while(($data = fgetcsv($handle)) !== false){
                $emailfirst_parts = explode(' ', $data[0]);
                $emailfirst = strtolower($emailfirst_parts[0]);
                $emaillast = strtolower(str_replace(' ', '', $data[2]));
                $sample['email'] = $emailfirst . $emaillast . '-student@tiftci.org';
                $sample['password'] = md5('student123');
                $sample['accounttype'] = 'student';

                $muserid = DB::table('main_users')
                    ->insertGetID([
                        'email' => $sample['email'],
                        'password' => $sample['password'],
                        'accounttype' => 'student',
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);

                $getSectionID = DB::table('sections')
                    ->where('strand', $data[6])
                    ->where('yearlevel', 11)
                    ->where('section_name', $data[7])
                    ->first();

                DB::table('students')
                    ->insert([
                        'userid' => $muserid,
                        'sectionid' => $getSectionID->id,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);

                DB::table('main_users_details')
                    ->insert([
                        'userid' => $muserid,
                        'lrn' => $data[5],
                        'strand' => $data[6],
                        'yearlevel' => 11,
                        'firstname' => $data[0],
                        'middlename' => !empty($data[1]) ? $data[1] : '',
                        'lastname' => $data[2],
                        'mobilenumber' => $data[3],
                        'address' => $data[4],
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);

                $voucher = 0;
                $tuition = 0;
                $registration = 0;
                if($data[8] == 'public'){
                    $voucher = 17500.00;
                    $tuition = 0.00;
                    $registration = 1000.00;
                } else if($data[8] == 'semi'){
                    $voucher = 14000.00;
                    $tuition = 3500.00;
                    $registration = 1000.00;
                } else {
                    $voucher = 0.00;
                    $tuition = 17500.00;
                    $registration = 1000.00;
                }

                if($data[9] == 'full'){
                    $voucher = 0;
                    $tuition = 0;
                    $registration = 0;
                }

                $latestyear = DB::table('schoolyears')
                    ->orderBy('school_year', 'desc')
                    ->first();

                DB::table('tuition')
                ->insert([
                    'userid' => $muserid,
                    'yearid' => $latestyear->id,
                    'paymenttype' => $data[8],
                    'paymentmethod' => $data[9],
                    'voucher' => $voucher,
                    'tuition' => $tuition,
                    'registration' => $registration,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]);

            }
            fclose($handle);
        }

        return redirect($this->default_url.'?n=1');
    }

    public function adminstudent_edit(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        if(empty($query['id'])){
            die('Error: Requirements are not complete');
        }

        $data['dbdata'] = $dbdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->leftjoin('students', 'students.userid', '=', 'main_users.id')
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->where('accounttype', 'student')
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
                'sections.section_name',
                'sections.strand',
                'sections.yearlevel',
            )
            ->first();

        $data['sections'] = $sections = DB::table('sections')
            ->where('strand', $dbdata->strand)
            ->where('yearlevel', $dbdata->yearlevel)
            ->get()
            ->toArray();

        return view('admin.adminstudent_edit', $data);
    }

    public function adminstudent_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['did']) || empty($input['lrn']) || empty($input['email']) || empty($input['firstname']) || empty($input['lastname']) || empty($input['status'])){
            return redirect($this->default_url.'?e=1');
            die();
        }

        if($input['status'] != 'active' && $input['status'] != 'inactive'){
            return redirect($this->default_url.'?e=6');
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
            'email' => $input['email'],
            'status' => $input['status'],
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

    public function adminstudent_section_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['did']) || empty($input['section'])){
            return redirect($this->default_url.'?e=1');
            die();
        }

        DB::table('main_users_details')
            ->where('userid', $input['did'])
            ->update([
                'strand' => $input['strand'],
                'yearlevel' => $input['yearlevel'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        DB::table('students')
            ->where('userid', $input['did'])
            ->update([
                'sectionid' => $input['section'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=7');
    }

    public function adminstudent_pass_process(Request $request){
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

    public function adminstudent_image_process(Request $request){
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

    public function adminstudent_delete_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : $this->default_lpp,
            'page' => !empty($input['page']) ? $input['page'] : $this->default_page,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : '',
        ]);

        if(empty($input['did'])){
            return redirect($this->default_url.'?e1&'.$qstring);
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->where('accounttype', $this->default_accounttype)
            ->first();

        if(empty($logindata)){
            return redirect($this->default_url.'?e=5&'.$qstring);
            die();
        }

        DB::table('main_users')
            ->where('id', $input['did'])
            ->delete();

        DB::table('main_users_details')
            ->where('userid', $input['did'])
            ->delete();

        return redirect($this->default_url.'?n=4&'.$qstring);
    }


    public function getSections($yearlevel, $strand){

        Log::debug("yearlevel: $yearlevel");
        Log::debug("strand: $strand");

        $sections = DB::table('sections')
        ->where('yearlevel', $yearlevel)
        ->where('strand', $strand)
        ->pluck('section_name', 'id');

        return response()->json($sections);
    }

}
