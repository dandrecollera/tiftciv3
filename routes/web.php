<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\RealCurriculumController;
use App\Http\Controllers\SubjectAdminController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\AdminAppointmentsController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\EmailUpdateController;
use App\Http\Controllers\AdminAlumni;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\StudentCashierController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\MainTeacherController;
use App\Http\Controllers\Alumni\AlumniController;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/testmail', [EmailUpdateController::class, 'index'])->name('testemail');
Route::get('/', [LoginController::class, 'index'])->name('loginScreen');
Route::post('/login', [LoginController::class, 'login'])->name('loginProcess');
Route::get('/logout', [LoginController::class, 'logout'])->name('logoutProcess');
Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');
Route::get('/appointment_add', [AppointmentController::class, 'appointment_add'])->name('appointment_add');
Route::post('/appointment_add_process', [AppointmentController::class, 'appointment_add_process'])->name('appointment_add_process');


Route::get('/getDailyChartData', function () {
    $sixDaysAgo = Carbon::now()->subDays(6)->toDateString();

    $dailyData = DB::table('transactions')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total_amount'))
        ->where('created_at', '>=', $sixDaysAgo)
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    return response()->json($dailyData);
});

Route::get('/getWeeklyChartData', function () {
    $fourWeeksAgo = Carbon::now()->subWeeks(4)->toDateString();

    $weeklyData = DB::table('transactions')
        ->select(DB::raw('YEAR(created_at) as year'), DB::raw('WEEK(created_at) as week'), DB::raw('SUM(amount) as total_amount'))
        ->where('created_at', '>=', $fourWeeksAgo)
        ->groupBy('year', 'week')
        ->orderBy('year', 'asc')
        ->orderBy('week', 'asc')
        ->get();

    return response()->json($weeklyData);
});

Route::get('/getDailyAppointmentsCount', function () {
    $sixDaysAgo = Carbon::now()->subDays(6)->toDateString();

    $dailyCounts = DB::table('appointments')
        ->select(DB::raw('DATE(appointeddate) as date'),
            DB::raw('SUM(goodmoral) as goodmoral_count'),
            DB::raw('SUM(registration) as registration_count'),
            DB::raw('SUM(f138) as f138_count'),
            DB::raw('SUM(others) as others_count'))
        ->where('active', 'Completed')
        // ->orWhere('active', 'Approved')
        ->where('appointeddate', '>=', $sixDaysAgo)
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    return response()->json($dailyCounts);
});

Route::get('/getWeeklyAppointmentsCount', function () {
    $fourWeeksAgo = Carbon::now()->subWeeks(4)->toDateString();

    $weeklyCounts = DB::table('appointments')
        ->select(DB::raw('YEAR(appointeddate) as year'),
            DB::raw('WEEK(appointeddate) as week'),
            DB::raw('SUM(goodmoral) as goodmoral_count'),
            DB::raw('SUM(registration) as registration_count'),
            DB::raw('SUM(f138) as f138_count'),
            DB::raw('SUM(others) as others_count'))
        ->where('active', 'Completed')
        // ->orWhere('active', 'Approved')
        ->where('appointeddate', '>=', $fourWeeksAgo)
        ->groupBy('year', 'week')
        ->orderBy('year', 'asc')
        ->orderBy('week', 'asc')
        ->get();

    return response()->json($weeklyCounts);
});


Route::get('tester', function(){
    return view('test');
});


Route::get('handbook', function () {
    $pathToFile = public_path('files/handbook.pdf');

    return response()->file($pathToFile);
});
Route::get('strandoffered', function () {
    $pathToFile = public_path('files/strandoffered.png');

    return response()->file($pathToFile);
});
Route::get('DownloadsEnrollmentFees', function () {
    $pathToFile = public_path('files/DownloadsEnrollmentFees.pdf');

    return response()->file($pathToFile);
});
Route::get('DownloadsEnrollmentSHSRegForm', function () {
    $pathToFile = public_path('files/DownloadsEnrollmentSHSRegForm.pdf');

    return response()->file($pathToFile);
});
Route::get('DownloadsEnrollmentStudentProfile', function () {
    $pathToFile = public_path('files/DownloadsEnrollmentStudentProfile.pdf');

    return response()->file($pathToFile);
});

