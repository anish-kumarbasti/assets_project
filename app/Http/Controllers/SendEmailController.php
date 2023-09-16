<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\BusinessSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index(){
        return view('Backend.Page.Setting.emails.sendEmail');
        // $data = [
        //     'subject' =>'My mail',
        //     'body' => 'Hello this is my email delivery!'
        // ];
        // try{
        //     Mail::to('anujsingh854282@gmail.com')->send(new TestMail($data));
        //     return response()->json(['Great check your mail box']);
        // }catch (Exception $th){
        //     return response()->json(['Sorry something went wrong']);
        // }
    }
    public function update(Request $request)
{
    // Validation code (if needed)

    // Extract the input values from the request
    $mailTransport = $request->input('mail_transport');
    $mailHost = $request->input('mail_host');
    $mailPort = $request->input('mail_port');
    $mailUsername = $request->input('mail_username');
    $mailPassword = $request->input('mail_password');
    $mailEncryption = $request->input('mail_encryption');
    $mailFrom = $request->input('mail_from');

    // Define an array with the settings you want to update
    $settings = [
        'mail_transport' => $mailTransport,
        'mail_host' => $mailHost,
        'mail_port' => $mailPort,
        'mail_username' => $mailUsername,
        'mail_password' => $mailPassword,
        'mail_encryption' => $mailEncryption,
        'mail_from' => $mailFrom,
    ];

    // Loop through the settings and update them in the "business_settings" table
    foreach ($settings as $title => $value) {
        BusinessSetting::updateOrCreate(
            ['title' => $title],
            ['value' => $value]
        );
    }

    // Redirect back with a success message
    return redirect()->route('emails.send')->with('success', 'Email settings updated successfully.');
}


}
