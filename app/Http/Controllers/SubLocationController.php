<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\SubLocationModel;
use Illuminate\Http\Request;

class SubLocationController extends Controller
{
    public function index()
    {
        $sublocations = SubLocationModel::with('locations')->get();
        return view('Backend.Page.Master.sublocation.index', compact('sublocations'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('Backend.Page.Master.sublocation.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
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
            'name' => 'required',
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
        $sublocation->delete();
        return redirect()->route('sublocation-index')->with('success', 'Delete Sub Location successfully');
    }
    public function updateStatus(Request $request, SubLocationModel $sublocationId)
    {

        $request->validate([
            'status' => 'required|boolean',
        ]);
        if ($sublocationId->status == 1) {
            SubLocationModel::where('id', $sublocationId->id)->update([
                'status' => 0
            ]);
        } else {
            Location::where('id', $sublocationId->id)->update([
                'status' => 1
            ]);
        }
        // dd($Location);

        return redirect()->route('sublocation-index')->with('success', 'Location status updated successfully.');
    }
}
