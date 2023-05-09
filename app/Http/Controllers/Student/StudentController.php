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

        // dd($news);

        $latestYear = DB::table('schoolyears')
            ->orderby('id', 'desc')
            ->first();



        $data['balance'] = $balance = DB::table('tuition')
            ->leftjoin('schoolyears', 'schoolyears.id', '=', 'tuition.yearid')
            ->where('userid', $userinfo[0])
            ->where('yearid', $latestYear->id)
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
            ->leftjoin('subjects', 'subjects.id', '=', 'schedules.sectionid')
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

        return view('student.home', $data);
    }

    public function grades(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');


        $data['studentsection'] = $studentsection = DB::table('students')
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->where('students.userid', $userinfo[0])
            ->select('sections.section_name', 'sections.id')
            ->first();

        $data['subjects'] = $subjects = DB::table('schedules')
            ->where('sectionid', $studentsection->id)
            ->leftjoin('subjects', 'subjects.id', '=', 'schedules.subjectid')
            ->get();

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
        $data['qstring'] = http_build_query($qstring);
        $data['qstring'] = $qstring;

        return view('student.schedule', $data);
    }

    public function balance(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['balance'] = $balance = DB::table('tuition')
            ->leftjoin('schoolyears', 'schoolyears.id', '=', 'tuition.yearid')
            ->where('userid', $userinfo[0])
            ->orderBy('tuition.id', 'desc')
            ->first();
        $data['today'] = $today = Carbon::now()->format('l');
        $data['total'] = $total = $balance->voucher + $balance->tuition + $balance->registration;


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

        $data['errorlist'] = [
            1 => 'Only Monday to Friday is Available',
        ];
        $data['error'] = 0;
        if (!empty($_GET['e'])) {
            $data['error'] = $_GET['e'];
        }


        $data['notiflist'] = [
            1 => 'Request Form Sent',
        ];
        $data['notif'] = 0;
        if(!empty($_GET['n'])){
            $data['notif'] = $_GET['n'];
        }

        $query = $request->query();
        $qstring = array();


        $data['qstring'] = http_build_query($qstring);
        $data['qstring2'] = $qstring;

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


        return redirect('/studentappointment?n=1');
    }
}
