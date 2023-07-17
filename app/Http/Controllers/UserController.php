<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(){
        return view('Backend.Page.User.add-user');

    }

    public function userCard(){
        return view('Backend.Page.User.user-details');
    }
        public function userProfile(){
            return view('Backend.Page.User.user-profile');


       

    }
   
}
