@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Permissions for Role: {{ $role->name }}</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" method="post" action="{{ route('roles.update_permissions',$role->id) }}" novalidate="">
                @csrf
                @isset($permissions)
                @method('put');
                @endisset
                <div class="card-item border">
                    <div class="row p-3">
                        @foreach ($permissions as $permission)
                        <div class="col-md-4 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}">
                                <label class="form-check-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="footer-item">
                    <button class="btn btn-primary mt-3" type="submit" data-bs-original-title="" title="">Update Permissions</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
