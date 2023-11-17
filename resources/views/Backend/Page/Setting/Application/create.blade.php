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
                    <li class="text-muted">Business Setting</li>
                    {{-- <li class="text-muted"><a href="{{ url('department') }}" class="text-muted">Department</a></li> --}}
                    <li class="active"><a href="{{ url('application-setting ') }}">General Settings</a></li>
                </ol>
            </div>
        </div>
    </div>
 </div>
 @endsection
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