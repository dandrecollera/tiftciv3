<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MainTeacherController extends Controller
{

    public $default_url = 'studentsgrades';

    public function __construct(Request $request) {
        $this->middleware('axuteacher');
    }

    public function teacher(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['news'] = $news = DB::table('wp_posts')
            ->where('post_type', 'news')
            ->orderby('id', 'desc')
            ->limit(3)
            ->get()
            ->toArray();

        $data['today'] = $today = Carbon::now()->format('l');
        $data['schedules'] = $schedule = DB::table('schedules')
            ->where('schedules.userid', $userinfo[0])
            ->where('schedules.day', $today)
            ->leftjoin('subjects', 'subjects.id', '=', 'schedules.subjectid')
            ->leftjoin('sections', 'sections.id', '=', 'schedules.sectionid')
            ->select(
                'sections.section_name',
                'subjects.subject_name',
                DB::raw("TIME_FORMAT(schedules.start_time, '%h:%i %p') as start_time"),
                DB::raw("TIME_FORMAT(schedules.end_time, '%h:%i %p') as end_time"),
            )
            ->orderBy('schedules.start_time', 'asc')
            ->get()
            ->toArray();

        // dd($schedule);


        return view('teacher.home', $data);
    }

    public function grading(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['subjects'] = $subjects = DB::table('schedules')
            ->where('userid', $userinfo[0])
            ->leftjoin('subjects', 'subjects.id', '=', 'schedules.subjectid')
            ->get()
            ->toArray();

        return view('teacher.grades', $data);
    }

    public function section(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        $data['subjectname'] = $subjectname = DB::table('subjects')
            ->where('id', $query['subject'])
            ->first();


        $data['sections'] = $sections = DB::table('schedules')
            ->where('subjectid', $query['subject'])
            ->leftjoin('subjects', 'subjects.id', '=', 'schedules.subjectid')
            ->leftjoin('sections', 'sections.id', '=', 'schedules.sectionid')
            ->get();


        return view('teacher.section', $data);
    }

    public function studentsgrades(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();
        $qstring = array();

        $qstring['subject'] = $query['subject'];
        $qstring['section'] = $query['section'];

        $data['errorlist'] = [
            1 => 'Invalid Grade Input',
        ];
        $data['error'] = 0;
        if(!empty($_GET['e'])){
            $data['error'] = $_GET['e'];
        }
        $data['notiflist'] = [
            1 => 'Grade Saved.',
        ];
        $data['notif'] = 0;
        if(!empty($_GET['n'])){
            $data['notif'] = $_GET['n'];
        }


        $data['subject'] = $sections = DB::table('subjects')
            ->where('id', $query['subject'])
            ->first();

        $data['section'] = $sections = DB::table('sections')
            ->where('id', $query['section'])
            ->first();

        $data['students'] = $students = DB::table('students')
            ->where('students.sectionid', $query['section'])
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'students.userid')
            // ->leftjoin('grades', 'grades.userid', '=', 'students.userid')
            ->select(
                'main_users_details.userid',
                'main_users_details.firstname',
                'main_users_details.middlename',
                'main_users_details.lastname',
            )
            ->get()
            ->toArray();

        // dd($students)

        $data['qstring'] = http_build_query($qstring);
        $data['qstring2'] = $qstring;
        // dd($dbresult);
        return view('teacher.studentgrades', $data);
    }

    public function studentsgrades_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();


        $data['sid'] = $query['id'];
        $data['subject'] = $query['subject'];
        $data['section'] = $query['section'];
        $data['quarter'] = $query['quarter'];
        // dd($query);
        $data['query'] = $query;
        return view('teacher.studentgrades_add', $data);
    }

    public function studentsgrades_add_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $input = $request->input();

        if(empty($input['grade'])){
            return redirect($this->default_url.'?e=1&subject='.$input['subject'].'&section='.$input['section']);
            die();
        }

        if($input['grade'] <= 0 || $input['grade'] > 100){
            return redirect($this->default_url.'?e=1&subject='.$input['subject'].'&section='.$input['section']);
            die();
        }

        $latestyear = DB::table('schoolyears')
            ->orderBy('school_year', 'desc')
            ->first();

        DB::table('grades')
            ->insert([
                'studentid' => $input['sid'],
                'subjectid' => $input['subject'],
                'yearid' => $latestyear->id,
                'sectionid' => $input['section'],
                'grade' => $input['grade'],
                'quarter' => $input['quarter'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=1&subject='.$input['subject'].'&section='.$input['section']);
    }

    public function studentsgrades_edit(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();


        $data['gid'] = $query['grade'];
        $data['sid'] = $query['id'];
        $data['subject'] = $query['subject'];
        $data['section'] = $query['section'];
        $data['quarter'] = $query['quarter'];
        // dd($query);

        $data['score'] = $score = DB::table('grades')
            ->where('id', $query['grade'])
            ->first();

        $data['query'] = $query;
        return view('teacher.studentgrades_edit', $data);
    }

    public function studentsgrades_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['grade'])){
            return redirect($this->default_url.'?e=1&subject='.$input['subject'].'&section='.$input['section']);
            die();
        }

        if($input['grade'] <= 0 || $input['grade'] > 100){
            return redirect($this->default_url.'?e=1&subject='.$input['subject'].'&section='.$input['section']);
            die();
        }

        DB::table('grades')
            ->where('id', $input['gid'])
            ->update([
                'grade' => $input['grade'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=1&subject='.$input['subject'].'&section='.$input['section']);
    }


    public function teacherschedule(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        $qstring = array();

        $day = '';
        if(!empty($query['day'])){
            $qstring['day'] = $day = $query['day'];
            $data['day'] = $day;
        }

        $schedules = DB::table('schedules')
            ->where('userid', $userinfo[0])
            ->leftjoin('subjects', 'subjects.id', '=', 'schedules.subjectid')
            ->leftjoin('sections', 'sections.id', '=', 'schedules.sectionid')
            ->select(
                'sections.section_name',
                'subjects.subject_name',
                'schedules.day',
                DB::raw("TIME_FORMAT(schedules.start_time, '%h:%i %p') as start_time"),
                DB::raw("TIME_FORMAT(schedules.end_time, '%h:%i %p') as end_time"),
            )
            ->orderBy('schedules.start_time', 'asc');

        if(!empty($day)){
            $schedules->where('schedules.day', 'like', "%$day%");
        }

        $data['schedules'] = $schedules->get()->toArray();

        $data['qstring'] = http_build_query($qstring);
        $data['qstring'] = $qstring;

        return view('teacher.myschedule', $data);
    }

    public function studentlist(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');


        $data['sections'] = $sections = DB::table('schedules')
            ->where('userid', $userinfo[0])
            ->orderBy('sectionid', 'asc')
            ->leftjoin('sections', 'sections.id', '=', 'schedules.sectionid')
            ->select(
                'schedules.sectionid',
                'sections.section_name',
            )
            ->get()
            ->toArray();

        // dd($sections);

        return view('teacher.studentlist', $data);

    }

    public function students(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();
        $sectionid = $query['sid'];

        $data['section'] = $section = DB::table('sections')
            ->where('id', $sectionid)
            ->first();

        $data['dbresult'] = $dbresult = DB::table('students')
            ->where('sectionid', $sectionid)
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'students.userid')
            ->get()
            ->toArray();



        // dd($dbresult);
        return view('teacher.students', $data);
    }
}
