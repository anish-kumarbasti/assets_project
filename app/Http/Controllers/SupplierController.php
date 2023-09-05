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
        ], [
            'name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);


        Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
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
        ], [
            'name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);

        $supplier = Supplier::find($id);
        $supplier->name = $validatedData['name'];
        $supplier->email = $validatedData['email'];
        $supplier->phone = $validatedData['phone'];
        $supplier->address = $validatedData['address'];
        $supplier->save();

        return redirect()->route('suppliers.index');
    }
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect()->route('suppliers.index');
    }
}
