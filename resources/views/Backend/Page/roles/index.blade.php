@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <button class="btn btn-outline-primary role-btn" type="button" data-original-title="btn btn-outline-danger-2x" title="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-plus"></i> Add Role
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog d-flex align-items-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" action="{{ route('roles.store') }}" method="POST" novalidate="">
                            @csrf
                            <div class="card-item border">
                                <div class="row p-3">
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="roleName">Add Role</label>
                                        <input class="form-control" id="roleName" name="name" type="text" required="" placeholder="Role Name">
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
                        @foreach ($roles as $role)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td class="w-20">
                                <label class="mb-0 switch">
                                <input type="checkbox" checked=""><span class="switch-state"></span>
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('roles.permissions', $role->id) }}" class="btn btn-warning" data-bs-original-title="" title="">Permission</a>
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary" data-bs-original-title="" title="">Edit</a>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" data-bs-original-title="" title="">Delete</button>
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
