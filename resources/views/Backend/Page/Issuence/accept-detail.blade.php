@extends('Backend.Layouts.panel')

@section('Style-Area')
@endsection

@section('Content-Area')
<div class="col-sm-12">
    <div class="card custom-card user-card">
       <div class="text-center profile-details">
          <h4>Product Name : {{$data->product_info}}</h4>
          <h6>Configuration : {{$data->configuration}}</h6>
       </div>
       <ul class="list-group">
           <li class="list-group-item">Type : {{$data->asset_type->name??'N/A'}}</li>
           <li class="list-group-item">Asset : {{$data->assetmain->name??'N/A'}}</li>
           <li class="list-group-item">Brand : {{$data->brand->name??'N/A'}}</li>
           <li class="list-group-item">Model : {{$data->brandmodel->name??'N/A'}}</li>
          <li class="list-group-item">Supplier : {{$data->getsupplier->name??'N/A'}}</li>
       </ul>
       </div>
    </div>
 </div>
 </div>
@endsection

@section('Script-Area')
@endsection