<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function home()
    {
        // dd('hi');
        $attributes = Attribute::all();
        return view('Backend.Page.Master.attribute.add_attribute', compact('attributes'));
    }

    public function create()
    {
        return view('Backend.Page.Master.add_attribute.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'status' => 'boolean'
        ]);

        Attribute::create($validatedData);

        return redirect()->route('attributes-index')->with('success', 'Attribute created successfully.');
    }

    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('Backend.Page.Master.attribute.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        // dd($id);

        $attribute = Attribute::findOrFail($id);
        $attribute->update([
            'name'=>$request->name,
        ]);

        return redirect()->route('attributes-index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        return response()->json(['success' => true]);
    }
    public function updateStatus(Request $request, Attribute $attribute){
        dd($attribute);
        $request->validate([
            'status' => 'required|boolean',
        ]);
    if($attribute->status==1){
        Attribute::where('id',$attribute->id)->update([
            'status' => 0
        ]);
    }else{
    Attribute::where('id',$attribute->id)->update([
        'status' => 1
    ]);
    }
}
}
