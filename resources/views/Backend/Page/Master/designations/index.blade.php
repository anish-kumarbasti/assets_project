@extends('Backend.Layouts.panel')
@section('Content-Area')
@if (session('message'))
      <div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
        <p><b> Well done! </b>{{session('message')}}</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>
                Designations
                <a href="{{ route('designations.create') }}" class="btn btn-primary float-right">Add Designation</a>
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
                            <td>{{ $designation->department->name }}</td>
                            <td>{{ $designation->designation }}</td>

                            <td class="w-20">
                                <label class="mb-0 switch">
                                <input type="checkbox" checked=""><span class="switch-state"></span>
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('designations.edit', $designation->id) }}" class="btn btn-primary">Edit</a>
                                <form method="POST" action="{{ route('designations.destroy', $designation->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
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
