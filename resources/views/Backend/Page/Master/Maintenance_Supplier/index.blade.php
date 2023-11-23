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
                        <li class="active"><a href="{{ url('maintenance/suppliers') }}">Maintenance Supplier</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('Content-Area')
    @if (session('success'))
        <div id="alert-message" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i
                class="icon-thumb-up alert-center"></i>
            <p>{{ session('message') }}</p>
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
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0 d-flex">
                <div class="float-left col-sm-6">
                    <h4>Suppliers</h4>
                </div>
                <div class="col-sm-6">
                    {{-- <a href="{{ route('trash.suppliers') }}" class="btn btn-danger float-end"
                        style="margin-left: 5px;">Trash</a> --}}
                    <a href="{{ route('maintenance.suppliers.create') }}" class="btn btn-primary float-end"><i
                            class="fa fa-plus"></i>&nbsp;Create Suppliers</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Maintenance SupplierID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->id }}</td>
                                    <td>{{ $supplier->MaintenanceSupllierID }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td>
                                        <a href="{{ url('maintenance/suppliers/' . $supplier->id . '/edit') }}"
                                            class="btn btn-primary"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
                                        <a href="{{ route('maintenance.suppliers.destroy', $supplier->id) }}"
                                            class="btn btn-danger"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
                                        {{-- <button type="button" class=" delete-button btn btn-danger"
                                            data-id="{{ $supplier->id }}"><i class="fa fa-trash-o"></i>&nbsp;Trash</button> --}}
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
            var alertmessage = $('#alert-message');
            setTimeout(function() {
                alertmessage.alert('close');
            }, 3000);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

    <script>
        document.querySelectorAll('.delete-button').forEach(function(button) {
            button.addEventListener('click', function() {
                const Id = this.getAttribute('data-id');
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
                        fetch('/suppliers/' + Id, {
                                method: 'delete',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        'Trash!',
                                        'Your file has been trashed.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
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
@endsection
