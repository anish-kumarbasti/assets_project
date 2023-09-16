<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{


    public function showLoginForm()
    {
        return view('Backend.Auth.Page.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Set a success message in the session
            Session::flash('success', 'Login Successfully');
            if(Auth::user()->role_id == 2){
                return redirect()->route('user-dashboard')->with('success', 'Login Successfully');
            }else{
            return redirect()->route('home')->with('success', 'Login Successfully');
            }
        }
        // If login fails, show an error message
        Session::flash('error', 'Login Failed. Please try again.');

        return redirect()->back()->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('/');
    }
}
