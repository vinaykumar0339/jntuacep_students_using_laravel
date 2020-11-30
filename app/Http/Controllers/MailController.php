<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{

     public function student_verify_mail($verification_code) {
        $student = User::where(['verification_code' => $verification_code])->first();

        if (!$student) {
            return abort(404);
            
        }else {

            if ($student->is_verified === 1){
                return redirect('/login')->with('success', 'your account is already verified, '.$student->username.' you can login now');
            }else {
                $student->is_verified = true;
                $student->email_verified_at = Carbon::now()->toDateTimeString();
                $student->save();

                return redirect('/login')->with('success', 'email verification is completed successfully');
            }
      
        }

     }
}
