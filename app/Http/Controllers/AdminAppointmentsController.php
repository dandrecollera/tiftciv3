<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Mail\UpdateUser;
use Illuminate\Support\Facades\Mail;


class AdminAppointmentsController extends Controller
{
    public function __construct(Request $request) {
        $this->middleware('axuadmin');
    }

    public $default_url = '/adminappointments';
    public $default_lpp = 25;
    public $default_start_page = 1;

    public function adminappointments(Request $request){
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
            1 => 'Appointment Approved.',
            2 => 'Appointment Declined.',
            3 => 'Appointment Completed.',
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
            ['display' => 'Default', 'field' => 'appointments.id'],
            ['display' => 'Email', 'field' => 'appointments.email'],
            ['display' => 'Inquiry', 'field' => 'appointments.inquiry'],
            ['display' => 'Appointed Date', 'field' => 'appointments.appointeddate'],
            ['display' => 'Created Date', 'field' => 'appointments.created_at']
        ];
        if(!empty($query['sort'])){
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }

        $page = $this->default_start_page;
        if(!empty($query['page'])){
            $page = $query['page'];
        }
        $qstring['page'] = $page;

        $countdata = DB::table('appointments')
            ->count();
        $dbdata = DB::table('appointments')
            ->select('id', 'email', 'inquiry', 'created_at', 'appointeddate', 'active');



        if(!empty($keyword)){
            $countdata = DB::table('appointments')
                ->where('appointments.email', 'like', "%$keyword%")
                ->orwhere('appointments.inquiry', 'like', "%$keyword%")
                ->orwhere('appointments.created_at', 'like', "%$keyword%")
                ->orwhere('appointments.appointeddate', 'like', "%$keyword%")
                ->count();

            $dbdata->where('appointments.email', 'like', "%$keyword%");
            $dbdata->orwhere('appointments.inquiry', 'like', "%$keyword%");
            $dbdata->orwhere('appointments.created_at', 'like', "%$keyword%");
            $dbdata->orwhere('appointments.appointeddate', 'like', "%$keyword%");
        }

        $arrange = "asc";
        if($data['sort'] == 0){
            $arrange = "desc";
        }
        $dbdata->orderBy($data['orderbylist'][$data['sort']]['field'] , $arrange);

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

        return view('admin.appointments', $data);
    }

    public function adminappointments_info(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();

        $data['info'] = $info = DB::table('appointments')
            ->where('id', $query['sid'])
            ->first();



        return view('admin.appointments_info', $data);
    }

    public function adminappointments_delete_process(Request $request){
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

        DB::table('appointments')
            ->where('id', $input['sid'])
            ->update([
                'active' => "Approved",
            ]);

        $emailInfo = DB::table('appointments')
            ->where('id', $input['sid'])
            ->first();


        $Mail = $emailInfo->email;
        $userMail = $emailInfo->firstname. ' '.$emailInfo->lastname;
        $statusMail = $emailInfo->active;
        $requestMail = $emailInfo->inquiry;
        $dateMail = $emailInfo->appointeddate;
        Mail::to($Mail)->send(new UpdateUser($userMail, $statusMail, $requestMail, $dateMail, "Appointment Approved", $emailInfo));

        return redirect('/adminappointments?n=1');
    }

    public function adminappointments_decline_process(Request $request){
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

        DB::table('appointments')
            ->where('id', $input['sid'])
            ->update([
                'active' => "Declined",
            ]);

        $emailInfo = DB::table('appointments')
            ->where('id', $input['sid'])
            ->first();


        $Mail = $emailInfo->email;
        $userMail = $emailInfo->firstname. ' '.$emailInfo->lastname;
        $statusMail = $emailInfo->active;
        $requestMail = $emailInfo->inquiry;
        $dateMail = $emailInfo->appointeddate;
        Mail::to($Mail)->send(new UpdateUser($userMail, $statusMail, $requestMail, $dateMail, "Appointment Declined", $emailInfo));


        return redirect('/adminappointments?n=2');
    }

    public function adminappointments_complete_process(Request $request){
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

        DB::table('appointments')
            ->where('id', $input['sid'])
            ->update([
                'active' => "Completed",
            ]);

        $emailInfo = DB::table('appointments')
            ->where('id', $input['sid'])
            ->first();


        $Mail = $emailInfo->email;
        $userMail = $emailInfo->firstname. ' '.$emailInfo->lastname;
        $statusMail = $emailInfo->active;
        $requestMail = $emailInfo->inquiry;
        $dateMail = $emailInfo->appointeddate;
        Mail::to($Mail)->send(new UpdateUser($userMail, $statusMail, $requestMail, $dateMail, "Appointment Complete", $emailInfo));


        return redirect('/adminappointments?n=3');
    }

    public function registrarreport(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
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
            ['display' => 'Default', 'field' => 'appointments.id'],
            ['display' => 'Email', 'field' => 'appointments.email'],
            ['display' => 'Inquiry', 'field' => 'appointments.inquiry'],
            ['display' => 'Appointed Date', 'field' => 'appointments.appointeddate'],
            ['display' => 'Created Date', 'field' => 'appointments.created_at']
        ];
        if(!empty($query['sort'])){
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }
        // dd($lpp);
        $page = $this->default_start_page;
        if(!empty($query['page'])){
            $page = $query['page'];
        }
        $qstring['page'] = $page;

        $countdata = DB::table('appointments')
            // ->where('active', 'Approved')
            ->where('active', 'Completed')
            ->count();
        $dbdata = DB::table('appointments')
            // ->where('active', '=' ,'Approved')
            ->where('active', 'Completed')
            ->orderBy('id', 'desc');

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

        return view('admin.registrarreport', $data);
    }
}
