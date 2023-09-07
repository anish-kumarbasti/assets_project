@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
@if (session('success'))
<div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p><b> Well done! </b>{{ session('success') }}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif
@if ($errors->any())
<ul class="alert alert-danger inverse alert-dismissible">
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    @endforeach
</ul>
@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            Admin Permissions
            <button class="btn btn-outline-primary permission-btn float-end" type="button" data-original-title="btn btn-outline-danger-2x" title="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-plus"></i> Add permission
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog d-flex align-items-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" action="{{ route('permission.store') }}" method="POST" novalidate="">
                            @csrf
                            <div class="card-item border">
                                <div class="row p-3">
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="roleName">Add Permission</label>
                                        <input class="form-control" id="roleName" name="name" type="text" required="" placeholder="Permission Name">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permission as $role)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td class="w-20">
                                    <label class="mb-0 switch">
                                        <input type="checkbox" checked=""><span class="switch-state"></span>
                                    </label>
                                </td>
                                <td>
                                    {{-- <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary" data-bs-original-title="" title="">Edit</a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" data-bs-original-title="" title="">Delete</button>
                                    </form> --}}
                                    <div class="btn-group">
                                        <a href="{{ route('permission.edit', $role->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>&nbsp;&nbsp;
                                        <button class="btn btn-danger delete-button"  data-id="{{ $role->id }}" type="button"><i class="fa fa-trash-o"></i> Delete</button>
                                        </div>
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
