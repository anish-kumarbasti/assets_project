@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        .card-item {
            height: 142px;
            width: 153px;
        }

        .icofontt {
            float: right;
        }

        .first-heading {
            color: #5C61F2;
            font-size: 30px;
            font-weight: 700;


            border-bottom: 1px solid #5555551A;
        }

        .heading-item {
            color: black;
        }

        .widget-joins .d-flex .flex-grow-1 {
            text-align: left !important;
        }

        .has-search .form-control {
            padding-left: 2.375rem;
        }

        .has-search .form-control-feedback {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            color: #aaa;
        }

        .left-header .input-group {
            padding: 12px 15px !important;
            border-radius: 10px;
            overflow: hidden;
            background-color: #f6f8fc;

        }

        .rounded-circle {
            position: relative;
            left: -43px;
        }

        .ican-item-1 {
            background: #4FAAD51A;
            height: 32px;
            width: 40px;
            padding: 8px;
            color: #4FAAD5 !important;
            border-radius: 6px;
            font-weight: 700;
            font-size: 19px;
        }

        .home-item {
            border-bottom: 3px solid #55555533;
        }

        .home-card-item {
            border-right: 3px solid #55555533;
        }

        .home-item-1 {
            border-top: 3px solid #55555533;

        }

        .number-item {
            color: #4FAAD5 !important;
            font-size: 20px;
        }

        input[readonly] {
            background-color: white !important;
        }

        textarea[readonly] {
            background-color: white !important;
        }

        .action-button {
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        .action-button:hover {
            background-color: #f0f0f0 !important;
            color: #333;
        }
    </style>
@endsection
@section('Content-Area')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="col-sm-12 text-end p-2">
                    {{-- @dd($id) --}}
                    {{-- <a class="btn btn-info" href="{{route('print-transfer',['id'=>session('id')])}}"><i class="fas fa-print"></i> Print</a> --}}
                </div>
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-md-4">
                            <div class="p-1">
                                <h5>Employee From</h5>
                                EMP ID:<input class="form-control mt-3" value="{{$transfer->employee_id??'N/A'}}" readonly>
                            </div>
                            <div class="p-1">
                                EMP Name:<input class="form-control mt-3" value="{{$find->first_name??'N/A'}} {{$find->last_name??'N/A'}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-1">
                                <h5>Approved By</h5>
                                Manager ID:<input class="form-control mt-3" value="{{$user->employee_id??'N/A'}}" readonly>
                            </div>
                            <div class="p-1">
                                Manager Name:
                                <input class="form-control mt-3" value="{{$user->first_name??'N/A'}} {{$user->last_name??'N/A'}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-1">
                                <h5>Handover ID</h5>
                                EMP ID:<input class="form-control mt-3" value="{{$transfer->handover_employee_id??'N/A'}}" readonly>
                            </div>
                            <div class="p-1">
                                EMP Name:<input class="form-control mt-3" value="{{$find2->first_name??'N/A'}} {{$find2->last_name??'N/A'}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-md-5">
                            <div class="p-2">
                            <h5>Transaction Code:</h5>
                            <input class="form-control mt-3" value="{{$transfer->transfers_transaction_code??'N/A'}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h5>Description:</h5>
                            <textarea readonly disabled cols="30" rows="3" autofocus class="form-control mt-3">{{$transfer->description??''}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card appointment-detail">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="setting-list">
                            <ul class="list-unstyled setting-option">
                                <li>
                                    <div class="setting-light"><i class="icon-layout-grid2"></i></div>
                                </li>
                                <li><i class="view-html fa fa-code font-white"></i></li>
                                <li><i class="icofont icofont-maximize full-card font-white"></i></li>
                                <li><i class="icofont icofont-minus minimize-card font-white"></i></li>
                                <li><i class="icofont icofont-refresh reload-card font-white"></i></li>
                                <li><i class="icofont icofont-error close-card font-white"> </i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                        <table class="table table-bordered">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Type</th>
                                <th>Asset</th>
                                <th>Product</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($productdata as $stock)
                                    <tr>
                                        <td>{{$stock->product_number??''}}</td>
                                        <td>{{$stock->asset_type->name??''}}</td>
                                        <td>{{$stock->assetmain->name??'N/A'}}</td>
                                        <td>{{$stock->configuration??''}}</td>
                                        <td>
                                            <button class="btn btn-success btn-block action-button"type="button" style="width: 100%;">Accepted</button>
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function setProductIdToReject(productId) {
            document.getElementById('productIdToReject').value = productId;
        }
    </script>
@endsection
