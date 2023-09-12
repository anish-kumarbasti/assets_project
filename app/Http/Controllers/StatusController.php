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
        return view('Backend.Page.Master.Status.index', compact('data'));
    }
    public function save(Request $request)
    {
        $status = $request->validate([
            // 'status' => 'required|numeric|in:0,1,2,3',
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
        $request->validate(
            [
                // 'status' => 'numeric|required|in:0,1,2,3',
                'name' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^[A-Za-z]+([A-Za-z]+)*$/',
                    Rule::notIn(['']),
                ]
            ],
            [
                'name.regex' => 'The :attribute may only contain letters and spaces. Numbers and special characters are not allowed.',
            ]
        );
        $status = Status::find($id);
        $status->name = $request->name;
        // $status->status = $request->status;
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
