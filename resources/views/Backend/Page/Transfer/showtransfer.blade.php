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

        .card-stepper {
            z-index: 0
        }

        #progressbar-2 {
            color: #455A64;
        }

        #progressbar-2 li {
            list-style-type: none;
            font-size: 13px;
            width: 33.33%;
            float: left;
            position: relative;
        }

        #progressbar-2 #step1:before {
            content: '\f058';
            font-family: "Font Awesome 5 Free";
            color: #fff;
            width: 37px;
            margin-left: 0px;
            padding-left: 0px;
        }

        #progressbar-2 #step2:before {
            content: '\f058';
            font-family: "Font Awesome 5 Free";
            color: #fff;
            width: 37px;
        }

        #progressbar-2 #step3:before {
            content: '\f058';
            font-family: "Font Awesome 5 Free";
            color: #fff;
            width: 37px;
            margin-right: 0;
            text-align: center;
        }

        #progressbar-2 #step4:before {
            content: '\f111';
            font-family: "Font Awesome 5 Free";
            color: #fff;
            width: 37px;
            margin-right: 0;
            text-align: center;
        }

        #progressbar-2 li:before {
            line-height: 37px;
            display: block;
            font-size: 12px;
            background: #c5cae9;
            border-radius: 50%;
        }

        #progressbar-2 li:after {
            content: '';
            width: 100%;
            height: 10px;
            background: #c5cae9;
            position: absolute;
            left: 0%;
            right: 0%;
            top: 15px;
            z-index: -1;
        }

        #progressbar-2 li:nth-child(1):after {
            left: 1%;
            width: 100%
        }

        #progressbar-2 li:nth-child(2):after {
            left: 1%;
            width: 100%;
        }

        #progressbar-2 li:nth-child(3):after {
            left: 1%;
            width: 100%;
            /* background: #c5cae9 !important; */
        }

        #progressbar-2 li:nth-child(4) {
            left: 0;
            width: 37px;
        }

        #progressbar-2 li:nth-child(4):after {
            left: 0;
            width: 0;
        }

        #progressbar-2 li.active:before,
        #progressbar-2 li.active:after {
            background: #6520ff;
        }
    </style>
