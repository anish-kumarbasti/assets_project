@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
  .icon {
    background: #5c61f2;
    color: white;
    padding: 15px;
    padding-left: 20px;
    padding-top: 8px;
    font-size: 22px;
    font-weight: bold;
  }
</style>
@endsection
@section('Content-Area')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header pb-0">
          <h4>TimeLine</h4>
        </div>
        <div class="card-body">
          @if ($product->isEmpty())
            <div class="row">
              <div class="col-sm-12">
                <div class="h3 text-center">
                  There is no Timeline for this Product.
                </div>
              </div>
            </div>
          @else
          <section class="cd-container" id="cd-timeline">
            @foreach ($product as $data)
            <div class="cd-timeline-block">
              <div class="cd-timeline-img cd-picture icon">{{$loop->iteration}}</div>
              <div class="cd-timeline-content">
                <h4>{{$loop->iteration}}.{{$data->action}}</h4>
                @if ($data->action == 'Product Created')
                <p class="m-0">Date & Time of Adding The Product in InStock</p> 
                @elseif ($data->action == 'Product Issued')
                <p class="m-0">Date & Time of Issuing The Product to the Employee</p> 
                <div class="cd-timeline-block">
                    <div class="bg-white p-2 pl-4">
                      @php
                      $user = App\Models\User::where('employee_id', $data['issuance']->employee_id)->first();
                      @endphp
                      @if($user)
                      <p style="font-size:15px;">Issued to this Employee :<a style="color:rgba(107, 107, 107, 0.564);">{{ $user->first_name }} {{$user->last_name}}</a></p>
                      <p>Mobile: <a style="color:rgba(107, 107, 107, 0.564);">{{ $user->mobile_number }}</a></p>
                      <p>E-mail: <a style="color:rgba(107, 107, 107, 0.564);">{{ $user->email }}</a></p>
                      @endif
                    </div>
                    <p>Date & Time of Allocating The Product to Employee</p><a style="color:rgba(107, 107, 107, 0.564);">{{ $data['issuance']->created_at->format('d/m/Y \a\t H:i A') }}</a>
                </div>
                @elseif ($data->action == 'Product Transferred')
                <p class="m-0">Date & Time of Transferring The Product by Employee to Employee</p> 
                <div class="cd-timeline-block">
                  <div class="bg-white p-2 pl-4">
                    @php
                    $user = App\Models\User::where('employee_id', $data['transfer']->handover_employee_id)->first();
                    @endphp
                    @if($user)
                    <p style="font-size:15px;">Transfer to this Employee :<a style="color:rgba(107, 107, 107, 0.564);">{{ $user->first_name }} {{$user->last_name}}</a></p>
                    <p>Mobile: <a style="color:rgba(107, 107, 107, 0.564);">{{ $user->mobile_number }}</a></p>
                    <p>E-mail: <a style="color:rgba(107, 107, 107, 0.564);">{{ $user->email }}</a></p>
                    @endif
                  </div>
                  <p>Date & Time of Transfering The Product to New Employee</p><a style="color:rgba(107, 107, 107, 0.564);">{{ $data['transfer']->created_at->format('d/m/Y \a\t H:i A') }}</a>
                </div>
                @elseif ($data->action == 'Product Maintenance')
                <p class="m-0">Date & Time of Start Maintenance The Product</p> 
                <div class="cd-timeline-block">
                  <div class="bg-white p-2 pl-4">
                    @php
                    $user = App\Models\Supplier::where('id', $data['maintenance']->supplier_id)->first();
                    @endphp
                    @if($user)
                    <p style="font-size:15px;">This Product is Under Maintenance by <a style="color:rgba(107, 107, 107, 0.564);">{{ $user->name }}</a></p>
                    <p>Mobile: <a style="color:rgba(107, 107, 107, 0.564);">{{ $user->phone }}</a></p>
                    <p>E-mail: <a style="color:rgba(107, 107, 107, 0.564);">{{ $user->email }}</a></p>
                    @endif
                  </div>
                  <p>Date & Time of Starting Maintenance of the Product</p><a style="color:rgba(107, 107, 107, 0.564);">{{ $data['maintenance']->created_at->format('d/m/Y \a\t H:i A') }}</a>
                </div>
                @endif
                <p>{{date('d-m-Y', strtotime($data->created_at))}}</p><span class="cd-date f-w-600">{{ $data->created_at->format('M d') }}</span>
              </div>
            </div>
            @endforeach
          </section>
          @endif
          {{-- <a href="{{url('gettimelinePDF',$data->id)}}" class="btn btn-primary text-white" style="text-align:center;width:20%;transform:translate(450px,10px);border-radius:20px;">Download</a> --}}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
