<?php

namespace App\Http\Controllers;

use App\Models\AssetType;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttributeController extends Controller
{
    public function home()
    {
        // dd('hi');
        $attributes = Attribute::all();
        $assettype = AssetType::all();
        return view('Backend.Page.Master.attribute.add_attribute', compact('attributes', 'assettype'));
    }

    public function create()
    {
        return view('Backend.Page.Master.add_attribute.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'boolean',
            'asset_type_id' => 'required',
            'name' => [
                'required',
                'string',
                'max:40',
                'min:2',
            ],
        ]);

        Attribute::create($validatedData);

        return redirect()->route('attributes-index')->with('success', 'Attribute created successfully.');
    }

    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        $assettype = AssetType::all();
        return view('Backend.Page.Master.attribute.edit', compact('attribute', 'assettype'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_type_id' => 'required',
            'name' => [
                'required',
                'string',
                'max:50',
                'min:2',
            ],
        ]);
        // dd($id);

        $attribute = Attribute::findOrFail($id);
        $attribute->update([
            'asset_type_id' => $request->asset_type_id,
            'name' => $request->name,
        ]);

        return redirect()->route('attributes-index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        return response()->json(['success' => true]);
    }
    public function updateStatus(Request $request, Attribute $attribute)
    {
        dd($attribute);
        $request->validate([
            'status' => 'required|boolean',
        ]);
        if ($attribute->status == 1) {
            Attribute::where('id', $attribute->id)->update([
                'status' => 0
            ]);
        } else {
            Attribute::where('id', $attribute->id)->update([
                'status' => 1
            ]);
        }
    }
}
