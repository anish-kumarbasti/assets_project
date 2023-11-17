@extends('Backend.Layouts.panel')

@section('Style-Area')
    <style>
        .swal2-popup {
            text-align: center;
        }
    </style>
    <style>
        /* Custom styles for breadcrumbs */
        .breadcrumbs-dark ol.breadcrumbs {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .breadcrumbs-dark ol.breadcrumbs li {
            font-size: 14px;
            /* Adjust font size as needed */
            color: #555;
            /* Adjust text color as needed */
        }

        .breadcrumbs-dark ol.breadcrumbs li:not(:last-child):after {
            content: ">";
            margin-left: 10px;
            margin-right: 10px;
            color: #777;
        }

        .breadcrumbs-dark ol.breadcrumbs li.text-muted {
            color: #333;
            font-weight: bold;
        }
        .breadcrumbs-dark ol.breadcrumbs li.text-muted a {
            color: #333;
            font-weight: bold;
        }
        .breadcrumbs-dark ol.breadcrumbs li.active a {
            color: #333;
            font-weight: bold;
        }
        .breadcrumbs-dark ol.breadcrumbs li.active a:hover {
            color: blue;
        }
    </style>    
@endsection
@section('breadcrumbs')
    <div class="breadcrumbs-dark pb-0 pt-2" id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <ol class="breadcrumbs mb-2">
                        <li class="text-muted">Dashboard</li>
                        <li class="text-muted">Master</li>
                        <li class="text-muted"><a href="{{url('department')}}" class="text-muted">Department</a></li>
                        <li class="active"><a href="{{url('departments/create')}}">Add-Department</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('Content-Area')
@if (session('message'))
<div id="alerts" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p>{{session('message')}}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@can('create_department')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Add Department</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" novalidate method="POST" action="{{ url('/departments') }}">
                @csrf
                <div class="card-item">
                    <div class="row p-3">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="validationCustom01">Department Name</label>
                            <input class="form-control mb-2" id="validationCustom01" type="text" value="{{old('name')}}" name="name" required="" data-bs-original-title="" title="" placeholder="Enter Department Name">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <label class="form-label" for="validationCustom02">Department Id</label>
                            <input class="form-control" id="validationCustom02" type="text" value="DEP" name="unique" required="" data-bs-original-title="" title="" placeholder="Enter Department Id">
                            @error('unique')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="footer-item">
                    <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">ADD</button>
                    <a href="{{ route('departments-index') }}" class="btn btn-warning">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@can('manage_department')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Department</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Department ID</th>
                            <th>Department Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                        <tr>
                            <td>{{ $department->id }}</td>
                            <td>{{ $department->unique_id }}</td>
                            <td>{{ $department->name }}</td>
                            <td class="w-20">
                                <label class="mb-0 switch">
                                    <input type="checkbox" data-id="{{ $department->id }}" {{ $department->status ? 'checked' : '' }}>
                                    <span class="switch-state"></span>
                                </label>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary" href="{{ url('/departments/' . $department->id . '/edit') }}"><i class="fa fa-pencil"></i> Edit</a>&nbsp;&nbsp;
                                    <button class="btn btn-danger delete-button" type="button" data-id="{{ $department->id }}"><i class="fa fa-trash-o"></i> Delete</button>
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
@endcan
@endsection

@section('Script-Area')
<script>
    $(document).ready(function() {
        var alertfun = $('#alerts');
        setTimeout(function() {
            alertfun.alert('close');
        }, 3000);
    });
</script>

<script>
    // Add an event listener to the checkboxes for updating the department status
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const departmentId = this.getAttribute('data-id');
            const status = this.checked;

            // Send an AJAX request to update the status
            fetch(`/departments/${departmentId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: status
                }) // Send the correct status value
            }).then(function(response) {
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

<script>
    document.querySelectorAll('.delete-button').forEach(function(button) {
        button.addEventListener('click', function() {
            const departmentId = this.getAttribute('data-id');
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
                    fetch('/departments/' + departmentId, {
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