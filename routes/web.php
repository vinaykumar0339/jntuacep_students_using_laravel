<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StudentsController;

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
// pages controller
Route::get('/', [PagesController::class, 'index']);
Route::get('/about', [PagesController::class, 'about']);
Route::get('/contactus', [PagesController::class, 'contactus']);
Route::get('/gallery', [PagesController::class, 'gallery']);
Route::get('/login', [PagesController::class, 'loginTemplate']);
Route::post('/login', [PagesController::class, 'login']);
Route::get('/logout', [PagesController::class, 'logout']);

Route::post('/admin-login', [PagesController::class, 'admin_login']);
Route::get('/admin-logout', [PagesController::class, 'admin_logout']);



// email verification
Route::get('/students/verify-mail/{verification_code}', [MailController::class, 'student_verify_mail']);

// Student Controller or User Controller
Route::resource('students',StudentsController::class);
Route::get('students/{rollno}/deleteImage',[StudentsController::class, 'delete_image']);

Route::resource('admin',AdminController::class);
Route::post('admin/students', [AdminController::class, 'student_search']);
Route::get('admin/student/{rollno}', [AdminController::class, 'get_student']);


