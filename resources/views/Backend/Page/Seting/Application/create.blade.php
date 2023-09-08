@extends('Backend.Layouts.panel')

@section('Content-Area')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $businessSetting ? 'Update' : 'Add' }} Application Settings</h4>
                </div>
                {{-- @dd($businessSetting->id); --}}
                <div class="card-body">
                    <form method="POST" action="{{ $businessSetting ? route('settings.application.storeOrUpdate') : route('settings.application.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $businessSetting->id }}">
                        <div class="form-group">
                            <label for="name">Company Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter company name" value="{{ $businessSetting->name ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ $businessSetting->email ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="4" placeholder="Enter address">{{ $businessSetting->address ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control-file" id="logo" name="logo">
                            <small class="form-text text-muted">Upload a company logo (if needed).</small>
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
