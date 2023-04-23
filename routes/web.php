<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;

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

Route::get('/', [LoginController::class, 'index'])->name('loginScreen');
Route::post('/login', [LoginController::class, 'login'])->name('loginProcess');
Route::get('/logout', [LoginController::class, 'logout'])->name('logoutProcess');

Route::group(['middleware' => 'axuauth'], function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    Route::get('/adminuser', [AdminController::class, 'adminuser'])->name('adminuser');
    Route::get('/adminuser_add', [AdminController::class, 'adminuser_add'])->name('adminusersAddPage');
    Route::post('/adminuser_add_process', [AdminController::class, 'adminuser_add_process'])->name('adminuserAddProcess');
    Route::get('/adminuser_edit', [AdminController::class, 'adminuser_edit'])->name('adminuserEditPage');
    Route::post('/adminuser_edit_process', [AdminController::class, 'adminuser_edit_process'])->name('adminuserEditProcess');
    Route::post('/adminuser_pass_process', [AdminController::class, 'adminuser_pass_process'])->name('adminuserPassProcess');
    Route::post('/adminuser_image_process', [AdminController::class, 'adminuser_image_process'])->name('adminuserImageProcess');
    Route::get('/adminuser_delete_process', [AdminController::class, 'adminuser_delete_process'])->name('adminuserDeleteProcess');


    Route::get('/adminteacher', [TeacherController::class, 'adminteacher'])->name('adminteacher');

    Route::get('/adminteacher_add', [TeacherController::class, 'adminteacher_add'])->name('adminTeacherAddPage');
    Route::post('/adminteacher_add_process', [TeacherController::class, 'adminteacher_add_process'])->name('adminTeacherAddProcess');
    Route::get('/adminteacher_edit', [TeacherController::class, 'adminteacher_edit'])->name('adminTeacherPage');
    Route::post('/adminteacher_edit_process', [TeacherController::class, 'adminteacher_edit_process'])->name('adminTeacherEditProcess');
    Route::post('/adminteacher_pass_process', [TeacherController::class, 'adminteacher_pass_process'])->name('adminTeacherPassProcess');
    Route::post('/adminteacher_image_process', [TeacherController::class, 'adminteacher_image_process'])->name('adminTeacherImageProcess');
    Route::get('/adminteacher_delete_process', [TeacherController::class, 'adminteacher_delete_process'])->name('adminTeacherDeleteProcess');

});
