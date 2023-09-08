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
    $businessSetting = BusinessSetting::findOrNew(1);
    // if ($request->isMethod('put'))
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'address' => 'required|string',
            'logo' => 'sometimes|file',
        ]);


        $businessSetting->name = $request->name;
        $businessSetting->email = $request->email;
        $businessSetting->address = $request->address;

        if ($request->hasFile('logo')) {
            $businessSetting->logo = $request->file('logo')->store('company_logos', 'public');
        } else {

            $businessSetting->logo = null;
        }

        $businessSetting->save();

        return redirect()->route('settings.application')->with('success', 'Settings saved successfully!');
    }

    return redirect()->route('settings.application.storeOrUpdate', compact('businessSetting'));
}


}
