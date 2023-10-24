<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SubjectAdminController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('axuadmin');
    }

    public $default_url = '/adminsubject';
    public $default_lpp = 25;
    public $default_start_page = 1;

    public $default_url_sub = '/subject_teacher';

    public function adminsubject(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['errorlist'] = [
            1 => 'All forms are required please try again.',
            2 => 'Your password is too short, it should be at least 8 characters long.',
            3 => 'Both password and retype password are not the same.',
            4 => 'The subject already existed, please try to check the subject on the list.',
            5 => 'This Subject does not exist',
            6 => 'Status should only be Active or Inactive',
            7 => 'Added Teacher to a Subject Sucessfully',
        ];
        $data['error'] = 0;
        if(!empty($_GET['e'])){
            $data['error'] = $_GET['e'];
        }

        $data['notiflist'] = [
            1 => 'New Subject has been saved.',
            2 => 'Changes has been saved.',
            3 => 'Password has been changed.',
            4 => 'Subject has been deleted.',
            5 => 'Added Teacher to a Subject Sucessfully'
        ];
        $data['notif'] = 0;
        if(!empty($_GET['n'])){
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
            ['display' => 'Default', 'field' => 'subjects.id'],
            ['display' => 'Subject', 'field' => 'subjects.subject_name'],
            ['display' => 'Strand', 'field' => 'subjects.strand'],
            ['display' => 'Semester', 'field' => 'subjects.semester'],
            ['display' => 'Year Level', 'field' => 'subjects.yearlevel'],
        ];
        if(!empty($query['sort'])){
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }

        $page = $this->default_start_page;
        if(!empty($query['page'])){
            $page = $query['page'];
        }
        $qstring['page'] = $page;

        $countdata = DB::table('subjects')
            ->count();
        $dbdata = DB::table('subjects');

        if(!empty($keyword)){
            $countdata = DB::table('subjects')
                ->where('subjects.subject_name', 'like', "%$keyword%")
                ->count();

            $dbdata->where('subjects.subject_name', 'like', "%$keyword%");
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

        return view('admin.subjects', $data);
    }

    public function adminsubject_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('admin.subjects_add', $data);
    }

    public function adminsubject_add_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['subjectname'])){
            return redirect($this->default_url.'?e=1');
            die();
        }

        $checksubject = DB::table('subjects')
            ->where('subject_name', $input['subjectname'])
            ->first();
        if(!empty($checksubject->subject_name)){
            return redirect($this->default_url.'?e=4');
            die();
        }

        $subjectid = DB::table('subjects')
            ->insertGetID([
                'subject_name' => $input['subjectname'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=1');
    }

    public function adminsubject_edit(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        if(empty($query['id'])){
            die('Error: Requirements are not complete');
        }

        $data['dbdata'] = $dbdata = DB::table('subjects')
            ->where('subjects.id', $query['id'])
            ->first();

        return view('admin.subjects_edit', $data);
    }

    public function adminsubject_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['subjectname'])){
            return redirect($this->default_url.'?e=1');
            die();
        }

        DB::table('subjects')
            ->where('id', $input['did'])
            ->update([
                'subject_name' => $input['subjectname'],
                'semester' => $input['semester'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=2');
    }

    public function adminsubject_delete_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : $this->default_lpp,
            'page' => !empty($input['page']) ? $input['page'] : $this-> default_page,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : ''
        ]);

        if(empty($input['did'])){
            return redirect($this->default_url.'?e1&'.$qstring);
            die();
        }

        DB::table('subjects')
            ->where('id', $input['did'])
            ->delete();

        return redirect($this->default_url.'?n=4&'.$qstring);
    }

    public function adminsubject_archive_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : $this->default_lpp,
            'page' => !empty($input['page']) ? $input['page'] : $this-> default_page,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : ''
        ]);

        if(empty($input['did'])){
            return redirect($this->default_url.'?e1&'.$qstring);
            die();
        }

        $subjectstatus = DB::table('subjects')
            ->where('id', $input['did'])
            ->first();

        if($subjectstatus->status == 'active'){
            DB::table('subjects')
            ->where('id', $input['did'])
            ->update([
                'status' => 'inactive',
            ]);
        } else {
            DB::table('subjects')
            ->where('id', $input['did'])
            ->update([
                'status' => 'active',
            ]);
        }

        return redirect($this->default_url.'?n=4&'.$qstring);
    }

    // Admin Teacher Components
    public function admin_teacher(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        if(empty($query['sid'])){
            die('Error: Requirements are not complete');
        }

        $data['qsid'] = $query['sid'];

        $data['errorlist'] = [
            1 => 'All forms are required please try again.',
            2 => 'Your password is too short, it should be at least 8 characters long.',
            3 => 'Both password and retype password are not the same.',
            4 => 'The Teacher already existed, please try to check the Teacher on the list.',
            5 => 'This Subject does not exist',
            6 => 'Status should only be Active or Inactive',
            7 => 'Added Teacher to a Subject Sucessfully',
        ];
        $data['error'] = 0;
        if(!empty($_GET['e'])){
            $data['error'] = $_GET['e'];
        }

        $data['notiflist'] = [
            1 => 'Add.',
            2 => 'Changes has been saved.',
            3 => 'Password has been changed.',
            4 => 'Teacher on a Subject has been deleted.',
            5 => 'Added Teacher to a Subject Sucessfully'
        ];
        $data['notif'] = 0;
        if(!empty($_GET['n'])){
            $data['notif'] = $_GET['n'];
        }

        $data['subjectname'] = $subjectname = DB::table('subjects')
            ->where('id', $query['sid'])
            ->first();

        $data['dbdata'] = $dbdata = DB::table('teachers')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'teachers.userid')
            ->leftjoin('subjects', 'subjects.id', '=', 'teachers.subjectid')
            ->where('subjectid', $query['sid'])
            ->select('main_users_details.userid', 'main_users_details.firstname', 'main_users_details.middlename', 'main_users_details.lastname' ,'subjects.subject_name', 'teachers.subjectid');

        $data['dbresult'] = $dbresult = $dbdata->get()->toArray();

        return view('admin.subject_teacher', $data);
    }

    public function admin_teacher_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();

        $data['sid'] = $query['sid'];

        $data['teachers'] = $teachers = DB::table('main_users')
            ->where('accounttype', 'teacher')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->select('main_users.id', 'main_users_details.firstname', 'main_users_details.middlename', 'main_users_details.lastname')
            ->get()
            ->toArray();

        return view('admin.subject_teacheradd', $data);
    }

    public function admin_teacher_add_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'sid' => !empty($input['sid']) ? $input['sid'] : '',
        ]);


        if(empty($input['teacher'])){
            return redirect($this->default_url_sub.'?e=1&'.$qstring);
            die();
        }

        $checkname = DB::table('teachers')
            ->where('subjectid', $input['sid'])
            ->where('userid', $input['teacher'])
            ->first();

        if(!empty($checkname->id)){
            return redirect($this->default_url_sub.'?e=4&'.$qstring);
            die();
        }

        DB::table('teachers')
            ->insertGetID([
                'userid' => $input['teacher'],
                'subjectid' => $input['sid'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url_sub.'?n=5&'.$qstring);
    }

    public function admin_teacher_delete_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();
        $query = $request->query();

        // QSTRING PROBLEM
        $qstring = http_build_query([
            'sid' => !empty($query['sid']) ? $query['sid'] : '',
        ]);

        if(empty($input['did'])){
            return redirect($this->default_url_sub.'?e=1&'.$qstring);
            die();
        }

        $test = DB::table('teachers')
            ->where('userid', $input['did'])
            ->where('subjectid', $input['sid'])
            ->delete();

        return redirect($this->default_url_sub.'?n=4&'.$qstring);
    }

}
