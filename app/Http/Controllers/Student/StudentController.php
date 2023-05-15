<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Mail\UpdateUser;
use Illuminate\Support\Facades\Mail;


class StudentController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('axustudent');
    }

    public function portal(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');


        $data['news'] = $news = DB::table('wp_posts')
            ->where('post_type', 'news')
            ->orderby('id', 'desc')
            ->limit(3)
            ->get()
            ->toArray();




        $data['balance'] = $balance = DB::table('tuition')
            ->leftjoin('schoolyears', 'schoolyears.id', '=', 'tuition.yearid')
            ->where('userid', $userinfo[0])
            ->orderBy('yearid', 'desc')
            ->first();
        $data['today'] = $today = Carbon::now()->format('l');
        $data['total'] = $total = $balance->voucher + $balance->tuition + $balance->registration;

        // dd($balance);
        $data['studentsection'] = $studentsection = DB::table('students')
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->where('students.userid', $userinfo[0])
            ->select('sections.section_name')
            ->first();

        $data['schedules'] = $schedule = DB::table('students')
            ->leftjoin('schedules', 'schedules.sectionid', '=', 'students.sectionid')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'schedules.userid')
            ->leftjoin('subjects', 'subjects.id', '=', 'schedules.subjectid')
            ->where('students.userid', $userinfo[0])
            ->where('schedules.day', $today)
            ->select(
                'main_users_details.firstname',
                'main_users_details.middlename',
                'main_users_details.lastname',
                DB::raw("TIME_FORMAT(schedules.start_time, '%h:%i %p') as start_time"),
                DB::raw("TIME_FORMAT(schedules.end_time, '%h:%i %p') as end_time"),
                'subjects.subject_name',
            )
            ->orderBy('schedules.start_time', 'asc')
            ->get()
            ->toArray();
            // dd($schedule);

        return view('student.home', $data);
    }

    public function grades(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');


        $getStatus = DB::table('main_users_details')
            ->where('userid', $userinfo[0])
            ->first();

        if($getStatus->yearlevel != "Graduate"){
            $data['studentsection'] = $studentsection = DB::table('students')
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->where('students.userid', $userinfo[0])
            ->select('sections.section_name', 'sections.id')
            ->first();

        $data['subjects'] = $subjects = DB::table('schedules')
            ->where('sectionid', $studentsection->id)
            ->leftjoin('subjects', 'subjects.id', '=', 'schedules.subjectid')
            ->get();
        }



        // dd($subjects);

        return view('student.grades', $data);
    }

    public function schedule(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        $qstring = array();

        $day = '';
        if(!empty($query['day'])){
            $qstring['day'] = $day = $query['day'];
            $data['day'] = $day;
        }

        $getStatus = DB::table('main_users_details')
            ->where('userid', $userinfo[0])
            ->first();


        if($getStatus->yearlevel != "Graduate"){
            $data['studentsection'] = $studentsection = DB::table('students')
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->where('students.userid', $userinfo[0])
            ->select('sections.section_name', 'sections.id')
            ->first();

        $schedules = DB::table('schedules')
            ->where('sectionid', $studentsection->id)
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'schedules.userid')
            ->leftjoin('subjects', 'subjects.id', '=', 'schedules.subjectid')
            ->select(
                'main_users_details.firstname',
                'main_users_details.middlename',
                'main_users_details.lastname',
                DB::raw("TIME_FORMAT(schedules.start_time, '%h:%i %p') as start_time"),
                DB::raw("TIME_FORMAT(schedules.end_time, '%h:%i %p') as end_time"),
                'subjects.subject_name',
                'schedules.day',
            )
            ->orderBy('schedules.start_time', 'asc');


        if(!empty($day)){
            $schedules->where('schedules.day', 'like', "%$day%");
        }

        $data['schedules'] = $schedules->get();
        // dd($schedules);
        // dd($data['schedules']);
        }

        $data['qstring'] = http_build_query($qstring);
        $data['qstring'] = $qstring;

        return view('student.schedule', $data);
    }

    public function balance(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['balances'] = $balances = DB::table('tuition')
            ->leftjoin('schoolyears', 'schoolyears.id', '=', 'tuition.yearid')
            ->where('userid', $userinfo[0])
            ->orderBy('tuition.id', 'desc')
            ->get()
            ->ToArray();
        // $data['today'] = $today = Carbon::now()->format('l');
        // $data['total'] = $total = $balance->voucher + $balance->tuition + $balance->registration;


        return view('student.balance', $data);
    }

    public function hmv(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        return view('student.hmv', $data);
    }

    public function studentappointment(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();
        $qstring = array();
        $data['errorlist'] = [
            1 => 'Only Monday to Friday is Available',
        ];
        $data['error'] = 0;
        if (!empty($_GET['e'])) {
            $data['error'] = $_GET['e'];
        }

        $data['notiflist'] = [
            1 => 'Request Form Sent',
            2 => 'Appointment cancelled.'
        ];
        $data['notif'] = 0;
        if(!empty($_GET['n'])){
            $data['notif'] = $_GET['n'];
        }

        $page = 1;
        if(!empty($query['page'])){
            $page = $query['page'];
        }
        $qstring['page'] = $page;


        $data['sort'] = 0;
        $data['orderbylist'] = [
            ['display' => 'Default', 'field' => 'appointments.id'],
            ['display' => 'Status', 'field' => 'appointments.active'],
            ['display' => 'Inquiry', 'field' => 'appointments.inquiry'],
            ['display' => 'Appointed Date', 'field' => 'appointments.appointeddate'],
            ['display' => 'Created Date', 'field' => 'appointments.created_at']
        ];
        if(!empty($query['sort'])){
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }

        $myappointments = DB::table('appointments')
            ->where('email', $userinfo[4]);
        $countz = DB::table('appointments')
            ->where('email', $userinfo[4])
            ->count();

        $arrange = "asc";
        if($data['sort'] == 0){
            $arrange = "desc";
        }
        $myappointments->orderBy($data['orderbylist'][$data['sort']]['field'] , $arrange);


        $data['totalpages'] = ceil($countz / 10);
        $data['page'] = $page;
        $data['totalitems'] = $countz;
        $dataoffset = ($page*10)-10;

        $myappointments->offset($dataoffset)->limit(10);
        $data['qstring'] = http_build_query($qstring);
        $data['qstring2'] = $qstring;

        if ($page < 2) {
            //disabled URLS of first and previous button
            $data['page_first_url'] = '<a class="btn btn-warning disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-left fa-xs"></i> </a>';
            $data['page_prev_url'] = '<a class="btn btn-warning disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-left fa-xs"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = 1; //firstpage
            $data['page_first_url'] = '<a class="btn btn-warning" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-left fa-xs"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] - 1; // current page minus 1 for prev
            $data['page_prev_url'] = '<a class="btn btn-warning" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-left fa-xs"></i> </a>';
        }
        if ($page >= $data['totalpages']) {
            //disabled URLS on next and last button
            $data['page_last_url'] = '<a class="btn btn-warning disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-right fa-xs"></i> </a>';
            $data['page_next_url'] = '<a class="btn btn-warning disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-right fa-xs"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = $data['totalpages']; //lastpage
            $data['page_last_url'] = '<a class="btn btn-warning" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-right fa-xs"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] + 1; //nest page
            $data['page_next_url'] = '<a class="btn btn-warning" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-right fa-xs"></i> </a>';
        }

        $data['myappointments'] = $myappointments->get()->toArray();

        return view('student.feedback', $data);
    }

    public function studentappointment_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('student.appointment_add', $data);
    }

    public function studentappointment_add_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();
        $sections = DB::table('students')
            ->where('userid', $userinfo[0])
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->first();

        $myself = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('main_users.id', $userinfo[0])
            ->first();

        $currentyear = DB::table('schoolyears')
            ->orderBy('id', 'desc')
            ->first();

        $forminput['inquiry'] = $inquiry = $input['inquiry'];

        $forminput['goodmoral'] = $goodmoral = false;
        $forminput['f137'] = $f137 = false;
        $forminput['f138'] = $f138 = false;
        $forminput['diploma'] = $diploma = false;
        $forminput['others'] = $others = false;
        $forminput['otherdocument'] = $otherdocument = '';
        if($inquiry == 'Document Request'){

            if(!empty($input['goodmoral'])){
                $forminput['goodmoral'] = $goodmoral = true;
            }
            if(!empty($input['f137'])){
                $forminput['f137'] = $f137 = true;
            }
            if(!empty($input['f138'])){
                $forminput['f138'] = $f138 = true;
            }
            if(!empty($input['diploma'])){
                $forminput['diploma'] = $diploma = true;
            }
            if(!empty($input['others'])){
                if(!empty($input['otherdocument'])){
                    $forminput['others'] = $others = true;
                    $forminput['otherdocument'] = $otherdocument = $input['otherdocument'];
                }
            }
        }

        $forminput['otherreason'] = $otherreason = $input['otherreason'];
        $appointeddate = $input['appointeddate'];
        $dateparse = Carbon::parse($appointeddate);

        if ($dateparse->isWeekend()){
            return redirect('/studentappointment?e=1');
            die();
        }


        $forminput['appointeddate'] = $appointeddate;

        DB::table('appointments')
        ->insert([
            'email' => $myself->email,
            'firstname' => $myself->firstname,
            'middlename' =>  $myself->middlename,
            'lastname' =>  $myself->lastname,
            'mobilenumber' => $myself->mobilenumber,
            'address' => $myself->address,
            'lrn' => $myself->lrn,
            'graduate' => 'No',
            'yearattended' => $currentyear->school_year,
            'section' => $sections->section_name,
            'inquiry' => $forminput['inquiry'],
            'goodmoral' => $forminput['goodmoral'],
            'f137' => $forminput['f137'],
            'f138' => $forminput['f138'],
            'diploma' => $forminput['diploma'],
            'others' => $forminput['others'],
            'otherdocument' => $forminput['otherdocument'],
            'otherreason' => $forminput['otherreason'],
            'appointeddate' => $forminput['appointeddate'],
            'created_at' => Carbon::now()->tz('Asia/Manila')->toDateTimeString(),
            'updated_at' => Carbon::now()->tz('Asia/Manila')->toDateTimeString()
        ]);

        $emailInfo = DB::table('appointments')
            ->where('email', $myself->email)
            ->orderBy('id', 'desc')
            ->first();


        $Mail = $emailInfo->email;
        $userMail = $emailInfo->firstname. ' '.$emailInfo->lastname;
        $statusMail = $emailInfo->active;
        $requestMail = $emailInfo->inquiry;
        $dateMail = $emailInfo->appointeddate;
        Mail::to($Mail)->send(new UpdateUser($userMail, $statusMail, $requestMail, $dateMail, "Appointment Pending"));


        return redirect('/studentappointment?n=1');
    }

    public function studentappointment_cancel_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : 25,
            'page' => !empty($input['page']) ? $input['page'] : 1,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : ''
        ]);

        if(empty($input['sid'])){
            return redirect($this->default_url.'?e1&'.$qstring);
            die();
        }

        DB::table('appointments')
            ->where('id', $input['sid'])
            ->update([
                'active' => "Cancelled",
            ]);

        $emailInfo = DB::table('appointments')
            ->where('id', $input['sid'])
            ->first();


        $Mail = $emailInfo->email;
        $userMail = $emailInfo->firstname. ' '.$emailInfo->lastname;
        $statusMail = $emailInfo->active;
        $requestMail = $emailInfo->inquiry;
        $dateMail = $emailInfo->appointeddate;
        Mail::to($Mail)->send(new UpdateUser($userMail, $statusMail, $requestMail, $dateMail, "Appointment Cancelled"));


        return redirect('/studentappointment?n=2');
    }

    public function studentprofile(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        return view('student.components.studentprofile', $data);
    }

    public function studentsettings(Request $request){
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
            9 => 'Image is over 2MB.',
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

        return view('student.components.settings', $data);
    }

    public function studentsetting_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();
        if(empty($input['did']) || empty($input['firstname']) || empty($input['lastname'])){
            return redirect('studentsettings?e=1');
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->first();
        if(empty($logindata)){
            return redirect('studentsettings?e=5');
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

        return redirect('studentsettings?n=2');
    }

    public function studentsetting_pass_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();


        if(empty($input['did']) || empty($input['password']) || empty($input['password2'])){
            return redirect('studentsettings?e=1');
            die();
        }

        if(strlen($input['password']) < 8){
            return redirect('studentsettings?e=2');
            die();
        }

        if($input['password'] != $input['password2']){
            return redirect('studentsettings?e=3');
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->first();

        if(empty($logindata)){
            return redirect('studentsettings?e=5');
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

        return redirect('studentsettings?n=3');
    }

    public function studentsetting_image_process(Request $request){
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
                return redirect('studentsettings?e=9');
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
            return redirect('studentsettings?e=7');
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

        return redirect('studentsettings?n=5');
    }


}
