<?php

namespace App\Http\Controllers;

use App\Models\AssetReturn;
use App\Models\BusinessSetting;
use App\Models\Issuence;
use App\Models\Stock;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Email;

class SettingController extends Controller
{
    public function index()
    {
        $businessSetting = BusinessSetting::first();
        return view('Backend.Page.Setting.Application.create', compact('businessSetting'));
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

    public function user_profile()
    {
        $user = Auth::user();
        $issueproduct = Issuence::where('employee_id', $user->employee_id)->count();
        $itasset = Issuence::where('employee_id', $user->employee_id)->where('asset_type_id', 1)->count();
        $nonitasset = Issuence::where('employee_id', $user->employee_id)->where('asset_type_id', 2)->count();
        $component = Issuence::where('employee_id', $user->employee_id)->where('asset_type_id', 4)->count();
        $software = Issuence::where('employee_id', $user->employee_id)->where('asset_type_id', 3)->count();
        $transfer = Transfer::where('employee_id', $user->employee_id)->count();
        $returns = AssetReturn::where('return_by_user', $user->id)->count();
        $returnproducts = json_decode(AssetReturn::where('return_by_user', $user->id)->pluck('product_id'));
        $ittransfer = 0;
        $nonittransfer = 0;
        $componenttransfer = 0;
        $softwaretransfer = 0;
        $transferProducts = Transfer::where('employee_id', $user->employee_id)->pluck('product_id');
        $ittransfer = 0;
        $nonittransfer = 0;
        $componenttransfer = 0;
        $softwaretransfer = 0;

        if ($transferProducts) {
            foreach ($transferProducts as $product) {
                $decodedProducts = json_decode($product);
                foreach ($decodedProducts as $decodedProducts) {
                    $transferProduct = Stock::find($decodedProducts);
                    if ($transferProduct) {
                        if ($transferProduct->asset_type_id == 1) {
                            $ittransfer = $ittransfer + 1;
                        }
                        if ($transferProduct->asset_type_id == 2) {
                            $nonittransfer = $nonittransfer + 1;
                        }
                        if ($transferProduct->asset_type_id == 4) {
                            $componenttransfer = $componenttransfer + 1;
                        }
                        if ($transferProduct->asset_type_id == 3) {
                            $softwaretransfer = $softwaretransfer + 1;
                        }
                    }
                }
            }
        }

        $itreturns = 0;
        $nonitreturns = 0;
        $softwarereturns = 0;
        $compnentreturns = 0;

        if ($returnproducts) {
            foreach ($returnproducts as $returnproducts) {
                $productID = json_decode($returnproducts);
                foreach ($productID as $return) {
                    $returnProducts = Stock::find($return);
                    if ($returnProducts->asset_type_id == 1) {
                        $itreturns = $itreturns + 1;
                    }
                    if ($returnProducts->asset_type_id == 2) {
                        $nonitreturns = $nonitreturns + 1;
                    }
                    if ($returnProducts->asset_type_id == 4) {
                        $compnentreturns = $compnentreturns + 1;
                    }
                    if ($returnProducts->asset_type_id == 3) {
                        $softwarereturns = $softwarereturns + 1;
                    }
                }
            }
        }

        $totalitasset = ($itasset - $itreturns) - $ittransfer;
        $totalnonitasset = ($nonitasset - $nonitreturns) - $nonittransfer;
        $totalcomponent = ($component - $compnentreturns) - $componenttransfer;
        $totalsoftware = ($software - $softwarereturns) - $softwaretransfer;

        return view('Backend.Page.User.user-profile', compact('user', 'issueproduct', 'transfer', 'returns', 'totalitasset', 'totalnonitasset', 'totalcomponent', 'totalsoftware'));
    }
}
