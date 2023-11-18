<?php

namespace App\Http\Controllers;

use App\Exports\LocationExport;
use App\Imports\LocationImport;
use App\Models\Location;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LocationController extends Controller
{
    public function index()
    {

        $locations = Location::all();
        return view('Backend.Page.Master.location.index', compact('locations'));
    }
    public function trash()
    {
        $locations = Location::onlyTrashed()->get();
        return view('Backend.Page.Master.location.trash', compact('locations'));
    }
    public function restore($id)
    {
        $locations = Location::withTrashed()->findOrFail($id);
        if (!empty($locations)) {
            $locations->restore();
        }
        return redirect()->route('location-index')->with('success', 'Brand Restore Successfully');
    }
    public function forceDelete($id)
    {
        $locations = Location::withTrashed()->find($id);
        $locations->forceDelete();
        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('Backend.Page.Master.location.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30|unique:locations,name,except,id',

        ]);
        $location = Location::create($request->all());
        return redirect()->route('location-index')
            ->with('success', 'location created successfully');
    }

    public function show(Location $location)
    {
        return view('Backend.Page.Master.location.show', compact('location'));
    }

    public function edit(Location $location, $id)
    {
        $location = Location::findOrFail($id);
        return view('Backend.Page.Master.location.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $location->update($request->all());

        return redirect()->route('location-index')
            ->with('success', 'location  updated successfully');
    }
    public function locationStatus(Request $request, $locationId)
    {

        $location = Location::findOrFail($locationId);

        if ($location->status == true) {
            Location::where('id', $locationId)->update([
                'status' => 0,
            ]);
        } else {
            Location::where('id', $locationId)->update([
                'status' => 1,
            ]);
        }

        return response()->json(['message' => 'location Type status updated successfully']);
    }
    public function destroy(Location $location)
    {
        $referencesExist = $location->users()->exists() || $location->issuances()->exists() || $location->sublocations()->exists();
        // dd($referencesExist);
        if ($referencesExist) {
            return response()->json(['success' => false, 'message' => 'location is referenced in one or more tables and cannot be deleted.']);
        }
        $location->delete();
        return response()->json(['success' => true, 'message' => 'location deleted successfully.']);
    }
    public function export()
    {
        return Excel::download(new LocationExport(), 'Location_format.xlsx');
    }
    public function import(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx',
        ]);
        $path = $request->file('select_file')->getRealPath();
        $data = Excel::toCollection(new LocationImport(), $path)->first()->skip(1);
        foreach ($data as $row) {
            Location::updateOrCreate(
                ['name' => $row[0]],
                [
                    'name' => $row[0],
                ]
            );
        }
        return redirect()->route('location-index')->with('message', 'Data imported successfully.');
    }
}
