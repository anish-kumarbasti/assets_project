<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Brandmodel;
use Illuminate\Http\Request;

class BrandmodelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        $brandmodel = Brandmodel::all();
        // dd($brands);
        return view('Backend.Page.Master.brandmodel.create', compact('brands', 'brandmodel'));
    }
    public function trash()
    {
        $brands = Brand::all();
        $brandmodel = Brandmodel::onlyTrashed()->get();
        return view('Backend.Page.Master.brandmodel.trash', compact('brands', 'brandmodel'));
    }
    public function restore($id)
    {
        $brandmodel = Brandmodel::withTrashed()->findOrFail($id);
        if (!empty($brandmodel)) {
            $brandmodel->restore();
        }
        return redirect()->route('create-brand')->with('success', 'Brand Restore Successfully');
    }
    public function forceDelete($id)
    {
        $brandmodel = Brandmodel::withTrashed()->find($id);

        if (!$brandmodel) {
            return response()->json(['message' => false], 404);
        }

        $brandmodel->forceDelete();

        return response()->json(['message' => true]);
    }

    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|min:2|max:50|unique:brandmodels,name,except,id',
            // Add other validation rules if needed
        ]);

        // Create the brand using the brand model
        Brandmodel::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            // Add other fields if needed
        ]);

        // Redirect back to the list of brands

        session()->flash('success', 'Data has been successfully stored.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // dd($id);
        $brandmodel = Brandmodel::find($id); // Add this line for debugging
        $brands = Brand::all();
        return view('Backend.Page.Master.brandmodel.edit', compact('brandmodel', 'brands'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'brand_id' => 'required|integer'
        ]);
        // dd($id);
        $brand = Brandmodel::find($id)->update([
            'name' => $request->brand,
            'brand_id' => $request->brand_id,
            // Add other fields if needed
        ]);
        session()->flash('success', 'Data has been successfully Updated.');
        return redirect()->route('brand-model.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brandmodel::find($id);
        // dd($brand);
        if ($brand) {
            $brand->delete();
        }
        return response()->json(['success' => true]);
    }
    public function updateStatus(Request $request, Brandmodel $brand)
    {

        $request->validate([
            'status' => 'required|boolean',
        ]);
        if ($brand->status == 1) {
            Brandmodel::where('id', $brand->id)->update([
                'status' => 0
            ]);
        } else {
            Brandmodel::where('id', $brand->id)->update([
                'status' => 1
            ]);
        }
        // dd($brand);

        return redirect()->route('create-brand')->with('success', 'brand Model status updated successfully.');
    }
}
