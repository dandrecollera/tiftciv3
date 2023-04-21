<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function __construct(Request $request) {
        $this->middleware('axuadmin'); //only admin can enter here
    }

    public $default_url = '/adminteachers';
    public $default_lpp = 25;
    public $default_start_page = 1;
    public $default_accounttype = 'teacher';

    public function teacheruser(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $data['errorlist'] = [
            1 => 'All forms are required please try again.',
            2 => 'Your password is too short, it should be at least 8 characters long.',
            3 => 'Both password and retype password are not the same.',
            4 => 'the email already existed, please try to check the user on the list.',
            5 => 'This user doed not exist',
            6 => 'status should only be Active or Inactive',
        ];

        $data['error'] = 0;
        if(!empty($_GET['e'])){
            $data['error'] = $_GET['e'];
        }

        $data['notiflist'] = [
            1 => 'New User has been saved.',
            2 => 'Changes has been saved.',
            3 => 'Password has been changed.',
            4 => 'User has been deleted.'
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
            ['display'=>'ID', 'field'=>'main_users.id'],
            ['display'=>'Username/Email', 'field'=>'main_users.email'],
            ['display'=>'Last Name', 'field'=>'main_users_details.lastname'],
            ['display'=>'First Name', 'field'=>'main_users_details.firstname'],
            ['display'=>'Middle Name', 'field'=>'main_users_details.middlename']
        ];
        if(!empty($query['sort'])){
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }

        $page = $this->default_start_page;
        if(!empty($query['page'])){
            $page = $query['page'];
        }
        $qstring['page'] = $page;

        $countdata = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('accounttype', $this->default_accounttype)
            ->count();
        $dbdata = DB::table('main_users')
            ->select('main_users.*', 'main_users_details.firstname', 'main_users_details.middlename', 'main_users_details.lastname', 'main_users_details.mobilenumber', 'main_users_details.address')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('accounttype', $this->default_accounttype);
        if(!empty($keyword)){
            $countdata = DB::table('main_users')
                ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
                ->where('accounttype', $this->default_accounttype)
                ->where('main_users.email', 'like', "%$keyword%")
                ->orwhere('main_users_details.firstname', 'like', "%$keyword%")
                ->orwhere('main_users_details.middlename', 'like', "%$keyword%")
                ->orwhere('main_users_details.lastname', 'like', "%$keyword%")
                ->orwhere('main_users_details.mobilenumber', 'like', "%$keyword%")
                ->orwhere('main_users_details.address', 'like', "%$keyword%")
                ->count();

            $dbdata->where('main_users.email', 'like', "%$keyword%");
            $dbdata->orwhere('main_users_details.firstname', 'like', "%$keyword%");
            $dbdata->orwhere('main_users_details.middlename', 'like', "%$keyword%");
            $dbdata->orwhere('main_users_details.lastname', 'like', "%$keyword%");
            $dbdata->orwhere('main_users_details.mobilenumber', 'like', "%$keyword%");
            $dbdata->orwhere('main_users_details.address', 'like', "%$keyword%");
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
            $data['page_first_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-left"></i> </a>';
            $data['page_prev_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-left"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = 1; //firstpage
            $data['page_first_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-left"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] - 1; // current page minus 1 for prev
            $data['page_prev_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-left"></i> </a>';
        }
        if ($page >= $data['totalpages']) {
            //disabled URLS on next and last button
            $data['page_last_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-right"></i> </a>';
            $data['page_next_url'] = '<a class="btn btn-success disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-right"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = $data['totalpages']; //lastpage
            $data['page_last_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-right"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] + 1; //nest page
            $data['page_next_url'] = '<a class="btn btn-success" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-right"></i> </a>';
        }

        $data['dbresult'] = $dbresult = $dbdata->get()->toArray();

        return view('admin.teachers', $data);
    }
}
