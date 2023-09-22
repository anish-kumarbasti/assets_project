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
         <h4>IT Assets</h4>
         <p>Total Records: {{ $stockCount }}</p>
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
                    <th>In Stock: {{ $statusCounts['in_stock'] }}</th>
                    <th>Allocated: {{ $statusCounts['allocated'] }}</th>
                    <th>Stolen: {{ $statusCounts['stolen'] }}</th>
                    <th>Lost: {{ $statusCounts['lost'] }}</th>
                    <th>Scrapped: {{ $statusCounts['scrapped'] }}</th>
                    <th>Under Repair: {{ $statusCounts['under_repair'] }}</th>
                    <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($stocks as $stock)
                  <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>{{ $stock->name }}</td>
                     <td>{{ $stock->asset_type }}</td>
                     <td>{{ $stock->asset }}</td>
                     <td>{{ $stock->in_stock }}</td>
                     <td>{{ $stock->allocated}}</td>
                     <td>{{ $stock->stolen }}</td>
                     <td>{{ $stock->lost }}</td>
                     <td>{{ $stock->scrapped }}</td>
                     <td>{{ $stock->under_repair }}</td>
                     <td>
                        <a href="#" class="btn btn-primary" data-bs-original-title="" title=""><i class="fas fa-edit"></i> Edit</a>
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
