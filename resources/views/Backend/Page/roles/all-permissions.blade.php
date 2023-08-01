@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            Admin Permissions
        </div>
        <div class="card-body">
            <form action="{{ route('permissions.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="w-30">
                                <th>Module</th>
                                <th>Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modules as $module)
                            <tr>
                                <td>{{ $module }}</td>
                                <td>
                                    <div class="row">
                                        @foreach(['manage', 'create', 'edit', 'delete'] as $permissionType)
                                        <div class="col-md-3">
                                            <div style="display: flex; align-items: center;">
                                                <span class="mt-2" style="order: 1;">{{ ucfirst($permissionType) }}</span>
                                                <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                                    <input type="checkbox" name="{{ $module }}[{{ $permissionType }}]"
                                                           {{ in_array($module . '.' . $permissionType, $permissions) ? 'checked' : '' }}>
                                                    <span class="switch-state"></span>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update Permissions</button>
            </form>
        </div>
    </div>
</div>
@endsection
