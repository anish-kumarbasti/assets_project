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
                        {{-- <li class="text-muted"><a href="{{url('department')}}" class="text-muted">Department</a></li> --}}
                        <li class="active"><a href="{{url('transfer-create')}}">Transfer-Reason</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('Content-Area')
@if (session('success'))
<div id="alrt-message" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p>{{ session('success') }}</b>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            @if (isset($transferReason))
            <h4>Edit Transfer Reason</h4>
            @else
            <h4>Transfer Reason</h4>
            @endif
        </div>
        <div class="card-body">
            @if (isset($transferReason))
            <form method="POST" action="{{ route('transfer-reasons.update', $transferReason) }}">
                @method('PUT')
                @else
                <form method="POST" action="{{ route('transfer-reasons.store') }}">
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <input type="text" class="form-control" id="reason" name="reason" value="{{ isset($transferReason) ? $transferReason->reason : '' }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end">
                        @if (isset($transferReason))
                        Update
                        @else
                        Create
                        @endif
                    </button>
                </form>
        </div>
    </div>
</div>
@if (isset($transferReason))
@else
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="d-flex justify-content-between align-items-center">
                <span>List of Transfer Reason</span>
                <a href="{{ route('trash.transfer-reasons') }}" class="btn btn-primary float-right">Trash</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transferReasons as $reason)
                        <tr>
                            <td>{{ $reason->id }}</td>
                            <td>{{ $reason->reason }}</td>
                            <td class="w-20">
                                <label class="mb-0 switch">
                                    <input type="checkbox" data-id="{{ $reason->id }}" {{ $reason->status ? 'checked' : '' }}>
                                    <span class="switch-state"></span>
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('transfer-reasons.edit', $reason->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                <button class="btn btn-danger delete-button" type="button" data-id="{{ $reason->id }}"><i class="fa fa-trash-o"></i> Trash</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var alertfunction = $('#alrt-message');
        setTimeout(function() {
            alertfunction.alert('close');
        }, 3000);
    });
</script>
<script>
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const reasonId = this.getAttribute('data-id');
            const status = this.checked;

            fetch(`/reason-status/${reasonId}`, {
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
                console.log('Status updated successfully');
            }).catch(function(error) {
                // Handle errors if any
                console.error('Error:', error);
            });
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
<script>
    document.querySelectorAll('.delete-button').forEach(function(button) {
        button.addEventListener('click', function() {
            const reasonId = this.getAttribute('data-id');
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
                    fetch('/transfer-reasons/' + reasonId, {
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
                                    'Trash!',
                                    'Your file has been trash.',
                                    'success'
                                ).then(() => {
                                    location
                                        .reload(); // Reload the page after the alert is closed
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
                                'An error occurred while trash the file.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>
@endsection