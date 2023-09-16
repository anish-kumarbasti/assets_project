@extends('Backend.Layouts.panel')

@section('Style-Area')
<style>
   .custom-btn {
      font-size: 11px;
      padding: 5px 10px;
      line-height: 1.5;
      pointer-events: none;
   }
</style>
@endsection

@section('Content-Area')
@if (session('success'))
<div id="stocks" class="alert alert-success inverse alert-dismissible fade show" role="alert"><i class="icon-thumb-up alert-center"></i>
   <p><b> Well done! </b>{{session('success')}}</p>
   <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <h4>IT Assets</h4>
         <hr>
      </div>
      <div class="card">
         <div class="card-body">
            <div class="table-responsive theme-scrollbar">
               <table class="display" id="basic-1">
                  <thead>
                     <tr class="text-center">
                        <th>SL</th>
                        <th>Product</th>
                        <th>Asset Type</th>
                        <th>Asset</th>
                        <th>Brand</th>
                        <th>Brand Model</th>
                        <th>Configuration</th>
                        <th>Serial Number</th>
                        <th>Supplier</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Active/Inactive</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($stock as $stock)
                     <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$stock->product_info}}</td>
                        <td>{{$stock->asset_type->name??''}}</td>
                        {{-- @dd($stock->assetmain); --}}
                        <td>{{$stock->assetmain->name??''}}</td>
                        <td>{{$stock->brand->name??''}}</td>
                        <td>{{$stock->brandmodel->name??''}}</td>
                        <td>{{$stock->configuration}} </td>
                        <td>{{$stock->serial_number}} </td>
                        <td>{{$stock->getsupplier->name??''}} </td>
                        <td>{{$stock->price??''}} </td>
                        <td>
                           <img src="{{ asset('images/' . $stock->image) }}" alt="Stock Image">
                        </td>

                        <td class="w-20">
                           <label class="mb-0 switch">
                              <input type="checkbox" data-id="{{$stock->id}}" {{ $stock->status ? 'checked' : '' }}><span class="switch-state"></span>
                           </label>
                        </td>
                        <td> <span class=" custom-btn {{$stock->statuses->status ??''}}">{{$stock->statuses->name??''}}</span></td>
                        <td>
                           <a class="btn btn-primary" href="{{ url('/edit-stock/' . $stock->id) }}">Edit</a>
                        <td>
                           <form action="{{ route('delete.stock', $stock->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this stock item?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">Delete</button>
                           </form>
                        </td>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('Script-Area')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
      var stocks = $('#stocks');
      setTimeout(function() {
         stocks.alert('close');
      }, 3000);
   });
</script>
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
