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
@endsection

@section('Content-Area')
@if (session('success'))
<div id="pop" class="alert alert-success inverse alert-dismissible show" role="alert"><i class="icon-thumb-up alert-center"></i>
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
            <div class="col-sm-6"></div>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile Photo</th>
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <img src="{{ asset($user->profile_photo) }}" alt="Profile Photo" style="width: 100px; height: 50px;">
                            </td>
                            <td><a href="{{ route('users.user-profile', $user->id) }}">{{ $user->first_name }} {{ $user->last_name }} </a></td>
                            <td>{{$user->employee_id}}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{$user->department->name??''}}</td>
                            <td> {{ $user->designation->designation??'' }} </td>
                            <td>
                                <div class="d-flex justify-content-between align-item-center">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary custom-btn"><i class="fa fa-pencil"></i>&nbsp;Edit</a>&nbsp;
                                    <button class="btn btn-danger custom-btn delete-button" type="button" data-id="{{ $user->id }}"><i class="fa fa-trash-o"></i>&nbsp;Delete</button>
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
            const deleteRoute = '{{ route("users.destroy", ["id" => ":id"]) }}'.replace(':id', assetId);

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
                                    'Deleted!',
                                    'The user has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    'Failed to delete the user.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error',
                                'An error occurred while deleting the user.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>

@endsection