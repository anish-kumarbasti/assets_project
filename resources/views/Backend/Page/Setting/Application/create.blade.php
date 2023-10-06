@extends('Backend.Layouts.panel')

@section('Content-Area')
@if (session('success'))
<div id="pop" class="alert alert-success inverse alert-dismissible show" role="alert"><i class="icon-thumb-up alert-center"></i>
    <p><b> Well done! </b>{{ session('success') }}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $businessSetting ? 'Update' : 'Add' }} General Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.application.storeOrUpdate') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" value="{{ $businessSetting ? $businessSetting->id : '' }}">
                        <div class="form-group">
                            <label for="name">Company Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter company name" value="{{ $businessSetting->name ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ $businessSetting->email ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" required id="address" name="address" rows="4" placeholder="Enter address">{{ $businessSetting->address ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" required>
                            <small class="form-text text-muted">Upload a company logo.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ $businessSetting ? 'Update' : 'Add' }}</button>
                        <a href="" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Script-Area')
<script>
    $(document).ready(function() {
        var alerts = $('#pop');
        setTimeout(function() {
            alerts.alert('close');
        }, 3000);
    });
</script>
@endsection