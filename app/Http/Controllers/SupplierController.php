<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

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
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return redirect()->route('suppliers.index');
    }
    public function edit($id)
    {

        $supplier = Supplier::find($id);
        return view('Backend.Page.Master.suppliers.edit', compact('supplier'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
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

