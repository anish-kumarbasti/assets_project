@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>

 .img{
    width:100%;
    }

</style>
@endsection

@section('Content-Area')
<div class="col-sm-12">
<div class="row">
    @foreach ($users as $user )
    <div class="col-lg-4 col-md-6 box-col-33">
        <div class="card custom-card">
          <div class="card-header"><img class="img-fluid img" src="{{ asset($user->cover_photo) }}" style="width: 300px; height: 100px;" alt="Uploaded Image"></div>
          <div class="card-profile"><img class="rounded-circle" src="{{ asset($user->profile_photo) }}" alt=""></div>
          <div class="text-center profile-details"><a href="user-profile.html" data-bs-original-title="" title="">
              <h4>{{ $user->first_name }} {{ $user->last_name }}</h4></a>
            <h6>{{ $user->designation->designation }}</h6>
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




@endsection
