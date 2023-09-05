@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
<div class="col-sm-12">
    @if(session('success'))
    <div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
        <p>{{ session('success') }}</b>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>
<div class="card">
    <div class="card-header pb-0">
        <h4 class="d-flex justify-content-between align-items-center">
            <span>Sub Locations</span>
            <a href="{{ route('sublocation-create') }}" class="btn btn-primary">Sub Location</a>
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive theme-scrollbar">
            <table class="display" id="basic-1">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Location</th>
                        <th>Sub Location</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sublocations as $sublocation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sublocation->locations->name??''}}</td>
                        <td>{{ $sublocation->name }}</td>
                        <td class="w-20">
                            <label class="mb-0 switch">
                                <input type="checkbox" data-id="{{ $sublocation->id }}" value="{{$sublocation->id}}" {{ $sublocation->status ? 'checked' : '' }}>
                                <span class="switch-state"></span>
                            </label>
                        </td>
                        <td>
                            <a href="{{ route('sublocation-edit', $sublocation->id) }}" class="btn btn-primary" data-bs-original-title="" title="">Edit</a>
                            <button class="btn btn-danger delete-button" type="button" data-id="{{ $sublocation->id }}">Delete</button>
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
@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $('input[type="checkbox"]').on('change', function() {
            const locationId = $(this).val();
            const status = $(this).prop('checked');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: `/location-update-status/${locationId}`,
                method: 'post',
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
            const sublocationId = this.getAttribute('data-id');
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
                    fetch('/sublocation-destroy/' + sublocationId, {
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
                                'An error occurred while deleting the file.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>
@endsection

@endsection