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
    @if (session('success'))
        <div id="btn" class="alert alert-success" role="alert"><i class="icon-thumb-up alert-center"></i>
            <p>{{ session('success') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger outline" role="alert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-md-5">
                            <h4>Transaction Code:</h4>
                            <input class="form-control mt-3" value="{{ $transactioncode }}" readonly>
                        </div>
                        <div class="col-md-7">
                            <h4>Description:</h4>
                            <textarea readonly disabled cols="30" rows="3" autofocus class="form-control mt-3">{{ $description }}</textarea>
                        </div>
                        <div class="col-md-12 mt-5 text-end fw-bold">
                            <small>
                                @foreach ($createdDates as $issuedata)
                                    {{ Carbon\Carbon::parse($issuedata)->diffForHumans() }}
                                @endforeach
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card appointment-detail">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-primary">Asset Requests<i class="fa fa-circle"> </i>
                            </p>
                            <h4>Asset Requests</h4>
                        </div>
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
                                {{-- <th>Type</th> --}}
                                <th>Product</th>
                                <th>Description</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <form
                                        action="{{ Auth::check() && Auth::user()->role_id == 2 ? route('accept-asset', $product->id) : route('accept-asset-manager', $product->id) }}">
                                        <tr>
                                            <td>{{ $product->product_number ?? '' }}</td>
                                            <td>
                                                <div class="d-flex"><img class="img-fluid align-top circle"
                                                        src="../assets/images/dashboard/default/01.png" alt="">
                                                    <div class="flex-grow-1"><a
                                                            href="{{ route('accept-detail-asset', $product->id) }}"><span>{{ $product->product_info }}</span></a>

                                                        <p class="mb-0">
                                                            {{-- @foreach ($createdDates as $issuedata)
                                                            {{ Carbon\Carbon::parse($issuedata)->diffForHumans() }}
                                                            @endforeach --}}

                                                        </p>

                                                    </div>
                                                </div>
                                            </td>
                                            @if (Auth::check() && Auth::user()->role_id == 2)
                                                <td>Hello User A new Asset ({{ $product->product_info }}) has been
                                                    issued
                                                    please
                                                    accept to the
                                                    request!</td>
                                                <td class="text-end">
                                                    @if ($product->status_available == 15)
                                                        <div class="btn-group" role="group" aria-label="Action Buttons">
                                                            <button class="btn btn-primary action-button"
                                                                type="submit">Accept</button>
                                                            <button class="btn btn-danger action-button" type="button"
                                                                data-toggle="modal" data-target="#rejectionModal"
                                                                onclick="setProductIdToReject('{{ $product->id }}')">Reject</button>
                                                        </div>
                                                    @elseif ($product->status_available == 4)
                                                        <button class="btn btn-danger btn-block action-button"
                                                            type="button" style="width: 100%;">Rejected</button>
                                                    @else
                                                        <button class="btn btn-success btn-block action-button"
                                                            type="button" style="width: 100%;">Accepted</button>
                                                    @endif
                                                </td>
                                            @elseif (Auth::check() && Auth::user()->role_id == 3)
                                                <td>Hello A new Asset ({{ $product->product_info }}) has been
                                                    issued. to
                                                    the ({{ $user->first_name }} {{ $user->last_name }})</td>
                                                <td class="text-end">
                                                    @if ($product->status_available == 15)
                                                        <a class="btn btn-success"
                                                            href="{{ route('approve-manager', $product->id) }}">Approve</a>
                                                        <a class="btn btn-danger"
                                                            href="{{ route('denied-manager', $product->id) }}">Denied</a>
                                                    @elseif ($product->status_available == 14)
                                                        <a class="btn btn-danger" type="button">Denied.</a>
                                                    @else
                                                        <a class="btn btn-success" type="button">Approved.</a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="rejectionModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('rejection') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectionModalLabel">Enter Rejection Reason</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="productIdToReject" name="productIdToReject" value="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reason">Reason for Rejection</label>
                            <textarea class="form-control" name="reason" id="reason" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" id="submitRejection">Submit</button>
                    </div>
                </div>
            </form>
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
