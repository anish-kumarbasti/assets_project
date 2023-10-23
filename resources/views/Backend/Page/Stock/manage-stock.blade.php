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
         <h4>Stock Inventory</h4>
      </div>
      <div class="card-body">
         <div class="table-responsive theme-scrollbar">
            <table class="table table-bordered table-striped" id="basic-1">
               <thead>
                  <tr>
                     <th>SL</th>
                     <th>Asset Code</th>
                     <th>Serial Number</th>
                     <th>Product Name</th>
                     <th>Asset Type</th>
                     <th>Asset</th>
                     <th>In Stock</th>
                     <th>Allocated</th>
                     <th>Scrapped</th>
                     <th>Under Repair</th>
                     <th>Stolen</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($groupedStocks as $stock)
                  <tr>
                     <td>{{ $loop->iteration??''}}</td>
                     <td>{{$stock['product_number']}}</td>
                     <td>{{$stock['serial_number']?? 'N/A'}}</td>
                     <td>{{ $stock['product_info']??''}}</td>
                     <td>{{ $stock['asset_type']??''}}</td>
                     <td>{{ $stock['assetmain']??''}}</td>
                     <td class="text-center">
                        <span class="badge rounded-pill badge-light-success">{{$stock['instocks']}}</span>
                     </td>
                     <td class="text-center">
                        <span class="badge rounded-pill badge-light-secondary">{{$stock['allottedCount']}}</span>
                     </td>
                     <td class="text-center">
                        <span class="badge rounded-pill badge-light-danger">{{$stock['scrappedCount'] }}</span>
                     </td>
                     <td class="text-center">
                        <span class="badge rounded-pill badge-light-warning">{{$stock['underRepairCount'] }}</span>
                     </td>
                     <td class="text-center">
                        <span class="badge rounded-pill badge-light-primary">{{$stock['stolen']}}</span>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection
