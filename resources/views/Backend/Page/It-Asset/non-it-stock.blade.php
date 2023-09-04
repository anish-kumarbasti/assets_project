@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
   .btn-view {
      background: #BB4F00 !important;
      border: 2px solid #BB4F00 !important;
   }

   .qr_btn {
      border-radius: 10px;
      padding: 10px;
   }

   .stock-item {
      border: 3px solid #55555533 !important;
      margin-top: 17px;
      border-radius: 28px;
      background-color: #F5F6FE;
      position: relative;
      left: 20px;
   }

   .border-right {
      border-right: 3px solid #55555533;
   }
</style>
@endsection
@section('Content-Area')
<div class="col-sm-12">
   <div class="card">
      <div class="card-header pb-0">
         <div class="card">
            <div class="row ">
               <div class="col-md-9">
                  <h4>Non-IT Assets</h4>
               </div>
               <div class="col-md-3 text-end p-4">
                  <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/Vector1.svg') }}" alt='...'></button>
                  <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/veckor2.svg') }}" alt='...'></button>
                  <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/Vector3.svg') }}" alt='...'></button>

               </div>
            </div>
         </div>
      </div>
      <div class="card-body">
         <div class="table-responsive theme-scrollbar">
            <table class="display" id="basic-1">
               <thead>
                  <tr>
                     <th>SL</th>
                     <th>Code</th>
                     <th>Asset</th>
                     <th>Specification</th>
                     <th>Quantity</th>
                     <th>Allocated</th>
                     <th>Balanced</th>
                     <th>Allocation</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($matchingData as $nonit )
                  <tr>
                     <td>{{$nonit->id}}</td>
                     <td>a23</td>
                     <td>{{$nonit->product_info }}</td>
                     <td>{{$nonit->specification}}</td>
                     <td>
                        <span class="badge rounded-pill badge-light-success">{{$nonit->quantity}}</span>
                     </td>
                     <td>5</td>
                     <td>{{$nonit->price}}</td>
                     <td>
                        <a href="{{url('non-it-assets-timeline')}}" class="btn btn-primary btn-view" type="submit" data-bs-original-title="" title="">View</a>
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