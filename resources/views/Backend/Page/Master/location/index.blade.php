@extends('Backend.Layouts.panel')
@section('Content-Area')
@if(session('success'))
<div id="success-message" class="alert alert-success inverse alert-dismissible fade show" role="alert">
    <i class="icon-thumb-up alert-center"></i>
    <p>{{ session('success') }}</b>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('failed'))
<div class="alert alert-danger inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p>{{ session('failed') }}</b>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0 d-flex">
            <div class="float-left col-sm-6">
                <h4>Location</h4>
            </div>
            <div class="col-sm-6"><a href="{{route('location.trash')}}" class="btn btn-danger float-end" style="margin-left: 5px;">Trash</a>
                <a href="{{ route('location-create') }}" class="btn btn-primary float-end"><i class="fa fa-plus"></i> Create Location</a>                <a class="btn btn-primary text-end m-b-30" id="openModalButton" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i>Import</a>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content date-picker">
                    <div class="modal-header border-bottom">
                        <h4 class="modal-title text-primary" id="exampleModalLabel">Import File :</h4>
                        <button type="button" class="close ml-auto rounded float-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="excelFile">Choose Excel File</label>
                            <input type="file" class="form-control" id="excelFile" name="excelFile" required>
                        </div>
                        <div class="footer-item">
                        <button type="submit" class="btn btn-primary float-right">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locations as $location)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $location->name }}</td>
                            <td class="w-20">
                                <label class="mb-0 switch">
                                    <input type="checkbox" data-id="{{ $location->id }}" {{ $location->status ? 'checked' : '' }}>
                                    <span class="switch-state"></span>
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('location-edit', $location->id) }}" class="btn btn-primary" data-bs-original-title="" title=""><i class="fa fa-pencil"></i> Edit</a>
                                <button class="btn btn-danger delete-button" type="button" data-id="{{ $location->id }}"><i class="fa fa-trash-o"></i> Trash</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    });
</script>
<script>
    $(document).ready(function() {
        var alertfun = $('#success-message');
        setTimeout(function() {
            alertfun.alert('close');
        }, 3000);
    });
</script>
<script>
    $(document).ready(function() {

        $('input[type="checkbox"]').on('change', function() {
            const locationId = $(this).data('id');
            const status = $(this).prop('checked');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: `/location-status/${locationId}`,
                type: 'PUT',
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
            const locationId = this.getAttribute('data-id');
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
                    fetch('/location-destroy/' + locationId, {
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
                                    'Your file has been trash.',
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
<script>
    $(document).ready(function() {
        // Check if the success message exists and hide it after 5 seconds (adjust the time as needed)
        if ($('#success-message').length) {
            setTimeout(function() {
                $('#success-message').alert('close');
            }, 5000); // Hide after 5 seconds
        }
    });
</script>

@endsection
