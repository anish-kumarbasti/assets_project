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
        $brands = Brandmodel::all();
        // dd($brands);
        return view('Backend.Page.Master.brandmodel.create', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
            'name' => 'required',
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
        $brand = Brandmodel::find($id);
        $brands = Brandmodel::all();
        return view('Backend.Page.Master.brandmodel.edit', compact('brands','brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          // Validate the form data
          $brand = Brandmodel::findOrFail($id);
          $brand->update([
            'brand' => 'required',
            // Add other validation rules if needed
        ]);

        // Create the brand using the brand model
        Brandmodel::create([
            'name' => $request->brand,
            'brand_id' => $request->brand_id,
            // Add other fields if needed
        ]);
        return redirect()->route('brand-model.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brandmodel::find($id);

if ($brand) {
    $brand->delete();
}
        return redirect()->route('brand-model.index');
    }
}
