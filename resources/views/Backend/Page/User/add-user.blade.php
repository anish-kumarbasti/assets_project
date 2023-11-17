@extends('Backend.Layouts.panel')

@section('Style-Area')
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
                    {{-- <li class="text-muted"><a href="{{ url('department') }}" class="text-muted"></a></li> --}}
                    <li class="active"><a href="{{ url('users/create') }}">Add-Users</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Content-Area')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <h4>User Info</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-item border ">
                        <div class="row p-3">
                            <div class="col-md-6">
                                <label class="form-label" for="firstName">First Name</label>
                                <input class="form-control" id="firstName" name="first_name" type="text"
                                    placeholder="First Name" autocomplete="off">
                                @error('first_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="lastName">Last Name</label>
                                <input class="form-control" id="lastName" name="last_name" type="text"
                                    placeholder="Last Name" autocomplete="off">
                                @error('last_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" id="email" name="email" type="email"
                                    placeholder="Email" autocomplete="off">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="mobileNumber">Mobile Number</label>
                                <input class="form-control" id="mobileNumber" name="mobile_number" type="number"
                                    placeholder="Mobile Number" autocomplete="off">
                                @error('mobile_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="Age">Age</label>
                                <input class="form-control" autocomplete="off" id="Age" name="age" type="number"
                                    placeholder="Enter Age">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="gender">Gender</label>
                                <select class="form-select" id="gender" name="gender"
                                    aria-label="Default select example">
                                    <option selected> Select Gender</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Others</option>
                                </select>
                                @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control" id="password" name="password" type="password"
                                    placeholder="Password" autocomplete="new-password">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="confirmPassword">Confirm Password</label>
                                <input class="form-control" id="confirmPassword" name="confirm_password" type="password"
                                    placeholder="Confirm Password">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="exampleInputfile1">Profile Photo</label>
                                <input type="file" class="form-control" name="profile_photo" id="exampleInputFile"
                                    aria-describedby="fileHelp" placeholder="Enter file">
                                <small id="fileHelp" class="form-text text-muted"></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="exampleInputfile1">Cover Photo</label>
                                <input type="file" class="form-control" name="cover_photo" id="exampleInputFile"
                                    aria-describedby="fileHelp" placeholder="Enter file">
                                <small id="fileHelp" class="form-text text-muted"></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="exampleInputfile1">Employee ID</label>
                                <input type="text" class="form-control" name="employee_id" id="exampleInputFile"
                                    aria-describedby="fileHelp" placeholder="Enter Employee ID">
                                @error('employee_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="department">Department</label>
                                <select class="form-select" id="department" name="department_id"
                                    aria-label="Default select example">
                                    <option selected> Enter Department </option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="designation">Designation</label>
                                <select class="form-select" id="designation" name="designation_id"
                                    aria-label="Default select example">
                                    <option selected> Enter Designation </option>
                                </select>
                                @error('designation_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="location">Location</label>
                                <select class="form-select" id="location" name="location_id"
                                    aria-label="Default select example">
                                    <option selected> Enter Location </option>
                                    @foreach ($location as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="sublocation">Sub Location</label>
                                <select class="form-select" id="sublocation" name="sub_location_id"
                                    aria-label="Default select example">
                                    <option selected> Select Sublocation </option>
                                </select>
                                @error('sublocation_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="department">Role</label>
                                <select name="role" id="role" class="form-select"
                                    aria-label="Default select example">
                                    <option selected>--Select Role--</option>
                                    @foreach ($role as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="footer-item mt-3 mb-3 float-end">
                                <button class="btn btn-primary mt-3" type="submit" data-bs-original-title=""
                                    title="">Add</button>
                                <a href="{{ route('users.index') }}" class="btn btn-warning mt-3"
                                    data-bs-original-title="">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('Script-Area')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#department").change(function() {
                var departmentId = $(this).val();
                if (departmentId) {
                    $.ajax({
                        url: '/get-designations/' + departmentId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#designation').empty();
                            $('#designation').append('<option value="">Select Designation</option>');
                            $.each(data, function(key, value) {
                                $('#designation').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                }
            });
            $("#location").change(function() {
                var locationId = $(this).val();
                if (locationId) {
                    $.ajax({
                        url: '/get-locations/' + locationId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#sublocation').empty();
                            $('#sublocation').append('<option value="">Select sublocation</option>');
                            $.each(data, function(key, value) {
                                $('#sublocation').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
