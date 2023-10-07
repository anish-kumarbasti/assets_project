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
            <div class="card">
                <div class="row ">
                    <div class="col-md-6 p-4">
                        <h4>Assets Software</h4>
                    </div>
                    <div class="col-md-6 text-end p-4">
                        <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/veckor2.svg') }}" alt='...'></button>

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
                            <th>Product Key</th>
                            <th>Quantity</th>
                            <th>Allocated</th>
                            <th>Balance</th>
                            <th>Allocation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($softwareData as $software)
                        <tr>
                            <td>{{$software->id}}</td>
                            <td>{{$software->product_number??''}}</td>
                            <td>{{$software->product_info??''}}</td>
                            <td>{{$software->serial_number??''}}</td>
                            <td>
                                <span class="badge rounded-pill badge-light-success">{{$software->quantity??''}}</span>
                            </td>
                            <td>15 </td>
                            <td>{{$software->price??''}}</td>
                            <td>
                                <form action="{{url('timeline',$software->id)}}" method="post">
                                    @csrf
                                    <button class="btn btn-primary btn-view" type="submit" data-bs-original-title="" title="">View</button>
                                </form>
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