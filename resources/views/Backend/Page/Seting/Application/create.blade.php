@extends('Backend.Layouts.panel')
@section('Content-Area')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Application Setting</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.application.storeOrUpdate') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Company Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter company name">
                        </div>
                        <input type="hidden" name="id" value="{{ $businessSetting->id ?? '' }}"/>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="4" placeholder="Enter address"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control-file" id="logo" name="logo">
                            <small class="form-text text-muted">Upload a company logo (if needed).</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection