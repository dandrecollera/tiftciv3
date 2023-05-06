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

        $data['balance'] = $balance = DB::table('tuition')
            ->leftjoin('schoolyears', 'schoolyears.id', '=', 'tuition.yearid')
            ->where('userid', $userinfo[0])
            ->first();
        $data['today'] = $today = Carbon::now()->format('l');
        $data['total'] = $total = $balance->voucher + $balance->tuition + $balance->registration;


        $data['studentsection'] = $studentsection = DB::table('students')
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->where('students.userid', $userinfo[0])
            ->select('sections.section_name')
            ->first();

        $data['schedules'] = $schedule = DB::table('students')
            ->leftjoin('schedules', 'schedules.sectionid', '=', 'students.sectionid')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'schedules.teacherid')
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
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'schedules.teacherid')
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

    public function feedback(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        return view('student.feedback', $data);
    }
}
