@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            User Info
        </div>
        <div class="card-body">
            <form action="{{ route('users-update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-item border ">
                    <div class="row p-3">
                        <div class="col-md-6">
                            <label class="form-label" for="firstName">First Name</label>
                            <input class="form-control" id="firstName" value="{{$user->first_name}}" name="first_name" type="text" required="" placeholder="First Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="lastName">Last Name</label>
                            <input class="form-control" id="lastName" value="{{$user->last_name}}" name="last_name" type="text" required="" placeholder="Last Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control" id="email" value="{{$user->email}}" name="email" type="email" required="" placeholder="Email">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="mobileNumber">Mobile Number</label>
                            <input class="form-control" id="mobileNumber" value="{{$user->mobile_number}}" name="mobile_number" type="tel" required="" placeholder="Mobile Number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="Age">Age</label>
                            <input class="form-control" id="Age" value="{{$user->age}}" name="age" type="tel" required="" placeholder="Enter Age">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="gender">Gender</label>
                            <select class="form-select" id="gender" name="gender" aria-label="Default select example">
                                <option selected> Select Gender </option>

                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Others</option>



                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" id="password" value="{{$user->password}}" name="password" type="password" required="" placeholder="Password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="confirmPassword">Confirm Password</label>
                            <input class="form-control" id="confirmPassword" value="{{$user->confirm_password}}" name="confirm_password" type="password" required="" placeholder="Confirm Password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profilePhoto">Profile Photo</label>
                            <input class="form-control" id="profilePhoto" name="profile_photo" type="file" required="">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="coverPhoto">Cover Photo</label>
                            <input class="form-control" id="coverPhoto" name="cover_photo" type="file" required="">
                        </div>
                    </div>
                </div>
                <div class="card-item border ">
                    <div class="row p-3">
                        <div class="col-md-6">
                            <label class="form-label" for="department">Department</label>
                            <select class="form-select" id="department" name="department_id" aria-label="Default select example">
                                <option selected> Enter Department </option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="designation">Designation</label>
                            <select class="form-select" id="designation" name="designation_id" aria-label="Default select example">
                                <option selected> Enter Designation </option>
                                <!-- Add designations dynamically -->
                            </select>
                        </div>
                    </div>
                    <div class="footer-item mt-3 mb-3">
                        <button class="btn btn-primary mt-3" type="submit" data-bs-original-title="" title="">Add</button>
                        <button class="btn btn-warning mt-3" type="submit" data-bs-original-title="" title="">Cancel</button>
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
                        $.each(data, function(key, value) {
                            $('#designation').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
@endsection