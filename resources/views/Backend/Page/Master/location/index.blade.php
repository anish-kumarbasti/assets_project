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
                        <li class="active"><a href="{{url('location-index')}}">Location</a></li>
                        {{-- <li class="active"><a href="{{url('departments/create')}}">Add-Department</a></li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('Content-Area')
@if(session('success'))
<div id="success-message" class="alert alert-success inverse alert-dismissible fade show" role="alert">
    <i class="icon-thumb-up alert-center"></i>
    <p>{{ session('success') }}</b>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('message'))
<div id="alerts" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i
        class="icon-thumb-up alert-center"></i>
    <p>{{ session('message') }}</p>
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
                <a href="{{ route('location-create') }}" class="btn btn-primary float-end"><i class="fa fa-plus"></i>&nbsp;Create Location</a>
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
                                <a href="{{ route('location-edit', $location->id) }}" class="btn btn-primary" data-bs-original-title="" title=""><i class="fa fa-pencil"></i>&nbsp;Edit</a>
                                <button class="btn btn-danger delete-button" type="button" data-id="{{ $location->id }}"><i class="fa fa-trash-o"></i>&nbsp;Trash</button>
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
                    fetch('/location-destroy/' + locationId, {
                            method: 'delete',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
                                'Content-Type': 'application/json' // Set the content type
                            }
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
                                    data.message || 'Failed to trash the file.',
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
        if ($('#success-message').length) {
            setTimeout(function() {
                $('#success-message').alert('close');
            }, 3000);
        }
    });
</script>

@endsection