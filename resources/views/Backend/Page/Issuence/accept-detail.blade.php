@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
<div class="col-sm-4">
    <div class="card custom-card user-card">
       <div class="text-center profile-details">
          <h4>{{$data->product_info}}</h4>
          <h6>{{$data->configuration}}</h6>
       </div>
       <ul class="card-social">
          <button class="btn btn-light ican-envo">
          <i class="fa fa-envelope" aria-hidden="true"></i>
          </button>
          <button class="btn btn-light ican-envo">
          <i class="fa fa-phone" aria-hidden="true"></i>
          </button>
          <button class="btn btn-light ican-action">Active</button>
       </ul>
       </div>
    </div>
 </div>
 </div>
@endsection

@section('Script-Area')
@endsection