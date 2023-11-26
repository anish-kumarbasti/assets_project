<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
</head>
<body>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-md-6">
                            <div class="p-1">
                                {{-- <h5>Employee From</h5> --}}
                                {{-- @dd($user) --}}
                                Asset Controller ID:<input class="form-control mt-3" value="{{$assetc->employee_id??'Other Department Controller issue Product'}}" readonly>
                            </div>
                            <div class="p-1">
                                Asset Controller Name:<input class="form-control mt-3" value="{{$assetc->first_name??'N/A'}} {{$assetc->last_name??'N/A'}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-1">
                                EMP Name:<input class="form-control mt-3" value="{{$user->employee_id??'N/A'}}" readonly>
                            </div>
                            <div class="p-1">
                                EMP Name:<input class="form-control mt-3" value="{{$user->first_name??'N/A'}} {{$user->last_name??'N/A'}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-md-5">
                            <h5>Transaction Code:</h5>
                            <input class="form-control mt-3" value="{{$issue->transaction_code??'N/A'}}" readonly>
                        </div>
                        <div class="col-md-7">
                            <h5>Description:</h5>
                            <textarea readonly disabled cols="30" rows="3" autofocus class="form-control mt-3">{{$issue->description??''}}</textarea>
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
                <div class="container">
                    @foreach ($stock as $data)
                        @if ($data->status_available == 15)
                            <div class="d-flex mb-3 p-2 mt-2">
                                <div style="height:25px;width:25px;border-radius:50%;background:#6520ff;color:white;">
                                    <div style="transform:translate(10px,2px);" class="fw-bold">
                                        {{ $loop->iteration }}</div>
                                </div>
                                <div><b class="text-dark mx-2">Product</b></div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar bg-primary" role="progressbar" style="width:50%">
                                    Issue Applied
                                </div>
                            </div>
                        @elseif ($data->status_available == 3)
                            <div class="d-flex mb-3 p-2 mt-2">
                                <div style="height:25px;width:25px;border-radius:50%;background:#6520ff;color:white;">
                                    <div style="transform:translate(10px,2px);" class="fw-bold">
                                        {{ $loop->iteration }}</div>
                                </div>
                                <div><b class="text-dark mx-2">Product</b></div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar bg-primary" role="progressbar" style="width:50%">
                                    Issue Applied
                                </div>
                                <div class="progress-bar progress-bar bg-success" role="progressbar" style="width:50%">
                                    Accepted by Employee
                                </div>
                            </div>
                        @else
                            <div class="d-flex mb-3 p-2 mt-2">
                                <div style="height:25px;width:25px;border-radius:50%;background:#6520ff;color:white;">
                                    <div style="transform:translate(10px,2px);" class="fw-bold">
                                        {{ $loop->iteration }}</div>
                                </div>
                                <div><b class="text-dark mx-2">Product</b></div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar bg-primary" role="progressbar" style="width:50%">
                                    Issue Applied
                                </div>
                                <div class="progress-bar progress-bar bg-danger" role="progressbar" style="width:50%">
                                    Failed
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                        <table class="table table-bordered">
                            <thead>
                                <th>Asset Code</th>
                                <th>Serial Number</th>
                                <th>Asset Type</th>
                                <th>Asset</th>
                                <th>Product</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($stock as $stock)
                                    <tr>
                                        <td>{{$stock->product_number??''}}</td>
                                        <td>{{$stock->serial_number??'N/A'}}</td>
                                        <td>{{$stock->asset_type->name??''}}</td>
                                        <td>{{$stock->assetmain->name??'N/A'}}</td>
                                        <td>{{$stock->configuration??''}}</td>
                                        <td>
                                            <a class="{{ $stock->statuses->status }} action-button"
                                                style="width: 100%;">{{ $stock->statuses->name }}</a>                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
    