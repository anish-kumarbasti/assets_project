@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
@section('Content-Area')
@if (Session::has('success'))
<div id="alerts" class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif
@if (Session::has('danger'))
<div id="alerts" class="alert alert-danger">
    {{ Session::get('danger') }}
</div>
@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4>Choose Role</h4>
        </div>
        <div class="card-body border">
            <div class="col-md-12">
                <label for="selectRole" class="form-label fw-bold">Choose Role</label>
                <select name="role" required class="form-control" id="selectRole">
                    <option value="">Select Role</option>
                    @foreach ($chooserole as $value)
                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    {{-- @dd($permissionsByModule->firstWhere('name')); --}}
    <div class="card" id="permissionsCard" style="display: none">
        <div class="card-header pb-0">
            <h4>Admin Permissions</h4>
        </div>
        <div class="card-body">
            <form action="" method="POST" id="permissionsForm">
                @csrf
                @method('put')
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr class="w-30">
                                <th>Module</th>
                                <th>Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissionsByModule as $module => $modulePermissions)
                            <tr>
                                <div class="row">
                                    <div class="col-md-12 d-flex">
                                        <div class="col-md-2">
                                            <td>{{ $module }}</td>
                                        </div>
                                        <td>
                                            <div class="col-md-10 d-flex">
                                                @foreach ($permissionTypes as $permissionT)
                                                @switch($permissionT)
                                                @case('view')
                                                <div class="col-sm-2" style="display: flex; align-items: center;">
                                                    <span class="mt-2" style="order: 1;">{{ ucfirst($permissionT) }}</span>
                                                    <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                                        <input type="checkbox" name="permissions[]" value="{{ $modulePermissions[0]->id }}" data-permission-name="{{ $modulePermissions[0]->name }}">
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                                @break

                                                @case('manage')
                                                <div class="col-sm-2" style="display: flex; align-items: center;">
                                                    <span class="mt-2" style="order: 1;">{{ ucfirst($permissionT) }}</span>
                                                    <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                                        <input type="checkbox" name="permissions[]" value="{{ $modulePermissions[1]->id ?? '' }}" data-permission-name="{{ $modulePermissions[1]->name??'' }}">
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                                @break

                                                @case('create')
                                                <div class="col-sm-2" style="display: flex; align-items: center;">
                                                    <span class="mt-2" style="order: 1;">{{ ucfirst($permissionT) }}</span>
                                                    <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                                        <input type="checkbox" name="permissions[]" value="{{ $modulePermissions[2]->id ?? '' }}" data-permission-name="{{ $modulePermissions[2]->name??'' }}">
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                                @break

                                                @case('edit')
                                                <div class="col-sm-2" style="display: flex; align-items: center;">
                                                    <span class="mt-2" style="order: 1;">{{ ucfirst($permissionT) }}</span>
                                                    <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                                        <input type="checkbox" name="permissions[]" value="{{ $modulePermissions[3]->id ?? '' }}" data-permission-name="{{ $modulePermissions[3]->name??'' }}">
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                                @break

                                                @default
                                                <div class="col-sm-2" style="display: flex; align-items: center;">
                                                    <span class="mt-2" style="order: 1;">{{ ucfirst($permissionT) }}</span>
                                                    <label class="mb-0 switch" style="order: 2; margin-left: 5px;">
                                                        <input type="checkbox" name="permissions[]" value="{{ $modulePermissions[4]->id ?? '' }}" data-permission-name="{{ $modulePermissions[4]->name??'' }}">
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                                @break
                                                @endswitch
                                                @endforeach
                                            </div>
                                        </td>
                                    </div>
                                </div>
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
@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var alert = $('#alerts');
        setTimeout(function() {
            alert.alert('close');
        }, 3000);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to the select box and permissions card
        const selectRole = document.getElementById('selectRole');
        const permissionsCard = document.getElementById('permissionsCard');
        const form = document.getElementById('permissionsForm');

        // Add an event listener to the select box
        selectRole.addEventListener('change', () => {
            const selectedRoleId = selectRole.value;
            const roleUrl = `/roles/${selectedRoleId}/admin/permissions`;

            // Set the form action to the role-specific URL
            form.setAttribute('action', roleUrl);

            // Fetch the permissions associated with the selected role
            fetch(`/getPermissionsForRole/${selectedRoleId}`)
                .then(response => response.json())
                .then(data => {
                    // Debug: Log the received data
                    console.log('Received data:', data);

                    const permissionIds = data.permissions;

                    // Update the permission checkboxes based on the permission names
                    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
                    checkboxes.forEach(checkbox => {
                        const permissionId = parseInt(checkbox.value);
                        const shouldShowToggle = permissionIds.includes(permissionId);
                        checkbox.checked = shouldShowToggle;
                        // const toggleButton = checkbox.nextElementSibling; // Assuming the toggle button is the next element
                        // if (toggleButton) {
                        //     toggleButton.style.display = shouldShowToggle ? 'block' : 'none';
                        // }
                    });
                })
                .catch(error => {
                    console.error('Error fetching permissions:', error);
                });

            // Show the permissions card
            permissionsCard.style.display = 'block';
        });
    });
</script>
@endsection