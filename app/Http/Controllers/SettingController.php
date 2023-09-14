<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;
use PharIo\Manifest\Email;

class SettingController extends Controller
{
    public function index(){
        $businessSetting=BusinessSetting::first();
        return view('Backend.Page.Setting.Application.create',compact('businessSetting'));
    }
    public function createOrUpdate(Request $request)
    {
        $data = [
            'company_name' => $request->input('name'),
            'company_email' => $request->input('email'),
            'company_address' => $request->input('address'),
            'logo_path' => $request->hasFile('logo') ? $request->file('logo')->store('company_logos', 'public') : null,
        ];
        $titleValuePairs = [];

        foreach ($data as $title => $value) {
            $titleValuePairs[] = ['title' => $title, 'value' => $value];
        }

        BusinessSetting::upsert($titleValuePairs, ['title'], ['value']);

        return redirect()->route('settings.application')->with('success', 'Settings saved successfully!');
    }


}
