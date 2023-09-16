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
    </style>
@endsection
@section('Content-Area')
    <div class="row">
        <div class="col-xl-12">
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
                        <table class="table">
                            <tbody>
                                @foreach ($products as $product)
                                    <form action="{{ route('accept-asset', $product->id) }}">
                                        <tr>
                                            <td>
                                                <div class="d-flex"><img class="img-fluid align-top circle"
                                                        src="../assets/images/dashboard/default/01.png" alt="">
                                                    <div class="flex-grow-1"><a
                                                            href="#"><span>{{ $product->product_info }}</span></a>
                                                        <p class="mb-0">
                                                            {{ Carbon\Carbon::parse($issuedata->created_at)->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Hello User A new Asset ({{ $product->product_info }}) has been issued please
                                                accept to the
                                                request!</td>
                                            <td class="text-end">
                                                @if ($product->status_available == 3)
                                                <button class="btn btn-success" type="button">Accepted</button>
                                                @elseif ($product->status_available == 4)
                                                <button class="btn btn-danger" type="button">Rejected</button>
                                                @else
                                                <button class="btn btn-primary" type="submit">Accept</button>
                                                <button class="btn btn-danger" type="submit">Reject</button>
                                                @endif
                                            </td>
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
@endsection
