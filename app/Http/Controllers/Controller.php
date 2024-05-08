<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\User3;
use App\Mail\VerifyEmail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PharIo\Manifest\Email;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendEmail($email)
    {
        $verify = DB::table('password_reset_tokens')->where([['email',$email]]);
        if ($verify->exists()) {
            $verify->delete();
        }
        $pin = rand(100000, 999999);
        DB::table('password_reset_tokens')->insert(['email' => $email, 'token' => $pin ]);
        Mail::to($email)->send(new VerifyEmail($pin));
        if(request()->is('api/*')){
            return response()->json(['message' => 'we sent 6 digit code to this email']);
        }
        return view('');
    }

}
