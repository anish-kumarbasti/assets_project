@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
   .text-p {
      font-size: 15px !important;
   }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('Backend/assets/css/vendors/datatables.css')}}">
@endsection
@section('Content-Area')

<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <h4>IT Assets</h4>
      </div>
      <div class="card-body">
         <div class="table-responsive theme-scrollbar">
            <table class="display" id="basic-1">
               <thead>
                  <tr>
                     <th>SL</th>
                     <th>Name</th>
                     <th>Asset Type</th>
                     <th>Asset</th>
                     <th>InStock</th>
                     <th>Allocated</th>
                     <th>Stolen</th>
                     <th>Lost</th>
                     <th>Scrapped</th>
                     <th>Under Repair</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>1</td>
                     <td>Dell Inspiron</td>
                     <td>IT Assets</td>
                     <td>Laptop</td>
                     <td>
                        <span class="badge rounded-pill badge-light-success">1,443</span>
                     </td>
                     <td>780</td>
                     <td>50</td>
                     <td>50</td>
                     <td>50 </td>
                     <td>50 </td>
                     <td>
                        <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">Edit</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection