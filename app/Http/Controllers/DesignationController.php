<?php

namespace App\Http\Controllers;

use App\Exports\DesignationExport;
use App\Imports\DesignationImport;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

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
        // dd($id);
        $designation = Designation::find($id);
        $referencesExist = $designation->users()->exists();
        if ($referencesExist) {
            return response()->json(['success' => false, 'message' => 'Designation is referenced in one or more tables and cannot be deleted.']);
        }
        $designation->delete();
        return response()->json(['success' => true, 'message' => 'Designation deleted successfully.']);
    }
    public function export()
    {
        return Excel::download(new DesignationExport(), 'designations_format.xlsx');
    }
    public function import(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx',
        ]);
        // dd($request);
        $path = $request->file('select_file')->getRealPath();
        $data = Excel::toCollection(new DesignationImport(), $path)->first()->skip(1);
        foreach ($data as $row) {
            $department = Department::updateOrCreate(
                ['name' => $row[0]],
                [
                    'name' => $row[0],
                ]
            );
            $myString = $row[1];
            $myArray = explode(',', $myString);
            foreach ($myArray as $value) {
                Designation::updateOrCreate(
                    ['designation' => $value],
                    [
                        'department_id' => $department->id,
                    ]
                );
            }
        }
        return redirect()->route('designations.index')->with('message', 'Data imported successfully.');
    }
}
