<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Issuence;
use App\Models\Stock;
use App\Models\User;
use Hamcrest\Type\IsString;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $employee = User::with('department', 'designation')
            ->where('employee_id', 'LIKE', '%' . $request->employeeId . '%')
            ->first() ?? null;
        
        $issue = Issuence::with('allStock')
            ->where('employee_id', 'LIKE', '%' . $request->employeeId . '%')
            ->first() ?? null;
        
        $result = [];
        
        if ($employee && $issue) {
            $result['employee'] = $employee;
            
            // Decode the JSON product_id field from Issuence model
            $productIds = json_decode($issue->product_id);
        
            // Retrieve the products from the Stock model where any ID matches the product_ids
            $products = Stock::whereIn('id', $productIds)->get();
            
            $result['products'] = $products;
        } else {
            $result['employee'] = null;
            $result['products'] = [];
        }
        
        // Now, $result contains both the employee and associated products.
        
        $jsonData = json_encode($result);

        return view('Backend.Page.Transfer.transfer', ['jsonData' => $jsonData]);
        }
        return view('Backend.Page.Transfer.transfer');
    }
}
