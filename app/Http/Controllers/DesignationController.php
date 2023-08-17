<?php
namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Department;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::with('department')->get();
        // dd($designations);
        return view('Backend.Page.Master.designations.index', compact('designations'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('Backend.Page.Master.designations.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'designation_name' => 'required',
            'department_id' => 'required',
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
            'designation_name' => 'required',
            'department_id' => 'required',
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