@endsection
@section('Content-Area')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-md-4">
                            <div class="p-1">
                                <h5>Employee From</h5>
                                EMP ID:<input class="form-control mt-3" value="{{ $transfer->employee_id ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="p-1">
                                EMP Name:<input class="form-control mt-3"
                                    value="{{ $find->first_name ?? 'N/A' }} {{ $find->last_name ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-1">
                                <h5>Approved By</h5>
                                Manager ID:<input class="form-control mt-3" value="{{ $user->employee_id ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="p-1">
                                Manager Name:
                                <input class="form-control mt-3"
                                    value="{{ $user->first_name ?? 'N/A' }} {{ $user->last_name ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-1">
                                <h5>Handover ID</h5>
                                EMP ID:<input class="form-control mt-3"
                                    value="{{ $transfer->handover_employee_id ?? 'N/A' }}" readonly>
                            </div>
                            <div class="p-1">
                                EMP Name:<input class="form-control mt-3"
                                    value="{{ $find2->first_name ?? 'N/A' }} {{ $find2->last_name ?? 'N/A' }}" readonly>
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
                                <input class="form-control mt-3"
                                    value="{{ $transfer->transfers_transaction_code ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h5>Description:</h5>
                            <textarea readonly disabled cols="30" rows="3" autofocus class="form-control mt-3">{{ $transfer->description ?? '' }}</textarea>
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
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12">
                            <div class="card card-stepper text-black" style="border-radius: 16px;">
                                <div class="card-body p-5">
                                    @foreach ($productdata as $data)
                                        <div class="d-flex mb-5 p-2 mt-3">
                                            <div
                                                style="height:25px;width:25px;border-radius:50%;background:#6520ff;color:white;">
                                                <div style="transform:translate(10px,2px);" class="fw-bold">
                                                    {{ $loop->iteration }}</div>
                                            </div>
                                            <div><b class="text-dark mx-2">Product</b></div>
                                        </div>
                                        @if ($data->status_available == 16)
                                            <ul id="progressbar-2"
                                                class="d-flex justify-content-between mx-0 mt-0 mb-5 px-0 pt-0 pb-2">
                                                <li class="step0 active text-center" id="step1"></li>
                                                <li class="step0 active text-center" id="step2"></li>
                                                <li class="step0 active text-center" id="step3"></li>
                                                <li class="step0 text-muted text-end" id="step4"></li>
                                            </ul>
                                        @elseif ($data->status_available == 8)
                                            <ul id="progressbar-2"
                                                class="d-flex justify-content-between mx-0 mt-0 mb-5 px-0 pt-0 pb-2">
                                                <li class="step0 active text-center" id="step1"></li>
                                                <li class="step0 active text-center" id="step2"></li>
                                                <li class="step0 text-muted text-end" id="step3"></li>
                                                <li class="step0 text-muted text-end" id="step4"></li>
                                            </ul>
                                        @elseif ($data->status_available == 17)
                                            <ul id="progressbar-2"
                                                class="d-flex justify-content-between mx-0 mt-0 mb-5 px-0 pt-0 pb-2">
                                                <li class="step0 active text-center" id="step1"></li>
                                                <li class="step0 active text-center" id="step2"></li>
                                                <li class="step0 active text-center" id="step3"></li>
                                                <li class="step0 text-muted text-end" id="step4"></li>
                                            </ul>
                                        @elseif ($data->status_available == 5)
                                            <ul id="progressbar-2"
                                                class="d-flex justify-content-between mx-0 mt-0 mb-5 px-0 pt-0 pb-2">
                                                <li class="step0 active text-center" id="step1"></li>
                                                <li class="step0 active text-center" id="step2"></li>
                                                <li class="step0 active text-center" id="step3"></li>
                                                <li class="step0 active text-center" id="step4"></li>
                                            </ul>
                                        @endif
                                        <div class="d-flex justify-content-between">
                                            @if ($data->status_available == 16)
                                                <div class="d-lg-flex align-items-center">
                                                    <i class="fas fa-clipboard-list fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                                                    <div>
                                                        <p class="fw-bold mb-1">Transfer</p>
                                                        <p class="fw-bold mb-0">Applied</p>
                                                    </div>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    <i class="fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    <i class="me-lg-4 mb-3 mb-lg-0"></i>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    <i class="me-lg-4 mb-3 mb-lg-0"></i>
                                                </div>
                                            @elseif ($data->status_available == 8)
                                                <div class="d-lg-flex align-items-center">
                                                    {{-- <i class="fas fa-clipboard-list fa-3x me-lg-4 mb-3 mb-lg-0"></i> --}}
                                                    <div>
                                                        <p class="fw-bold mb-1">Transfer</p>
                                                        <p class="fw-bold mb-0">Applied</p>
                                                    </div>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    {{-- <i class="fas fa-box-open fa-3x me-lg-4 mb-3 mb-lg-0"></i> --}}
                                                    <div>
                                                        <p class="fw-bold mb-1">Approved</p>
                                                        <p class="fw-bold mb-0">by Manager</p>
                                                    </div>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    {{-- <i class="fa-3x me-lg-4 mb-3 mb-lg-0"></i> --}}
                                                    <div></div>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    {{-- <i class="me-lg-4 mb-3 mb-lg-0"></i> --}}
                                                    <div></div>
                                                </div>
                                            @elseif ($data->status_available == 17)
                                                <div class="d-lg-flex align-items-center">
                                                    <div>
                                                        <p class="fw-bold mb-1">Transfer</p>
                                                        <p class="fw-bold mb-0">Applied</p>
                                                    </div>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    <div>
                                                        <p class="fw-bold mb-1">Transfer</p>
                                                        <p class="fw-bold mb-0">by Manager</p>
                                                    </div>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    <div>
                                                        <p class="fw-bold mb-1">Transfer by</p>
                                                        <p class="fw-bold mb-0">Controller</p>
                                                    </div>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                </div>
                                            @elseif ($data->status_available == 5)
                                                <div class="d-lg-flex align-items-center">
                                                    <div>
                                                        <p class="fw-bold mb-1">Transfer</p>
                                                        <p class="fw-bold mb-0">Applied</p>
                                                    </div>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    <div>
                                                        <p class="fw-bold mb-1">Transfer</p>
                                                        <p class="fw-bold mb-0">by Manager</p>
                                                    </div>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    <div>
                                                        <p class="fw-bold mb-1">Transfer by</p>
                                                        <p class="fw-bold mb-0">Controller</p>
                                                    </div>
                                                </div>
                                                <div class="d-lg-flex align-items-center">
                                                    <div>
                                                        <p class="fw-bold mb-1">Transfered</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
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
                                @foreach ($productdata as $stock)
                                    <tr>
                                        <td>{{ $stock->product_number ?? 'N/A' }}</td>
                                        <td>{{ $stock->serial_number ?? 'N/A' }}</td>
                                        <td>{{ $stock->asset_type->name ?? '' }}</td>
                                        <td>{{ $stock->assetmain->name ?? 'N/A' }}</td>
                                        <td>{{ $stock->configuration ?? '' }}</td>
                                        <td>
                                            <a class="{{ $stock->statuses->status }} action-button"
                                                style="width: 100%;">{{ $stock->statuses->name }}</a>

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
