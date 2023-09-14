<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index(){
        $data = [
            'subject' =>'My mail',
            'body' => 'Hello this is my email delivery!'
        ];
        try{
            Mail::to('anujsingh854282@gmail.com')->send(new TestMail($data));
            return response()->json(['Great check your mail box']);
        }catch (Exception $th){
            return response()->json(['Sorry something went wrong']);
        }
    }

}
