<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::with('department')->get();
        // dd($designations);
        return view('Backend.Page.Master.designations.index', compact('designations'));
    }
    public function trash()
    {
        $designations = Designation::onlyTrashed('department')->get();
        return view('Backend.Page.Master.designations.trash', compact('designations'));
    }
    public function restore($id)
    {
        $designations = Designation::withTrashed()->findOrFail($id);
        if (!empty($designations)) {
            $designations->restore();
        }
        return redirect()->route('designations.index')->with('success', 'Designation Restore Successfully');
    }
    public function forceDelete($id)
    {
        $designations = Designation::withTrashed()->find($id);
        $designations->forceDelete();
        return response()->json(['success' => true]);
    }


    public function create()
    {
        $departments = Department::all();
        return view('Backend.Page.Master.designations.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required',
            'designation_name' => [
                'required',
                'unique:designations,designation,except,id',
                'string',
                'max:50',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
                'min:2',
                Rule::notIn(['']),
            ],
        ], [
            'designation_name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);

        $designation = new Designation();
        $designation->designation = $validated['designation_name'];
        $designation->department_id = $validated['department_id'];
        $designation->save();

        return redirect()->route('designations.index')->with('message', 'Designation added successfully!');
    }

    public function edit($id)
    {
        $designation = Designation::find($id);
        $departments = Department::all();
        return view('Backend.Page.Master.designations.edit', compact('designation', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'department_id' => 'required',
            'designation_name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
                'min:2',
                Rule::notIn(['']),
            ],
        ], [
            'designation_name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);

        $designation = Designation::find($id);
        $designation->designation = $validated['designation_name'];
        $designation->department_id = $validated['department_id'];
        $designation->save();

        return redirect()->route('designations.index')->with('message', 'Designation updated successfully!');
    }

    public function destroy($id)
    {
        $designation = Designation::find($id);
        $designation->delete();

        return response()->json(['success' => true]);
    }
}
