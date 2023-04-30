<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('axuadmin');
    }

    public $default_url = '/adminsection';
    public $default_lpp = 25;
    public $default_start_page = 1;

    public $default_url_sched = '/adminschedule';

    public function adminsection(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['errorlist'] = [
            1 => 'All forms are required please try again.',
            2 => 'The section already existed, please try to check the section on the list.',

        ];
        $data['error'] = 0;
        if(!empty($_GET['e'])){
            $data['error'] = $_GET['e'];
        }

        $data['notiflist'] = [
            1 => 'New Section has been saved.',
            2 => 'Section successfully edited.',
            3 => 'Section does not exist.',
            4 => 'Section has been deleted.'
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
            ['display' => 'ID', 'field' => 'sections.id'],
            ['display' => 'Section', 'field' => 'sections.section_name'],
            ['display' => 'Strand', 'field' => 'sections.strand'],
            ['display' => 'Year Level', 'field' => 'sections.yearlevel']
        ];
        if(!empty($query['sort'])){
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }

        $page = $this->default_start_page;
        if(!empty($query['page'])){
            $page = $query['page'];
        }
        $qstring['page'] = $page;

        $countdata = DB::table('sections')
            ->count();
        $dbdata = DB::table('sections');

        if(!empty($keyword)){
            $countdata = DB::table('sections')
                ->where('sections.section_name', 'like', "%$keyword%")
                ->orwhere('sections.strand', 'like', "%$keyword%")
                ->orwhere('sections.yearlevel', 'like', "%$keyword%")
                ->count();

            $dbdata->where('sections.section_name', 'like', "%$keyword%");
            $dbdata->orwhere('sections.strand', 'like', "%$keyword%");
            $dbdata->orwhere('sections.yearlevel', 'like', "%$keyword%");
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
            $data['page_first_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-left fa-xs"></i> </a>';
            $data['page_prev_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-left fa-xs"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = 1; //firstpage
            $data['page_first_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-left fa-xs"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] - 1; // current page minus 1 for prev
            $data['page_prev_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-left fa-xs"></i> </a>';
        }
        if ($page >= $data['totalpages']) {
            //disabled URLS on next and last button
            $data['page_last_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-right fa-xs"></i> </a>';
            $data['page_next_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-right fa-xs"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = $data['totalpages']; //lastpage
            $data['page_last_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-right fa-xs"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] + 1; //nest page
            $data['page_next_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-right fa-xs"></i> </a>';
        }

        $data['dbresult'] = $dbresult = $dbdata->get()->toArray();

        return view('admin.sections', $data);
    }

    public function adminsection_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('admin.sections_add', $data);
    }

    public function adminsection_add_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['sectionname']) || empty($input['strand']) || empty($input['yearlevel'])){
            return redirect($this->default_url.'?e=1');
            die();
        }

        $checksection = DB::table('sections')
            ->where('section_name', $input['sectionname'])
            ->first();
        if(!empty($checksection->section_name)){
            return redirect($this->default_url.'?e=2');
            die();
        }

        $sectionid = DB::table('sections')
            ->insertGetID([
                'section_name' => $input['sectionname'],
                'strand' => $input['strand'],
                'yearlevel' => $input['yearlevel'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=1');
    }

    public function adminsection_edit(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        if(empty($query['id'])){
            die('Error: Requirements are not complete');
        }

        $data['dbdata'] = $dbdata = DB::table('sections')
            ->select('sections.*')
            ->where('sections.id', $query['id'])
            ->first();

        return view('admin.sections_edit', $data);
    }

    public function adminsection_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        if(empty($input['sid']) ||empty($input['sectionname']) || empty($input['strand']) || empty($input['yearlevel'])){
            return redirect($this->default_url.'?e=1');
            die();
        }

        DB::table('sections')
            ->where('id', $input['sid'])
            ->update([
                'section_name' => $input['sectionname'],
                'strand' => $input['strand'],
                'yearlevel' => $input['yearlevel'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect($this->default_url.'?n=2');
    }

    public function adminsection_delete_process(Request $request){
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

        DB::table('sections')
            ->where('id', $input['sid'])
            ->delete();

        return redirect($this->default_url.'?n=4&'.$qstring);
    }

    public function adminschedule(Request $request){
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

        $data['section'] = $subjectname = DB::table('sections')
            ->where('id', $query['sid'])
            ->first();

        $data['dbdata'] = $dbdata = DB::table('schedules')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'schedules.teacherid')
            ->leftjoin('sections', 'sections.id', '=', 'schedules.sectionid')
            ->leftjoin('subjects', 'subjects.id', '=', 'schedules.subjectid')
            ->where('sectionid', $query['sid'])
            ->select(
                'main_users_details.userid',
                'main_users_details.firstname',
                'main_users_details.middlename',
                'main_users_details.lastname',
                'subjects.subject_name',
                'sections.section_name',
                'subjects.subject_name',
                DB::raw("TIME_FORMAT(schedules.start_time, '%h:%i %p') as start_time"),
                DB::raw("TIME_FORMAT(schedules.end_time, '%h:%i %p') as end_time"),
                'schedules.day'
            );

        $data['dbresult'] = $dbresult = $dbdata->get()->toArray();

        return view('admin.schedules', $data);
    }

    public function adminschedule_add(Request $request)
    {

    }
}
