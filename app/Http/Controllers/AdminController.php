<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return abort(404);
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
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function student_search(Request $request) {

        $typeOfSearch = $request->input('typeOfSearch');
        
        if ($typeOfSearch == 'byyear') {
            $search = substr($request->input('search'), -2);
            $students = User::where('rollno', 'like', $search.'191%')->orwhere('rollno', 'like', ((int)$search + 1).'195%')->get();
            if (Count($students) == 0) {
                return redirect('/admin/students')->with('studentNotFonud','Students Not Found');
            }else {
                return view('admin.students',['students' => $students]);
            }
        }elseif ($typeOfSearch == 'byrollno') {
            $search = Str::lower($request->input('search'));
            $student = User::where('rollno',$search)->first();
            if($student){
                return view('admin.student',['student' => $student]);
            }
            else{
                return redirect('/admin/students')->with('studentNotFonud','Student Not Found');
            }
        }

    }

    public function get_student($rollno) {
        if(Auth::guard('staff')->check()){
            $student = User::where('rollno',$rollno)->first();
            return view('admin.student',['student' => $student]);
        }else {
            return redirect('/login')->with('adminloginFirst', 'please login');
        }
    }
    
    public function show($id)
    {
        //
        if(Auth::guard('staff')->check()){
            return view('admin.index');
        }else {
            return redirect('/login')->with('adminloginFirst', 'please login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return abort(404);
    }
}