Route::group(['middleware' => 'axuauth'], function () {
    // Admin Home
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/adminsettings', [AdminController::class, 'adminsettings'])->name('adminsettings');
    Route::get('/adminprofile', [AdminController::class, 'adminprofile'])->name('adminprofile');
    Route::post('/adminsetting_edit_process', [AdminSettingController::class, 'adminsetting_edit_process'])->name('adminsetting_edit_process');
    Route::post('/adminsetting_pass_process', [AdminSettingController::class, 'adminsetting_pass_process'])->name('adminsetting_pass_process');
    Route::post('/adminsetting_image_process', [AdminSettingController::class, 'adminsetting_image_process'])->name('adminsetting_image_process');

    // Admin/Accounts/Admin
    Route::get('/adminuser', [AdminController::class, 'adminuser'])->name('adminuser');
    Route::get('/adminuser_add', [AdminController::class, 'adminuser_add'])->name('adminusersAddPage');
    Route::post('/adminuser_add_process', [AdminController::class, 'adminuser_add_process'])->name('adminuserAddProcess');
    Route::get('/adminuser_edit', [AdminController::class, 'adminuser_edit'])->name('adminuserEditPage');
    Route::post('/adminuser_edit_process', [AdminController::class, 'adminuser_edit_process'])->name('adminuserEditProcess');
    Route::post('/adminuser_pass_process', [AdminController::class, 'adminuser_pass_process'])->name('adminuserPassProcess');
    Route::post('/adminuser_image_process', [AdminController::class, 'adminuser_image_process'])->name('adminuserImageProcess');
    Route::get('/adminuser_delete_process', [AdminController::class, 'adminuser_delete_process'])->name('adminuserDeleteProcess');
    Route::get('/adminuser_archive_process', [AdminController::class, 'adminuser_archive_process'])->name('adminuser_archive_process');


    // Admin/Accounts/Teachers
    Route::get('/adminteacher', [TeacherController::class, 'adminteacher'])->name('adminteacher');
    Route::get('/adminteacher_add', [TeacherController::class, 'adminteacher_add'])->name('adminTeacherAddPage');
    Route::post('/adminteacher_add_process', [TeacherController::class, 'adminteacher_add_process'])->name('adminTeacherAddProcess');
    Route::get('/adminteacher_edit', [TeacherController::class, 'adminteacher_edit'])->name('adminTeacherPage');
    Route::post('/adminteacher_edit_process', [TeacherController::class, 'adminteacher_edit_process'])->name('adminTeacherEditProcess');
    Route::post('/adminteacher_pass_process', [TeacherController::class, 'adminteacher_pass_process'])->name('adminTeacherPassProcess');
    Route::post('/adminteacher_image_process', [TeacherController::class, 'adminteacher_image_process'])->name('adminTeacherImageProcess');
    Route::get('/adminteacher_delete_process', [TeacherController::class, 'adminteacher_delete_process'])->name('adminTeacherDeleteProcess');
    Route::get('/adminteacher_archive_process', [TeacherController::class, 'adminteacher_archive_process'])->name('adminteacher_archive_process');

    // Admin/Subjects
    Route::get('/adminsubject', [SubjectAdminController::class, 'adminsubject'])->name('adminSubjectPage');
    Route::get('/adminsubject_add', [SubjectAdminController::class, 'adminsubject_add'])->name('adminSubjectAddPage');
    Route::post('/adminsubject_add_process', [SubjectAdminController::class, 'adminsubject_add_process'])->name('adminSubjectAddProcess');
    Route::get('/adminsubject_edit', [SubjectAdminController::class, 'adminsubject_edit'])->name('adminSubjectEditPage');
    Route::post('/adminsubject_edit_process', [SubjectAdminController::class, 'adminsubject_edit_process'])->name('adminSubjectEditProcess');
    Route::get('/adminsubject_delete_process', [SubjectAdminController::class, 'adminsubject_delete_process'])->name('adminSubjectDeleteProcess');
    Route::get('/adminsubject_archive_process', [SubjectAdminController::class, 'adminsubject_archive_process'])->name('adminsubject_archive_process');
    Route::get('/subject_teacher', [SubjectAdminController::class, 'admin_teacher'])->name('adminSubjectTeacher');
    Route::get('/subject_teacher_add', [SubjectAdminController::class, 'admin_teacher_add'])->name('adminSubjectTeacherAdd');
    Route::post('/subject_teacher_add_process', [SubjectAdminController::class, 'admin_teacher_add_process'])->name('adminSubjectTeacherAddProcess');
    Route::get('/subject_teacher_delete_process', [SubjectAdminController::class, 'admin_teacher_delete_process'])->name('adminSubjectTeacherDeleteProcess');

    // Real Curriculum
    Route::get('/admincurriculum', [RealCurriculumController::class, 'admincurriculum'])->name('adminrealcurriculum');
    Route::get('/adminrealcurriculum_subjects', [RealCurriculumController::class, 'admincurriculum_subjects'])->name('adminrealcurriculum_subjects');
    Route::get('/adminnewcurriculum_add', [RealCurriculumController::class, 'admincurriculum_add'])->name('adminrealcurriculum_add');
    Route::post('/adminrealcurriculum_add_process', [RealCurriculumController::class, 'admincurriculum_add_process'])->name('adminrealcurriculum_add_process');
    Route::get('/adminnewcurriculum_edit', [RealCurriculumController::class, 'admincurriculum_edit'])->name('adminnewcurriculum_edit');
    Route::post('/adminrealcurriculum_edit_process', [RealCurriculumController::class, 'admincurriculum_edit_process'])->name('adminrealcurriculum_edit_process');
    Route::get('/adminnewcurriculum_archive', [RealCurriculumController::class, 'admincurriculum_archive'])->name('adminnewcurriculum_archive');


    // Updated Admin Section
    Route::get('/adminsection', [CurriculumController::class, 'admincurriculum'])->name('admincurriculum');
    Route::get('/admincurriculum_add', [CurriculumController::class, 'admincurriculum_add'])->name('admincurriculum_add');
    Route::post('/admincurriculum_add_process', [CurriculumController::class, 'admincurriculum_add_process'])->name('admincurriculum_add_process');
    Route::get('/admincurriculum_subjects', [CurriculumController::class, 'admincurriculum_subjects'])->name('admincurriculum_subjects');
    Route::get('/admincurriculum_edit', [CurriculumController::class, 'admincurriculum_edit'])->name('admincurriculum_edit');
    Route::post('/admincurriculum_edit_process', [CurriculumController::class, 'admincurriculum_edit_process'])->name('admincurriculum_edit_process');
    Route::get('/fetchTeachers', [CurriculumController::class, 'fetchTeachers'])->name('fetchTeachers');
    Route::get('/fetchSubjects', [CurriculumController::class, 'fetchSubjects'])->name('fetchSubjects');
    Route::get('/admincurriculum_archive', [CurriculumController::class, 'admincurriculum_archive'])->name('admincurriculum_archive');
    Route::get('/fetchNewCurr', [CurriculumController::class, 'fetchNewCurr'])->name('fetchNewCurr');
    Route::get('/fetchNewSub', [CurriculumController::class, 'fetchNewSub'])->name('fetchNewSub');



    //Admin/Sections
    Route::get('/adminsection_add', [SectionController::class, 'adminsection_add'])->name('adminSectionAddPage');
    Route::post('/adminsection_add_process', [SectionController::class, 'adminsection_add_process'])->name('adminSectionAddProcess');
    Route::get('/adminsection_edit', [SectionController::class, 'adminsection_edit'])->name('adminSectionEditPage');
    Route::post('/adminsection_edit_process', [SectionController::class, 'adminsection_edit_process'])->name('adminSectionEditProcess');
    Route::get('/adminsection_delete_process', [SectionController::class, 'adminsection_delete_process'])->name('adminSectionDeleteProcess');

    Route::get('/adminschedule', [SectionController::class, 'adminschedule'])->name('adminSchedulePage');
    Route::get('/adminschedule_add', [SectionController::class, 'adminschedule_add'])->name('adminScheduleAddPage');
    Route::post('/adminschedule_add_process', [SectionController::class, 'adminschedule_add_process'])->name('adminScheduleAddProcess');
    Route::get('/adminschedule_delete_process', [SectionController::class, 'adminschedule_delete_process'])->name('adminScheduleDeleteProcess');

    //Admin/School Year
    Route::get('/adminschoolyear', [SchoolYearController::class, 'adminschoolyear'])->name('adminSchoolYearPage');
    Route::get('/adminschoolyear_add', [SchoolYearController::class, 'adminschoolyear_add'])->name('adminSchoolYearAddPage');
    Route::get('/adminschoolyear_add_process', [SchoolYearController::class, 'adminschoolyear_add_process'])->name('adminSchoolYearAddProcess');
    Route::get('/adminschoolyear_lock_process', [SchoolYearController::class, 'adminschoolyear_lock_process'])->name('adminSchoolYearLockProcess');
    Route::get('/adminschoolyear_activate_process', [SchoolYearController::class, 'adminschoolyear_activate_process'])->name('adminSchoolYearActivateProcess');
    Route::get('/adminschoolyear_delete_process', [SchoolYearController::class, 'adminschoolyear_delete_process'])->name('adminSchoolYearDeleteProcess');

    // Admin/Students
    Route::get('/adminstudent', [AdminStudentController::class, 'adminstudent'])->name('adminstudentPage');
    Route::get('/adminstudent_add', [AdminStudentController::class, 'adminstudent_add'])->name('adminstudent_add');
    Route::get('/getSections/{yearlevel}/{strand}/{schoolyear}/{semester}/', [AdminStudentController::class, 'getSections'])->name('getSections');
    Route::post('/adminstudent_add_process', [AdminStudentController::class, 'adminstudent_add_process'])->name('adminstudent_add_process');
    Route::get('/adminstudent_batchadd', [AdminStudentController::class, 'adminstudent_batchadd'])->name('adminstudent_batchadd');
    Route::post('/adminstudent_batchadd_process', [AdminStudentController::class, 'adminstudent_batchadd_process'])->name('adminstudent_batchadd_process');
    Route::get('/adminstudent_edit', [AdminStudentController::class, 'adminstudent_edit'])->name('adminstudent_edit');
    Route::post('/adminstudent_edit_process', [AdminStudentController::class, 'adminstudent_edit_process'])->name('adminstudent_edit_process');
    Route::post('/adminstudent_section_process', [AdminStudentController::class, 'adminstudent_section_process'])->name('adminstudent_section_process');
    Route::post('/adminstudent_pass_process', [AdminStudentController::class, 'adminstudent_pass_process'])->name('adminstudent_pass_process');
    Route::post('/adminstudent_image_process', [AdminStudentController::class, 'adminstudent_image_process'])->name('adminstudent_image_process');
    Route::get('/adminstudent_delete_process', [AdminStudentController::class, 'adminstudent_delete_process'])->name('adminstudent_delete_process');
    Route::get('/adminstudent_archive_process', [AdminStudentController::class, 'adminstudent_archive_process'])->name('adminstudent_archive_process');


    // Admin/Students/Transaction
    Route::get('/admintransaction', [AdminTransactionController::class, 'admintransaction'])->name('admintransaction');
    Route::post('/admintransaction_deduct_process', [AdminTransactionController::class, 'admintransaction_deduct_process'])->name('admintransaction_deduct_process');

    // Admin/Appointments
    Route::get('/adminappointments', [AdminAppointmentsController::class, 'adminappointments'])->name('adminappointments');
    Route::get('/adminappointments_info', [AdminAppointmentsController::class, 'adminappointments_info'])->name('adminappointments_info');
    Route::get('/adminappointments_delete_process', [AdminAppointmentsController::class, 'adminappointments_delete_process'])->name('adminappointments_delete_process');
    Route::get('/adminappointments_decline_process', [AdminAppointmentsController::class, 'adminappointments_decline_process'])->name('adminappointments_decline_process');
    Route::get('/adminappointments_complete_process', [AdminAppointmentsController::class, 'adminappointments_complete_process'])->name('adminappointments_complete_process');

    // Admin Alumni
    Route::get('/adminalumni', [AdminAlumni::class, 'adminalumni'])->name('adminalumni');
    Route::get('/adminalumni_add', [AdminAlumni::class, 'adminalumni_add'])->name('adminalumni_add');
    Route::get('/adminalumni_add_process', [AdminAlumni::class, 'adminalumni_add_process'])->name('adminalumni_add_process');
    Route::get('/adminalumni_batchadd', [AdminAlumni::class, 'adminalumni_batchadd'])->name('adminalumni_batchadd');
    Route::post('/adminalumni_batchadd_process', [AdminAlumni::class, 'adminalumni_batchadd_process'])->name('adminalumni_batchadd_process');
    Route::get('/adminalumni_edit', [AdminAlumni::class, 'adminalumni_edit'])->name('adminalumni_edit');
    Route::post('/adminalumni_edit_process', [AdminAlumni::class, 'adminalumni_edit_process'])->name('adminalumni_edit_process');
    Route::post('/adminalumni_pass_process', [AdminAlumni::class, 'adminalumni_pass_process'])->name('adminalumni_pass_process');
    Route::post('/adminalumni_image_process', [AdminAlumni::class, 'adminalumni_image_process'])->name('adminalumni_image_process');
    Route::get('/adminalumni_archive_process', [AdminAlumni::class, 'adminalumni_archive_process'])->name('adminalumni_archive_process');


    // Admin Cashier
    Route::get('/admincashier', [CashierController::class, 'admincashier'])->name('admincashier');
    Route::get('/admincashier_add', [CashierController::class, 'admincashier_add'])->name('admincashier_add');
    Route::get('/admincashier_edit', [CashierController::class, 'admincashier_edit'])->name('admincashier_edit');
    Route::get('/admincashier_archive_process', [CashierController::class, 'admincashier_archive_process'])->name('admincashier_archive_process');
    Route::post('/admincashier_add_process', [CashierController::class, 'admincashier_add_process'])->name('admincashier_add_process');
    Route::post('/admincashier_edit_process', [CashierController::class, 'admincashier_edit_process'])->name('admincashier_edit_process');
    Route::post('/admincashier_pass_process', [CashierController::class, 'admincashier_pass_process'])->name('admincashier_pass_process');
    Route::post('/admincashier_image_process', [CashierController::class, 'admincashier_image_process'])->name('admincashier_image_process');

    // Admin Registrar
    Route::get('/adminregistrar', [RegistrarController::class, 'adminregistrar'])->name('adminregistrar');
    Route::get('/adminregistrar_add', [RegistrarController::class, 'adminregistrar_add'])->name('adminregistrar_add');
    Route::post('/adminregistrar_add_process', [RegistrarController::class, 'adminregistrar_add_process'])->name('adminregistrar_add_process');
    Route::get('/adminregistrar_edit', [RegistrarController::class, 'adminregistrar_edit'])->name('adminregistrar_edit');
    Route::post('/adminregistrar_edit_process', [RegistrarController::class, 'adminregistrar_edit_process'])->name('adminregistrar_edit_process');
    Route::post('/adminregistrar_pass_process', [RegistrarController::class, 'adminregistrar_pass_process'])->name('adminregistrar_pass_process');
    Route::post('/adminregistrar_image_process', [RegistrarController::class, 'adminregistrar_image_process'])->name('adminregistrar_image_process');
    Route::get('/adminregistrar_archive_process', [RegistrarController::class, 'adminregistrar_archive_process'])->name('adminregistrar_archive_process');
    Route::get('/registrarreport', [AdminAppointmentsController::class, 'registrarreport'])->name('registrarreport');
    Route::get('/regreport', [RegistrarController::class, 'regreport'])->name('regreport');

    // Student Cashier
    Route::get('/studentcashier', [StudentCashierController::class, 'studentcashier'])->name('studentcashier');
    Route::get('/studentcashierreport', [StudentCashierController::class, 'studentcashierreport'])->name('studentcashierreport');
    Route::get('/cashreport', [StudentCashierController::class, 'cashreport'])->name('cashreport');


    // Student Portal
    Route::get('/portal', [StudentController::class, 'portal'])->name('portal');
    Route::get('/studentprofile', [StudentController::class, 'studentprofile'])->name('studentprofile');
    Route::get('/studentsettings', [StudentController::class, 'studentsettings'])->name('studentsettings');
    Route::post('/studentsetting_edit_process', [StudentController::class, 'studentsetting_edit_process'])->name('studentsetting_edit_process');
    Route::post('/studentsetting_pass_process', [StudentController::class, 'studentsetting_pass_process'])->name('studentsetting_pass_process');
    Route::post('/studentsetting_image_process', [StudentController::class, 'studentsetting_image_process'])->name('studentsetting_image_process');

    Route::post('/studentenrollment', [StudentController::class, 'studentenrollment'])->name('studentenrollment');
    Route::get('/fetschSchedule', [StudentController::class, 'fetschSchedule'])->name('fetschSchedule');
    Route::get('/enrollment', [StudentController::class, 'enrollment'])->name('enrollment');
    Route::get('/grades', [StudentController::class, 'grades'])->name('grades');
    Route::get('/schedule', [StudentController::class, 'schedule'])->name('schedule');
    Route::get('/balance', [StudentController::class, 'balance'])->name('balance');
    Route::get('/hmv', [StudentController::class, 'hmv'])->name('hmv');
    Route::get('/studentappointment', [StudentController::class, 'studentappointment'])->name('studentappointment');
    Route::get('/studentappointment_add', [StudentController::class, 'studentappointment_add'])->name('studentappointment_add');
    Route::post('/studentappointment_add_process', [StudentController::class, 'studentappointment_add_process'])->name('studentappointment_add_process');
    Route::get('/studentappointment_cancel_process', [StudentController::class, 'studentappointment_cancel_process'])->name('studentappointment_cancel_process');
    Route::get('/enrollSection', [StudentController::class, 'enrollSection'])->name('enrollSection');

    // Teacher Portal
    Route::get('/teacher', [MainTeacherController::class, 'teacher'])->name('teacher');
    Route::get('/teacherprofile', [MainTeacherController::class, 'teacherprofile'])->name('teacherprofile');
    Route::get('/teachersettings', [MainTeacherController::class, 'teachersetting'])->name('teachersetting');
    Route::post('/teachersetting_edit_process', [MainTeacherController::class, 'teachersetting_edit_process'])->name('teachersetting_edit_process');
    Route::post('/teachersetting_pass_process', [MainTeacherController::class, 'teachersetting_pass_process'])->name('teachersetting_pass_process');
    Route::post('/teachersetting_image_process', [MainTeacherController::class, 'teachersetting_image_process'])->name('teachersetting_image_process');
    Route::get('/grading', [MainTeacherController::class, 'grading'])->name('grading');
    Route::get('/section', [MainTeacherController::class, 'section'])->name('section');
    Route::get('/teacherschedule', [MainTeacherController::class, 'teacherschedule'])->name('teacherschedule');
    Route::get('/studentlist', [MainTeacherController::class, 'studentlist'])->name('studentlist');
    Route::get('/students', [MainTeacherController::class, 'students'])->name('students');
    Route::get('/studentsgrades', [MainTeacherController::class, 'studentsgrades'])->name('studentsgrades');
    Route::get('/studentsgrades_add', [MainTeacherController::class, 'studentsgrades_add'])->name('studentsgrades_add');
    Route::post('/studentsgrades_add_process', [MainTeacherController::class, 'studentsgrades_add_process'])->name('studentsgrades_add_process');
    Route::get('/studentsgrades_edit', [MainTeacherController::class, 'studentsgrades_edit'])->name('studentsgrades_edit');
    Route::post('/studentsgrades_edit_process', [MainTeacherController::class, 'studentsgrades_edit_process'])->name('studentsgrades_edit_process');
    Route::get('/fetchYearSubject', [MainTeacherController::class, 'fetchYearSubject'])->name('fetchYearSubject');
    Route::get('/getSubjectName', [MainTeacherController::class, 'getSubjectName'])->name('getSubjectName');
    Route::get('/saveGrade', [MainTeacherController::class, 'saveGrade'])->name('saveGrade');
    Route::get('/studentgradeslock', [MainTeacherController::class, 'studentgradeslock'])->name('studentgradeslock');

    Route::get('/getStudentSection', [MainTeacherController::class, 'getStudentSection'])->name('getStudentSection');
    Route::get('/studentlistpdf', [MainTeacherController::class, 'studentlistpdf'])->name('studentlistpdf');
    Route::get('/teacherschedulepdf', [MainTeacherController::class, 'teacherschedulepdf'])->name('teacherschedulepdf');

    // Aluni Portal
    Route::get('/alumni', [AlumniController::class, 'home'])->name('alumnihome');
    Route::get('/alumniappointment', [AlumniController::class, 'alumniappointment'])->name('alumniappointment');
    Route::get('/alumniappointmentslist', [AlumniController::class, 'alumniappointmentslist'])->name('alumniappointmentslist');
    Route::post('/alumniappointment_add_processs', [AlumniController::class, 'alumniappointment_add_processs'])->name('alumniappointment_add_processs');

});
