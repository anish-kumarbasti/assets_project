<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password; // Add this import statement
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgetPassword()
    {
        return view('Backend.Auth.Page.forgot');
    }

    public function forgetPasswordPost(Request $request)
{
    $request->validate([
        'email' => "required|email|exists:users", // Corrected 'exists' spelling
    ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('Backend.Auth.Page.reset', ['token' => $token], function ($message) use ($request){
            $message->to($request->email);
            $message->subject("Reset Password");
        });
        return redirect()->route('forget.password')->with("success", "We have sent an email to reset password");
    }

    public function resetPassword($token){
        return view('Backend.Auth.Page.new-password', compact('token'));
    }
    public function resetPasswordPost(Request $request){
        $request->validate([
            'email' => "required|email|exists:users", // Corrected 'exists' spelling
            'password' => "required|string|min:6|confirmed",
            'password_confirmation' => "required"
        ]);

        $updatePassword = DB::table('password_reset_tokens')
        ->where([
            "email" =>$request->email,
            "token" => $request->token
        ])->first();

        if(!$updatePassword){
            return redirect()->route('reset.password', ['token' => $request->token])->with("success", "Password reset Success");
        }
        User::where("email", $request->email)->update(["password" => Hash::make($request->password)]);

        DB::table("password_reset_tokens")->where(["email" => $request->email])->delete();

        return redirect()->route('/')->with("success", "Password reset Success");
    }

}
