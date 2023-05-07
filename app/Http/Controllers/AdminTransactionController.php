<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminTransactionController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('axuadmin');
    }

    public $default_url = 'adminstudent';

    public function admintransaction(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        $query = $request->query();
        if(empty($query['sid'])){
            die('Error: Requirements are not complete');
        }

        $data['qsid'] = $query['sid'];

        $data['errorlist'] = [
            1 => 'All forms are required please try again.',
            2 => 'Enter the right amount',
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

        $data['schoolyear'] = $schoolyear = DB::table('schoolyears')
            ->leftjoin('tuition', 'tuition.yearid', '=', 'schoolyears.id')
            ->orderBy('schoolyears.id', 'desc')
            ->select('schoolyears.id', 'yearid', 'school_year')
            ->first();



        $data['dbresult'] = $transaction = DB::table('tuition')
            ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'tuition.userid')
            ->leftjoin('schoolyears', 'schoolyears.id', '=', 'tuition.yearid')
            ->where('yearid', $schoolyear->id)
            ->where('tuition.userid', $query['sid'])
            ->select(
                'main_users_details.firstname',
                'main_users_details.middlename',
                'main_users_details.lastname',
                'tuition.paymenttype',
                'tuition.paymentmethod',
                'tuition.voucher',
                'tuition.tuition',
                'tuition.registration',
                'schoolyears.school_year',
            )
            ->first();

            // dd($transaction);
        return view('admin.transaction', $data);
    }

    public function admintransaction_deduct_process(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();
        $query = $request->query();


        if(empty($input['did'])){
            return redirect($this->default_url.'?e=1&');
            die();
        }

        $tuitionamount = DB::table('tuition')
            ->where('userid', $input['did'])
            ->first();

        if($input['voucher'] > $tuitionamount->voucher){
            return redirect($this->default_url.'?e=8');
            die();
        }

        if($input['tuition'] > $tuitionamount->tuition){
            return redirect($this->default_url.'?e=8');
            die();
        }

        if($input['registration'] > $tuitionamount->registration){
            return redirect($this->default_url.'?e=8');
            die();
        }


        $voucher = $tuitionamount->voucher - $input['voucher'];
        $tuition = $tuitionamount->tuition - $input['tuition'];
        $registration = $tuitionamount->registration - $input['registration'];

        DB::table('tuition')
            ->where('userid', $input['did'])
            ->update([
                'voucher' => $voucher,
                'tuition' => $tuition,
                'registration' => $registration,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        return redirect($this->default_url.'?n=6');
    }
}
