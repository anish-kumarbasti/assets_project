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
                    <div class="col-md-6">
                        <h4>Assets Software</h4>
                    </div>
                    <div class="col-md-6 text-end p-4">
                        <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/Vector1.svg') }}" alt='...'></button>
                        <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/Vector3.svg') }}" alt='...'></button>
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
                            <td>a23</td>
                            <td>{{$software->name}}</td>
                            <td>xxxx xxxx xxxx</td>
                            <td>
                                <span class="badge rounded-pill badge-light-success">{{$software->quantity}}</span>
                            </td>
                            <td>15 </td>
                            <td>{{$software->price}}</td>
                            <td>
                                <a href="{{url('assets-software-timeline')}}" class="btn btn-primary" type="submit" data-bs-original-title="" title="">View</a>
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