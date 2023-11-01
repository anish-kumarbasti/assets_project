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
                <h3>All datas</h3>
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
                                    <th>Description</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($issuedata as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach ($product as $value)
                                                <a id="detail"
                                                    href="{{ route('accept-detail-asset', $value->id) }}"><span>{{ $value->product_info }}</span></a>
                                            @endforeach
                                        </td>
                                        <td>{{ $data->user->first_name ?? '' }} ({{ $data->employee_id ?? '' }})</td>
                                        <td>{{ $data->manager->first_name ?? '' }}({{ $data->manager->employee_id ?? '' }})
                                        </td>
                                        <td>{{ $data->description ?? '' }}</td>
                                        <td>{{ $data->created_at ?? '' }}</td>
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
