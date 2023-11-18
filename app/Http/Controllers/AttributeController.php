<?php

namespace App\Http\Controllers;

use App\Exports\AttributeExport;
use App\Imports\AttributeImport;
use App\Models\AssetType;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class AttributeController extends Controller
{
    public function home()
    {
        // dd('hi');
        $attributes = Attribute::with('asset_type')->get();
        $assettype = AssetType::all();
        return view('Backend.Page.Master.attribute.add_attribute', compact('attributes', 'assettype'));
    }
    public function trash()
    {
        $attributes = Attribute::onlyTrashed()->get();
        $assettype = AssetType::all();
        return view('Backend.Page.Master.attribute.trash', compact('attributes', 'assettype'));
    }
    public function restore($id)
    {
        $attributes = Attribute::withTrashed()->findOrFail($id);
        if (!empty($attributes)) {
            $attributes->restore();
        }
        return redirect()->route('attributes-index')->with('success', 'Attribute Restore Successfully');
    }
    public function forceDelete($id)
    {
        $attributes = Attribute::withTrashed()->find($id);

        if (!$attributes) {
            return response()->json(['success' => false], 404);
        }

        $attributes->forceDelete();

        return response()->json(['success' => true]);
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
                'unique:attributes,name,except,id',
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
        $attribute = Attribute::find($id);
        $referencesExist = $attribute->stocks()->exists();
        if ($referencesExist) {
            return response()->json(['success' => false, 'message' => 'Attribute is referenced in one or more tables and cannot be deleted.']);
        }
        $attribute->delete();
        return response()->json(['success' => true, 'message' => 'Attribute deleted successfully.']);
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
    public function export()
    {
        return Excel::download(new AttributeExport(), 'Attribute_format.xlsx');
    }
    public function import(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx',
        ]);
        $path = $request->file('select_file')->getRealPath();
        $data = Excel::toCollection(new AttributeImport(), $path)->first()->skip(1);
        foreach ($data as $row) {
            $asset = AssetType::updateOrCreate(
                ['name' => $row[0]],
                [
                    'name' => $row[0],
                ]
            );
            $myString = $row[1];
            $myArray = explode(',', $myString);
            foreach ($myArray as $value) {
                Attribute::updateOrCreate(
                    ['name' => $value],
                    [
                        'asset_type_id' => $asset->id,
                    ]
                );
            }
        }
        return redirect()->route('attributes-index')->with('message', 'Data imported successfully.');
    }
}
