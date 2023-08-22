<?php

namespace App\Http\Controllers\Issuence;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IssuenceController extends Controller
{
    public function index(Request $request){
        $output = '';
        if($request->ajax()){
            $employee = User::where('id','LIKE','%'.$request->employeeId.'%')
                ->orWhere('first_name','LIKE','%'.$request->employeeId.'%')->get();

            if($employee){
                $output .= 
               '<div class="row p-3">
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Name:</label>
                     <input class="form-control" id="validationCustom01" type="text" value="'.$employee->first_name.'" required="" data-bs-original-title=""
                        title="" placeholder="Abhi" readonly>
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Department:</label>
                     <input class="form-control" id="validationCustom01" type="text" value="'.$employee->department->name.'" required="" data-bs-original-title=""
                        title="" placeholder="IT Department" readonly>
                  </div>
                  <div class="col-md-4 mb-4">
                     <label class="form-label" for="validationCustom01">Location:</label>
                     <input class="form-control" id="validationCustom01" type="text" required="" value="'.$employee->designation->name.'" data-bs-original-title=""
                        title="" placeholder="Lucknow" readonly>
                  </div>
               </div>
                ';

                return response()->json($output);
            }
        }
        return view('Backend.Page.Issuence.issuence');
    }
}
