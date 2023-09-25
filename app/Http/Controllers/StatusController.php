<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatusController extends Controller
{
    public function status()
    {
        $data = Status::all();
        return view('Backend.Page.Master.status.index', compact('data'));
    }
    public function trash()
    {
        $data = Status::onlyTrashed()->get();
        return view('Backend.Page.Master.status.trash', compact('data'));
    }
    public function restore($id)
    {
        $data = Status::withTrashed()->findOrFail($id);
        if (!empty($data)) {
            $data->restore();
        }
        return redirect()->route('change-status')->with('success', 'Status Restore Successfully');
    }
    public function forceDelete($id)
    {
        $data = Status::withTrashed()->find($id);

        $data->forceDelete();

        return response()->json(['success' => true]);
    }
    public function save(Request $request)
    {
        $status = $request->validate([
            'status' => 'required',
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
        // dd($status);
        Status::create($status);
        return redirect()->route('change-status')->with('success', 'Status Created Successfully');
    }
    public function edit($id)
    {
        $status = Status::findOrFail($id);
        return view('Backend.Page.Master.status.edit', compact('status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:20',
        ]);
        $status = Status::find($id);
        $status->name = $request->name;
        $status->status = $request->status;
        $status->update();
        return redirect()->route('change-status')->with('success', 'Status Updated Successfully');
    }
    public function destroy($id)
    {
        $data = Status::find($id);
        $data->delete($data);
        return response()->json(['success' => true]);
    }
}
