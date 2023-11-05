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


        $data['getSchoolYear'] = $getSchoolYear = DB::table('tuition')
            ->where('userid', $query['sid'])
            ->leftjoin('curriculums', 'curriculums.id', '=', 'tuition.yearid')
            ->get()
            ->toArray();

        if(!empty($query['year'])){
            $data['dbresult'] = $transaction = DB::table('tuition')
                ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'tuition.userid')
                ->leftjoin('curriculums', 'curriculums.id', '=', 'tuition.yearid')
                ->where('curriculums.schoolyear', $query['year'])
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
                    'curriculums.schoolyear',
                )
                ->first();
        } else {
            $recentYear = DB::table('tuition')
                ->where('userid', $query['sid'])
                ->leftjoin('curriculums', 'curriculums.id', '=', 'tuition.yearid')
                ->orderBy('curriculums.id', 'desc')
                ->first();


            $data['dbresult'] = $transaction = DB::table('tuition')
                ->leftjoin('main_users_details', 'main_users_details.userid', '=', 'tuition.userid')
                ->leftjoin('curriculums', 'curriculums.id', '=', 'tuition.yearid')
                ->where('yearid', $recentYear->id)
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
                    'curriculums.schoolyear',
                )
                ->first();
        }


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

        $getYear = DB::table('curriculums')
            ->where('schoolyear', $input['dyear'])
            ->first();

        $tuitionamount = DB::table('tuition')
            ->where('userid', $input['did'])
            ->where('yearid', $getYear->id)
            ->orderBy('id', 'desc')
            ->first();

        $transact = array();
        $transact['voucher'] = 0;
        $transact['tuition'] = 0;
        $transact['registration'] = 0;
        if(!empty($input['voucher'])){
            $transact['voucher'] = intval(str_replace(',', '', $input['voucher']));
        }
        if(!empty($input['tuition'])){
            $transact['tuition'] = intval(str_replace(',', '', $input['tuition']));
        }
        if(!empty($input['registration'])){
            $transact['registration'] = intval(str_replace(',', '', $input['registration']));
        }

        if($transact['voucher'] > $tuitionamount->voucher){
            return redirect($this->default_url.'?e=8');
            die();
        }

        if($transact['tuition'] > $tuitionamount->tuition){
            return redirect($this->default_url.'?e=8');
            die();
        }

        if($transact['registration'] > $tuitionamount->registration){
            return redirect($this->default_url.'?e=8');
            die();
        }


        $voucher = $tuitionamount->voucher - $transact['voucher'];
        $tuition = $tuitionamount->tuition - $transact['tuition'];
        $registration = $tuitionamount->registration - $transact['registration'];

        DB::table('tuition')
            ->where('userid', $input['did'])
            ->where('yearid', $getYear->id)
            ->update([
                'voucher' => $voucher,
                'tuition' => $tuition,
                'registration' => $registration,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        return redirect($this->default_url.'?n=6');
    }
}
