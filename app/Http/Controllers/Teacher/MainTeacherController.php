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
    public function __construct(Request $request) {
        $this->middleware('axuteacher');
    }

    public function teacher(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');


        $data['subjects'] = $subjects = DB::table('teachers')
            ->where('userid', $userinfo[0])
            ->leftjoin('subjects', 'subjects.id', '=', 'teachers.subjectid')
            ->get()
            ->toArray();

        return view('teacher.home', $data);
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
            ->select(
                'main_users_details.userid',
                'main_users_details.firstname',
                'main_users_details.middlename',
                'main_users_details.lastname',
            )
            ->get()
            ->toArray();

        $data['qstring'] = http_build_query($qstring);
        $data['qstring2'] = $qstring;
        // dd($dbresult);
        return view('teacher.studentgrades', $data);
    }

}
