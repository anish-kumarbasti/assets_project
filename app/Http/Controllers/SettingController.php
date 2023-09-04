<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $setting=BusinessSetting::all();
        return view('Backend.Page.Seting.Application.create',compact('setting'));  
    }
    
    public function storeOrUpdate(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'address' => 'required|string',
            'logo' => 'required', // Optional logo upload
        ]);

        // Update or create a record based on 'id'
        $businessSetting = BusinessSetting::updateOrCreate(
            ['id' => $request->id], // Identify record by 'id'
            [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'logo' => $request->hasFile('logo') ? $request->file('logo')->store('company_logos', 'public') : null,
            ]
        );

        // Redirect to the 'settings.application' route
        return redirect()->route('settings.application')->with('success', 'Settings saved successfully!');
    }
    


}
