<?php

namespace App\Http\Controllers\Master;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{

    public function create()
    {
        $departments = Department::all();
        return view('Backend.Page.Master.department.create', ['departments' => $departments]);
    }

    // Store the newly created department
    public function store(Request $request)
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
            ],
        ], [
            'name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);

        // Create the department using the Department model
        Department::create([
            'name' => $request->name,
            // Add other fields if needed
        ]);

        // Redirect back to the list of departments
        return redirect('departments')->with('message', 'Department Added Successfully!');
    }

    // Show the list of departments
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
            ],
        ], [
            'name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
        ]);

        // Find the department and update its data
        $department = Department::findOrFail($id);
        $department->update([
            'name' => $request->name,
            // Add other fields if needed
        ]);

        // Redirect back to the list of departments
        return redirect('/departments/create')->with('message', 'Department updated Successfully!');
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
}
