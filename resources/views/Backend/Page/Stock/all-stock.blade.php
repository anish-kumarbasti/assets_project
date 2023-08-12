@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
.text-p{
   font-size:15px !important;
}
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('Backend/assets/css/vendors/datatables.css')}}">
@endsection
@section('Content-Area')

<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
        <h4>IT Assets</h4>
        <span class="py-2 mt-3 pt-3 text-p">The Searching Functionality Provided By DataTables Is Useful For Quickly Search Through The Information In The Table - However The Search Is
Global, And You May Wish To Present Controls That Search On Specific Columns.</span>
      </div>
      <div class="card-body">
         <div class="table-responsive theme-scrollbar">
            <table class="display" id="basic-1">
               <thead>
                  <tr>
                     <th>SL</th>
                     <th>ID</th>
                     <th>Product</th>

                     <th>Asset Type</th>
                     <th>Asset</th>
                      <th>Brand</th>
                     <th>Brand Model</th>
                     <th>Location</th>
                     
                     <th>Sub Location</th>
                    
                     
                     <th>Configuration</th>
                      <th>Serial Number</th>
                      <th>Vendor</th>
                      <th>Price</th>
                      <th>Status</th>

                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                @foreach ($stock as $stock)
                  <tr>
                     <td>{{$loop->iteration}}</td>
                     <td>{{$stock->id}}</td>
                     <td>{{$stock->product_info}}</td>
                     <td>{{$stock->asset_type->name}}</td>
                     {{-- @dd($stock->assetmain); --}}
                       <td>{{$stock->assetmain->name}}</td>
                         <td>{{$stock->brand->name}}</td>
                           <td>780</td>
                        <td>{{$stock->location->name}}</td>
                        
                         <td>50</td>
                           <td>{{$stock->configuration}} </td>
                           <td>{{$stock->serial_number}} </td>
                           <td>{{$stock->vendor}} </td>
                           <td>{{$stock->price}} </td>
                           <td class="w-20">
                            <label class="mb-0 switch">
                            <input type="checkbox" data-id="{{$stock->id}}" {{ $stock->status ? 'checked' : '' }}><span class="switch-state"></span>
                            </label>
                        </td>
                           <td>
                        <button class="btn btn-primary" type="submit" data-bs-original-title=""
                           title="">Edit</button>
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
@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

       $('input[type="checkbox"]').on('change', function() {
          const stockId = $(this).data('id');
          const status = $(this).prop('checked');
          const csrfToken = $('meta[name="csrf-token"]').attr('content');

          $.ajax({
             url: `/stock-status/${stockId}`,
             type: 'PUT',
             data: {
                status: status
             },
             headers: {
                'X-CSRF-TOKEN': csrfToken
             },
             success: function(response) {
                console.log('Status updated successfully');
             },
             error: function(error) {
                console.error('Error:', error);
             }
          });
       });
    });
 </script>
@endsection