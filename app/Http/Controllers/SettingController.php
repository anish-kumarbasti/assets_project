<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $businessSetting=BusinessSetting::first();
        return view('Backend.Page.Seting.Application.create',compact('businessSetting'));
    }
    public function createOrUpdate(Request $request)
{
    $businessSetting = BusinessSetting::UpdateOrCreate([
        'id'=>$request->id,
    ],[
        'name'=>$request->name,
        'email'=>$request->email,
        'address'=>$request->address
    ]);
    {

        if ($request->hasFile('logo')) {
            $businessSetting->logo = $request->file('logo')->store('company_logos', 'public');
        } else {

            $businessSetting->logo = null;
        }

        return redirect()->route('settings.application')->with('success', 'Settings saved successfully!');
    }

    return redirect()->route('settings.application.storeOrUpdate', compact('businessSetting'));
}


}
