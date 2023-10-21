@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        #detail:hover {
            color: black;
            text-decoration: underline;
        }
    </style>
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
                                    <th>Products</th>
                                    <th>Employee Name</th>
                                    <th>Employee Manager</th>
                                    <th>Handover Employee</th>
                                    <th>Handover Manager</th>
                                    <th>Transfer Reason</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transfers as $transfer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach ($product as $value)
                                                <a id="detail"
                                                    href="{{ route('accept-detail-asset', $value->id) }}"><span>{{ $value->product_info }}</span></a>
                                            @endforeach
                                        </td>
                                        <td>{{ $transfer->user->first_name ?? '' }} ({{ $transfer->employee_id ?? '' }})</td>
                                        <td>{{ $transfer->manager->first_name ?? '' }}({{ $transfer->manager->employee_id ?? '' }})
                                        </td>
                                        <td>{{ $transfer->handoveruser->first_name ?? '' }}
                                            ({{ $transfer->handoveruser->employee_id ?? '' }})</td>
                                        <td>{{ $transfer->handovermanager->first_name ?? '' }}
                                            ({{ $transfer->handovermanager->employee_id ?? '' }})</td>
                                        <td>{{ $transfer->reason->reason ?? '' }}</td>
                                        <td>{{ $transfer->description ?? '' }}</td>
                                        <td>{{ $transfer->created_at ?? '' }}</td>
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
