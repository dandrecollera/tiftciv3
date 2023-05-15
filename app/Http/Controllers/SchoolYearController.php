<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SchoolYearController extends Controller
{
    public function __consturct(Request $request){
        $this-middleware('axuadmin');
    }

    public $default_url = '/adminschoolyear';
    public $default_lpp = 25;
    public $default_start_page = 1;

    public function adminschoolyear(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['errorlist'] = [
            1 => 'All forms are required please try again.',
            2 => 'The School Year is already existed, please try to check the School Year on the list.',
            3 => 'This School Year does not exist',
            4 => 'Status should only be Active or Inactive',
        ];
        $data['error'] = 0;
        if(!empty($_GET['e'])){
            $data['error'] = $_GET['e'];
        }

        $data['notiflist'] = [
            1 => 'New School Year has been added.',
            2 => 'School Year has been deleted.',
            3 => 'School Year has been deactivated.',
            4 => 'School Year has been activated.',
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
            ['display' => 'ID', 'field' => 'schoolyears.id'],
            ['display' => 'School Year', 'field' => 'schoolyears.school_year'],
            ['display' => 'Status', 'field' => 'schoolyears.status'],
        ];
        if(!empty($query['sort'])){
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }

        $page = $this->default_start_page;
        if(!empty($query['page'])){
            $page = $query['page'];
        }
        $qstring['page'] = $page;

        $countdata = DB::table('schoolyears')
            ->count();
        $dbdata = DB::table('schoolyears');

        if(!empty($keyword)){
            $countdata = DB::table('schoolyears')
                ->where('schoolyears.school_year', 'like', "%$keyword%")
                ->count();

            $dbdata->where('schoolyears.school_year', 'like', "%$keyword%");
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

        return view('admin.schoolyear', $data);
    }

    public function adminschoolyear_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('admin.schoolyear_add', $data);
    }

    public function adminschoolyear_add_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $currentyear = DB::table('schoolyears')
            ->orderBy('id', 'desc')
            ->first();

        $years = explode('-', $currentyear->school_year);
        $newyear = intval($years[1]) + 1;
        $newacademicyear = $years[1]. '-' . strval($newyear);

        $schoolyearid = DB::table('schoolyears')
            ->insertGetID([
                'school_year' => $newacademicyear,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);


        // 12 -> Grad, 11 -> 12
        DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('main_users.accounttype', 'student')
            ->where('main_users_details.yearlevel', '12')
            ->update([
                'main_users_details.yearlevel' => 'Graduate',
            ]);

        DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('main_users.accounttype', 'student')
            ->where('main_users_details.yearlevel', '11')
            ->update([
                'main_users_details.yearlevel' => '12',
            ]);

        // Get the new 12 and update their section
        $get1112 = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->leftjoin('students', 'students.userid', '=', 'main_users.id')
            ->leftjoin('sections', 'sections.id', '=', 'students.sectionid')
            ->where('accounttype', 'student')
            ->where('main_users_details.yearlevel', '12')
            ->select(
                'main_users_details.strand',
                'sections.section_name',
                'main_users.id',
            )
            ->get();

        $voucher = 0;
        $tuition = 0;
        $registration = 0;
        foreach ($get1112 as $students => $student) {
            $newsection = DB::table('sections')
                ->where('strand', $student->strand)
                ->where('section_name', $student->section_name)
                ->where('yearlevel', '12')
                ->first();

            DB::table('students')
                ->where('userid', $student->id)
                ->update([
                    'sectionid' => $newsection->id,
                ]);

            $tuitiondb = DB::table('tuition')
                ->where('userid', $student->id)
                ->select('paymenttype')
                ->first();

            if($tuitiondb->paymenttype == 'public'){
                $voucher = 17500.00;
                $tuition = 0.00;
                $registration = 1000.00;
            } else if($tuitiondb->paymenttype == 'semi'){
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
                'userid' => $student->id,
                'yearid' => $schoolyearid,
                'paymenttype' => $tuitiondb->paymenttype,
                'paymentmethod' => 'semestral',
                'voucher' => $voucher,
                'tuition' => $tuition,
                'registration' => $registration,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        }


        $getGrad = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('accounttype', 'student')
            ->where('yearlevel', 'Graduate')
            ->get();

        foreach ($getGrad as $students => $student) {
            DB::table('students')
                ->where('userid', $student->id)
                ->delete();
        }


        return redirect($this->default_url.'?n=1');
    }

    public function adminschoolyear_lock_process(Request $request){
        $data = array();
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : $this->default_lpp,
            'page' => !empty($input['page']) ? $input['page'] : $this-> default_page,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : ''
        ]);

        if(empty($input['sid'])){
            return redirect($this->default_url.'?e1&'.$qstring);
            die();
        }

        DB::table('schoolyears')
            ->where('id', $input['sid'])
            ->update([
                'status' => "inactive",
            ]);

        return redirect($this->default_url.'?n=3');
    }

    public function adminschoolyear_activate_process(Request $request){
        $data = array();
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : $this->default_lpp,
            'page' => !empty($input['page']) ? $input['page'] : $this-> default_page,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : ''
        ]);

        if(empty($input['sid'])){
            return redirect($this->default_url.'?e1&'.$qstring);
            die();
        }

        DB::table('schoolyears')
            ->where('id', $input['sid'])
            ->update([
                'status' => "active",
            ]);

        return redirect($this->default_url.'?n=4');
    }

    public function adminschoolyear_delete_process(Request $request){
        $data = array();
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : $this->default_lpp,
            'page' => !empty($input['page']) ? $input['page'] : $this-> default_page,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : ''
        ]);

        if(empty($input['sid'])){
            return redirect($this->default_url.'?e1&'.$qstring);
            die();
        }

        DB::table('schoolyears')
            ->where('id', $input['sid'])
            ->delete();

        return redirect($this->default_url.'?n=2');
    }
}
