@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        #detail:hover {
            color: black;
            text-decoration: underline;
        }
    </style>
    <style>
        /* Custom styles for breadcrumbs */
        .breadcrumbs-dark ol.breadcrumbs {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .breadcrumbs-dark ol.breadcrumbs li {
            font-size: 14px;
            /* Adjust font size as needed */
            color: #555;
            /* Adjust text color as needed */
        }

        .breadcrumbs-dark ol.breadcrumbs li:not(:last-child):after {
            content: ">";
            margin-left: 10px;
            margin-right: 10px;
            color: #777;
        }

        .breadcrumbs-dark ol.breadcrumbs li.text-muted {
            color: #333;
            font-weight: bold;
        }

        .breadcrumbs-dark ol.breadcrumbs li.text-muted a {
            color: #333;
            font-weight: bold;
        }

        .breadcrumbs-dark ol.breadcrumbs li.active a {
            color: #333;
            font-weight: bold;
        }

        .breadcrumbs-dark ol.breadcrumbs li.active a:hover {
            color: blue;
        }
    </style>
@endsection
@section('breadcrumbs')
    <div class="breadcrumbs-dark pb-0 pt-2" id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <ol class="breadcrumbs mb-2">
                        <li class="text-muted">Dashboard</li>
                        <li class="text-muted">Transfer/Return</li>
                        {{-- <li class="text-muted"><a href="{{ url('department') }}" class="text-muted">Department</a></li> --}}
                        <li class="active"><a href="{{ url('transfer/all') }}">All Transfer</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('Content-Area')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <h3>All Transfers</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Transaction Code</th>
                                    {{-- <th>Products</th> --}}
                                    <th>Employee Name</th>
                                    <th>Employee Manager</th>
                                    <th>Handover Employee</th>
                                    <th>Handover Manager</th>
                                    <th>Transfer Reason</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transfers as $transfer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transfer->transfers_transaction_code ?? '' }}</td>
                                        <td>{{ $transfer->user->first_name ?? '' }} ({{ $transfer->employee_id ?? '' }})
                                        </td>
                                        <td>{{ $transfer->manager->first_name ?? '' }}({{ $transfer->manager->employee_id ?? '' }})
                                        </td>
                                        <td>{{ $transfer->handoveruser->first_name ?? '' }}
                                            ({{ $transfer->handoveruser->employee_id ?? '' }})
                                        </td>
                                        <td>{{ $transfer->handovermanager->first_name ?? '' }}
                                            ({{ $transfer->handovermanager->employee_id ?? '' }})</td>
                                        <td>{{ $transfer->reason->reason ?? '' }}</td>
                                        <td>{{ $transfer->description ?? '' }}</td>
                                        <td>{{ $transfer->created_at ?? '' }}</td>
                                        <td>
                                            <a class="btn btn-primary"
                                                href="{{ route('transfer.show.product', $transfer->id) }}">View</a>&nbsp;
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
