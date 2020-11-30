<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\StudentsController;
use App\Models\User;

class PagesController extends Controller
{
    public function index() {
        return view('pages.index');
    }

    public function about() {
        return view('pages.about');
    }

    public function contactus() {
        return view('pages.contactus');
    }

    public function gallery() {
        return view('pages.gallery');
    }

    public function loginTemplate() {
        if(Auth::guard('student')->check()) {
            return redirect()->action([StudentsController::class, 'show'], ['student' => Auth::guard('student')->user()->rollno]);
        }elseif(Auth::guard('staff')->check()){
            return redirect()->action([AdminController::class, 'show'], ['admin' => Auth::guard('staff')->user()->username]);
        }else {
            return view('pages.login');
        }
    }

    public function login(Request $request) {

        $rules = [
            'rollno' => ['required'],
            'password' => ['required']
        ];

        $customMessages = [
            'required' => 'The :attribute field can not be blank',
        ];

        $this->validate($request, $rules, $customMessages);

        $rollno = Str::lower($request->input('rollno'));
        $password = $request->input('password');

        $user = User::where('rollno', $rollno)->first();
        if($user){

            if (Auth::guard('student')->attempt(['rollno' => $rollno, 'password' => $password, 'is_verified' => 1])) {
                return redirect()->action([StudentsController::class, 'show'], ['student' => $rollno])->with('loginSuccess', Auth::guard('student')->user()->username.'- You logged in!');
            }elseif (Auth::guard('student')->attempt(['rollno' => $rollno, 'password' => $password])) {
                Auth::guard('student')->logout();
                $request->session()->invalidate();
                return redirect('/login')->with('loginError', 'please verify email');
            }
            else {
                return redirect('/login')->with('loginError', 'invalid credentials');
            }

        }else{
            return redirect('/login')->with('loginError', 'Student not registered yet');
        }

        

        

    }

    public function logout(Request $request) {
        Auth::guard('student')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function admin_login(Request $request) {
        

        $rules = [
            'username' => ['required'],
            'adminpassword' => ['required']
        ];

        $customMessages = [
            'required' => 'The :attribute field can not be blank',
        ];

        $this->validate($request, $rules, $customMessages);

        $username = $request->input('username');
        $password = $request->input('adminpassword');

        

        if (Auth::guard('staff')->attempt(['username' => $username, 'password' => $password])) {
            return redirect()->action([AdminController::class, 'show'], ['admin' => $username])->with('loginSuccess', $username.' - you logged in!');
        }
        else {
            return redirect('/login')->with('adminloginError', 'invalid credentials');
        }

    }

    public function admin_logout(Request $request) {
        Auth::guard('staff')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

}
