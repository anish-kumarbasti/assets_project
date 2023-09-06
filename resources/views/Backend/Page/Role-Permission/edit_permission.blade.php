@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Edit Permission</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" novalidate="" action="{{ route('permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-item border">
                    <div class="row p-3">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="validationCustom01">Permission Name</label>
                            <input class="form-control" id="validationCustom01" type="text" required="" data-bs-original-title="" title="" name="name" value="{{ $permission->name }}" placeholder="Permission Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
