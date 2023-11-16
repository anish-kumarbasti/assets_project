<?php

namespace App\Http\Controllers\Master;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\DepartmentImport;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{

    public function create()
    {
        $departments = Department::all();
        return view('Backend.Page.Master.department.create', ['departments' => $departments]);
    }
    public function trash()
    {
        $departments = Department::onlyTrashed()->get();
        return view('Backend.Page.Master.department.trash', ['departments' => $departments]);
    }
    public function restore($id)
    {
        $departments = Department::withTrashed()->findOrFail($id);
        if (!empty($departments)) {
            $departments->restore();
        }
        return redirect()->route('departments-index')->with('success', 'Department Restore Successfully');
    }
    public function forceDelete($id)
    {
        $departments = Department::withTrashed()->find($id);

        if (!$departments) {
            return response()->json(['success' => false], 404);
        }

        $departments->forceDelete();

        return response()->json(['success' => true]);
    }

    // Store the newly created department
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:departments,name,except,id',
                'max:50',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
                'min:2',
                Rule::notIn(['']),
            ],
            'unique' => 'required|unique:departments,name,except,id'
        ], [
            'name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);
        // dd($request->all());
        Department::create([
            'name' => $request->name,
            'unique_id'=>$request->unique,
        ]);
        return redirect('/departments')->with('message', 'Department created successfully.');
    }
    public function index()
    {
        $departments = Department::all();
        return view('Backend.Page.Master.department.index', ['departments' => $departments]);
    }

    // Show the "Edit Department" form
    public function edit($id)
    {

        $department = Department::findOrFail($id);
        return view('Backend.Page.Master.department.edit', ['department' => $department]);
    }

    // Update the department
    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
                'min:2',
                Rule::notIn(['']),
            ],'unique' => 'required|unique:departments,name,except,id'
        ], [
            'name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);

        // Find the department and update its data
        $department = Department::findOrFail($id);
        $department->update([
            'name' => $request->name,
            'unique_id'=>$request->unique,
        ]);
        return redirect('departments')->with('message', 'Department updated Successfully!');
    }

    // Delete the department
    public function destroy($id)
    {
        // Find the department and delete it
        $department = Department::findOrFail($id);
        $department->delete();

        // Redirect back to the list of departments
        return response()->json(['success' => true]);
    }
    public function updateStatus(Request $request, Department $department)
    {

        $request->validate([
            'status' => 'required|boolean',
        ]);
        if ($department->status == 1) {
            Department::where('id', $department->id)->update([
                'status' => 0
            ]);
        } else {
            Department::where('id', $department->id)->update([
                'status' => 1
            ]);
        }
        // dd($department);

        return redirect()->route('auth.create-department')->with('success', 'Department status updated successfully.');
    }
    public function import(Request $request){
        Excel::import(new DepartmentImport, $request->file('file'));

        return redirect()->back();
    }
}
