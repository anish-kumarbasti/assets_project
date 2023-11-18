<?php

namespace App\Http\Controllers;

use App\Exports\SubLocationExport;
use App\Imports\SubLocationImport;
use App\Models\Location;
use App\Models\SubLocationModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubLocationController extends Controller
{
    public function index()
    {
        $message = 'Sub location status updated successfully';
        $sublocations = SubLocationModel::with('locations')->get();
        return view('Backend.Page.Master.sublocation.index', compact('sublocations', 'message'));
    }
    public function trash()
    {
        $sublocations = SubLocationModel::onlyTrashed('locations')->get();
        return view('Backend.Page.Master.sublocation.trash', compact('sublocations'));
    }
    public function restore($id)
    {
        $sublocations = SubLocationModel::withTrashed()->findOrFail($id);
        if (!empty($sublocations)) {
            $sublocations->restore();
        }
        return redirect()->route('sublocation-index')->with('success', 'Sublocation Restore Successfully');
    }
    public function forceDelete($id)
    {
        $sublocations = SubLocationModel::withTrashed()->find($id);

        if (!$sublocations) {
            return response()->json(['message' => false], 404);
        }

        $sublocations->forceDelete();

        return response()->json(['message' => true]);
    }

    public function create()
    {
        $locations = Location::all();
        return view('Backend.Page.Master.sublocation.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:sublocations,name,except,id',
            'location_id' => 'required',
        ]);

        SubLocationModel::create($request->all());

        return redirect()->route('sublocation-index')
            ->with('success', 'Sub Location created successfully');
    }
    public function show(SubLocationModel $sublocation)
    {
        return view('Backend.Page.Master.sublocation.show', compact('sublocation'));
    }
    public function edit(SubLocationModel $sublocation, $id)
    {
        $locations = Location::all();
        $sublocation = SubLocationModel::findOrFail($id);
        return view('Backend.Page.Master.sublocation.edit', compact('sublocation', 'locations'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        $sublocation = SubLocationModel::findOrFail($id);
        $sublocation->name = $request->input('name');
        $sublocation->location_id = $request->input('location_id');
        $sublocation->update();

        // SubLocationModel::create([
        //     'name' => $request->name,
        //     'location_id' => $request->location_id,
        // ]);
        return redirect()->route('sublocation-index')->with('success', 'Sub location  updated successfully');
    }
    public function destroy(SubLocationModel $sublocation)
    {
        $referencesExist = $sublocation->users()->exists() || $sublocation->issuances()->exists();
        if ($referencesExist) {
            return response()->json(['success' => false, 'message' => 'Sub Location is referenced in one or more tables and cannot be deleted.']);
        }
        $sublocation->delete();
        return response()->json(['success' => true, 'message' => 'Sub Location deleted successfully.']);
    }
    public function updateStatus(Request $request, $sublocationId)
    {

        $location = SubLocationModel::findOrFail($sublocationId);

        if ($location->status == 0) {
            SubLocationModel::where('id', $sublocationId)->update([
                'status' => 1,
            ]);
        } else {
            SubLocationModel::where('id', $sublocationId)->update([
                'status' => 0,
            ]);
        }

        return response()->json(['message' => 'Sub location Type status updated successfully']);
    }
    public function export()
    {
        return Excel::download(new SubLocationExport(), 'SubLocation_format.xlsx');
    }
    public function import(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx',
        ]);
        // dd($request);
        $path = $request->file('select_file')->getRealPath();
        $data = Excel::toCollection(new SubLocationImport(), $path)->first()->skip(1);
        foreach ($data as $row) {
            $brand = Location::updateOrCreate(
                ['name' => $row[0]],
                [
                    'name' => $row[0],
                ]
            );
            $myString = $row[1];
            $myArray = explode(',', $myString);
            foreach ($myArray as $value) {
                SubLocationModel::updateOrCreate(
                    ['name' => $value],
                    [
                        'location_id' => $brand->id,
                    ]
                );
            }
        }
        return redirect()->route('sublocation-index')->with('message', 'Data imported successfully.');
    }
}
