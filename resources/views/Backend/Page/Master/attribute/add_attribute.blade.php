@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')

@if (session('success'))
<div id="alert-message" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p><b> Well done! </b>{{ session('success') }}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Attribute </h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" action="{{ route('attribute-store') }}" method="post">
                @csrf
                <div class="card-item">
                    <div class="row p-4">
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Asset Type</label>
                            <select class="form-select" id="asset_type_id" name="asset_type_id" aria-label="Default select example">
                                <option value="">--Select Asset Type--</option>
                                @foreach ($assettype as $assettypes)
                                <option value="{{ $assettypes->id }}">{{ $assettypes->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="form-label">Attribute Name</label>
                            <input class="form-control me-2" id="validationCustom01" type="text" name="name" required data-bs-original-title="" title="" placeholder="Enter Attribute Name">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="footer-item">
                    <button class="btn btn-primary mt-3" type="submit" data-bs-original-title="" title="">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>List Models</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>SL</th>

                            <th>Attribute Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- @dd($brandmodel); --}}

                        @foreach($attributes as $attribute)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $attribute->name }}</td>

                            <td class="w-20">
                                <label class="mb-0 switch">
                                    <input type="checkbox" data-id="{{ $attribute->id }}" {{ $attribute->status ? 'checked' : '' }}>
                                    <span class="switch-state"></span>
                                </label>
                            </td>
                            {{-- @dd($brandmodel->id); --}}
                            <td>
                                <a class="btn btn-primary" href="{{ url('attributes/' . $attribute->id . '/edit' ) }}"><i class="fa fa-pencil"></i> Edit</a>
                                <button class="btn btn-danger delete-button" type="button" data-id="{{ $attribute->id }}"><i class="fa fa-trash-o"></i> Delete</button>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
<script>
    $(document).ready(function() {
        var alertfunction = $('#alert-message');
        setTimeout(function() {
            alertfunction.alert('close');
        }, 3000);
    });
</script>

<script>
    // Add an event listener to the checkboxes for updating the brand status
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const attributeID = this.getAttribute('data-id');
            const status = this.checked;

            // Send an AJAX request to update the status
            fetch(`/attributes/${attributeID}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: status
                }) // Send the correct status value
            }).then(function(response) {
                console.log(response);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                // Optionally, you can handle the response here
                console.log('Status updated successfully');
            }).catch(function(error) {
                // Handle errors if any
                console.error('Error:', error);
            });
        });
    });
</script>
<script>
    document.querySelectorAll('.delete-button').forEach(function(button) {
        button.addEventListener('click', function() {
            const attributeId = this.getAttribute('data-id');
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
                    fetch('/attributes/' + attributeId, {
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