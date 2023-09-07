@extends('Backend.Layouts.panel')
@section('Style-Area')
@endsection
@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4>Choose Role</h4>
        </div>
        <div class="card-body border">
            <div class="col-md-12">
                <label for="selectRole" class="form-label fw-bold">Choose Role</label>
               <select name="role" class="form-control" id="selectRole">
                <option value="">Select Role</option>
                @foreach ($chooserole as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
               </select>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary float-end" type="button">Submt</button>
        </div>
    </div>
   <div class="card" id="permissionsCard" style="display: none;">
      <div class="card-header pb-0">
         <h4>Admin Permissions</h4>
      </div>
      <div class="card-body">
         <form action="" method="POST">
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
@section('Script-Area')
<script>
     document.addEventListener('DOMContentLoaded', function () {
    // Get references to the select box and permissions card
    const selectRole = document.getElementById('selectRole');
    const permissionsCard = document.getElementById('permissionsCard');

    // Add an event listener to the select box
    selectRole.addEventListener('change', () => {
        const selectedRoleId = selectRole.value;

        // Send an AJAX request to get the permissions for the selected role
        // Replace 'getPermissionsForRole' with the actual URL to fetch permissions
        fetch(`/getPermissionsForRole/${selectedRoleId}`)
            .then(response => response.json())
            .then(data => {
                // Update the permission checkboxes based on the data received
                // You can use a loop to go through each permission and set the checkbox states
                // For example, if data.permissions is an array of permission names, you can do something like this:
                data.permissions.forEach(permission => {
                    console.log(permission); // Log the permission to the console for debugging
                    const checkbox = document.querySelector(`input[name="${permission}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
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
