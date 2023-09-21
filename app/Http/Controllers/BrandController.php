<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function create()
    {

        $brands = Brand::all();
        return view('Backend.Page.Master.brands.create', ['brands' => $brands]);
    }
    public function trash()
    {
        $brands = Brand::onlyTrashed()->get();
        return view('Backend.Page.Master.brands.trash', ['brands' => $brands]);
    }
    public function restore($id)
    {
        $brands = Brand::withTrashed()->findOrFail($id);
        if (!empty($brands)) {
            $brands->restore();
        }
        return redirect()->route('create-brand')->with('success', 'Brand Restore Successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
        Brand::create([
            'name' => $request->name,
            // Add other fields if needed
        ]);

        // Redirect back to the list of brands
        session()->flash('success', 'Data has been successfully stored.');
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
        $validated = $request->validate([
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

        // Find the brand and update its data
        $brand = Brand::findOrFail($id);
        $brand->update([
            'name' => $request->name,
            // Add other fields if needed
        ]);

        // Redirect back to the list of brands
        return redirect('/brands/create')->with('success', 'Data Updated Successfully!');
    }

    // Delete the brand
    public function destroy($id)
    {
        // Find the brand and delete it
        $brand = Brand::find($id);
        if ($brand) {
            $brand->delete();
        }
        // dd($brand);
        // $asset->delete();

        return response()->json(['success' => true]);
    }
    public function updateStatus(Request $request, brand $brand)
    {

        $request->validate([
            'status' => 'required|boolean',
        ]);
        if ($brand->status == 1) {
            Brand::where('id', $brand->id)->update([
                'status' => 0
            ]);
        } else {
            Brand::where('id', $brand->id)->update([
                'status' => 1
            ]);
        }
        // dd($brand);

        return redirect()->route('create-brand')->with('success', 'brand status updated successfully.');
    }
}
