<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSender;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;


class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $students = User::all();
        // return view('students.index')->with('students', $students);
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(Auth::guard('student')->check()) {
            return redirect()->action([StudentsController::class, 'show'], ['student' => Auth::guard('student')->user()->rollno]);
        }elseif(Auth::guard('staff')->check()) {
            return redirect()->action([AdminController::class, 'show'], ['admin' => Auth::guard('staff')->user()->username]);
        }else {
            return view('students.register');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        // validating the form

        $rules = [
            'rollno' => ['required', 'regex:/(^[0-9]{2}19(1|5)(A|a)0[0-9]{3}$)/u', 'unique:users', 'max:255'],
            'username' => ['required', 'min:6', 'max:255'],
            'email' => ['required', 'max:255'],
            'phone_number' => ['required', 'digits:10', 'max:255'],
            'home_address' => ['required', 'max:255'],
            'work_address' => ['required', 'max:255'],
            'password' => ['required', 'min:6'],
            'confirmPassword' => ['required', 'same:password', 'min:6'],
            
        ];

        $customMessages = [
            'required' => 'The :attribute field can not be blank',
            'regex' => 'please enter valid :attribute',
            'required_with' => 'password not matched',
            'same' => 'password not matched',
            'digits' => 'please enter 10 digits mobile number'
        ];

        $this->validate($request, $rules, $customMessages);

        // creating Student
        $student = new User();
        $student->rollno = str::lower($request->input('rollno'));
        $student->username = $request->input('username');
        $student->email = $request->input('email');
        $student->phone_number = $request->input('phone_number');
        $student->home_address = $request->input('home_address');
        $student->work_address = $request->input('work_address');
        $student->verification_code = sha1(time());

        // hashing password
        $passwordHashing = Hash::make($request->input('password'));
        $student->password = $passwordHashing;

        Mail::to($request->input('email'))->send(new MailSender($student));

        $student->save();
            

        return redirect('/login')->with('success', 'you registered suceessfully, please verify email');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($rollno)
    {
        //
        if (Auth::guard('student')->check() || Auth::guard('staff')->check()){
            $student = User::where(['rollno' => $rollno])->firstOrFail();
            return view('students.index')->with('student', $student);
        }
        else {
            return redirect('/login')->with('loginFirst', 'please login');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($rollno)
    {
        if (Auth::guard('student')->check()){
            $student = User::where(['rollno' => $rollno])->firstOrFail();
            return view('students.edit')->with('student', $student);
        }
        else {
            return redirect('/login')->with('loginFirst', 'please login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rollno)
    {
        //
        $rules = [
            'username' => ['required','min:6', 'max:255'],
            'email' => ['required', 'max:255'],
            'phone_number' => ['required', 'digits:10', 'max:255'],
            'home_address' => ['required', 'max:255'],
            'work_address' => ['required', 'max:255'],
            'profile' => ['mimes:jpeg,jpg', 'max:5120']
            
        ];

        $customMessages = [
            'required' => 'The :attribute field can not be blank',
            'same' => 'password not matched',
            'digits' => 'please enter 10 digits mobile number',
            'mimes' => 'only jpg and jpeg files allowed',
        ];

        $this->validate($request, $rules, $customMessages);



        if (Auth::guard('student')->check()){
            $student = User::where(['rollno' => $rollno])->firstOrFail();
            $student->username = $request->input('username');
            $student->email = $request->input('email');
            $student->phone_number = $request->input('phone_number');
            $student->home_address = $request->input('home_address');
            $student->work_address = $request->input('work_address');

            if ($request->hasFile('profile')){
                $image = $request->file('profile');
                $name = $student->rollno.'.'.$image->getClientOriginalExtension();

                $image_resize = Image::make($image->getRealPath());  

                $image_resize->resize(315, 315);
                $image_resize->save(public_path('upload/profiles/' .$name));

                // $destinationPath = public_path('/upload/profiles');
                // $image->resize(315,315)->move($destinationPath, $name);

                $student->imageUrl = '/upload/profiles/'.$name;
            }

            $student->save();
            return redirect()->action([StudentsController::class, 'show'], ['student' => $rollno])->with('profileUpdated', 'Your profile is Updated successfully');
        }
        else {
            return redirect('/login')->with('loginFirst', 'please login');
        }
    }

    public function delete_image($rollno) {
        if(Auth::guard('student')->check()){
            $student = User::where('rollno', $rollno)->first();
            if (File::exists(\public_path($student->imageUrl))){
                
                File::delete(\public_path($student->imageUrl));
            }
            $student->imageUrl = Null;
            $student->save();
            return redirect()->action([StudentsController::class, 'edit'], ['student' => $rollno])->with('imageDeleted','you deleted profile picture');
        }else{
            return redirect('/login')->with('loginFirst', 'please login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $rollno)
    {
        //
        Auth::guard('student')->logout();

        $request->session()->invalidate();

        $student = User::where(['rollno' => $rollno])->firstOrFail();

        $username = $student->username;

        $student->delete();

        return redirect('/')->with('accountDeleted', Str::upper($rollno).' ('.$username.') '.' deleted account successfully');
    }
}
