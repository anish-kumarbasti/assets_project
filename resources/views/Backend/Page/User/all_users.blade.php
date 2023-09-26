@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
    .img {
        width: 100%;
    }

    .square-image {
        width: 100px;
        /* You can adjust this value to your desired square size */
        height: 100px;
        /* Keep the same value as width to maintain a square aspect ratio */
    }

    .custom-btn {
        font-size: 12px;
        padding: 5px 10px;
        line-height: 1.5;
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
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="float-end" role="group" aria-label="Toggle View">
                <a id="toggleListView" class="fw-bold link" href="#"><i class="fa fa-list-alt"></i> View List</a>
                <a id="toggleCardView" class="fw-bold link" href="#"><i class="fa fa-user"></i>View Card</a>
            </div>
        </div>
    </div>
    <div class="row" id="userList" style="display: none;">
        <div class="col-md-12">
            <table class="display" id="basic-1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Profile Photo</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <img src="{{ asset($user->profile_photo) }}" alt="Profile Photo" style="width: 100px; height: 50px;">
                        </td>
                        <td>{{$user->department->name??''}}</td>
                        <td> {{ $user->designation->designation??'' }} </td>
                        <td>
                            <div class="d-flex justify-content-between align-item-center">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary custom-btn"><i class="fa fa-pencil"></i> Edit</a>
                                <button class="btn btn-danger custom-btn delete-button" type="button" data-id="{{ $user->id }}"><i class="fa fa-trash-o"></i> Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    <div class="row" id="userCard">
        @foreach ($users as $user)
        <div class="col-lg-4 col-md-6 box-col-33">
            <div class="card custom-card">
                <!-- ... Card view content ... -->
                <div class="card-header"><img class="img-fluid img" src="{{ asset($user->cover_photo) }}" style="width: 300px; height: 100px;" alt="Uploaded Image"></div>
                <div class="card-profile"><img class="rounded-circle square-image" src="{{ asset($user->profile_photo) }}" alt=""></div>
                <div class="text-center profile-details"><a href="{{ route('users.user-profile', $user->id) }}" data-bs-original-title="" title="">

                        <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                    </a>
                    <h6>{{ $user->designation->designation??'' }}</h6>

                </div>
                <ul class="card-social">
                    <button class="btn btn-light ican-envo"><i class="fa fa-envelope" aria-hidden="true"></i></button>
                    <button class="btn btn-light ican-envo"><i class="fa fa-phone" aria-hidden="true"></i></button>
                    <button class="btn btn-light ican-action">Active</button>
                </ul>
                <div class="card-footer row">
                    <div class="col-4 col-sm-4">
                        <p class="text-it">IT Asset</p>
                        <h3 class="counter">09</h3>
                    </div>
                    <div class="col-4 col-sm-4">
                        <p class="text-it">Non IT Asset</p>
                        <h3><span class="counter">09</span></h3>
                    </div>
                    <div class="col-4 col-sm-4">
                        <p class="text-it">Software</p>
                        <h3><span class="counter">09</span></h3>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
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
    $(document).ready(function() {
        $('#toggleCardView').hide();
        $('#toggleListView').click(function() {
            $('#userCard').hide();
            $('#userList').show();
            $('#toggleCardView').show();
            $(this).hide();
        });

        $('#toggleCardView').click(function() {
            $('#userList').hide();
            $('#userCard').show();
            $('#toggleListView').show();
            $(this).hide();
        });
    });
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