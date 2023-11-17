<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('Backend.Page.Master.suppliers.index', compact('suppliers'));
    }
    public function trash()
    {
        $suppliers = Supplier::onlyTrashed()->get();
        return view('Backend.Page.Master.suppliers.trash', compact('suppliers'));
    }
    public function restore($id)
    {
        $suppliers = Supplier::withTrashed()->findOrFail($id);
        if (!empty($suppliers)) {
            $suppliers->restore();
        }
        return redirect()->route('suppliers.index')->with('success', 'Supplier Restore Successfully');
    }
    public function forceDelete($id)
    {
        $suppliers = Supplier::withTrashed()->find($id);

        if (!$suppliers) {
            return response()->json(['success' => false], 404);
        }

        $suppliers->forceDelete();

        return response()->json(['success' => true]);
    }
    public function create()
    {
        return view('Backend.Page.Master.suppliers.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:10,12',
            'address' => 'required|string|max:60',
            'name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
                'min:2',
                Rule::notIn(['']),
            ],
            'unique' => 'required|unique:suppliers,supplier_id,except,id',
        ], [
            'name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);

        Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'supplier_id' => $request->unique,
        ]);
        return redirect()->route('suppliers.index')->with('message', 'Supplier Add successfully!');
    }
    public function edit($id)
    {

        $supplier = Supplier::find($id);
        return view('Backend.Page.Master.suppliers.edit', compact('supplier'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:10,12',
            'address' => 'required|string|max:60',
            'name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
                'min:2',
                Rule::notIn(['']),
            ],
            'unique' => 'required|unique:suppliers,supplier_id,except,id',
        ], [
            'name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);

        $supplier = Supplier::find($id);
        $supplier->name = $validatedData['name'];
        $supplier->email = $validatedData['email'];
        $supplier->phone = $validatedData['phone'];
        $supplier->address = $validatedData['address'];
        $supplier->supplier_id = $validatedData['unique'];
        $supplier->save();

        return redirect()->route('suppliers.index')->with('message', 'Supplier Update Successfully');
    }
    public function destroy($id)
    {
        // dd($id);
        $supplier = Supplier::find($id);
        $referencesExist = $supplier->stocks()->exists();
        // dd($referencesExist);
        if ($referencesExist) {
            return response()->json(['success' => false, 'message' => 'Supplier is referenced in one or more tables and cannot be deleted.']);
        }
        $supplier->delete();
        return response()->json(['success' => true, 'message' => 'Supplier deleted successfully.']);
    }
}
