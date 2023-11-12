<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RealCurriculumController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('axuadmin');
    }

    public $default_url_adminuser = "/admincurriculum";
    public $default_lpp = 25;
    public $default_start_page = 1;

    public function admincurriculum(Request $request){
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
            1 => 'Curriculum Added.',
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
            ['display' => 'Default', 'field' => 'realcurriculums.id'],
            ['display' => 'Name', 'field' => 'realcurriculums.name'],
            ['display' => 'School Year', 'field' => 'realcurriculums.schoolyear'],
            ['display' => 'Year Level', 'field' => 'realcurriculums.yearlevel'],
        ];
        if(!empty($query['sort'])){
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }

        $page = $this->default_start_page;
        if(!empty($query['page'])){
            $page = $query['page'];
        }
        $qstring['page'] = $page;

        $countdata = DB::table('realcurriculums')
            ->count();
        $dbdata = DB::table('realcurriculums');

        if(!empty($keyword)){
            $countdata = DB::table('realcurriculums')
                ->where('realcurriculums.name', 'like', "%$keyword%")
                ->orWhere('realcurriculums.yearlevel', 'like', "%$keyword%")
                ->count();

            $dbdata->where('realcurriculums.name', 'like', "%$keyword%");
            $dbdata->orWhere('realcurriculums.yearlevel', 'like', "%$keyword%");
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

        return view('admin.newcurriculum', $data);
    }

    public function admincurriculum_subjects(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();

        $data['subjects'] = $subjects = DB::table('realcurriculums')
            ->where('id', $query['sid'])
            ->first();

        // dd($subjects);

        return view('admin.newcurriculum_subjects', $data);

        dd($subjects);
    }

    public function admincurriculum_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('admin.newcurriculum_add', $data);
    }

    public function admincurriculum_add_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $csttData = [];

        for($i = 0; $i < count($input['subject']) ; $i++){
            $csttData[] = [
                'subjectid' => $input['subject'][$i],
            ];
        }

        // dd($input);
        // dd(json_encode($csttData));

        DB::table('realcurriculums')
            ->insert([
                'name' => $input['name'],
                'schoolyear' => $input['schoolyear'],
                'yearlevel' => $input['yearlevel'],
                'strand' => $input['strand'],
                'semester' => $input['semester'],
                'cstt' => json_encode($csttData),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);


        return redirect('/admincurriculum?n=1');
    }

    public function admincurriculum_edit(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        $data['curriculum'] = $curriculum = DB::table('realcurriculums')
            ->where('id', $query['id'])
            ->first();


        // dd($curriculum);
        return view('admin.newcurriculum_edit', $data);
    }

    public function admincurriculum_edit_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();


        $csttData = [];

        for($i = 0; $i < count($input['subject']) ; $i++){
            $csttData[] = [
                'subjectid' => $input['subject'][$i],
            ];
        }

        DB::table('realcurriculums')
            ->where('id', $input['sid'])
            ->update([
                'name' => $input['name'],
                'schoolyear' => $input['schoolyear'],
                'yearlevel' => $input['yearlevel'],
                'strand' => $input['strand'],
                'semester' => $input['semester'],
                'cstt' => json_encode($csttData),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect('/admincurriculum?n=1');
    }

    public function admincurriculum_archive(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $qstring = http_build_query([
            'lpp' => !empty($input['lpp']) ? $input['lpp'] : $this->default_lpp,
            'page' => !empty($input['page']) ? $input['page'] : $this->default_start_page,
            'keyword' => !empty($input['keyword']) ? $input['keyword'] : '',
            'sort' => !empty($input['sort']) ? $input['sort'] : '',
        ]);

        if(empty($input['did'])){
            return redirect($this->default_url_adminuser.'?e1&'.$qstring);
            die();
        }

        $logindata = DB::table('realcurriculums')
            ->where('id', $input['did'])
            ->first();

        if(empty($logindata)){
            return redirect($this->default_url_adminuser.'?e=5&'.$qstring);
            die();
        }

        if($logindata->status == 'active'){
            DB::table('realcurriculums')
                ->where('id', $input['did'])
                ->update([
                    'status' => 'inactive',
                ]);
        } else {
            DB::table('realcurriculums')
                ->where('id', $input['did'])
                ->update([
                    'status' => 'active',
                ]);
        }

        return redirect($this->default_url_adminuser.'?n=4&'.$qstring);
    }
}
