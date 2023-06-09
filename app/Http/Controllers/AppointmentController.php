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

class AppointmentController extends Controller
{
    public function index(Request $request){
        $data = array();

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


        return view('publicappointment', $data);
    }

    public function appointment_add(Request $request){
        return view('appointment_add');
    }

    public function appointment_add_process(Request $request){
        $input = $request->input();

        $forminput = array();

        if(empty($input['inquiry']) || $input['inquiry'] == ""){
            return redirect('/appointment?e=2');
            die();
        }

        $forminput['email'] = $email = $input['email'];
        $forminput['lrn'] = $email = $input['lrn'];
        $forminput['firstname'] = $firstname = $input['firstname'];
        $forminput['middlename'] = $middlename = empty($input['middlename']) ? '' : $input['middlename'];
        $forminput['lastname'] = $lastname = $input['lastname'];
        $forminput['mobilenumber'] = $mobilenumber = empty($input['mobilenumber']) ? '' : $input['mobilenumber'];
        $forminput['address'] = $address = empty($input['address']) ? '' : $input['address'];

        $forminput['graduate'] = $graduate = $input['graduate'];
        $forminput['yearattended'] = $yearattended = $input['lastyearattended'];
        $forminput['section'] = $section = $input['strand'];

        $forminput['inquiry'] = $inquiry = $input['inquiry'];

        $forminput['goodmoral'] = $goodmoral = false;
        $forminput['f137'] = $f137 = false;
        $forminput['f138'] = $f138 = false;
        $forminput['diploma'] = $diploma = false;
        $forminput['others'] = $others = false;
        $forminput['otherdocument'] = $otherdocument = '';
        if($inquiry == 'Document Request'){

            if(empty($input['goodmoral']) && empty($input['f137']) && empty($input['f138']) && empty($input['diploma']) && empty($input['others'])){
                return redirect('/appointment?e=4');
                die();
            }

            if(!empty($input['goodmoral'])){
                $forminput['goodmoral'] = $goodmoral = true;
            }
            if(!empty($input['f137'])){
                $forminput['f137'] = $f137 = true;
            }
            if(!empty($input['f138'])){
                $forminput['f138'] = $f138 = true;
            }
            if(!empty($input['diploma'])){
                $forminput['diploma'] = $diploma = true;
            }
            if(!empty($input['others'])){
                if(!empty($input['otherdocument'])){
                    $forminput['others'] = $others = true;
                    $forminput['otherdocument'] = $otherdocument = $input['otherdocument'];
                }
            }
        }

        if(empty($input['appointeddate'])){
            return redirect('/appointment?e=3');
            die();
        }

        $forminput['otherreason'] = $otherreason = $input['otherreason'];
        $appointeddate = $input['appointeddate'];
        $dateparse = Carbon::parse($appointeddate);

        if ($dateparse->isPast()){
            return redirect('/appointment?e=5');
            die();
        }

        if ($dateparse->isWeekend()){
            return redirect('/appointment?e=1');
            die();
        }
        $forminput['appointeddate'] = $appointeddate;
        $forminput['otherreason'] = $otherreason = $input['otherreason'];

        DB::table('appointments')
            ->insert([
                'email' => $forminput['email'],
                'firstname' => $forminput['firstname'],
                'middlename' => $forminput['middlename'],
                'lastname' => $forminput['lastname'],
                'mobilenumber' => $forminput['mobilenumber'],
                'address' => $forminput['address'],
                'graduate' => $forminput['graduate'],
                'yearattended' => $forminput['yearattended'],
                'section' => $forminput['section'],
                'inquiry' => $forminput['inquiry'],
                'goodmoral' => $forminput['goodmoral'],
                'f137' => $forminput['f137'],
                'f138' => $forminput['f138'],
                'diploma' => $forminput['diploma'],
                'lrn' => $forminput['lrn'],
                'others' => $forminput['others'],
                'otherdocument' => $forminput['otherdocument'],
                'otherreason' => $forminput['otherreason'],
                'appointeddate' => $forminput['appointeddate'],
                'created_at' => Carbon::now()->tz('Asia/Manila')->toDateTimeString(),
                'updated_at' => Carbon::now()->tz('Asia/Manila')->toDateTimeString()
            ]);

        $emailInfo = DB::table('appointments')
            ->where('email', $forminput['email'])
            ->orderBy('id', 'desc')
            ->first();


        $Mail = $emailInfo->email;
        $userMail = $emailInfo->firstname. ' '.$emailInfo->lastname;
        $statusMail = $emailInfo->active;
        $requestMail = $emailInfo->inquiry;
        $dateMail = $emailInfo->appointeddate;
        Mail::to($Mail)->send(new UpdateUser($userMail, $statusMail, $requestMail, $dateMail, "Appointment Pending"));

        return redirect('/appointment?n=1');
    }
}
