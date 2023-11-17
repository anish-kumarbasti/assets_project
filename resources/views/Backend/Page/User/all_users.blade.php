@extends('Backend.Layouts.panel')

@section('Style-Area')
    <style>
        .img {
            width: 100%;
        }

        .square-image {
            width: 100px;
            height: 100px;
        }

        .custom-btn {
            font-size: 12px;
            padding: 5px 10px;
            line-height: 1.5;
            display: flex;
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
                        <li class="text-muted">User-Management</li>
                        {{-- <li class="text-muted"><a href="{{ url('department') }}" class="text-muted">Department</a></li> --}}
                        <li class="active"><a href="{{ url('users') }}">All-Users</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('Content-Area')
    @if (session('success'))
        <div id="pop" class="alert alert-success inverse alert-dismissible show" role="alert"><i
                class="icon-thumb-up alert-center"></i>
            <p><b> Well done! </b>{{ session('success') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0 d-flex">
                <div class="float-left col-sm-6">
                    <h4>All User</h4>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('users.trash') }}" class="btn btn-danger float-end"
                        style="margin-left: 5px;">Trash</a>
                </div>
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
                                    <td>{{ $user->employee_id }}</td>
                                    <td><a href="{{ route('users.user-profile', $user->id) }}">{{ $user->first_name }}
                                            {{ $user->last_name }} </a></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->department->name ?? '' }}</td>
                                    <td> {{ $user->designation->designation ?? '' }} </td>
                                    <td>
                                        <img src="{{ asset($user->profile_photo) }}" alt="Profile Photo"
                                            style="width: 100px; height: 50px;">
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-item-center">
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-primary custom-btn" style="display: flex;"><i
                                                    class="fa fa-pencil" style="margin-top: 4px;"></i>&nbsp;Edit</a>&nbsp;
                                            <button class="btn btn-danger custom-btn delete-button" type="button"
                                                data-id="{{ $user->id }}" style="display: flex;"><i class="fa fa-trash"
                                                    style="margin-top: 4px;"></i>&nbsp;Trash</button>
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
            var alerts = $('#pop');
            setTimeout(function() {
                alerts.alert('close');
            }, 3000);
        });
    </script>
    <script>
        // $(document).ready(function() {
        //     $('#toggleCardView').hide();
        //     $('#toggleListView').click(function() {
        //         $('#userCard').hide();
        //         $('#userList').show();
        //         $('#toggleCardView').show();
        //         $(this).hide();
        //     });

        //     $('#toggleCardView').click(function() {
        //         $('#userList').hide();
        //         $('#userCard').show();
        //         $('#toggleListView').show();
        //         $(this).hide();
        //     });
        // });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script>
        document.querySelectorAll('.delete-button').forEach(function(button) {
            button.addEventListener('click', function() {
                const assetId = this.getAttribute('data-id');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const deleteRoute = '{{ route('users.destroy', ['id' => ':id']) }}'.replace(':id',
                assetId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Trash it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(deleteRoute, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if ('success' in data && data.success) {
                                    Swal.fire(
                                        'Trashed!',
                                        'The user has been trashed.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error',
                                        'Failed to trash the user.',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error',
                                    'An error occurred while trashing the user.',
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    </script>
@endsection
