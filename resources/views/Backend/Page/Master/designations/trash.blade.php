@extends('Backend.Layouts.panel')
@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="d-flex justify-content-between align-items-center">
                <span>Trash Designations</span>
                <a href="{{ route('designations.index') }}" class="btn btn-info">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($designations as $designation)
                        <tr>
                            <td>{{ $designation->id }}</td>
                            <td>{{ $designation->department->name??'N/A'}}</td>
                            <td>{{ $designation->designation??'N/A' }}</td>

                            <td class="w-20">
                                <label class="mb-0 switch">
                                    <input type="checkbox" checked=""><span class="switch-state"></span>
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('designations.restore', $designation->id) }}" class="btn btn-primary">Restore</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('Script-Area')
@endsection