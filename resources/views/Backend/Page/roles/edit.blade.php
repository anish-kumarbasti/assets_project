@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Edit Role</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" novalidate="" action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-item border">
                    <div class="row p-3">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="validationCustom01">Role Name</label>
                            <input class="form-control" id="validationCustom01" type="text" required="" data-bs-original-title="" title="" name="name" value="{{ $role->name }}" placeholder="Role Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
