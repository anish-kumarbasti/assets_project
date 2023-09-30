@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
   .text-p {
      font-size: 15px !important;
   }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('Backend/assets/css/vendors/datatables.css')}}">
</head>
@endsection

@section('Content-Area')
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <h4>Manage Stock</h4>
      </div>
      <div class="card-body">
         <div class="table-responsive theme-scrollbar">
            <table class="table table-bordered table-striped" id="basic-1">
               <thead>
                  <tr>
                     <th>SL</th>
                     <th>Name</th>
                     <th>Asset Type</th>
                     <th>Asset</th>
                     <th>In Stock</th>
                     <th>Allocated</th>
                     <th>Stolen</th>
                     <th>Lost</th>
                     <th>Scrapped</th>
                     <th>Under Repair</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($groupedStocks as $stock)
                  <tr>
                     <td>{{ $loop->iteration??''}}</td>
                     <td>{{ $stock->product_info??''}}</td>
                     <td>{{ $stock->asset_type->name??''}}</td>
                     <td>{{ $stock->assetmain->name??''}}</td>
                     <td class="text-center">
                        <span class="badge rounded-pill badge-light-success">{{ $stock->count??''}}</span>
                     </td>
                     <td>{{ $stock->allocated??''}}</td>
                     <td>{{ $stock->stolen??''}}</td>
                     <td>{{ $stock->lost??''}}</td>
                     <td>{{ $stock->scrapped??''}}</td>
                     <td>{{ $stock->under_repair??''}}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection