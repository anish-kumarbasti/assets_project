@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
   .text-p {
      font-size: 15px !important;
   }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('Backend/assets/css/vendors/datatables.css')}}">
</head>
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
                   <li class="text-muted">Stock</li>
                   {{-- <li class="text-muted"><a href="{{ url('department') }}" class="text-muted">Department</a></li> --}}
                   <li class="active"><a href="{{ url('manage-stocks') }}">Stocks Inventory</a></li>
               </ol>
           </div>
       </div>
   </div>
</div>
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
