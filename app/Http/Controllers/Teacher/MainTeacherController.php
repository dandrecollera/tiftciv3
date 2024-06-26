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
use PDF;

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


        $data['latestyear'] = $latestyear = DB::table('curriculums')
            ->orderBy('schoolyear', 'desc')
            ->first();

        $selectedDay = $today;

        $data['newsched'] = $newsched = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->where('schoolyear', $latestyear->schoolyear)
            ->get()
            ->toArray();

        $teacherSchedule = [];

        foreach ($newsched as $schedule) {
            $csttData = json_decode($schedule->cstt);

            foreach ($csttData as $scheduleInfo) {
                if ($scheduleInfo->teacherid == $userinfo[0]) {

                    $day = $scheduleInfo->day;

                    if ($day == $selectedDay || $selectedDay == 'All') {
                        $startTime = date("h:i A", strtotime($scheduleInfo->starttime));
                        $endTime = date("h:i A", strtotime($scheduleInfo->endtime));

                        $subject = DB::table('subjects')
                            ->where('id', $scheduleInfo->subjectid)
                            ->value('subject_name');

                        $section = $schedule->name;

                        $teacherSchedule[] = [
                            'day' => $day,
                            'startTime' => $startTime,
                            'endTime' => $endTime,
                            'section' => $section,
                            'subject' => $subject,
                        ];
                    }
                }
            }
        }
        usort($teacherSchedule, function ($a, $b) {
            $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $dayComparison = array_search($a['day'], $dayOrder) - array_search($b['day'], $dayOrder);

            if ($dayComparison !== 0) {
                return $dayComparison;
            }

            return strtotime($a['startTime']) - strtotime($b['startTime']);
        });

        $data['teacherschedule'] = $teacherSchedule;

        return view('teacher.home', $data);
    }

    public function grading(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['allyear'] = $allyear = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->select([
                'schoolyear'
            ])
            ->orderBy('schoolyear', 'desc')
            ->get()
            ->unique('schoolyear')
            ->toArray();

        $latestyear = DB::table('curriculums')
            ->orderBy('schoolyear', 'desc')
            ->first();

        $data['subjects'] = $subjects = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->where('schoolyear', $latestyear->schoolyear)
            ->get()
            ->toArray();

        $selectedTeacherId = $userinfo[0];
        $compiledCsttData = [];

        foreach ($subjects as $subject) {

            $csttArray = json_decode($subject->cstt, true);

            $filteredCsttData = array_filter($csttArray, function ($item) use ($selectedTeacherId) {
                return $item['teacherid'] == $selectedTeacherId;
            });

            foreach ($filteredCsttData as $csttItem) {
                $csttItem['curriculumid'] = $subject->id;
                $csttItem['section'] = $subject->name;
                $csttItem['semester'] = $subject->semester;
                $compiledCsttData[] = $csttItem;
            }
        }

        $data['compiledCsttData'] = $compiledCsttData;

        return view('teacher.grades', $data);
    }

    public function fetchYearSubject(Request $request){
        $query = $request->query();
        $userinfo = $request->get('userinfo');



        $data['subjects'] = $subjects = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->where('schoolyear', $query['schoolyear'])
            ->get()
            ->toArray();

        $selectedTeacherId = $userinfo[0];
        $compiledCsttData = [];

        foreach ($subjects as $subject) {
            $csttArray = json_decode($subject->cstt, true);

            $filteredCsttData = array_filter($csttArray, function ($item) use ($selectedTeacherId) {
                return $item['teacherid'] == $selectedTeacherId;
            });

            foreach ($filteredCsttData as $csttItem) {
                $csttItem['curriculumid'] = $subject->id;
                $csttItem['section'] = $subject->name;
                $csttItem['semester'] = $subject->semester;
                $compiledCsttData[] = $csttItem;
            }
        }

        $data['compiledCsttData'] = $compiledCsttData;

        return response()->json($data['compiledCsttData']);
        dd($data['compiledCsttData']);

    }

    public function getSubjectName(Request $request){
        $query = $request->query();
        $subject = DB::table('subjects')
        ->where('id', $query['subjectid'])
        ->first();

        return response()->json(['subject_name' => $subject->subject_name]);
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

        $data['subject'] = $query['subject'];
        $data['section'] = $query['section'];

        $data['subject'] = $subjects = DB::table('subjects')
            ->where('id', $query['subject'])
            ->first();

        $data['section'] = $sections = DB::table('curriculums')
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

        $data['lock'] = $lock = DB::table('gradelock')
            ->where('subjectid', $query['subject'])
            ->where('sectionid', $query['section'])
            ->first();

        $data['qstring'] = http_build_query($qstring);
        $data['qstring2'] = $qstring;

        return view('teacher.studentgrades', $data);
    }


    public function saveGrade(Request $request){
        $userinfo = $request->get('userinfo');
        $query = $request->query();

        $checkgrade = DB::table('grades')
            ->where('studentid', $query['studentid'])
            ->where('subjectid', $query['subjectid'])
            ->where('sectionid', $query['sectionid'])
            ->where('quarter', $query['quarter'])
            ->first();


        if($checkgrade == null){
            DB::table('grades')
                ->insert([
                    'studentid' => $query['studentid'],
                    'subjectid' => $query['subjectid'],
                    'sectionid' => $query['sectionid'],
                    'grade' => $query['grade'],
                    'quarter' => $query['quarter'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]);
        } else {
            DB::table('grades')
                ->where('studentid', $query['studentid'])
                ->where('subjectid', $query['subjectid'])
                ->where('sectionid', $query['sectionid'])
                ->where('quarter', $query['quarter'])
                ->update([
                    'studentid' => $query['studentid'],
                    'subjectid' => $query['subjectid'],
                    'sectionid' => $query['sectionid'],
                    'grade' => $query['grade'],
                    'quarter' => $query['quarter'],
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]);
        }

    }

    public function studentgradeslock(Request $request){
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        DB::table('gradelock')
            ->insert([
                'subjectid' => $query['subject'],
                'sectionid' => $query['section'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect('/studentsgrades?subject='.$query['subject'].'&section='. $query['section']);
    }

    public function studentsgrades_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();


        $data['sid'] = $query['id'];
        $data['subject'] = $query['subject'];
        $data['section'] = $query['section'];
        $data['quarter'] = $query['quarter'];
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

        $selectedDay = isset($query['day']) ? $query['day'] : 'All';

        $data['allyear'] = $allyear = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->select([
                'schoolyear'
            ])
            ->orderBy('schoolyear', 'desc')
            ->get()
            ->unique('schoolyear')
            ->toArray();

        $data['latestyear'] = $latestyear = DB::table('curriculums')
            ->orderBy('schoolyear', 'desc')
            ->first();

        $selectedyear = isset($query['year']) ? $query['year'] : $latestyear->schoolyear;

        $data['newsched'] = $newsched = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->where('schoolyear', $selectedyear)
            ->get()
            ->toArray();

        $teacherSchedule = [];

        foreach ($newsched as $schedule) {
            $csttData = json_decode($schedule->cstt);

            foreach ($csttData as $scheduleInfo) {
                if ($scheduleInfo->teacherid == $userinfo[0]) {

                    $day = $scheduleInfo->day;

                    if ($day == $selectedDay || $selectedDay == 'All') {
                        $startTime = date("h:i A", strtotime($scheduleInfo->starttime));
                        $endTime = date("h:i A", strtotime($scheduleInfo->endtime));

                        $subject = DB::table('subjects')
                            ->where('id', $scheduleInfo->subjectid)
                            ->value('subject_name');

                        $section = $schedule->name;

                        $teacherSchedule[] = [
                            'day' => $day,
                            'startTime' => $startTime,
                            'endTime' => $endTime,
                            'section' => $section,
                            'subject' => $subject,
                        ];
                    }
                }
            }
        }
        usort($teacherSchedule, function ($a, $b) {
            $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $dayComparison = array_search($a['day'], $dayOrder) - array_search($b['day'], $dayOrder);

            if ($dayComparison !== 0) {
                return $dayComparison;
            }

            return strtotime($a['startTime']) - strtotime($b['startTime']);
        });

        $data['teacherschedule'] = $teacherSchedule;



        return view('teacher.myschedule', $data);
    }

    public function teacherschedulepdf(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        $qstring = array();

        $selectedDay = 'All';

        $data['allyear'] = $allyear = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->select([
                'schoolyear'
            ])
            ->orderBy('schoolyear', 'desc')
            ->get()
            ->unique('schoolyear')
            ->toArray();

        $data['latestyear'] = $latestyear = DB::table('curriculums')
            ->orderBy('schoolyear', 'desc')
            ->first();

        $data['selectedyear'] = $selectedyear = $query['year'];

        $data['newsched'] = $newsched = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->where('schoolyear', $selectedyear)
            ->get()
            ->toArray();

        $teacherSchedule = [];

        foreach ($newsched as $schedule) {
            $csttData = json_decode($schedule->cstt);

            foreach ($csttData as $scheduleInfo) {
                if ($scheduleInfo->teacherid == $userinfo[0]) {

                    $day = $scheduleInfo->day;

                    if ($day == $selectedDay || $selectedDay == 'All') {
                        $startTime = date("h:i A", strtotime($scheduleInfo->starttime));
                        $endTime = date("h:i A", strtotime($scheduleInfo->endtime));

                        $subject = DB::table('subjects')
                            ->where('id', $scheduleInfo->subjectid)
                            ->value('subject_name');

                        $section = $schedule->name;

                        $teacherSchedule[] = [
                            'day' => $day,
                            'startTime' => $startTime,
                            'endTime' => $endTime,
                            'section' => $section,
                            'subject' => $subject,
                        ];
                    }
                }
            }
        }
        usort($teacherSchedule, function ($a, $b) {
            $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $dayComparison = array_search($a['day'], $dayOrder) - array_search($b['day'], $dayOrder);

            if ($dayComparison !== 0) {
                return $dayComparison;
            }

            return strtotime($a['startTime']) - strtotime($b['startTime']);
        });

        $data['teacherschedule'] = $teacherSchedule;

        $pdf = PDF::loadview('teacher.teacherschedulepdf', $data);

        return $pdf->stream('myschedule.pdf');
    }

    public function studentlist(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $latestyear = DB::table('curriculums')
            ->orderBy('schoolyear', 'desc')
            ->first();

        $data['allyear'] = $allyear = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->select([
                'schoolyear'
            ])
            ->orderBy('schoolyear', 'desc')
            ->get()
            ->unique('schoolyear')
            ->toArray();


        $data['sections'] = $sections = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->orderBy('name', 'asc')
            ->where('schoolyear', $latestyear->schoolyear)
            ->get()
            ->toArray();

        return view('teacher.studentlist', $data);
    }

    public function getStudentSection(Request $request){
        $query = $request->query();
        $userinfo = $request->get('userinfo');

        $sections = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->orderBy('name', 'asc')
            ->where('schoolyear', $query['schoolyear'])
            ->get()
            ->toArray();

        return response()->json($sections);
    }

    public function students(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();
        $sectionid = $query['sid'];

        $data['section'] = $section = DB::table('curriculums')
            ->where('id', $sectionid)
            ->first();

        $data['dbresult'] = $dbresult = DB::table('students')
            ->where('sectionid', $sectionid)
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'students.userid')
            ->leftjoin('main_users', 'main_users.id', '=', 'students.userid')
            ->orderBy('lastname', 'asc')
            ->get()
            ->toArray();

        // dd($dbresult);
        return view('teacher.students', $data);
    }

    public function studentlistpdf(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();
        $sectionid = $query['id'];

        $data['section'] = $section = DB::table('curriculums')
            ->where('id', $sectionid)
            ->first();

        $data['dbresult'] = $dbresult = DB::table('students')
            ->where('sectionid', $sectionid)
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'students.userid')
            ->leftjoin('main_users', 'main_users.id', '=', 'students.userid')
            ->orderBy('lastname', 'asc')
            ->get()
            ->toArray();

        $pdf = PDF::loadview('teacher.studentlistpdf', $data);

        return $pdf->stream('studentlist.pdf');
    }

    public function teacherprofile(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        return view('teacher.components.teacherprofile', $data);
    }

    public function teachersetting(Request $request){
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

        return view('teacher.components.settings', $data);
    }

    public function teachersetting_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();
        if(empty($input['did']) || empty($input['firstname']) || empty($input['lastname'])){
            return redirect('teachersettings?e=1');
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->first();
        if(empty($logindata)){
            return redirect('teachersettings?e=5');
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

        return redirect('teachersettings?n=2');
    }

    public function teachersetting_pass_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();


        if(empty($input['did']) || empty($input['password']) || empty($input['password2'])){
            return redirect('teachersettings?e=1');
            die();
        }

        if(strlen($input['password']) < 8){
            return redirect('teachersettings?e=2');
            die();
        }

        if($input['password'] != $input['password2']){
            return redirect('teachersettings?e=3');
            die();
        }

        $logindata = DB::table('main_users')
            ->where('id', $input['did'])
            ->first();

        if(empty($logindata)){
            return redirect('teachersettings?e=5');
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

        return redirect('teachersettings?n=3');
    }

    public function teachersetting_image_process(Request $request){
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
                return redirect('teachersettings?e=9');
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
            return redirect('teachersettings?e=7');
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

        return redirect('teachersettings?n=5');
    }

    public function subjectarchive(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();

        DB::table('subjectarchive')
            ->insert([
                'teacherid' => $userinfo[0],
                'subjectid' => $query['subject'],
                'sectionid' => $query['section'],
            ]);

        return redirect('/grading');
    }

    public function checkArchive(Request $request)
    {
        $userinfo = $request->get('userinfo');
        $teacherid = $userinfo[0];
        $subjectid = $request->query('subjectid');
        $sectionid = $request->query('sectionid');

        // Query the subjectarchive table to check if the subject is in the archive
        $isInArchive = DB::table('subjectarchive')
            ->where('teacherid', $teacherid)
            ->where('subjectid', $subjectid)
            ->where('sectionid', $sectionid)
            ->exists();

        return response()->json($isInArchive);
    }

    public function gradingarchive(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['allyear'] = $allyear = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->select([
                'schoolyear'
            ])
            ->orderBy('schoolyear', 'desc')
            ->get()
            ->unique('schoolyear')
            ->toArray();

        $latestyear = DB::table('curriculums')
            ->orderBy('schoolyear', 'desc')
            ->first();

        $data['subjects'] = $subjects = DB::table('curriculums')
            ->whereJsonContains('cstt', [['teacherid' => $userinfo[0]]])
            ->where('schoolyear', $latestyear->schoolyear)
            ->get()
            ->toArray();

        $selectedTeacherId = $userinfo[0];
        $compiledCsttData = [];

        foreach ($subjects as $subject) {

            $csttArray = json_decode($subject->cstt, true);

            $filteredCsttData = array_filter($csttArray, function ($item) use ($selectedTeacherId) {
                return $item['teacherid'] == $selectedTeacherId;
            });

            foreach ($filteredCsttData as $csttItem) {
                $csttItem['curriculumid'] = $subject->id;
                $csttItem['section'] = $subject->name;
                $csttItem['semester'] = $subject->semester;
                $compiledCsttData[] = $csttItem;
            }
        }

        $data['compiledCsttData'] = $compiledCsttData;

        return view('teacher.gradesarchive', $data);
    }

}
