@extends('Backend.Layouts.panel')

@section('Content-Area')
<div class="card-body">
    <div class="col-sm-12 col-xl-6">
        <div class="card">
            <div class="card-header pb-0">
                <h4>User Settings</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="settings-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="password-tab" data-bs-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="true">
                            <i class="icofont icofont-ui-home"></i>Change Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                            <i class="icofont icofont-man-in-glasses"></i>Profile Photo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="cover-tab" data-bs-toggle="tab" href="#cover" role="tab" aria-controls="cover" aria-selected="false">
                            <i class="icofont icofont-contacts"></i>Cover Photo
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="settings-tabContent">
                    <!-- Change Password Tab -->
                    <div class="tab-pane fade show active" id="password" role="tabpanel" aria-labelledby="password-tab">
                        <form method="POST" action="">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password:</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" required>
                                @if ($errors->any('current_password'))
                                <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password:</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required>
                                @if ($errors->any('new_password'))
                                <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password:</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                                @if ($errors->any('confirm_password'))
                                <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                    <!-- Profile Photo Tab -->
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="photo" class="form-label">Profile Photo:</label>
                                <input type="file" id="photo" name="photo"  value="{{ $user->profile_photo }}" class="form-control" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Profile Photo</button>
                        </form>
                    </div>
                    <!-- Cover Photo Tab -->
                    <div class="tab-pane fade" id="cover" role="tabpanel" aria-labelledby="cover-tab">
                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="cover_photo" class="form-label">Cover Photo:</label>
                                <input type="file" id="cover_photo" name="cover_photo"  value="{{ $user->profile_photo }}" class="form-control" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Cover Photo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
