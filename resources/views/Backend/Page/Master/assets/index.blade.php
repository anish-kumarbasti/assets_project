@extends('Backend.Layouts.panel')

@section('Content-Area')
@if (session('success'))
        <div class="alert alert-success inverse alert-dismissible fade show" role="alert"><i
                class="icon-thumb-up alert-center"></i>
            <p><b> Well done! </b>{{ session('success') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>
                Assets
                <a href="{{ route('assets.create') }}" class="btn btn-primary float-right">Add Asset</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $asset)
                        <tr>
                            <td>{{ $asset->id }}</td>
                            <td>{{ $asset->name }}</td>
                            <td>{{ $asset->Asset->name }}</td>
                            <td class="w-20">
                                <label class="mb-0 switch">
                                <input type="checkbox" data-id="{{$asset->id}}" {{ $asset->status ? 'checked' : '' }}><span class="switch-state"></span>
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary">Edit</a>

                                <button class="btn btn-danger delete-button" type="button"
                                data-id="{{ $asset->id }}">Delete</button>

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
                const assetId = this.getAttribute('data-id');
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

                        fetch('assets/' + assetId, {

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

