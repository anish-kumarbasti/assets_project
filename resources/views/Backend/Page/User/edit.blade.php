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
            <form action="{{url('users',$user->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($user)
                @method('PUT')
                @endisset
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
                                <option value="1" {{$user->gender==1 ? 'checked':''}}>Male</option>
                                <option value="2" {{$user->gender == 2 ? 'checked':''}}>Female</option>
                                <option value="3" {{$user->gender == 3 ? 'checked':''}}>Others</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="gender">Role</label>
                            <select class="form-select" id="role" name="role" aria-label="Default select example">
                                <option>Select Role</option>
                                @foreach ($role as $role)
                                <option value="{{$role->id}}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profilePhoto">Profile Photo</label>
                            <input class="form-control" id="profilePhoto" name="profile_photo" type="file">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="coverPhoto">Cover Photo</label>
                            <input class="form-control" id="coverPhoto" name="cover_photo" type="file">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="department">Department</label>
                            <select class="form-select" id="department" name="department_id" aria-label="Default select example">
                                @foreach ($department as $depart )
                                <option value="{{$depart->id}}" {{ $user->department_id == $depart->id ? 'selected' : '' }}>{{$depart->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="designation">Designation</label>
                            <select class="form-select" id="designation" name="designation_id" aria-label="Default select example">
                                @foreach ($designation as $designations)
                                <option value="{{$designations->id}}" {{$user->designation_id == $designations->id ? 'selected':''}}>{{$designations->designation}} </option>
                                @endforeach
                                <!-- Add designations dynamically -->
                            </select>
                        </div>
                    </div>
                    <div class="footer-item mt-3 mb-3">
                        <button class="btn btn-primary mt-3" type="submit" data-bs-original-title="" title="">Update</button>
                        <a class="btn btn-warning mt-3" href="{{url('users')}}" data-bs-original-title="" title="">Cancel</a>
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
