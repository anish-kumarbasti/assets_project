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
        $brands_model = Brandmodel::all();
        return view('Backend.Page.Master.brandmodel.create', compact('brands','brands_model'));
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
            'name' => 'required|string|max:255',
            // Add other validation rules if needed
        ]);

        // Create the brand using the brand model
        Brandmodel::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            // Add other fields if needed
        ]);

        // Redirect back to the list of brands
        return redirect()->back()->with('message','Brand Model Registered Succesfully');
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
            'name' => 'required|string|max:255',
            // Add other validation rules if needed
        ]);

        // Create the brand using the brand model
        Brandmodel::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            // Add other fields if needed
        ]);
        return redirect()->route('brand-model.index')->with('message','Brand Model updated Succesfully');
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
     return response()->json(['success' => true]);
    }
    public function updateStatus(Request $request, Brandmodel $brand)
{

    $request->validate([
        'status' => 'required|boolean',
    ]);
if($brand->status==1){
    Brandmodel::where('id',$brand->id)->update([
        'status' => 0
    ]);
}else{
Brandmodel::where('id',$brand->id)->update([
    'status' => 1
]);

}
    // dd($brand);

    return redirect()->route('create-brand')->with('success', 'brand Model status updated successfully.');
}

}

