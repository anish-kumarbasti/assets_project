@extends('Backend.Layouts.panel')

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="d-flex justify-content-between align-items-center">
                <span>Trash User</span>
                <a href="{{ route('users.index') }}" class="btn btn-primary float-right">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Emp ID</th>
                            <th>Emp Name</th>
                            <th>Emp Email</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Profile Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{$user->employee_id}}</td>
                            <td><a href="{{ route('users.user-profile', $user->id) }}">{{ $user->first_name }} {{ $user->last_name }} </a></td>
                            <td>{{ $user->email }}</td>
                            <td>{{$user->department->name??''}}</td>
                            <td> {{ $user->designation->designation??'' }} </td>
                            <td>
                                <img src="{{ asset($user->profile_photo) }}" alt="Profile Photo" style="width: 100px; height: 50px;">
                            </td>
                            <td>
                                <div class="d-flex justify-content-between align-item-center">
                                    <a href="{{ route('users.restore', $user->id) }}" class="btn btn-primary custom-btn" style="display: flex;"><i class="fa fa-restore" style="margin-top: 4px;"></i>&nbsp;Restore</a>&nbsp;
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
@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $('input[type="checkbox"]').on('change', function() {
            const assetId = $(this).data('id');
            const status = $(this).prop('checked');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: `assets.destroy${assetId}`,
                type: 'delete',
                data: {
                    status: status
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log('Status updated successfully');
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
<script>
    document.querySelectorAll('.delete-button').forEach(function(button) {
        button.addEventListener('click', function() {
            const brandId = this.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Show SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to the server to delete the item
                    fetch('/assets-permanently-delete/' + brandId, {
                            method: 'delete',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
                                'Content-Type': 'application/json' // Set the content type
                            }
                            // You can set headers and other options here
                        })
                        .then(response => response.json())

                        .then(data => {

                            if ('success' in data && data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload the page after the alert is closed
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    'Failed to delete the file.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error',
                                'An error occurred while deleted the file.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>

@endsection