<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Mail\UpdateUser;
use Illuminate\Support\Facades\Mail;

class AlumniController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('axualumni');
    }

    public function home(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        $data['errorlist'] = [
            1 => 'Only Monday to Friday is Available',
            2 => 'Select a proper Inquiry.',
            3 => 'Select an appointment date.',
            4 => 'Select a Document for Document Request.',
            5 => 'Please select a future date',
        ];
        $data['error'] = 0;
        if (!empty($_GET['e'])) {
            $data['error'] = $_GET['e'];
        }

        $data['notiflist'] = [
            1 => 'Request Form Sent',
            2 => 'Appointment cancelled.'
        ];
        $data['notif'] = 0;
        if(!empty($_GET['n'])){
            $data['notif'] = $_GET['n'];
        }

        // dd($userinfo);
        $data['news'] = $news = DB::table('wp_posts')
            ->where('post_type', 'news')
            ->orderby('id', 'desc')
            ->limit(3)
            ->get()
            ->toArray();

        return view('alumni.home', $data);
    }

    public function  alumniappointment(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('alumni.appointment_add', $data);
    }

    public function alumniappointment_add_processs(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();


        $sections = DB::table('students')
            ->where('userid', $userinfo[0])
            ->leftjoin('curriculums', 'curriculums.id', '=', 'students.sectionid')
            ->orderBy('students.id', 'desc')
            ->first();

        $myself = DB::table('main_users')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'main_users.id')
            ->where('main_users.id', $userinfo[0])
            ->first();

        if(empty($input['inquiry']) || $input['inquiry'] == ""){
            return redirect('/alumni?e=2');
            die();
        }
        $forminput['inquiry'] = $inquiry = $input['inquiry'];
        $forminput['goodmoral'] = $goodmoral = false;
        $forminput['registration'] = $registration = false;
        $forminput['f138'] = $f138 = false;
        $forminput['others'] = $others = false;
        $forminput['otherdocument'] = $otherdocument = '';

        if(empty($input['goodmoral']) && empty($input['registration']) && empty($input['f138']) && empty($input['others'])){
            return redirect('/alumni?e=4');
            die();
        }

        if(!empty($input['goodmoral'])){
            $forminput['goodmoral'] = $goodmoral = true;
        }
        if(!empty($input['registration'])){
            $forminput['registration'] = $registration = true;
        }
        if(!empty($input['f138'])){
            $forminput['f138'] = $f138 = true;
        }
        if(!empty($input['others'])){
            if(!empty($input['otherdocument'])){
                $forminput['others'] = $others = true;
                $forminput['otherdocument'] = $otherdocument = $input['otherdocument'];
            }
        }

        if(empty($input['appointeddate'])){
            return redirect('/alumni?e=3');
            die();
        }

        $forminput['otherreason'] = $otherreason = $input['otherreason'];
        $appointeddate = $input['appointeddate'];
        $dateparse = Carbon::parse($appointeddate);

        if ($dateparse->isPast()){
            return redirect('/alumni?e=5');
            die();
        }

        if ($dateparse->isWeekend()){
            return redirect('/alumni?e=1');
            die();
        }

        $forminput['appointeddate'] = $appointeddate;

        DB::table('appointments')
        ->insert([
            'email' => $myself->email,
            'firstname' => $myself->firstname,
            'middlename' =>  $myself->middlename,
            'lastname' =>  $myself->lastname,
            'mobilenumber' => $myself->mobilenumber,
            'address' => $myself->address,
            'lrn' => $myself->lrn,
            'graduate' => 'Yes',
            'yearattended' => $sections->schoolyear,
            'section' => $sections->name,
            'inquiry' => $forminput['inquiry'],
            'goodmoral' => $forminput['goodmoral'],
            'registration' => $forminput['registration'],
            'f138' => $forminput['f138'],
            'others' => $forminput['others'],
            'otherdocument' => $forminput['otherdocument'],
            'otherreason' => $forminput['otherreason'],
            'appointeddate' => $forminput['appointeddate'],
            'created_at' => Carbon::now()->tz('Asia/Manila')->toDateTimeString(),
            'updated_at' => Carbon::now()->tz('Asia/Manila')->toDateTimeString()
        ]);

        $emailInfo = DB::table('appointments')
            ->where('email', $myself->email)
            ->orderBy('id', 'desc')
            ->first();


        $Mail = $emailInfo->email;
        $userMail = $emailInfo->firstname. ' '.$emailInfo->lastname;
        $statusMail = $emailInfo->active;
        $requestMail = $emailInfo->inquiry;
        $dateMail = $emailInfo->appointeddate;
        Mail::to($Mail)->send(new UpdateUser($userMail, $statusMail, $requestMail, $dateMail, "Appointment Pending", $emailInfo));


        return redirect('/alumni?n=1');
    }

    public function alumniappointmentslist(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        $page = 1;
        if(!empty($query['page'])){
            $page = $query['page'];
        }
        $qstring['page'] = $page;

        $data['sort'] = 0;
        $data['orderbylist'] = [
            ['display' => 'Default', 'field' => 'appointments.id'],
            ['display' => 'Status', 'field' => 'appointments.active'],
            ['display' => 'Inquiry', 'field' => 'appointments.inquiry'],
            ['display' => 'Appointed Date', 'field' => 'appointments.appointeddate'],
            ['display' => 'Created Date', 'field' => 'appointments.created_at']
        ];
        if(!empty($query['sort'])){
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }

        $myappointments = DB::table('appointments')
            ->where('email', $userinfo[4]);
        $countz = DB::table('appointments')
            ->where('email', $userinfo[4])
            ->count();

        $arrange = "asc";
        if($data['sort'] == 0){
            $arrange = "desc";
        }
        $myappointments->orderBy($data['orderbylist'][$data['sort']]['field'] , $arrange);


        $data['totalpages'] = ceil($countz / 10);
        $data['page'] = $page;
        $data['totalitems'] = $countz;
        $dataoffset = ($page*10)-10;

        $myappointments->offset($dataoffset)->limit(10);
        $data['qstring'] = http_build_query($qstring);
        $data['qstring2'] = $qstring;

        if ($page < 2) {
            //disabled URLS of first and previous button
            $data['page_first_url'] = '<a class="btn btn-warning disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-left fa-xs"></i> </a>';
            $data['page_prev_url'] = '<a class="btn btn-warning disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-left fa-xs"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = 1; //firstpage
            $data['page_first_url'] = '<a class="btn btn-warning" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-left fa-xs"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] - 1; // current page minus 1 for prev
            $data['page_prev_url'] = '<a class="btn btn-warning" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-left fa-xs"></i> </a>';
        }
        if ($page >= $data['totalpages']) {
            //disabled URLS on next and last button
            $data['page_last_url'] = '<a class="btn btn-warning disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angles-right fa-xs"></i> </a>';
            $data['page_next_url'] = '<a class="btn btn-warning disabled" href="#" role="button" aria-disabled="true" style="padding-top: 10px;"><i class="fa-solid fa-angle-right fa-xs"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = $data['totalpages']; //lastpage
            $data['page_last_url'] = '<a class="btn btn-warning" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angles-right fa-xs"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] + 1; //nest page
            $data['page_next_url'] = '<a class="btn btn-warning" href="?'.http_build_query($urlvar).'" role="button" style="padding-top: 10px;"><i class="fa-solid fa-angle-right fa-xs"></i> </a>';
        }

        $data['myappointments'] = $myappointments->get()->toArray();

        return view('alumni.appointment', $data);
    }
}
