@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Create Role</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" novalidate="">
                <div class="card-item border">
                    <div class="row p-3">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="validationCustom01">Add Role</label>
                            <input class="form-control" id="validationCustom01" type="text" required="" data-bs-original-title="" title="" placeholder="Role Name">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
