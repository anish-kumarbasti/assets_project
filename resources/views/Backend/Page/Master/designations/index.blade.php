@extends('Backend.Layouts.panel')
@section('Content-Area')
@if (session('message'))
<div id="alert-message" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p>{{session('message')}}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0 d-flex">
            <div class="float-left col-sm-6">
                <h4>Designations</h4>
            </div>
            <div class="col-sm-6">
                @can('create_designation')
                <a href="{{route('designation.trash')}}" class="btn btn-danger float-end" style="margin-left: 5px;">Trash</a><a href="{{route('designations.create')}}" class="btn btn-primary float-end"><i class="fa fa-plus"></i> Add Designation</a>
                @endcan
            </div>
        </div>
        @can('manage_designation')
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($designations as $designation)
                        <tr>
                            <td>{{ $designation->id }}</td>
                            <td>{{ $designation->department->name??'N/A'}}</td>
                            <td>{{ $designation->designation??'N/A' }}</td>

                            <td class="w-20">
                                <label class="mb-0 switch">
                                    <input type="checkbox" checked=""><span class="switch-state"></span>
                                </label>
                            </td>
                            <td>
                                @can('edit_designation')
                                <a href="{{ route('designations.edit', $designation->id) }}" class="btn btn-primary">Edit</a>
                                @endcan
                                @can('delete_designation')
                                <button class="btn btn-danger delete-button" type="button" data-id="{{ $designation->id }}">Trash</button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endcan
    </div>
</div>

@endsection
@section('Script-Area')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var alertmessage = $('#alert-message');
        setTimeout(function() {
            alertmessage.alert('close');
        }, 3000);
    });
</script>
<script>
    document.querySelectorAll('.delete-button').forEach(function(button) {
        button.addEventListener('click', function() {
            const designationId = this.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Show SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, trash it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to the server to delete the item
                    fetch('/designations/' + designationId, {
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
                                    'Trashed!',
                                    'Your file has been trashed.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload the page after the alert is closed
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    'Failed to trash the file.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error',
                                'An error occurred while trashing the file.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>
@endsection