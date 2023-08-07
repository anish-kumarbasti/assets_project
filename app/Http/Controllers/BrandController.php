<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function create()
    {

        $brands = Brand::all();

        return view('Backend.Page.Master.brands.create', ['brands' => $brands]);
    }

    // Store the newly created brand
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            // Add other validation rules if needed
        ]);

        // Create the brand using the brand model
        Brand::create([
            'name' => $request->name,
            // Add other fields if needed
        ]);

        // Redirect back to the list of brands
        return redirect('/brands/create');
    }

    // Show the list of brands
    public function index()
    {
        $brands = Brand::all();
        return view('Backend.Page.Master.brands.index', ['brands' => $brands]);
    }

    // Show the "Edit brand" form
    public function edit($id)
    {

        $brand = Brand::findOrFail($id);
        return view('Backend.Page.Master.brands.edit', ['brand' => $brand]);
    }

    // Update the brand
    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            // Add other validation rules if needed
        ]);

        // Find the brand and update its data
        $brand = Brand::findOrFail($id);
        $brand->update([
            'name' => $request->name,
            // Add other fields if needed
        ]);

        // Redirect back to the list of brands
        return redirect('/brands/create');
    }

    // Delete the brand
    public function destroy($id)
    {
        // Find the brand and delete it
        $brand = Brand::findOrFail($id);
        $brand->delete();

        // Redirect back to the list of brands
        return redirect('/brands/create');
    }
    public function updateStatus(Request $request, brand $brand)
{

    $request->validate([
        'status' => 'required|boolean',
    ]);
if($brand->status==1){
    Brand::where('id',$brand->id)->update([
        'status' => 0
    ]);
}else{
Brand::where('id',$brand->id)->update([
    'status' => 1
]);

}
    // dd($brand);

    return redirect()->route('create-brand')->with('success', 'brand status updated successfully.');
}
}
