<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\SubLocationModel;
use Illuminate\Http\Request;

class SubLocationController extends Controller
{
    public function index()
    {
        $sublocations = SubLocationModel::all();
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
            ->with('success', 'Location created successfully');
    }
    public function show(SubLocationModel $sublocation)
    {
        return view('Backend.Page.Master.sublocation.show', compact('sublocation'));
    }
    public function edit(SubLocationModel $sublocation, $id)
    {
        $sublocation = SubLocationModel::findOrFail($id);
        return view('Backend.Page.Master.sublocation.edit', compact('sublocation'));
    }
    public function update(Request $request, SubLocationModel $sublocation)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $sublocation->update($request->all());
        return redirect()->route('sublocation-index')->with('success', 'location  updated successfully');
    }
}
