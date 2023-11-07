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
            ->leftjoin('curriculums', 'curriculums.id', '=', 'tuition.yearid')
            ->where('userid', $userinfo[0])
            ->orderBy('yearid', 'desc')
            ->first();
        $data['today'] = $today = Carbon::now()->format('l');
        $data['total'] = $total = $balance->voucher + $balance->tuition + $balance->registration;


        $fetchlateststudent = DB::table('students')
            ->where('userid', $userinfo[0])
            ->orderby('id', 'desc')
            ->first();

        $data['sectname'] = $newsched = DB::table('curriculums')
            ->where('id', $fetchlateststudent->sectionid)
            ->first();

            $scheds = [];

            $csttData = json_decode($newsched->cstt);

            foreach ($csttData as $scheduleInfo) {
                $day = $scheduleInfo->day;

                if ($day == $today || $today == 'All') {
                    $startTime = date("h:i A", strtotime($scheduleInfo->starttime));
                    $endTime = date("h:i A", strtotime($scheduleInfo->endtime));

                    $subject = DB::table('subjects')
                        ->where('id', $scheduleInfo->subjectid)
                        ->value('subject_name');

                    $teacher = DB::table('main_users_details')
                        ->select('firstname', 'middlename', 'lastname')
                        ->where('userid', $scheduleInfo->teacherid)
                        ->first();

                    $section = $newsched->name;

                    // Append the schedule to the array
                    $scheds[] = [
                        'day' => $day,
                        'startTime' => $startTime,
                        'endTime' => $endTime,
                        'section' => $section,
                        'teacher' => $teacher,
                        'subject' => $subject,
                    ];
                }
            }

            // Sort the schedules
            usort($scheds, function ($a, $b) {
                $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                $dayComparison = array_search($a['day'], $dayOrder) - array_search($b['day'], $dayOrder);

                if ($dayComparison !== 0) {
                    return $dayComparison;
                }

                return strtotime($a['startTime']) - strtotime($b['startTime']);
            });

            $data['newsched'] = $scheds;

            return view('student.home', $data);
    }

    public function grades(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        $data['latestyearstudent'] = $latestyearstudent = DB::table('students')
            ->where('userid', $userinfo[0])
            ->leftjoin('curriculums', 'curriculums.id', '=', 'students.sectionid')
            ->orderBy('curriculums.schoolyear', 'desc')
            ->first();

        $data['allyear'] = $allyear = DB::table('students')
            ->where('userid', $userinfo[0])
            ->leftJoin('curriculums', 'curriculums.id', '=', 'students.sectionid')
            ->select('curriculums.schoolyear')
            ->orderBy('curriculums.schoolyear', 'desc')
            ->get()
            ->pluck('schoolyear')
            ->unique()
            ->toArray();

        // dd($allyear);

        $prioyear = isset($query['year'])  ? $query['year'] : $latestyearstudent->schoolyear;

        $fetchsection = DB::table('students')
            ->where('userid', $userinfo[0])
            ->leftjoin('curriculums', 'curriculums.id', '=', 'students.sectionid')
            ->where('curriculums.schoolyear', $prioyear)
            ->where('curriculums.semester', '1st')
            ->orderBy('curriculums.semester', 'asc')
            ->get()
            ->toArray();


        $fetchsection2 = DB::table('students')
            ->where('userid', $userinfo[0])
            ->leftjoin('curriculums', 'curriculums.id', '=', 'students.sectionid')
            ->where('curriculums.schoolyear', $prioyear)
            ->where('curriculums.semester', '2nd')
            ->orderBy('curriculums.semester', 'asc')
            ->get()
            ->toArray();


        $subjectgrades = [];
        $subjectgrades2 = [];

        foreach ($fetchsection as $section) {
            $csttData = json_decode($section->cstt);

            foreach ($csttData as $scheduleInfo) {

                $semesterselected = $section->semester;
                $subjectselected = $section->id;

                $first = 0;
                $second = 0;

                    $first = DB::table('grades')
                        ->where('quarter', '1st')
                        ->where('studentid', $userinfo[0])
                        ->where('subjectid', $scheduleInfo->subjectid)
                        ->where('sectionid', $subjectselected)
                        ->value('grade');
                    $second = DB::table('grades')
                        ->where('quarter', '2nd')
                        ->where('studentid', $userinfo[0])
                        ->where('subjectid', $scheduleInfo->subjectid)
                        ->where('sectionid', $subjectselected)
                        ->value('grade');

                $subject = DB::table('subjects')
                    ->where('id', $scheduleInfo->subjectid)
                    ->value('subject_name');


                $ave = 0;
                if($first != null && $second != null){
                    $ave = ($first + $second) / 2;
                }

                $subjectgrades[] = [
                    'subject' => $subject,
                    '1st' => $first == null ? '0' : $first,
                    '2nd' => $second == null ? '0' : $second,
                    'ave' => $ave,

                ];
            }
        }

        foreach ($fetchsection2 as $section) {
            $csttData = json_decode($section->cstt);

            foreach ($csttData as $scheduleInfo) {
                $semesterselected = $section->semester;
                $subjectselected = $section->id;

                $first = 0;
                $second = 0;

                $first = DB::table('grades')
                    ->where('quarter', '1st')
                    ->where('studentid', $userinfo[0])
                    ->where('subjectid', $scheduleInfo->subjectid)
                    ->where('sectionid', $subjectselected)
                    ->value('grade');
                $second = DB::table('grades')
                    ->where('quarter', '2nd')
                    ->where('studentid', $userinfo[0])
                    ->where('subjectid', $scheduleInfo->subjectid)
                    ->where('sectionid', $subjectselected)
                    ->value('grade');

                $subject = DB::table('subjects')
                    ->where('id', $scheduleInfo->subjectid)
                    ->value('subject_name');


                $ave = 0;
                if($first != null && $second != null){
                    $ave = ($first + $second) / 2;
                }

                $subjectgrades2[] = [
                    'subject' => $subject,
                    '1st' => $first == null ? '0' : $first,
                    '2nd' => $second == null ? '0' : $second,
                    'ave' => $ave,
                ];
            }
        }

        $data['first'] = $subjectgrades;
        $data['second'] = $subjectgrades2;

        return view('student.grades', $data);
    }

    public function schedule(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        $qstring = array();

        $selectedDay = isset($query['day']) ? $query['day'] : 'All';

        $data['today'] = $today = Carbon::now()->format('l');
        $fetchlateststudent = DB::table('students')
            ->where('userid', $userinfo[0])
            ->orderby('id', 'desc')
            ->first();

        $data['sectname'] = $newsched = DB::table('curriculums')
            ->where('id', $fetchlateststudent->sectionid)
            ->first();

        $scheds = [];

        $csttData = json_decode($newsched->cstt);

        foreach ($csttData as $scheduleInfo) {
            $day = $scheduleInfo->day;

            if ($day == $selectedDay || $selectedDay == 'All') {
                $startTime = date("h:i A", strtotime($scheduleInfo->starttime));
                $endTime = date("h:i A", strtotime($scheduleInfo->endtime));

                $subject = DB::table('subjects')
                    ->where('id', $scheduleInfo->subjectid)
                    ->value('subject_name');

                $teacher = DB::table('main_users_details')
                    ->select('firstname', 'middlename', 'lastname')
                    ->where('userid', $scheduleInfo->teacherid)
                    ->first();

                $section = $newsched->name;

                $scheds[] = [
                    'day' => $day,
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                    'section' => $section,
                    'teacher' => $teacher,
                    'subject' => $subject,
                ];
            }
        }

            // Sort the schedules
        usort($scheds, function ($a, $b) {
            $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $dayComparison = array_search($a['day'], $dayOrder) - array_search($b['day'], $dayOrder);

            if ($dayComparison !== 0) {
                return $dayComparison;
            }

            return strtotime($a['startTime']) - strtotime($b['startTime']);
        });

        $data['newsched'] = $scheds;

        $data['qstring'] = http_build_query($qstring);
        $data['qstring'] = $qstring;

        return view('student.schedule', $data);
    }

    public function studentenrollment(Request $request){
        $input = $request->input();
        $userinfo = $request->get('userinfo');

        DB::table('main_users_details')
            ->where('userid', $userinfo[0])
            ->update([
                'yearlevel' => $input['yearlevel'],
            ]);

        DB::table('students')
            ->where('userid', $userinfo[0])
            ->insert([
                'userid' => $userinfo[0],
                'sectionid' => $input['section'],
            ]);


        $voucher = 0;
        $tuition = 0;
        $registration = 0;


        $tuition2 = DB::table('tuition')
            ->where('userid', $userinfo[0])
            ->orderBy('id', 'desc')
            ->first();

        if($tuition2->paymenttype == 'public'){
            $voucher = 17500.00;
            $tuition = 0.00;
            $registration = 1000.00;
        } else if($tuition2->paymenttype == 'semi'){
            $voucher = 14000.00;
            $tuition = 3500.00;
            $registration = 1000.00;
        } else {
            $voucher = 0.00;
            $tuition = 17500.00;
            $registration = 1000.00;
        }



        DB::table('tuition')
            ->insert([
                'userid' => $userinfo[0],
                'yearid' => $input['section'],
                'paymenttype' => $tuition2->paymenttype,
                'paymentmethod' => 'semi',
                'voucher' => $voucher,
                'tuition' => $tuition,
                'registration' => $registration,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);


        return redirect('/enrollment?n=1');
        dd($input);
    }

    public function balance(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['balances'] = $balances = DB::table('tuition')
            ->leftjoin('curriculums', 'curriculums.id', '=', 'tuition.yearid')
            ->where('userid', $userinfo[0])
            ->orderBy('tuition.id', 'desc')
            ->get()
            ->ToArray();

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
            2 => 'Select a proper Inquiry.',
            3 => 'Select an appointment date.',
            4 => 'Select a Document for Document Request.',
            5 => 'Please select a future date',
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

        if(empty($input['inquiry']) || $input['inquiry'] == ""){
            return redirect('/studentappointment?e=2');
            die();
        }

        $forminput['inquiry'] = $inquiry = $input['inquiry'];
        $forminput['goodmoral'] = $goodmoral = false;
        $forminput['registration'] = $registration = false;
        $forminput['f138'] = $f138 = false;
        $forminput['others'] = $others = false;
        $forminput['otherdocument'] = $otherdocument = '';


        if(empty($input['goodmoral']) && empty($input['registration']) && empty($input['f138']) && empty($input['others'])){
            return redirect('/studentappointment?e=4');
            die();
        }

        if(!empty($input['goodmoral'])){
            $forminput['goodmoral'] = $goodmoral = true;
        }
        if(!empty($input['registration'])){
            $forminput['registration'] = $registration = true;
        }
        if(!empty($input['f138'])){
            $forminput['f138'] = $f138 = true;
        }
        if(!empty($input['others'])){
            if(!empty($input['otherdocument'])){
                $forminput['others'] = $others = true;
                $forminput['otherdocument'] = $otherdocument = $input['otherdocument'];
            }
        }


        if(empty($input['appointeddate'])){
            return redirect('/studentappointment?e=3');
            die();
        }

        $forminput['otherreason'] = $otherreason = $input['otherreason'];
        $appointeddate = $input['appointeddate'];
        $dateparse = Carbon::parse($appointeddate);

        if ($dateparse->isPast()){
            return redirect('/studentappointment?e=5');
            die();
        }

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
            'registration' => $forminput['registration'],
            'f138' => $forminput['f138'],
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
        Mail::to($Mail)->send(new UpdateUser($userMail, $statusMail, $requestMail, $dateMail, "Appointment Pending", $emailInfo));


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
        Mail::to($Mail)->send(new UpdateUser($userMail, $statusMail, $requestMail, $dateMail, "Appointment Cancelled", $emailInfo));


        return redirect('/studentappointment?n=2');
    }

    public function enrollment(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['getstrand'] = $getstrand = DB::table('main_users_details')
            ->where('userid', $userinfo[0])
            ->first();

        return view('student.enrollment', $data);
    }

    public function enrollSection(Request $request){
        $query = $request->query();
        $userinfo = $request->get('userinfo');

        $section = DB::table('curriculums')
            ->where('schoolyear', $query['schoolyear'])
            ->where('yearlevel', $query['yearlevel'])
            ->where('strand', $query['strand'])
            ->where('semester', $query['semester'])
            ->get()
            ->toArray();

        return response()->json($section);
    }

    public function fetschSchedule(Request $request){
        $query = $request->query();
        $userinfo = $request->get('userinfo');

        $subjects = DB::table('curriculums')
            ->where('id', $query['section'])
            ->first();

        $selectedDay = 'All';

        $scheds = [];

        $csttData = json_decode($subjects->cstt);

        foreach($csttData as $scheduleInfo){
            $day = $scheduleInfo->day;

            if($day == $selectedDay || $selectedDay == "All"){
                $startTime = date("h:i A", strtotime($scheduleInfo->starttime));
                $endTime = date("h:i A", strtotime($scheduleInfo->endtime));

                $subject = DB::table('subjects')
                    ->where('id', $scheduleInfo->subjectid)
                    ->value('subject_name');

                $teacher = DB::table('main_users_details')
                    ->select('firstname', 'middlename', 'lastname')
                    ->where('userid', $scheduleInfo->teacherid)
                    ->first();

                $section = $subjects->name;

                $scheds[] = [
                    'day' => $day,
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                    'section' => $section,
                    'teacher' => $teacher,
                    'subject' => $subject,
                ];
            }
        }

        usort($scheds, function($a, $b){
            $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $dayComparison = array_search($a['day'], $dayOrder) - array_search($b['day'], $dayOrder);

            if($dayComparison !== 0){
                return $dayComparison;
            }

            return strtotime($a['startTime']) - strtotime($b['startTime']);
        });

        return response()->json($scheds);

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
